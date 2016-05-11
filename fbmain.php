<?php

date_default_timezone_set('UTC'); 

require('vendor/autoload.php');

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequestException;
use Facebook\FacebookRequest;
use Facebook\HttpClients\FacebookGuzzleHttpClient;

// Set Facebook App ID, App Secret and Site URL
$_CONFIG = [
    'appid' => getenv('FB_APPID') ?: '',
    'secret' => getenv('FB_SECRET') ?: '',
    'site_url' => getenv('SITE_URL') ?: '',
    'access_token_key_prefix' => 'fbat_'
];

$access_token_key = $_CONFIG['access_token_key_prefix'] . $_CONFIG['appid'];

session_start();

// Setup application
FacebookSession::setDefaultApplication($_CONFIG['appid'], $_CONFIG['secret']);
FacebookRequest::setHttpClientHandler(new FacebookGuzzleHttpClient());

// Get the helper
$helper = new FacebookRedirectLoginHelper($_CONFIG['site_url']);

// Attempt to retrieve a session
if (isset($_GET['code'])) {
    $session = $helper->getSessionFromRedirect();

    if (!is_null($session)) {
        $_SESSION[$access_token_key] = $session->getToken();
    }

    header('Location: ' . $_CONFIG['site_url']);
}
if (isset($_SESSION[$access_token_key])) {
    $session = new FacebookSession($_SESSION[$access_token_key]);

    try {
        $session->validate();
    } catch (FacebookSDKException $e) {
        $session = null;
    }
}

if (is_null($session)) {
    header('Location:' . $helper->getLoginUrl(['publish_actions']));
    exit;
}

$user_profile = (new FacebookRequest($session, 'GET', '/me'))->execute()->getGraphObject('Facebook\GraphUser')->asArray();

// Generate an aleatory code to obtain always pics with different names
function code($length) {
	$pattern = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
	$max = strlen($pattern) - 1;
    $key = '';
	for ($i = 0; $i < $length; $i++) {
        $key .= $pattern[rand(0,$max)];
    }

	return $key;
}

// Call to 'code' function with 10 aleatory characters
$code2 = code(10);

// Start the upload
if (isset($_POST['action']) && $_POST['action'] == "upload_fb_image") {
	$message = ($_POST['message'] == 'Add a description...') ? 'This photo was created with the Cool Photos application. You can purchase the App here: http://bit.ly/U8onY1' : $_POST['message'];

	// Start the code to change the original image
	$res = json_decode(stripslashes($_POST['jsondata']), true);
	// Get data
	$count_images = count($res['images']);
	$background = str_replace($_CONFIG['site_url'], '', $_POST['photo']);
	$photo_data = getimagesize($background);
	$parts = explode(".", $background);
	$ext = end($parts);

	switch($ext){
		case "gif":
			$photo1	= imagecreatefromgif($background);
		break;
		case "jpg":
			$photo1	= imagecreatefromjpeg($background);
		break;
		case "jpeg":
			$photo1	= imagecreatefromjpeg($background);
		break;
		case "png":
			$photo1	= imagecreatefrompng($background);
		break;
	}

	$photo1W = imagesx($photo1);
	$photo1H = imagesy($photo1);
	$photoFrameW = $photo_data[0];
	$photoFrameH = $photo_data[1];
	$photoFrame = imagecreatetruecolor($photoFrameW,$photoFrameH);
	imagecopyresampled($photoFrame, $photo1, 0, 0, 0, 0, $photoFrameW, $photoFrameH, $photo1W, $photo1H);

	// The other images
	for($i = 1; $i < $count_images; ++$i){
		$insert = $res['images'][$i]['src'];
		$photoFrame2Rotation = (180-$res['images'][$i]['rotation']) + 180;
		$photo2 = imagecreatefrompng($insert);
		$photo2W = imagesx($photo2);
		$photo2H = imagesy($photo2);
		$photoFrame2W = $res['images'][$i]['width'];
		$photoFrame2H = $res['images'][$i]['height'];
		$photoFrame2TOP = $res['images'][$i]['top'];
		$photoFrame2LEFT= $res['images'][$i]['left'];
		$photoFrame2 = imagecreatetruecolor($photoFrame2W,$photoFrame2H);
		$trans_colour = imagecolorallocatealpha($photoFrame2, 0, 0, 0, 127);
		imagefill($photoFrame2, 0, 0, $trans_colour);
		imagecopyresampled($photoFrame2, $photo2, 0, 0, 0, 0, $photoFrame2W, $photoFrame2H, $photo2W, $photo2H);
		$photoFrame2 = imagerotate($photoFrame2,$photoFrame2Rotation, -1,0);
		// After rotating calculate the difference of new height/width with the one before
		$extraTop =(imagesy($photoFrame2)-$photoFrame2H)/2;
		$extraLeft =(imagesx($photoFrame2)-$photoFrame2W)/2;
		imagecopy($photoFrame, $photoFrame2,$photoFrame2LEFT-$extraLeft, $photoFrame2TOP-$extraTop, 0, 0, imagesx($photoFrame2), imagesy($photoFrame2));
	}

	// Save the new modificated picture in fb_images
	imagejpeg($photoFrame, "fb_images/$code2.jpg");

	// The relative path to the file
	$file = realpath("fb_images/".$code2.".jpg");

        try {
            $response = (new FacebookRequest($session, 'POST', '/me/photos', [
                'source' => fopen($file, 'r'),
                'message' => $message
            ]))->execute();

            $success = 'true';
        } catch (FacebookRequestException $e) {
            $success = 'false';
        }

	$parts = explode("/", $background);

	unlink("fb_images/".end($parts));
	unlink("fb_images/".$code2.".jpg");

	header("Location: index.php?res=$success");
}
