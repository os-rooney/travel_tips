<?php
session_start();
$_SESSION['message'];
$_SESSION['msg_type'];
// Foursquare API Info
$clientId = '';
$clientSecret = '';
$url = 'https://api.foursquare.com/v2/venues/explore?near=';
//$urlToFetch = '$url$city&limit=10&client_id=$clientId&client_secret=$clientSecret&v=20180101';


// OpenWeather Info
$openWeatherKey = '';
$weatherUrl = 'https://api.openweathermap.org/data/2.5/weather';
// JS urlToFetch = `${weatherUrl}?&q=${$input.val()}&APPID=${openWeatherKey}`


?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Styles CSS -->
    <link rel="stylesheet" href="./css/styles.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Travel Tips</title>
  </head>
  <body>
    <h1>Travel Tips</h1>
    <form id="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="container position-relative" method="POST">
        <div class="row position-absolute top-100 start-50 translate-middle">
            <label class="mb-1" for="city">Where do you want to land:</label>
            <div class="col-9">
                <input type="text" class="form-control" name="city" id="city" required>
            </div>
            <div class="col-3 d-flex align-items-center">
                <button type="submit" name="save">Submit</button>
            </div>
            <?php
            // check if the form is submitted
            if(isset($_POST['save'])){
            $city = htmlspecialchars($_POST['city']);
            // check the input to generate a error message
            // Input should only get letters. 
            if(!preg_match('/^[a-zA-Z]+$/', $city)){
                // create the message content with a msg_type for Bootstrap 5
                $_SESSION['message'] = 'Falsche Eingabe. Geben Sie den Namen einer Stadt ein.';
                $_SESSION['msg_type'] = 'danger';
                }
            }
            ?>
            <!-- formatting/Styling the error message -->
            <?php if(isset($_SESSION['message'])): ?>
                <div class="alert alert-<?= $_SESSION['msg_type']?> position-absolute top-100 start-80 mt-3 text-center">
            <?php
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            ?>
                </div>
            <?php endif; ?>
        </div>
    </form>

    

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>
