<?php
error_reporting(0);
ini_set('display_errors', 0);

// import api keys and Client Secrets
include 'apis.php';

// Foursquare Endpoint
$url = 'https://api.foursquare.com/v2/venues/explore?near=';
$foursquare = $url.$city.'&limit=10&client_id='.$clientId.'&client_secret='.$clientSecret.'&v=20180101';

// OpenWeather Endpoint
$weatherUrl = 'https://api.openweathermap.org/data/2.5/weather';
$openWeather = $weatherUrl. '?&q='.$city.'&APPID='.$openWeatherKey;

/* ***********************************
OpenWeather API call and show Results
************************************ */
$ow = curl_init();

// set the URL and other options
curl_setopt_array($ow, array(
    
));






/* ***********************************
Foursquare API call and show Results
************************************ */
// create a new cURL foursquare resource
$fq = curl_init();

// set the URL and other options
curl_setopt_array($fq, array(
    CURLOPT_URL => $foursquare,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_RETURNTRANSFER => TRUE,
));

// execute and pass the result to browser
$fqresult = json_decode(curl_exec($fq));
// close the cURL resource
curl_close($fq);

// check for empty results
if($fqresult && count((array)$fqresult->response->groups[0]->items) > 0){ 
    // Count found items.
    $count = count((array)$fqresult->response->groups[0]->items); 
    echo '<h3 class="top-att-text">Top '. $count .' attractions in '. $city. '</h3>';
    foreach($fqresult->response->groups[0]->items as $record){
        // Generate a Google maps link
        $lat =  $record->venue->location->lat;
        $lng = $record->venue->location->lng;
        echo '<div class="card">
            <h3 class="card-title">'. $record->venue->name .'</h3>';
        echo '<div class="adress">Adress:<br>';
        foreach($record->venue->location->formattedAddress as $adress){
            echo $adress . '<br>';
        }
        echo '</div>';
        echo'<p class="gmaps"><a href=https://maps.google.com/?q='.$lat.','.$lng. ' target=_blank> Show location on Goolge Maps</a></p>
            </div>';        
    }
} else {
    $_SESSION['message'] = 'Incorrect input. Enter the name of a city correctly in English.';
    $_SESSION['msg_type'] = 'failure';
}