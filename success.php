<!DOCTYPE html>
<html lang="EN">
    <head>
        <meta charset="UTF-8">
        <title>Success!</title>
        <!-- Custom Google Font -->
        <link href="https://fonts.googleapis.com/css?family=Rubik&display=swap" rel="stylesheet">
        <style>
        body {
            height: 100%;
            background-image: linear-gradient(to top, #09203f 0%, #537895 100%);
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: 'Rubik';
        }
        .center {
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        #msg {
            text-align: center;
            color: lime;
        }
        #image {
            border-radius: 50px;
        }
        #stat {
            color: red;
            text-align: center;
        }
        </style>
    </head>
    <body>
        <h1 id="msg">Success!</h1>
        <!-- <img width="250" class="center" src="https://cdn1.iconfinder.com/data/icons/interface-elements/32/accept-circle-512.png"> -->
        <img id="image" class="center" width="300" src="https://media2.giphy.com/media/aljcGvTYiyaJy/giphy.gif">
        <h3 id="stat">The LEDs for site ID <span style="color: blue;"><?=$unifi->get_site()?></span> have been turned 
        <span style="color: blue; text-decoration: underline;"><?php 
            if($state === 0) {
                echo 'off';
            } else {
                echo 'on';
            }
        ?></span></h3>
    </body>
</html>