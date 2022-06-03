<?php
    use Staark\Support\Model\User;
    include 'templates/header.php';
    User::login();
?>
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
<?php include 'templates/footer.php'; ?>