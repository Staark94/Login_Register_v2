<?php
use Staark\Support\Model\User;
require_once ('config.php');

User::login();
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
                    Login to your account
                </div>

                <div class="card-body">
                    <?php if(isset($_SESSION['succes'])): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $_SESSION['succes']; ?>
                        </div>
                    <?php unset($_SESSION['succes']); endif; ?>

                    <?php if($user->getErrors()): ?>
                        <div class="alert alert-danger" role="alert">
                            <?=$user->getErrors(); ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" enctype="multipart/form-data">
                        <div class="row mb-3">
                            <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" name="email" class="form-control" id="inputEmail" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10">
                                <input type="password" name="password" class="form-control" id="inputPassword" />
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-grid gap-2">
                                <input type="submit" value="Sign In" class="btn btn-primary btn-sm" />
                            </div>
                        </div>
                        <hr />
                        <div class="col-12">
                            <div class="d-flex justify-content-center">
                                <a href="./register">Create an account</a> | <a href="./forgot">Forgotten Password?</a>
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