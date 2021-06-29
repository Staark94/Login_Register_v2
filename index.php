<?php
use Staark\Support\Model\User;
require_once 'config.php';

User::isGuest();
$user->logout();

// $user->last_name = 'Costin';
// $user->save();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="style.css"  rel="stylesheet" />

        <title>PHP System - Login/Register/Forgot Password</title>
    </head>
    <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="./index">User Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav" style="float: right !important; display: block !important;">
                <ul class="navbar-nav" style="float: right !important; display: block !important;">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="./?logout=true">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

        <div class="container mt-5">
            <div class="card">
                <div class="card-body">
                    Welcome back <?=$user->name(); ?><br />
                    Your Email: <?=$user->email; ?><br />
                    <hr>
                    Last Login: <?=$user->update_at; ?><br />
                    Have a nice day Sir.
                </div>
            </div>
        </div>

        <!-- Optional JavaScript; choose one of the two! -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>