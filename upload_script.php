<?php

require_once __DIR__ . '/vendor/autoload.php';

define('APPLICATION_NAME', 'Drive API PHP');
define('CREDENTIALS_PATH',  __DIR__ . '/credentials/aceess_details.json');
define('CLIENT_SECRET_PATH', __DIR__ . '/credentials/client_secret.json');

$client = new Google_Client();
$client->setApplicationName(APPLICATION_NAME);
$client->addScope("https://www.googleapis.com/auth/drive");
$client->setAuthConfig(CLIENT_SECRET_PATH);
$client->setAccessType('offline');

if (file_exists(CREDENTIALS_PATH)) {

    $accessToken = json_decode(file_get_contents(CREDENTIALS_PATH), true);

}else{
    
    echo "Access token not found, Please create access token\n";
    exit();

}

if(isset($accessToken['error'])){

    echo "Some error occured, Please re-create access token\n";
    exit();

}

$client->setAccessToken($accessToken);

// Refresh the token if it's expired. Create new access and refresh token using existing 
// refresh token and write to aceess details file
if ($client->isAccessTokenExpired()) {

    $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
    file_put_contents(CREDENTIALS_PATH, json_encode($client->getAccessToken()));

}

if(isset($accessToken['error'])){

    echo "Some error occured, Please re-create access token\n";
    exit();

}

// Check if any file path given to upload.
if (defined('STDIN') && isset($argv[1])) {
  
    $filepath = $argv[1];

} else { 
  
    //set default file for upload.
    $filepath = __DIR__ . '/drive_upload_files/default.txt';

}

if (!file_exists($filepath)) {

  echo "File not found\n";
  exit();

}

// Upload to specfic folder(db_backups)
$folderId = "1nbqDBYti8NRIMHDU7VxQbUduHBiPfLJN";
$service = new Google_Service_Drive($client);
$file = new Google_Service_Drive_DriveFile(array('parents' => array($folderId)));
$file->name = basename($filepath);;
$chunkSizeBytes = 256 * 1024;

// Call the API with the media upload, defer so it doesn't immediately return.
$client->setDefer(true);
$request = $service->files->create($file);

// Create a media file upload to represent our upload process.
$media = new Google_Http_MediaFileUpload($client, $request, 'text/plain', null, true, $chunkSizeBytes);
$media->setFileSize(filesize($filepath));

// Upload as various chunks.
$status = false;
$handle = fopen($filepath, "rb");
while (!$status && !feof($handle)) {

    $chunk = readChunk($handle, $chunkSizeBytes);
    if($chunk == ""){
        echo "Empty file, can't upload\n";
        exit();
    }
    $status = $media->nextChunk($chunk);

}

if ($status != false) {

    echo "File upload completed\n";

}else{
  
    echo "Some error occured, File upload not completed\n";

}


fclose($handle);

/**
 * Split files to chunks
 * @param string file pointer
 * @param int chunk size
 * @return string chunk data.
 */
function readChunk ($handle, $chunkSize)
{
  $byteCount = 0;
  $giantChunk = "";
  while (!feof($handle)) {
      // fread will never return more than 262144 bytes(256KB) if the stream is read buffered and it does not represent a plain file
      $chunk = fread($handle, 262144);
      $byteCount += strlen($chunk);
      $giantChunk .= $chunk;
      if ($byteCount >= $chunkSize)
      {
          return $giantChunk;
      }
  }
  return $giantChunk;
}