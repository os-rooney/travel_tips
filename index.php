<?php
session_start();
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Styles CSS -->
    <link rel="stylesheet" href="./css/styles.css">

    <title>Travel Tips</title>
  </head>
  <body>
    <h1>Travel Tips</h1>
    <form id="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="flex" method="POST">
        <div class="">
            <label class="" for="city">Where do you want to land:</label>
            <div class="">
                <input type="text" class="input-field" name="city" id="city" required>
            </div>
            <div class="">
                <button type="submit" name="save" id="btn">Submit</button>
            </div>
            <?php
            // check if the form is submitted
            if(isset($_POST['save'])){
            $city = htmlspecialchars($_POST['city']);
            // check the input to generate a error message
            // Input should only get letters. 
            if(!preg_match('/^[a-zA-Z]+$/', $city)){
                // create the message content with a msg_type for Bootstrap 5
                $_SESSION['message'] = 'Incorrect input. Enter the name of a city correctly in English.';
                $_SESSION['msg_type'] = 'failure';
                $city = '';
                }
            }
            ?>
        </div>
    </form>


    <!-- formatting/Styling the error message -->
    <?php if(isset($_SESSION['message'])): ?>
        <div>
            <p class="<?= $_SESSION['msg_type']?>">
                <?php
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                ?>
            </p>
        </div>
    <?php else: ?>
        <!-- Show venues -->
        <div class="container">
            <?php 
                if(isset($city)){
                    include 'result.php';
                }
            ?>
        </div>
    <?php endif; ?>
  </body>
</html>
