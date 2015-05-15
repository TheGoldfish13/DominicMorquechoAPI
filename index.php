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
	$url = 'https://api.instagram.com/v1/users/' . $userID . '/media/recent?client_id=' . clientID . '&count=3'; /*request last 5 picsfrom ig*/
	$instagramInfo = connectToInstagram($url);
	$results = json_decode($instagramInfo, true);
	//parse through the info one at a time
	foreach ($results['data'] as $items) {
		$image_url = $items['images']['low_resolution']['url']; /*go through results and bring back url of pics to save in PHP server*/
		echo '<img src=" '.$image_url.'"class="test"/><br/>';
		//callin a function tp save $image_url
		savePictures($image_url);
	}
}
//creating a function to save image to server
function savePictures($image_url){
	/*echo $image_url . '<br>';*/
	$filename = basename($image_url);  /*the filename is what we storing basename is PHP built in method that we using to store $image_url*/
	/*echo $filename . '<br>';*/

	$destination = ImageDirectory . $filename; /*making sure image doesnt exist in the storage*/
	file_put_contents($destination, file_get_contents($image_url)); /*grabs imagefile and storesit in server*/
}



if(isset($_GET['code'])){ /*if you have logged in*/  
	$code = ($_GET['code']); /*set these variables*/
	$url = 'https://api.instagram.com/oauth/access_token';
	$access_token_settings = array('client_id' => clientID, /*and this array for connecting to instagram*/
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

?>
 <html>
 <head>
 	<title> Roger senpai!!!!</title>
 	<link rel="stylesheet" type="text/css" href="css/main.css"/>
 	<link href='http://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
 	<link href='http://fonts.googleapis.com/css?family=Redressed' rel='stylesheet' type='text/css'>
 	<meta name="viewport" content="width=device-width, initial-scale=1">
<div id="scrollbardolliecrave">
</div>
<style> /*this is really ugly code for the scrollbar that im too afraid to put in css*/
	::-webkit-scrollbar-button:start:decrement 
	{background-image: url(http://www.dolliehost.com/dolliecrave/scrollbars/arrowup.png);
	background-repeat: no-repeat;background-position:center;
        -webkit-box-shadow: inset 0 0 16px rgba(214,214,214,0.9);}
	::-webkit-scrollbar-thumb {
	background-color:transparent;
        -webkit-box-shadow: inset 0 0 16px rgba(192,192,192,0.9);
        background:url(http://www.dolliehost.com/dolliecrave/backgrounds/pretty2/59.gif); 
        background-size: 300% auto;
	border-left:0px solid #E5E5E5;
	border-right:0px solid #E5E5E5;
	border-bottom:0px solid #E5E5E5;
	border-top:0px solid #E5E5E5;
	border-radius:0%;
	}
	#scrollbardolliecrave {
	width:96px;
	height:20px;
	position: fixed;    
	left: 0px;    
	bottom: 0px;
	}
	::-webkit-scrollbar-track {
        background:url(http://www.dolliehost.com/dolliecrave/scrollbars/track.png); 
	border-radius:0%;
	}
</style>

 </head>
 <body>
 <div id="bunnybox"> <!-- bunny gifs -->
 	<img src="http://media.giphy.com/media/h7KMmkYUcbPQQ/giphy.gif" id="bunny">
 	<div id="rogertrust">
 		In Roger Kim We Trust
 	</div>
	<img src="http://media.giphy.com/media/h7KMmkYUcbPQQ/giphy.gif" id="rightbunny">
</div>	
 <?php

$result = curl_exec($curl);
curl_close($curl); /*close the session*/

$results = json_decode($result, true);

$userName = $results['user']['username'];

$userID = getUserID($userName);

printImages($userID); /*this is where the imagesare printed to out website*/
?>
		<div id="rogerpoem">
			What is Reality? <br>
			Roger Kim is reality <br>
			He is our religion <br>
			He is our God <br>
			He has a great bod <br>
			and a holy rod <br>
			he is great in bed <br>
			it would be an honor <br>
			to give him head <br>
			No Kpopstar can measure up to him <br>
			The one and only ROGER KIM. <br>
			-Reimi Mosses
		</div>
	</body>
	</html>
<?php 
}

else{ /*if not logged in then show this*/

 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title> Roger senpai!</title>
 	<link rel="stylesheet" type="text/css" href="css/login.css"/>
 	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
  	<meta name="viewport" content="width=device-width, initial-scale=1">
 </head>
 <body>
 <!-- login for people to aprove our app access to instagram
 after getting aproval we have info to play with -->
 	<div class="col-xs-2"></div>
 	<div class="col-xs-8" id="test">
 		<div id="lonk">
 			<a href="https:api.instagram.com/oauth/authorize/?client_id=<?php echo clientID; ?>&redirect_uri=<?php echo redirectURI; ?>&response_type=code" class="no-line">Login</a>
 		</div>
 	</div>
 </body>
 </html>

 <?php } ?>

