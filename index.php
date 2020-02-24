<?php
// Required Calls
include('config.php'); // Our Config
require_once('vendor/autoload.php'); // The library

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
            echo '<h1 style="color: red;">LEDs ON!</h1>';
        } else {
            $unifi->site_leds(false);
            echo '<h1 style="color: red;">LEDs OFF!</h1>';
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
                background-color: gainsboro;
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
            }
        </style>
    </head>
    <body>
        <div>
            <img id="unifi_logo" src="https://dl.ubnt.com/press/logo-UniFi.png">
            <h1 id="header">Site LED Toggler</h1>
        </div>
        <div id="content">
            <p>Please fill out the following information to instantaneously disable those annoying blue LEDs on all APs!</p>
            <form action="" method="post">
                <!-- Site selector -->
                <label for="site">Site Name</label><br>
                <select name="site" id="site" required>
                    <?php 
                        // Get the sites, remove default
                        $sites = $unifi->list_sites();
                        unset($sites[0]);

                    ?>
                    <?php foreach($sites as $site): ?>
                    <option value="<?php echo $site->name;?>"><?php echo $site->desc;?></option>
                    <?php endforeach;?>
                    <option value="" selected disabled>Select a site</option>
                </select>

                <!-- Intent selector -->
                <p>Toggle Toggle!</p>
                <label class="switch">
                    <input name="toggle" type="checkbox">
                    <span class="slider round"></span>
                </label><br><br>
                
                <!-- PIN -->
                <label for="pin">Enter PIN</lable><br>
                <input name="pin" type="password" pattern="[0-9]*" minlength="4" maxlength="4" inputmode="numeric" required>

                <!-- SUBMIT BUTTON -->
                <br><br><input type="submit" value="GO!">
            </form>
        </div>
        <div id="footer">
            <p>&copy; 2020 Jayke Peters</p>
        </div>
    </body>
</html>
