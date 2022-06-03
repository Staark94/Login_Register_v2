<?php
    use Staark\Support\Model\User;
    include 'templates/header.php';
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="./index">User Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <?php if($user::guest()): ?>
            <div class="collapse navbar-collapse" id="navbarNav" style="float: right !important; display: block !important;">
            <ul class="navbar-nav" style="float: right !important; display: block !important;">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="./?logout=true">Logout</a>
                </li>
            </ul>
        </div>
        <?php else: ?>
            <div class="collapse navbar-collapse" id="navbarNav" style="float: right !important; display: block !important;">
            <ul class="navbar-nav" style="float: right !important;">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="./signin.php">Login</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="./register.php">Register</a>
                </li>
            </ul>
        <?php endif; ?>
    </div>
</nav>

<?php if($user::guest()): ?>
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            Welcome back <?=$user->name() ?? ""; ?><br />
            Your Email: <?=$user->email ?? ""; ?><br />
            <hr>
            Last Login: <?=$user->update_at; ?><br />
            Have a nice day Sir.
        </div>
    </div>
</div>
<?php else: 
    @header("Location: ./signin.php"); exit();
?>
<?php endif; ?>

<?php include 'templates/footer.php'; ?>