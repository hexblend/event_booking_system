<?php
require_once('includes/header.php');
require_once('core/init.php');
if(isset($_SESSION['logged_in'])){
    header('Location: landing.php');
    exit();
}
?>

<div class="container">
    <h1 class="text-center mt-5">Welcome to South Venues</h1>
    <div class="row my-4">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card my-5">
                <div class="card-body">
                    <h3 class="card-title text-center">Sign In</h3>

                    <form action="features/login_sys/login.php" method="POST">
                        <div class="form-label-group my-3">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Username" required autofocus>
                        </div>

                        <div class="form-label-group my-3">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                        </div>
                        <button class="btn btn-lg btn-primary btn-block text-uppercase mt-4" type="submit">Log in</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?php require_once('includes/footer.php'); ?>
