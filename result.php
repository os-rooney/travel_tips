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

// create a new cURL resource
$curl = curl_init();

// set the URL and other options
curl_setopt_array($curl, array(
    CURLOPT_URL => $foursquare,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_RETURNTRANSFER => TRUE,
));

// execute and pass the result to browser
$fqresult = json_decode(curl_exec($curl));
// close the cURL resource
curl_close($curl);

// check for empty results
if($fqresult || strlen(trim($fqresult)) === 0){    
    foreach($fqresult->response->groups[0]->items as $record){
        echo '<div>
        
        </div>';





        echo $record->venue->name . '<br>';
        // display the formatted Adress of venue
        foreach($record->venue->location->formattedAddress as $adress){
            echo $adress . '<br>';
        }
        // Generate a Google maps link
        $lat =  $record->venue->location->lat;
        $lng = $record->venue->location->lng;
        echo 'Show location on Google Maps:';
        echo "<a href=https://maps.google.com/?q=$lat,$lng target=_blank> Click here</a>";
        echo '<br><br>';
    }
} else {
    $_SESSION['message'] = 'Incorrect input. Enter the name of a city correctly in English.';
    $_SESSION['msg_type'] = 'danger';
}