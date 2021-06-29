<?php
require_once ('config.php');
$user->password_reset();
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
        <?php if(!isset($_GET['code'])): ?>
        <div class="col-lg-8 col-md-10">
            <div class="forgot">
                <h2>Forgot your password?</h2>
                <p>Change your password in three easy steps. This will help you to secure your password!</p>
                <ol class="list-unstyled">
                    <li><span class="text-primary text-medium">1. </span>Enter your email address below.</li>
                    <li><span class="text-primary text-medium">2. </span>Our system will send you a temporary link</li>
                    <li><span class="text-primary text-medium">3. </span>Use the link to reset your password</li>
                </ol>
            </div>
            <form method="post" enctype="multipart/form-data" class="card mt-4 forgot">
                <div class="card-body">
                    <?php if(isset($_GET['expire'])): ?>
                    <div class="alert alert-warning mb-0" role="alert">
                        <?php echo htmlspecialchars_decode($_GET['error']); ?>
                    </div>
                    <?php endif; ?>

                    <?php if($user->getErrors()): ?>
                        <div class="alert alert-info mb-3" role="alert">
                            <?=$user->getErrors(); ?>
                        </div>
                    <?php endif; ?>

                    <?php if(!isset($_GET['expire'])): ?>
                    <div class="form-group hidden">
                        <label for="email-for-pass">Enter your email address</label>
                        <input class="form-control" name="email" type="text" id="email-for-pass" required="">
                        <small class="form-text text-muted">Enter the email address you used during the registration. Then we'll email a link to this address.</small>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="card-footer">
                    <?php if(!isset($_GET['expire'])): ?>
                    <input class="btn btn-success" type="submit" name="forgot" value="Get New Password" />
                    <a href="./signin" class="btn btn-danger">Back to Login</a>
                    <?php else: ?>
                    <a href="./signin" class="btn btn-danger">Back to Login</a>
                    <?php endif; ?>
                </div>

            </form>
        </div>
        <?php else: ?>
            <div class="col-lg-8 col-md-10">
                <form method="post" enctype="multipart/form-data" class="card mt-4 forgot">
                    <div class="card-body">
                        <?php if($user->getErrors()): ?>
                            <div class="alert alert-info mb-3" role="alert">
                                <?=$user->getErrors(); ?>
                            </div>
                        <?php endif; ?>

                        <div class="form-group mb-3">
                            <label for="email-for-pass">Reset Code</label>
                            <input class="form-control" name="code" type="text" value="<?=$_GET['code']; ?>" disabled />
                        </div>

                        <div class="form-group mb-3">
                            <label for="email-for-pass">Enter your new password</label>
                            <input class="form-control" name="password" type="password" id="email-for-pass" minlength="8" required="" />
                        </div>

                        <div class="form-group">
                            <label for="email-for-pass">Confirm your password</label>
                            <input class="form-control" name="confirm" type="password" id="email-for-pass" minlength="8" required="" />
                        </div>
                    </div>

                    <div class="card-footer">
                        <input class="btn btn-success btn-sm" type="submit" name="reset" value="Update Password" />
                    </div>
                </form>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Optional JavaScript; choose one of the two! -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>