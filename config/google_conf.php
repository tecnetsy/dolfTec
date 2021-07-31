<?php
//Include Google Client Library for PHP autoload file
require_once './vendor/autoload.php';


//Make object of Google API Client for call Google API
$google_client = new Google_Client();

//Set the OAuth 2.0 Client ID
$google_client->setClientId('485384502210-e574ldtp88qhq17fshohtugdm4io1pm9.apps.googleusercontent.com');

//Set the OAuth 2.0 Client Secret key
$google_client->setClientSecret('SYa2E7qxJf0wBPYwRIJxubkd');

//Set the OAuth 2.0 Redirect URI
$google_client->setRedirectUri('http://localhost/dolf/index.php');

//
$google_client->addScope('email');
//$google_client->addScope('user.phonenumbers.read');
$google_client->addScope('profile');