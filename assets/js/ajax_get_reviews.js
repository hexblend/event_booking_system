function ajaxGetReviews() {
    var xhr = new XMLHttpRequest();
    xhr.addEventListener ("load", reviewsReceived);
    xhr.open("GET", 'features/reviews/get.php');
    xhr.send();
}

// change this in the end
function reviewsReceived(e) {
    document.getElementById("pendingReviews").innerHTML = e.target.response;
}
