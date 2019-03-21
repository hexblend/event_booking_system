function ajaxSearch() {
    var xhr = new XMLHttpRequest();
    var search = document.getElementById("search").value;
    xhr.addEventListener ("load", responseReceived);
    xhr.open('GET', '/features/venues/search.php?search=' + search);
    xhr.send();
}
function responseReceived(e) {
    document.getElementById('venues').innerHTML = e.target.responseText;
}

