# User Manage System v2
 ### PHP User System 
 - Login
 - Register
 - Forgot Password 
 - Models
 - ActiveRecords
 - Validation on register

# Demo
[Demo Album](https://imgur.com/a/xNNEwBy)

# Usage Utilites
 - Bootstrap v5.2 Framework
 - PHP PDO For Connection
 - Password saved hash
 - User password change with email
 - PHPMailer

# Settings
`import Model with ' use Staark\Support\Model\User; '`

`import configuration with ' require_once 'config.php'; '`

# Exemple

 - Protected attr on model (not update in database with save() function):
    - id
    - password
    - password_reset 
    - created_at

```
- `$user->func or $user->attr`
- `User::func`

// Check session user's
User::isGuest();

// Update user attributes in database
$user->last_name = 'Your Last Name';
$user->save();

// Using that you create a new user in database.
User::create([
  'first_name' => 'John',
  'last_name' => 'Doe',
  'email' => 'youremail@exemple.com',
  'password' => User::passHash('pass'),
]);

```

```
// Get errors of action page
$user->getErrors(); return bool|array

// Send Email
$user->sendEmail('email', [array options]); return bool
```

# Configuration
Open file ``config.php`` and edit database and email server.
