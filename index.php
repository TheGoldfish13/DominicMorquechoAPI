<?php 
//configuration for our  PHP server
set_time_limit(0); /*set time limit as 0*/
ini_set('default_socket_timeout', 300); 
session_start(); /*start session*/

//make constants using define
define('clientId', '2ece9bd35d2e4598a98df7ef7a84bc30');
define('client_Secret', 'b5d576a86043439ca6a79447ce8a1b64');
define('redirectURI', 'http://localhost/DominicMorquechoAPI/index.php');
define('ImageDirectory', 'pics/');
 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<meta charset="utf-8">
 	<meta name="description" content="">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
 	<title></title>
 	<link rel="stylesheet" href="css/main.css">
 </head>
 <body>
 <!-- login for people to aprove our app access to instagram
 after getting aproval we have info to play with -->
 	<a href="https:api.instagram.com/oauth/authorize/?client_id=<?php echo clientID;?>&redirect_uri=<?php echo redirectURI;?>&response_type=code">Login</a>
 
 </body>
 </html>

