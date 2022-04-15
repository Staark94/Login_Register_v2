# User Manage System v2
[![Latest Stable Version](http://poser.pugx.org/staark/user/v)](https://packagist.org/packages/staark/user)
[![Total Downloads](http://poser.pugx.org/staark/user/downloads)](https://packagist.org/packages/staark/user)
[![Latest Unstable Version](http://poser.pugx.org/staark/user/v/unstable)](https://packagist.org/packages/staark/user)
[![License](http://poser.pugx.org/staark/user/license)](https://packagist.org/packages/staark/user)
![Lines of code](https://img.shields.io/tokei/lines/github/Staark94/Login_Register_v2?style=flat-square)
![GitHub code size in bytes](https://img.shields.io/github/languages/code-size/Staark94/Login_Register_v2?style=flat-square)
![Bitbucket open pull requests](https://img.shields.io/bitbucket/pr-raw/Staark94/Login_Register_v2?style=flat-square)
![Bitbucket open issues](https://img.shields.io/bitbucket/issues-raw/Staark94/Login_Register_v2?style=flat-square)

![](https://i.imgur.com/4MaTPS6.png)
![](https://i.imgur.com/5P62pzD.png)

# Languages Utilites
 - PHP (v 7.4)
 - Bootstrap Framework (v5.2 latest)
 - PDO (For Connection)
 - Password Hash (PHP Hash)
 - PHPMailer (PHP Framework)

 # System Options Avaible
 - Login
 - Register
 - Forgot Password 
 - Models
 - ActiveRecords
 - Validation on register
 - User password change with email

# Demo
[Demo Album](https://imgur.com/a/xNNEwBy)

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
