function ajaxAddReview(venue_id) {
    venueID = venue_id;
    var xhr2 = new XMLHttpRequest();
    var new_review = document.getElementById("new_review_" + venueID).value;
    xhr2.addEventListener ("load", reviewReceived);
    xhr2.open("POST", "/features/reviews/add.php?new_review=" + new_review + "&venue_id=" + venueID);
    xhr2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr2.send("new_review=" + new_review + "&venue_id=" + venueID);
    document.getElementById("add-review-form-" + venueID).reset();
}

function reviewReceived(e) {
    document.getElementById("response-" + venueID).innerHTML = e.target.response;
}

