var pending_reviews_number = document.getElementById("reviewsNumber").value;

function decreasePendingReviews(){
    pending_reviews_number--;
    if (pending_reviews_number == 0) {
        document.getElementById("reviews_number").innerText = 'No pending reviews';
    } else {
        document.getElementById("reviews_number").innerText = 'Pending reviews (' + pending_reviews_number + '):';
    }
}

function increasePendingReviews(){
    pending_reviews_number++;
    document.getElementById("reviews_number").innerText = 'Pending reviews (' + pending_reviews_number + '):';
}


