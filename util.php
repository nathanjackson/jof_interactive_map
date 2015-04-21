<?php

/// Converts an address into latitude and longitude coordinates.
function get_lat_long($address){

    $encoded_address = urlencode($address);

    $json = file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?address=$encoded_address&sensor=false");
    $json = json_decode($json);

    if(count($json->{'results'}) == 0) {
        throw new Exception("Failed to geocode.");
    }

    $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
    $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
    $LatLng = array($lat, $long);
    return $LatLng;
}
