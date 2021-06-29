<?php
require_once ('config.php');
use \Staark\Support\Model\User;

if(isset($_POST['register']))
    if($user->validate())
        $user->insert();
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
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col col-md-8">
            <div class="card">
                <div class="card-header">
                    Create your account free
                </div>

                <div class="card-body">
                    <?php if($user->getErrors()): ?>
                        <div class="alert alert-danger" role="alert">
                            <?=$user->getErrors(); ?>
                        </div>
                    <?php endif; ?>
                    <form class="row g-3" method="post" enctype="multipart/form-data">
                        <div class="col-md-6">
                            <label for="inputFirstName" class="form-label">First name</label>
                            <input type="text" name="first_name" class="form-control" placeholder="First name" aria-label="First name" id="inputFirstName" />
                        </div>

                        <div class="col-md-6">
                            <label for="inputLastName" class="form-label">Last name</label>
                            <input type="text" name="last_name" class="form-control" placeholder="Last name" aria-label="Last name" id="inputLastName" />
                        </div>

                        <div class="col-12">
                            <label for="userEmail" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Email" aria-label="Email" id="userEmail" />
                        </div>

                        <div class="col-md-6">
                            <label for="inputPassword" class="form-label">Password</label>
                            <input type="password" name="password" minlength="8" class="form-control" placeholder="******" aria-label="*****" id="inputPassword" />
                        </div>

                        <div class="col-md-6">
                            <label for="inputPassword" class="form-label">Password Confirm</label>
                            <input type="password" name="confirm" minlength="8" class="form-control" placeholder="******" aria-label="*****" id="inputPassword" />
                        </div>

                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="terms" id="gridCheck">
                                <label class="form-check-label" for="gridCheck">
                                    Accept Terms and Conditions
                                </label>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="d-grid gap-2">
                                <input type="submit" name="register" value="Register" class="btn btn-success btn-sm" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Optional JavaScript; choose one of the two! -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>