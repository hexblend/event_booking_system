function ajaxGetApprovedReviews(venue_id) {
    venueID = venue_id;
    var xhr = new XMLHttpRequest();
    xhr.addEventListener ("load", approvedReviewsReceived);
    xhr.open("GET", 'features/reviews/get_approved.php?venue_id=' + venueID);
    xhr.send();
}

// Output approved reviews
function approvedReviewsReceived(e) {
    document.getElementById("reviews-" + venueID).innerHTML = e.target.response;
}
