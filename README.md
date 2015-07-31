<h3><b>Android Client-Server Token Authentication</b></h3>

The first step is to set up the php files on your http server. This could be something like NGINX or Apache.

1. Copy the token.php file into your main directory
2. At the beginning of every php file you will want to include

	```
	$data = json_decode(file_get_contents('php://input'), true);
	$user = $data["userid"];
	$token = $data["token"];
	require_once("token.php");
	if(!verifyToken($token,$user))
	{
	print_r("logout");
	exit(0);
	}
	```
	* This reads the userid and token from the JSON and verifies the user with their token.
	* print_r is whatever message you want to send back to the app when the tokens do not mathc
	* exit(0) is to stop the rest of the php file since they are not verified

3. Set up JAR
	1. Create a directroy called 'libs' in the root directory of your project
	2. Download the ParabalToken.jar file and move it into the libs folder
	3. Rightclick on the jar and select Build Path > Add to Build Path
	4. In the header of your file include 
		```
		import com.parabal.*;
		```
	5. To use 
		* Create new ServerContact information. First parameter is the location from the http server's root directory, second is the server address
		```
		ServerContact c = new ServerContact("tokenTester.php","192.168.25.253");
		```
		* Next add parameters to send to the server. In this example it would be userid and token saved on the device.
		```
		c.addData("userid", "user");
		c.addData("token", "test");
		```
		* Finally, run it. This will return what's sent from print_r
		```
		c.run();
		```
	6.) This library doesn't need to be used just for authentication. It can be used to send any information to the server.


The goal of this project is to help make Android apps more secure and to make it easier for a user to send data. 

Any questions can be sent to:     gkingsbury at parabal com
		




