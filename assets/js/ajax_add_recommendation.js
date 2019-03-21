function ajaxAddRec(venue_id, recs){
    venueID = venue_id;
    recommendations = recs;
    outputDiv = document.getElementById("rec-" + venueID);
    var xhr = new XMLHttpRequest();
    xhr.addEventListener("load", recReceived)
    xhr.open("GET", "features/recommendations/add.php?venue_id=" + venueID + "&recs=" + recommendations);
    if (outputDiv.classList.contains('badge-danger')) {
        outputDiv.classList.remove('badge-danger');
        outputDiv.classList.add('badge-success');
    }
    xhr.send();
}

function recReceived(e){
    outputDiv.innerHTML = e.target.response;
}
