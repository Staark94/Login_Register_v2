<?php
@require_once 'src/loader.php';

ini_set('error_reporting', 1);
error_reporting(E_ALL);
@session_start();

$dbConnection = [
    'driver' => 'mysql',
    'host' => 'localhost',
    'dbname' => 'dbname',
    'user' => 'root',
    'pass' => '',
    'port' => '3306',
    'charset' => 'UTF-8'
];

// Email Server settings
$emailConfig = [
    'SMTPDebug'  => true,
    'Host'       => 'smtp.gmail.com',
    'SMTPAuth'   => true,
    'Username'   => 'youremail@gmail.com',
    'Password'   => 'secret',
    'Port'       => 587,

    'sender'     => 'admin@exemple.com',
    'head'       => 'Your password was reset'
];

\Staark\Support\Model\Eloquent::register('setConnection', $dbConnection);
\Staark\Support\Model\Eloquent::register('setEmailServer', $emailConfig);

// User Constructor
use \Staark\Support\Model\User;
$user = new User();