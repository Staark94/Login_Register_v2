<?php
namespace Staark\Support\Model;

class User extends Eloquent
{
    protected $fallible = ['first_name', 'last_name', 'email', 'password'];
    protected $table = "accounts";
    public $errors = [];
    public static $instance = null;

    public function __construct()
    {
        self::$instance =& $this;
        parent::__construct();
    }

    public static function isGuest(): bool
    {
        if(!isset($_SESSION['user']['logged'])) {
            if(strpos($_SERVER['REQUEST_URI'], "/index")) {
                @header("location: ./signin");
                exit(1);
            }
        } else {
            if(strpos($_SERVER['REQUEST_URI'], "/signin")) {
                @header("location: ./");
                exit(1);
            }

            if(strpos($_SERVER['REQUEST_URI'], "/register")) {
                @header("location: ./");
                exit(1);
            }

            if(strpos($_SERVER['REQUEST_URI'], "/forgot")) {
                @header("location: ./");
                exit(1);
            }
        }

        return false;
    }

    public static function create(array $values = []): bool
    {
        if(!empty($values) && is_array($values)) {
            $queryBinds = []; $queryValues = []; $queryValuesBind = [];

            foreach ($values as $keys => $val) {
                $queryBinds[] = $keys;
                $queryValues[] = ":" . $keys;
                $queryValuesBind[":" . $keys] = $val;
            }

            $query = parent::$connection->prepare("INSERT INTO " . (new static())->table . "(". implode(', ', $queryBinds) .") VALUES (". implode(', ', $queryValues) .")");

            try {
                $query->execute($queryValuesBind);
            } catch (\PDOException $e) {
                print_r($e->getMessage());
            }

            return true;
        }
    }

    public function password_reset()
    {
        if(isset($_POST['forgot'])) {
            if(!is_null($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                if($userData = self::findByEmail($_POST['email'])) {
                    $query = self::$connection->prepare("SELECT token, expire, used FROM `password_reset` WHERE expire > CURRENT_DATE() AND used = 0 AND email = '$userData->email'");
                    $query->execute();
                    $data = $query->fetch(5);

                    $left = $this->time_left($data->expire);
                    $timeLeft = "{$left->hour} hour and {$left->min} minutes left";

                    if($query->rowCount() > 0)
                        $this->errors[] = "You have an active request for this email, expire at: {$timeLeft}.";

                    if($query->rowCount() === 0)
                    {
                        $token = bin2hex(random_bytes(16));
                        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                        $expire = date('Y-m-d H:i:s', strtotime("+2 hours"));
                        $url = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

                        self::$connection->query("INSERT INTO `password_reset`(`token`, `email`, `expire`) VALUES ('$token', '$email', '$expire')");
                        $this->sendEmail($email, [
                            'url' => $url,
                            'code' => $token
                        ]);
                        self::$connection = null;
                        $this->errors[] = "Your password reset instructions has been send to your email, check inbox.";
                    }
                } else {
                    $this->errors[] = "Email not found on users, please try again.";
                }
            }
        }

        if(isset($_GET['code'])) {
            $token = $_GET['code'];
            $query = self::$connection->prepare("SELECT email, expire, used FROM `password_reset` WHERE expire > CURRENT_DATE() AND used = 0 AND token = '$token'");
            $query->execute();
            $data = $query->fetch(5);

            if($query->rowCount() === 0 || !empty($code)) {
                $s = "Your request to reset password has expired or change your password recently.";
                @header("Location: ./forgot?expire=code&error=" . $s);
                exit(200);
            } else {
                $left = $this->time_left($data->expire);
                $timeLeft = "{$left->hour} hour and {$left->min} minutes left";
                $this->errors[] = "Your request to reset password was expire at {$timeLeft}.";
            }

            if($query->rowCount() > 0) {
                if(isset($_POST['reset'])) {
                    if($_POST['confirm'] !== $_POST['password'])
                        $this->errors[] = "Confirm Password should be some at Password";

                    if($_POST['confirm'] === $_POST['password']) {
                        $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);
                        $email = $data->email;
                        $date = date("Y-m-d");

                        self::$connection->query("UPDATE `{$this->getTable()}` SET password = '$pass', password_reset = '$date' WHERE email = '$email'");
                        self::$connection->query("DELETE FROM `password_reset` WHERE token = '$token'");
                        $_SESSION['succes'] = "Your password has been reset. New login with new password.";

                        self::$connection = null;

                        @header("Location: ./signin");
                        exit(200);
                    }
                }
            }
        }
        return false;
    }

    public function name() {
        return $this->first_name . " " . $this->last_name;
    }

    public static function login(): bool
    {
        $allowToQuery = false;

        foreach (self::$instance->fallible as $item) {
            if(array_key_exists($item, self::$instance->dataStored)) {
                $allowToQuery = true;
            }
        }

        if($allowToQuery && !empty(self::$instance->dataStored['email'])) {
            $sql = "SELECT id, email, password FROM ". self::$instance->getTable() ." WHERE email = '". self::$instance->dataStored['email'] ."'";

            if($query = self::$connection->prepare($sql)) {
                try {
                    $query->execute();

                    if(!$query->rowCount())
                        self::$instance->errors[] = "<b>*</b> User with that email not found.";

                    if($query->rowCount() > 0) {
                        $userData = $query->fetch(5);

                        if(!password_verify(self::$instance->dataStored['password'], $userData->password))
                            self::$instance->errors[] = "<b>*</b> Password not match, please try again or reset your password.";

                        if(!self::$instance->errors) {
                            self::$connection->query("UPDATE `". self::$instance->getTable() ."` SET update_at = CURRENT_TIMESTAMP WHERE id = " . $userData->id);
                            $_SESSION['user']['id'] = $userData->id;
                            $_SESSION['user']['logged'] = true;

                            self::$connection = null;

                            @header("Location: ./index");
                            exit(200);
                        }
                    }
                } catch (\PDOException $e) {
                    echo $e->getMessage();
                }
            }
        }

        return !self::$instance->errors;
    }

    public function logout() {
        if(isset($_GET['logout'])) {
            session_destroy();
            unset($_SESSION['user']);
            @header("Location: ./signin" );
            exit(200);
        }
    }

    public function time_left($date)
    {
        $t1 = strtotime(date("Y-m-d H:i:s"));
        $t2 = strtotime($date);

        $dtd = new \stdClass();
        $dtd->interval = $t2 - $t1;
        $dtd->total_sec = abs($t2-$t1);
        $dtd->total_min = floor($dtd->total_sec/60);
        $dtd->total_hour = floor($dtd->total_min/60);
        $dtd->total_day = floor($dtd->total_hour/24);

        $dtd->day = $dtd->total_day;
        $dtd->hour = $dtd->total_hour - ($dtd->total_day*24);
        $dtd->min = $dtd->total_min - ($dtd->total_hour*60);
        $dtd->sec = $dtd->total_sec - ($dtd->total_min*60);
        return $dtd;
    }
}