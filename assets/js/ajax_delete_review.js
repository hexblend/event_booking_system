function ajaxDeleteReview(review_id) {
    reviewID = review_id;
    var xhr = new XMLHttpRequest();
    xhr.addEventListener ("load", reviewDeleted);
    xhr.open('GET', 'features/reviews/delete.php?review=' + reviewID);
    xhr.send();

}

function reviewDeleted() {
    var elem = document.getElementById('pendingReview-' + reviewID);
    return elem.parentNode.removeChild(elem);
}
