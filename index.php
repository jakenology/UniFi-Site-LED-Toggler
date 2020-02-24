<?php
// Required Calls
include('config.php'); // Our Config
require_once('vendor/autoload.php'); // The library

// Create an instance of UniFi and login to the controller
$unifi = new UniFi_API\Client(controller_user, controller_password, controller_url, site_id, controller_version, true);
$unifi->login();

// If the form was submitted...
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Was a site sent?
    if(isset($_POST['site'])) {
        // Set the site
        $unifi->set_site($_POST['site']);

        // Was the toggle selected? 
        if(isset($_POST['toggle'])) {
            $unifi->site_leds(true);
        } else {
            $unifi->site_leds(false);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="EN">
    <head>
        <meta charset="UTF-8">
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
            <p>Please fill out the following information to instantaneously disable that annoying blue LED!</p>
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
                </label>

                <!-- SUBMIT BUTTON -->
                <br><br><input type="submit" value="GO!">
            </form>
        </div>
        <div id="footer">
            <p>&copy; 2020 Jayke Peters</p>
        </div>
    </body>
</html>