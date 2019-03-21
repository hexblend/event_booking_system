function ajaxApproveReview(review_id) {
    reviewID = review_id;
    var xhr = new XMLHttpRequest();
    xhr.addEventListener ("load", reviewApproved);
    xhr.open('GET', 'features/reviews/approve.php?review=' + reviewID);
    xhr.send();
}

function reviewApproved(e) {
    var elem = document.getElementById('pendingReview-' + reviewID);
    elem.parentNode.removeChild(elem);
}
