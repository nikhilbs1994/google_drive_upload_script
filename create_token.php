<?php


require_once __DIR__ . '/vendor/autoload.php';


define('APPLICATION_NAME', 'Drive API PHP Quickstart');
define('CREDENTIALS_PATH',  __DIR__ . '/credentials/aceess_details.json');
define('CLIENT_SECRET_PATH', __DIR__ . '/credentials/client_secret.json');


$client = new Google_Client();
$client->setApplicationName(APPLICATION_NAME);
$client->addScope("https://www.googleapis.com/auth/drive");
$client->setAuthConfig(CLIENT_SECRET_PATH);
$client->setAccessType('offline');

$authUrl = $client->createAuthUrl();
printf("Open the following link in your browser:\n%s\n", $authUrl);
print 'Enter verification code: ';
$authCode = trim(fgets(STDIN));

$accessToken = $client->fetchAccessTokenWithAuthCode($authCode);


if(!file_exists(dirname(CREDENTIALS_PATH))) {
  mkdir(dirname(CREDENTIALS_PATH), 0700, true);
}

file_put_contents(CREDENTIALS_PATH, json_encode($accessToken));
printf("Credentials saved to %s\n", CREDENTIALS_PATH);

?>