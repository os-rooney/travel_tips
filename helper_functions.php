<?php
// ? Convert Kelvin to Celsius
function kelvinToCelsius($klevin){
    $celsius = $klevin - 273.15;
    return (int)$celsius;
}

// ? convert Visibility Value to a Weather condition / human readable
function VisibilitySignificance($val){
    $result = match(true){
        $val <= 1000 => 'Light fog',
        $val > 1000 && $val <= 2800 => 'Thin fog',
        $val > 2800 && $val <= 5900 => 'Haze',
        $val > 5900 && $val <= 10000 => 'Light haze',
        $val > 10000 && $val <= 20000 => 'Clear'
    }; 
    return $result;
}

// ? check humidity levels to scale
function humidity($val){
    $result = match(true){
        $val >= 0 && $val <= 20 => 'Uncomfortably Dry',
        $val > 20 && $val <= 60 => 'Comfort Range',
        $val > 60 && $val <= 100 => 'Uncomfortably Wet'
    };
    return $result;
}

// ? get the country name from the iso2 result of openweather
function getCountry($val){
    $countryURL = 'https://api.covid19api.com/countries';
        // Create a new CURL to get country name from its ISO2 form covid19api
        $country = curl_init();

        // set URL
        curl_setopt_array($country, array(
            CURLOPT_URL => $countryURL,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_RETURNTRANSFER => TRUE,
        ));

        // execute and pass the result to browser
        $countryResult = json_decode(curl_exec($country));
        // close the CURL resource
        curl_close($country);
        foreach($countryResult as $res){
            if($val == $res->ISO2){
                return $countryName =  $res->Country;
            }
        }


}