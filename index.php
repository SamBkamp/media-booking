<?php 

#this one has been cleaned

error_reporting(0);
ini_set('display_errors', 0);
$teacher = False;
$mysqli = new mysqli("localhost", "root", "", "userbase");
$fiesta = "";
$message = "";
$amp = "";
#just a bunch of stuff to initialise the system

if ($mysqli->connect_error) {
	echo("Connection failed: 0x636f6e6572726f72 (" . $mysqli->connect_error . ")");
	echo("<br>");
	echo("<br>");
	die("This is an error, please report it via email to samuel@bonnekamp.net");
} 
#make sure the mysql server is still alive

if (isset($_COOKIE["ident"])) {
	if  (isset($_COOKIE["secure"])){ #checks if the cookie belongs to admin account as regular accounts dont have the secure cookie (line 62)
		$ident = $_COOKIE["ident"];
		$glasses = "SELECT id FROM userData WHERE username = '" . $mysqli->real_escape_string($ident) . "'"; #takes the id based on the ident cookie
		$glassesQuery = $mysqli->query($glasses) or die($mysqli->error);
		$glassRow = implode($glassesQuery->fetch_assoc());
		$check = md5($glassRow . $_COOKIE["ident"]); #hashes it to re create how the original cookie was written (secure cookie hash was created with id + user)
		
		if ($check == $_COOKIE["secure"]){
			header("Location: /dashboard/index.php"); #here if it matches the cookie
		}
	}else {
		$ident = $_COOKIE["ident"];
		$glasses = "SELECT id FROM userData WHERE username = '" . $mysqli->real_escape_string($ident) . "'"; #takes the id based on the ident cookie
		$glassesQuery = $mysqli->query($glasses) or die($mysqli->error);
		if ($glassesQuery->num_rows > 0){
			header("Location: /dashboard/index.php"); #goes to this condition if cookie is set and is not teacher account (can be faked but, might aswell just use the form lmao)
		}else{
			
		}
	}
 }
#cookie checking script




if(isset($_POST["username"])){
	if ($_POST["username"] == "18bonnekampsb2" or $_POST["username"] == "teacher"){ #hard coded the admin accounts (dont sue me). just put in another select and youll be good. 
		$teacher = True;
		$fiesta = $_POST["username"]; #adds the second input field (check the actual html im too lazy to quote)

		if (isset($_POST["password"])){
			$passCheck = "SELECT password FROM userData WHERE username = '" . $mysqli->real_escape_string($_POST["username"]) . "'"; #takes password
			$passCheckQuery = $mysqli->query($passCheck) or die($mysqli->error);
			$passRow = implode($passCheckQuery->fetch_assoc());

			if ($passRow == $_POST["password"]){ #checks the password
				$idSel = "SELECT id FROM userData WHERE username = '" . $mysqli->real_escape_string($_POST["username"]) . "'";
				$idSelQuery = $mysqli->query($idSel) or die($mysqli->error);
				$idRow = implode($idSelQuery->fetch_assoc());
				$check = md5($idRow . $_POST["username"]);
				setcookie("ident", $_POST["username"], time() + (86400 * 30), "/"); #if its correct, generates secure hash with id and username (schould be secure enough)
				setcookie("secure", $check, time() + (86400 * 30), "/");
				header("Location: /teacher/index.php");
			}else {
				$GLOBALS["message"] = "Username and Password do not match."; #take a wild guess
			}
		}

		}else {
		$username = $_POST["username"];
		$GLOBALS["message"] = "";

		$check = "SELECT username FROM userData WHERE username ='" . $mysqli->real_escape_string($username) . "'";
		$checkQuery = $mysqli->query($check) or die($mysqli->error);
		$checkRow = implode($checkQuery->fetch_assoc());
		

			if ($username == $checkRow){ #checks if the inputted username actually exists, and if so, headers them to dash
				header("Location: /dashboard/index.php");
				setcookie("ident", $mysqli->real_escape_string($_POST["username"]), time() + (86400 * 30), "/"); #sets cookie based solely on username (dont need cookie security when its just a username)
			}else {
				$GLOBALS["message"] = "User doesn't exist";
			}
			
	}	
	#this section is for the plebians without admin accounts
	
}
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>Media Equipment booking</title>
	<link rel="shortcut icon" type="image/ico" href="favicon.ico"/>
	<?php
	
	?>
</head>

<body>
<?php

?>
   

    <div id="login">
        <div class="wrapper">
            <div id="tab">
                <p class="log">
                    <p class="log" id="logged">Booking Login</p>
                </p>
            </div>
            <form action="index.php" method="post">
            <p id="username">Username:</p>
            <input type="text" placeholder="Username" id="userinput" name="username" value="<?php echo($fiesta) ?>"/>
        </div>
        <div class="wrapper">
			<?php 
				if ($teacher == True){
            		echo('<p id="password">Password:</p>');
					echo('<input type="password" placeholder=" Password" id="passinput" name="password" />');
				}
			?>
			<button id="submit" onclick="myFunction()">Submit</button>
			</form>
            <p id="check"><?php echo($GLOBALS['message']);?></p>
        </div>
    </div>

    <script type="text/javascript" src="script.js"></script>
</body>

</html>
