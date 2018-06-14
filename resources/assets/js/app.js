/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.initMap = function () {
    let brasil = {lat: -10.6558907, lng: -58.7343253};
    window.mainMap = new google.maps.Map(document.getElementById('map'), {
        zoom: 4,
        center: brasil
    });

    loadTrips(window.trips);
};

function loadTrips(trips) {
    let locations = [];
    for (let i = trips.length - 1; i >= 0; i--) {
        locations[i * 2] = [trips[i]['end_address_lat'], trips[i]['end_address_lng']];
        locations[i * 2 + 1] = [trips[i]['start_address_lat'], trips[i]['start_address_lng']];
    }

    let markers = trips.map(function (location) {
        return new google.maps.Marker({
            position: location,
            map: window.mainMap
        });
    });

    new MarkerClusterer(map, markers,
        {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
};