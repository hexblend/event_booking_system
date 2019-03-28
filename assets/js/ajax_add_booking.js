function ajaxAddBooking(id, venue_id, day_of_month, avail){
    ID = id;
    var venueID = venue_id;
    dayofmonth = day_of_month;
    noOfSeats = document.getElementById('no_of_seats-' + ID).value;

    var xhr = new XMLHttpRequest();
    xhr.addEventListener("load", bookingReceived)
    xhr.open("GET", "features/bookings/add.php?venue_id=" + venueID + "&day_of_month=" + dayofmonth + "&no_of_seats=" + noOfSeats);
    xhr.send();

    // Hide Booking Form after booking
    var bookingForm = document.getElementById('booking-form-' + ID);
    bookingForm.parentNode.removeChild(bookingForm);
}

function bookingReceived(e){
    return document.getElementById('seats_available-' + ID).innerHTML = e.target.response;
}
