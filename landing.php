<?php
require_once('core/init.php');
require_once('includes/header.php');
require_once('includes/navbar.php');
if (!isset($_SESSION['logged_in'])){
    header('Location: index.php');
    exit();
}
if($_SESSION['logged_in'] === "admin"){
    include('features/reviews/pending.php');
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-12 mt-4" id="alert-container"></div>
        <div class="col-md-8 offset-md-2 mt-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mr-auto">Search a venue:</h5>
                    <form onsubmit="event.preventDefault(); ajaxSearch();">
                        <div class="form-group">
                            <input type="search" class="form-control" name="search" id="search" aria-describedby="emailHelp" placeholder="Restaurant, Bar, Fastfood, etc... ">
                        </div>
                        <button type="submit" class="btn btn-primary">Search</button>
                    </form>
                </div>
            </div>
            <a href="add_venue.php" class="btn btn-light btn-block mt-2">Add a venue</a>

            <?php /* Venues Front End */ ?>
            <div class="accordion mt-3" id="venues"></div>
        </div>
    </div>
</div>

<script src="assets/js/ajax_search.js"></script>
<script src="assets/js/ajax_add_recommendation.js"></script>
<script src="assets/js/ajax_add_review.js"></script>
<script src="assets/js/ajax_approve_review.js"></script>
<script src="assets/js/ajax_delete_review.js"></script>
<script src="assets/js/ajax_get_reviews.js"></script>
<script src="assets/js/pending_reviews_number.js"></script>
<script src="assets/js/ajax_get_approved_reviews.js"></script>
<?php require_once('includes/footer.php'); ?>
