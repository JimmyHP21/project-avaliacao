var checkedSpotlight = false;

if (document.getElementById('spotlight').checked === true ) {
    document.getElementById('spotlight-div').hidden = false
}


$('#spotlight').click(function() {
    if (document.getElementById('spotlight').checked === true) {
        document.getElementById('spotlight-div').hidden = false
    } else {
        document.getElementById('spotlight-div').hidden = true
    }
});
