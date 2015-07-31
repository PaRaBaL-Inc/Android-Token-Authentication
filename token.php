<?php



//Refresh the token saved in a database
function refreshToken($t, $u)
{
//random token and the username token is associated with
$rand_token = $t;
$user = $u;
//grab the salt from the database
$sql = "SELECT salt from salt WHERE user_id='".$user."'";
//connect to DB
$servername = "localhost";
$username = "user";
$password = "password";
$dbname = "database";

$conn = new mysqli($servername, $username, $password,$dbname);
if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
}
//run query from above
$rs = $conn->query($sql);
//get the first row
$row = $rs->fetch_assoc();
//get the salt value
$salt = ($row['salt']);
//One way encryption on the random token. Encrypted 6 times with the user's random salt saved in the db
$token = crypt($rand_token,'$6$'.$salt);
//Update the user's login token
$sql = "UPDATE tokens SET token='$token' WHERE user_id='$user'";
//call query
$conn->query($sql);
//Close db
$conn->close();
}


//Verifying tokens are the same
function verifyToken($t, $u)
{
//Get the user's salt
$sql = "SELECT salt from salt WHERE user_id='".$u."'";
//Login to DB
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "database";

$conn = new mysqli($servername, $username, $password,$dbname);
if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
}
//run salt query from above
$rs = $conn->query($sql);
//get the row
$row = $rs->fetch_assoc();
//get the salt value
$salt = ($row['salt']);
//encrypt the client token 6 times with the user's salt
$token = crypt($t,'$6$'.$salt);
//Get the encrypted server token
$sql = "SELECT token from tokens WHERE user_id='".$u."'";

$rs = $conn->query($sql);
$row = $rs->fetch_assoc();
//get token
$rtoken = $row['token'];
$conn->close();
//check if the encrypted client token matches the encrypted server token
return $rtoken==$token;




}




?>
