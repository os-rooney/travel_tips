<?php
// ? Convert Kelvin to Celsius 🤣
function kelvinToCelsius($klevin){
    $celsius = $klevin - 273.15;
    return (int)$celsius;
}

// ? convert Visibility Value to a Weather condition / human readable 🤐
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