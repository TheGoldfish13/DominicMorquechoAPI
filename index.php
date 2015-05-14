<?php 
//configuration for our  PHP server
set_time_limit(0); /*set time limit as 0*/
ini_set('default_socket_timeout', 300); 
session_start(); /*start session*/

//make constants using define
define('clientID', '2ece9bd35d2e4598a98df7ef7a84bc30');
define('clientSecret', 'b5d576a86043439ca6a79447ce8a1b64');
define('redirectURI', 'http://localhost/DominicMorquechoAPI/index.php');
define('ImageDirectory', 'pics/');

/*function that  is going to connect to instagram*/
function connectToInstagram($url){
	$ch = curl_init();

	curl_setopt_array($ch, array(
			CURLOPT_URL =>$url,
			CURLOPT_RETURNTRANSFER =>true,
			CURLOPT_SSL_VERIFYPEER =>false,
			CURLOPT_SSL_VERIFYHOST =>2,
		));
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}
/*function to get UserID because we need it to get pictures*/
function getUserID($userName){
	$url = 'https://api.instagram.com/v1/users/search?q=' . $userName . '&client_id=' . clientID; /*is this supposed to be captial N?*/
	$instagramInfo = connectToInstagram($url);
	$results = json_decode($instagramInfo, true);


	return $results['data']['0']['id'];
}
//function to print out images to our screen 
function printImages($userID){
	$url = 'https://api.instagram.com/v1/users/' . $userID . '/media/recent?client_id=' . clientID . '&count=5'; /*request last 5 picsfrom ig*/
	$instagramInfo = connectToInstagram($url);
	$results = json_decode($instagramInfo, true);
	//parse through the info one at a time
	foreach ($results['data'] as $items) {
		$image_url = $items['images']['low_resolution']['url']; /*go through results and bring back url of pics to save in PHP server*/
		echo '<img src=" '.$image_url.'"/><br/>';
	}
}




if(isset($_GET['code'])){ /*setting up array to acess ['code']*/
	$code = ($_GET['code']);
	$url = 'https://api.instagram.com/oauth/access_token';
	$access_token_settings = array('client_id' => clientID, 
									'client_secret' => clientSecret,
									'grant_type' => 'authorization_code',
									'redirect_uri' => redirectURI,
									'code' => $code
									);

//cURL is what we use in php, its a library that calls to other API's
$curl = curl_init($url); /*setting a cURL session and put in in $curl because thats were we are getting data from*/
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $access_token_settings); /*setting the postfields to the array setup that we made*/
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); /*setting it equal to 1 because we are getting strings back*/
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); /*but in live work-production we want this to be true*/


$result = curl_exec($curl);
curl_close($curl); /*close the session*/

$results = json_decode($result, true);

$userName = $results['user']['username'];

$userID = getUserID($userName);

printImages($userID);
}

else{

 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<meta name="viewport" content="width=device-width, initial-scale=1">
 	<title></title>
 	<!-- <link rel="stylesheet" href="css/main.css"> -->
 </head>
 <body>
 <!-- login for people to aprove our app access to instagram
 after getting aproval we have info to play with -->
 	<a href="https:api.instagram.com/oauth/authorize/?client_id=<?php echo clientID; ?>&redirect_uri=<?php echo redirectURI; ?>&response_type=code">Login</a>
 
 </body>
 </html>

 <?php } ?>

