<?php
namespace Staark\Support\Model;

use PDO;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Staark\Support\Interfaces\ActiveRecords;

/**
 * Class Eloquent
 */
class Eloquent implements ActiveRecords
{
    protected static $connection = null;
    protected static $mail = null;
    protected static $self = null;

    protected $attributes = [];
    protected $fallible = [];
    public $errors = [];
    protected $dataStored = [];
    protected $primaryKey = 'id';
    protected $table = "";

    public function __construct()
    {
        $this->load();

        if (self::$connection == null) {
            throw new \Exception("Database was it's not initialized.", 1);
        }

        if(empty($this->table) || !is_string($this->table)) {
            throw new \Exception("SQL Table not set in " . get_class(), 1);
        }

        if(isset($_POST) && !empty($_POST)) {
            $this->store($_POST);
        }

        if(isset($_SESSION['user']))
        {
            $query = self::$connection->prepare("SELECT * FROM `$this->table` WHERE id = " . $_SESSION['user']['id'] . " LIMIT 0,1");

            try {
                $query->execute();

                if($query->rowCount() > 0) {
                    foreach ($query->fetch(\PDO::FETCH_OBJ) as $key => $value) {
                        if($value == "") continue;

                        $this->__set($key, $value);
                    }
                }
            } catch(\PDOException $e) {
                die($e->getMessage());
            }
        }

    }

    public function setConnection(array $config = []): \PDO
    {
        $options = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        if(self::$connection == null) {
            try {
                self::$connection = new \PDO("{$config['driver']}:host={$config['host']};dbname={$config['dbname']};charset=utf8", $config['user'], $config['pass'], $options);
            } catch (\PDOException $e) {
                die($e->getMessage());
            }
        }

        return self::$connection;
    }

    public function setEmailServer(array $config = []): PHPMailer
    {
        if (self::$mail === null) {
            // Create an instance; passing `true` enables exceptions
            self::$mail = new PHPMailer(true);

            try {
                //Server settings
                self::$mail->SMTPDebug = false; // $config['SMTPDebug'] ? SMTP::DEBUG_SERVER : false;
                self::$mail->isSMTP();
                self::$mail->Host       = $config['Host'];
                self::$mail->SMTPAuth   = $config['SMTPAuth'];
                self::$mail->SMTPSecure = 'ssl';
                self::$mail->Username   = $config['Username'];
                self::$mail->Password   = $config['Password'];
                self::$mail->SMTPSecure = "tls";
                self::$mail->Port       = $config['Port'];

                self::$mail->setFrom($config['sender'], $config['head']);
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: " . self::$mail->ErrorInfo;
            }
        }

        return self::$mail;
    }

    public function __set(string $name, string $value): void
    {
        $this->attributes[$name] = $value;
    }

    public function __get(string $name): string
    {
        if (array_key_exists($name, $this->attributes)) {
            return $this->attributes[$name];
        }
    }

    public function load() {
        foreach (self::$self as $func) {
            call_user_func(array($this, $func[0]), $func[1]);
        }
    }

    public static function register(string $func, $args = []) {
        self::$self[] = [$func, $args];
    }

    public function save(): bool
    {
        $queryItems = [];
        $allowToQuery = false;

        foreach ($this->attributes as $item => $field) {
            if(!empty($field)) {
                $allowToQuery = true;
                if($item === "id" || $item == "password" || $item === "password_reset" || $item === "created_at") continue;
                $queryItems['values'][] = "{$item} = :{$item}";
                $queryItems['bind'][":" . $item] = $field;
            }
        }

        if($allowToQuery && isset($_SESSION['user'])) {
            $query = self::$connection->prepare("UPDATE `{$this->getTable()}` SET ". implode(', ', $queryItems['values']) ." WHERE id = " . $_SESSION['user']['id']);

            try {
                $query->execute($queryItems['bind']);
            } catch (\PDOException $e) {
                echo $e->getMessage();
            }
        }

        return false;
    }

    public function insert(): bool
    {
        $queryItems = [];
        $allowToQuery = false;

        foreach ($this->fallible as $item) {
            if(array_key_exists($item, $this->dataStored)) {
                $allowToQuery = true;
                $queryItems['items'][] = $item;
                $queryItems['values'][] = ":" . $item;
                $queryItems['bind'][":" . $item] = $this->dataStored[$item];
            }
        }

        if($allowToQuery) {
            $queryItems['bind'][':password'] = password_hash($queryItems['bind'][':password'], PASSWORD_BCRYPT);
            $query = self::$connection->prepare("INSERT INTO $this->table(". implode(', ', $queryItems['items']) .") VALUES (". implode(', ', $queryItems['values']) .")");

            try {
                $query->execute($queryItems['bind']);
                @header("Location: ./login");
                $_SESSION['succes'] = "Your Account has been create, new is allow login to your account.";
                exit(200);
            } catch (\PDOException $e) {
                echo $e->getMessage();
            }
        }

        return false;
    }

    public function delete(): bool
    {
        if(isset($_SESSION['user'])) {
            $query = self::$connection->prepare("DELETE FROM `{ $this->table }` WHERE id = " . $_SESSION['user']['id']);

            try {
                $query->execute();
            } catch(\PDOException $e) {
                echo $e->getMessage();
            }
        }

        return false;
    }

    public function update(): bool
    {
        self::save();
        return false;
    }

    public static function findOrFail(int $id = -1): bool
    {
        if($id > 0) {
            $query = self::$connection->prepare("SELECT * FROM ". (new static())->getTable() ." WHERE id = " . $id);
            $query->execute();

            return (bool)$query->rowCount();
        }

        return false;
    }

    public static function findById(int $id = -1)
    {
        if($id > 0) {
            $query = self::$connection->prepare("SELECT * FROM ". (new static())->getTable() ." WHERE id = " . $id);
            $query->execute();

            return $query->fetch(5);
        }

        return false;
    }

    public static function findByEmail(string $email = null)
    {
        if(!empty($email)) {
            $query = self::$connection->prepare("SELECT id, email FROM ". (new static())->getTable() ." WHERE email = '$email'");
            $query->execute();

            return ($query->rowCount()) ? $query->fetch(5) : false;
        }

        return false;
    }

    public function getTable(): ?string
    {
        return $this->table ?? null;
    }

    private function store(array $_data = array()) {
        // Not give an array return function
        if( !is_array($_data) || empty($_data) ) {
            try {
                throw new \Exception('Error Processing Request Data Store', 1);
            } catch (\Exception $e) {
                die($e->getMessage() . "<br /> <b>on line</b> " . __LINE__ . " class " . __CLASS__ . "<b> on function </b>" . __FUNCTION__);
            }
        }

        foreach($_data as $key => $value) {
            $this->dataStored[$key] = $value;
        }
    }

    public function validate(): bool
    {
        if( !$this->fallible || !is_array($this->fallible) || empty($this->fallible) ) {
            try {
                throw new \Exception('Error Processing Request Data Validation', 1);
            } catch (\Exception $e) {
                die($e->getMessage() . "<br /> <b>on line</b> " . __LINE__ . " class " . __CLASS__ . "<b> on function </b>" . __FUNCTION__);
            }
        }

        if( !$this->dataStored || !is_array($this->dataStored) || empty($this->dataStored) ) {
            try {
                throw new \Exception('Error Processing Request Data Validation', 1);
            } catch (\Exception $e) {
                die($e->getMessage() . "<br /> <b>on line</b> " . __LINE__ . " class " . __CLASS__ . "<b> on function </b>" . __FUNCTION__);
            }
        }

        foreach ($this->dataStored as $item => $value)
        {
            $item = str_replace("_", " ", $item);

            if($item === "email" || $item === "userEmail") {
                if(empty($this->dataStored[$item]) && !filter_var($this->dataStored[$item], FILTER_VALIDATE_EMAIL)) {
                    $this->errors[] = "<b>*</b> ". ucwords($item) ." is not allow to empty or is not valid email.";
                    continue;
                }
            }

            if($item === "confirm") {
                if($this->dataStored['confirm'] != $this->dataStored['password']) {
                    $this->errors[] = "<b>*</b> ". ucwords($item) ." Password should be some at Password";
                    continue;
                } else {
                    continue;
                }
            }

            if(empty($value)) {
                $this->errors[] =  "<b>*</b> ". ucwords($item) ." is not allow to empty.";
            }
        }

        if(!isset($this->dataStored['terms'])) {
            $this->errors['terms'] = "<b>*</b> Terms and Privacy should be at confirmed.";
        }

        return !$this->errors;
    }

    public function getErrors(): string
    {
        return implode("<br />", $this->errors);
    }

    public function sendEmail(string $email, array $subject = [])
    {
        if(self::$mail != null) {
            try {
                //Recipients
                self::$mail->addAddress("$email");

                //Content
                self::$mail->isHTML(true);                                  //Set email format to HTML
                self::$mail->Subject = 'Instructions for changing your password';
                self::$mail->Body    = 'You\'ve asked to reset your password for the account associated with this email address ('. $email .'). To get the password reset code, please click on the following link:' .
                    '<br><br><a href="'. $subject['url'] . '?code=' . $subject['code'] .'">'. $subject['url'] . '?code=' . $subject['code'] .'</a><br><br>';
                self::$mail->Body .= 'You can also copy and paste the link above into a new browser window<br><br>' .
                'Or enter the reset code directly into the password page:<br><br>' .
                    $subject['code'] .
                    '<br><br>This password change code will expire 2 hours from the time this email was sent. To re-start the password change process, click here:<br><br>' .
                $subject['url'] .
                    '<br><br>If you didn\'t make the request, you can ignore this email and do nothing. Another user likely entered your email address by mistake while trying to reset a password.';

                self::$mail->send();
            } catch (Exception $e) {
                throw new Exception("Message could not be sent. Mailer Error: " . self::$mail->ErrorInfo, 1);
            }
        } else
            throw new Exception("Message could not be sent. Mailer Error: " . self::$mail->ErrorInfo, 1);
    }

    public static function passHash(string $password = "", string $encrypt = PASSWORD_BCRYPT) {
        return password_hash($password, $encrypt);
    }
}