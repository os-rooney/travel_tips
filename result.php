<?php
error_reporting(0);
ini_set('display_errors', 0);
include 'helper_functions.php';

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
// Create a new CURL forsquare resource 
$ow = curl_init();

// set URL
curl_setopt_array($ow, array(
    CURLOPT_URL => $openWeather,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_RETURNTRANSFER => TRUE,
));

// execute and pass the result to browser
$owresult = json_decode(curl_exec($ow));
// close the CURL resource
curl_close($ow);

// save results
$temp = kelvinToCelsius($owresult->main->temp) . "&deg;";
$feelsLike = kelvinToCelsius($owresult->main->feels_like). "&deg;";
$tempMin = kelvinToCelsius($owresult->main->temp_min) . "&deg;";
$tempMax = kelvinToCelsius($owresult->main->temp_max) . "&deg;";
$humidity = $owresult->main->humidity . ' / ' . humidity($owresult->main->humidity);
$sunrise= date('H:i', $owresult->sys->sunrise);
$sunset= date('H:i', $owresult->sys->sunset);
$visibility = VisibilitySignificance($owresult->visibility);
$mainWeather =  $owresult->weather[0]->main;
$discWeather = $owresult->weather[0]->description;
$country = $owresult->sys->country;
$countryName = getCountry($country);

if($owresult){
    echo '<div class="wrapper">';
    echo '<div class="weather">';
    echo '<h2 class="weather">Weather Report</h2>';
    echo '<div class="weather-card">';
    echo '<h4>Actuell weather report of ' . $city . ' / '. $countryName . '</h4>';
    echo '<div class="weather-info">';
    echo '<div class="main-weather-val bold">'. $mainWeather .'</div>';
    echo '<div class="discription-weather-val">'. $discWeather .'</div>';
    echo '<div class="temp">temperature / feels like: </div>';
    echo '<div class="temp-val bold">'. $temp . ' / '. $feelsLike .'</div>';
    echo '<div class="temp-min-max">min./max. temperature:</div>';
    echo '<div class="temp-min-val bold">'. $tempMin . ' / ' . $tempMax .'</div>';
    echo '<div class="humidity">humidity:</div>';
    echo '<div class="humidity-val">'. $humidity .'</div>';
    echo '<div class="sun">sunrise / sunset:</div>';
    echo '<div class="sun-val bold">'. $sunrise . ' / ' . $sunset .'</div>';
    echo '<div class="visibility">visibility:</div>';
    echo '<div class="visibility-val">'. $visibility .'</div>';
    echo '</div>';
     // end ofweather-card
    echo '</div>';
    // end of weather class
    echo '</div>';

    // covid19api
    $covidUrl = 'https://api.covid19api.com/total/country/' . $countryName . '/status/confirmed';
    $cov = curl_init();
    curl_setopt_array($cov, array(
        CURLOPT_URL => $covidUrl,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_RETURNTRANSFER => TRUE,
    ));
    $covidResult = json_decode(curl_exec($cov));
    curl_close($cov);
    $days = count($covidResult);
    $casesActuell = $covidResult[$days - 1]->Cases - $covidResult[$days - 2]->Cases;
    $date = new DateTime($covidResult[$days - 1]->Date);
    $lastUpdate = $date->format('H:i, Y-m-d'); 

    if($casesActuell > 0){
       $casesSpanClass = "danger";
    } else {
       $casesSpanClass = "success"; 
    }

    echo '<div class="covid-container">';
    echo '<h4>Actuell Covid19 Cases</h4>';
    echo '<div class="covid">';
    echo '<div class="cases">actuell cases: <span class="'. $casesSpanClass .'">'. $casesActuell .'</span></div>';
    echo '<div class="lastupdate">last updated: '. $lastUpdate .'</div>';
    echo '</div>';
    echo '</div>';

    
    // end of wrapper class
    echo '</div>';
}

/* ***********************************
Foursquare API call and show Results
************************************ */
// create a new CURL foursquare resource
$fq = curl_init();

// set the URL and other options
curl_setopt_array($fq, array(
    CURLOPT_URL => $foursquare,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_RETURNTRANSFER => TRUE,
));

// execute and pass the result to browser
$fqresult = json_decode(curl_exec($fq));
// close the CURL resource
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


