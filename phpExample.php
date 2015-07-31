<?php
//get JSON data sent from Android client
$data = json_decode(file_get_contents('php://input'), true);
//Get the username and token
$user = $data["userid"];
$token = $data["token"];
//use authentication file
require_once("token.php");
//check if the token matches with the user
if(!verifyToken($token,$user))
{
//send back some sort of logout command for client 
print_r("logout");
//close out of php file
exit(0);
}

//BELOW IS WHERE THE REST OF THE SERVER CODE WOULD BE WHEN AUTHENTICATED


?>