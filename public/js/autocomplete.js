var placeSearch, autocomplete;


function initAutocomplete() {
    // Create the autocomplete object, restricting the search to geographical
    // location types.
    autocomplete = new google.maps.places.Autocomplete(
        (document.getElementById('getLocationInput')),
        {types: ['geocode']});
    // When the user selects an address from the dropdown, populate the address
    // fields in the form.
    autocomplete.addListener('place_changed', fillInAddress);
}

function fillInAddress() {
    // Get the place details from the autocomplete object.
    var place = autocomplete.getPlace();


    // Get each component of the address from the place details
    // and fill the corresponding field on the form.

    var getLat = place.geometry.location.lat();
    var getLng = place.geometry.location.lng();
   /* document.querySelector('.getLat').value = getLat;
    document.querySelector('.getLong').value = getLng;*/
    document.getElementById('getLat').value = getLat;
    document.getElementById('getLong').value = getLng;
    document.getElementById('getLatFilter').value = getLat;
    document.getElementById('getLongFilter').value = getLng;

}

// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var geolocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
                center: geolocation,
                radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
        });
    }
}
