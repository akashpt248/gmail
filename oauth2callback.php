<?php
require 'vendor/autoload.php';
use Google\Client;
use Dotenv\Dotenv;

// Load .env
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Init client
$client = new Client();
$client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
$client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
$client->setRedirectUri($_ENV['GOOGLE_REDIRECT_URI']); // Will update this below
$client->addScope('https://www.googleapis.com/auth/gmail.readonly');

// Handle auth code
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    
    if (isset($token['access_token'])) {
        echo "<h2> Access Token Received</h2><pre>";
        print_r($token);
        echo "</pre>";
    } else {
        echo "<h2>❌ Error fetching token</h2><pre>";
        print_r($token);
        echo "</pre>";
    }
} else {
    echo "No code parameter found.";
}
