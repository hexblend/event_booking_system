<?php
require_once('core/init.php');
require_once('includes/header.php');
require_once('includes/navbar.php');
if(!isset($_SESSION['logged_in'])){
    header('Location: index.php');
    exit();
} ?>

<div class="container">
    <div class="row my-3">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card my-5">
                <div class="card-body">
                    <h3 class="card-title text-center">Add a venue</h3>

                    <form action="features/venues/add.php" method="POST">
                        <div class="form-label-group my-3">
                            <label for="name">Name of venue</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Name" required autofocus>
                        </div>
                        <div class="form-label-group my-3">
                            <label for="type">Type</label>
                            <input type="text" name="type" id="type" class="form-control" placeholder="Restaurant, fastfood, etc." required>
                        </div>
                        <div class="form-label-group my-3">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="description" id="description" rows="3" placeholder="Small description..."></textarea>
                        </div>
                        <button class="btn btn-lg btn-primary btn-block text-uppercase mt-4" type="submit">Add venue</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once('includes/footer.php'); ?>



