<?php
    include 'templates/header.php';
    $user->password_reset();
?>

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
<?php include 'templates/footer.php'; ?>