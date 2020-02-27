<?php
// Required Calls
include('config.php'); // Our Config
include('htmllib.php'); // PHP Print Library
require_once('vendor/autoload.php'); // The library

// Some functions, to be an a "core.php" later
function printOption($name, $content, $selected = FALSE) {
    echo "<option name=\"$name\">$content</option>";
}

/*function checkFormSubmitted($method, $parameters) {
    $counter = 0;
    if($_SERVER['REQUEST_METHOD'] == strtoupper($method)) {
        foreach($parameters as $parameter) {
            if(isset($_paramater))
        }
        if($counter > 0) {
            return TRUE;
        }
    } else {
        return FALSE;
    }
}*/

// Create an instance of UniFi and login to the controller
$unifi = new UniFi_API\Client(controller_user, controller_password, controller_url, site_id, controller_version, true);
$unifi->login();

// If the form was submitted...
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Was a site and a pin sent?
    if(isset($_POST['site']) && isset($_POST['pin'])) {
        // Check that the pin is valid
        $pin = (integer) $_POST['pin'];
        if($pin !== PIN) {
            echo '<h1 style="color: red";>INVALID PIN!</h1>';
            die;
        }
        
        // Set the site
        $unifi->set_site($_POST['site']);

        // Was the toggle selected? 
        if(isset($_POST['toggle'])) {
            $unifi->site_leds(true);
            //echo '<h1 style="color: red;">LEDs ON!</h1>';
            $state = 1;
            include('success.php');
            exit;

        } else {
            $unifi->site_leds(false);
           // echo '<h1 style="color: red;">LEDs OFF!</h1>';
            $state = 0;
            include('success.php');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="EN">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Site LED Toggler</title>
        <!-- Custom Google Font -->
        <link href="https://fonts.googleapis.com/css?family=Rubik&display=swap" rel="stylesheet">
        <!-- TOGGLE CSS -->
        <link rel="stylesheet" href="toggle.css">
        <style>
            body {
                color: white;
                background: url('https://miro.medium.com/max/1024/1*9WeJrBj6pp-qnGjRGg2NUw.png') no-repeat center center fixed; 
                background-size: cover;
                font-family: 'Rubik';
            }
            #header {
                color: blue;
                text-align: center;
            }
            #unifi_logo {
                display: block;
                margin-left: auto;
                margin-right: auto;
                width: 250px;
            }
            #content {
                margin: 0 auto;
                width: 50%;
                border: 5px solid blue;
                border-radius: 10px;
                padding: 5px;
                background-color: rgba(0, 0, 0, 0.5);
            }
            #navigation {
                float: left;
                display: inline;
                /*border: 5px solid blue;
                border-radius: 360px;*/
                padding: 5px;
                position: absolute; /* Keeps UniFi logo centered */
            }
            #navigation:hover {
                background-color: gray;
                border-radius: 360px;
            }
            .footer {
                position: fixed;
                left: 0;
                bottom: 0;
                width: 100%;
                background-color: blue;
                color: white;
                text-align: center;
            }
            .form-help-text {
                color: blue;
                font-weight: bold;
                text-decoration: underline;
            }
        </style>
    </head>
    <body style="clear: left;">
        <div id="navigation">
            <a href="https://www.bluejayit.com/products/mns/"><img width="50" src="https://image.flaticon.com/icons/svg/25/25694.svg"></a>        </div>
        <div>
            <a href="<?=controller_url?>"><img id="unifi_logo" src="https://dl.ubnt.com/press/logo-UniFi.png"></a>
            <h1 id="header">Site LED Toggler</h1>
        </div>
        <div id="content">
            <p>Please fill out the following information to instantaneously disable those annoying blue LEDs on all APs!</p>
            <form action="" method="post" autocomplete="off">
                <!-- Site selector -->
                <label class="form-help-text" for="site">Site Name</label><br>
                <select name="site" id="site" required>
                    <?php 
                        // Get the sites, remove default
                        if(!defined(site_id)) {
                            $sites = $unifi->list_sites();
                            unset($sites[0]);
                        } else {
                            $sites = NULL;
                        }
                    ?>
                    <?php 
                        foreach($sites as $site): 
                    ?>
                    <option value="<?php echo $site->name;?>"><?php echo $site->desc;?></option>
                    <?php endforeach;?>
                    <option value="" selected disabled>Select a site</option>
                </select>

                <!-- Intent selector -->
                <p class="form-help-text">Toggle Toggle!</p>
                <label class="switch">
                    <input name="toggle" type="checkbox">
                    <span class="slider round"></span>
                </label><br><br>
                
                <!-- PIN -->
                <label class="form-help-text" for="pin">Enter PIN</lable><br>
                <input name="pin" type="password" pattern="[0-9]*" minlength="4" maxlength="4" inputmode="numeric" required>

                <!-- SUBMIT BUTTON -->
                <br><br><input type="submit" value="GO!">
            </form>
        </div>
        <div class="footer">
            <p>&copy; Copyright <?=date('Y')?> Jayke Peters</p>
        </div>
    </body>
</html>