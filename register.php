<?php
    include 'templates/header.php';

    /**
     * User Register form submit and validation
     */
    if(isset($_POST['register']))
        if($user->validate())
            $user->insert();
?>

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
<?php include 'templates/footer.php'; ?>