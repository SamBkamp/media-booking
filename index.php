<?php 
#error_reporting(0);
#ini_set('display_errors', 0);
$teacher = False;
$mysqli = new mysqli("localhost", "root", "", "userbase");
$fiesta = "";
	// if (isset($_COOKIE["user"]) || isset($_COOKIE["secret"])) {
	// 	$usernameQuery = "SELECT special FROM userData WHERE username ='" . $_COOKIE["user"] . "'";
	// 	$usernameResult = $mysqli->query($usernameQuery);
	// 	$usernameRow = implode($usernameResult->fetch_assoc());
	// 		if ($usernameRow === $_COOKIE["secret"]) {
	// 			header("Location:/dashboard/index.php");
	// 		} else {
	// 		}
	// }
if ($mysqli->connect_error) {
	die("Connection failed: 0x636f6e6572726f72 " . $mysqli->connect_error);
	echo("This is an error, please report it via email to samuel@bonnekamp.net");
} 
if(isset($_POST["username"])){
	if ($_POST["username"] == "18bonnekampsb2"){
		$teacher = True;
		$fiesta = $_POST["username"];
		if (isset($_POST["password"])){
			$passCheck = "SELECT password FROM userData WHERE username = '" . $_POST["username"] . "'";
			$passCheckQuery = $mysqli->query($passCheck) or die($mysqli->error);
			$passRow = implode($passCheckQuery->fetch_assoc());
			if ($passRow == $_POST["password"]){
				$idSel = "SELECT id FROM userData WHERE username = '" . $_POST["username"] . "'";
				$idSelQuery = $mysqli->query($idSel) or die($mysqli->error);
				$idRow = implode($idSelQuery->fetch_assoc());
				$check = md5($idRow . $_POST["username"]);
				setcookie("ident", $_POST["username"], time() + (86400 * 30), "/");
				setcookie("secure", $check, time() + (86400 * 30), "/");
				header("Location: /dashboard/index.php");
			}
		}
	}else {
		$username = $_POST["username"];
		$GLOBALS["message"] = "";

		$check = "SELECT username FROM userData WHERE username ='" . $username . "'";
		$checkQuery = $mysqli->query($check) or die($mysqli->error);
		if (!empty($checkQuery)){
			header("Location: /dashboard/index.php");
			setcookie("ident", $_POST["username"], time() + (86400 * 30), "/");
		}
	}
	
	
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
error_reporting(0);
ini_set('display_errors', 0);

?>
   

    <div id="login">
        <div class="wrapper">
            <div id="tab">
                <p class="log">
                    <p class="log" id="logged">Booking Login</p>
                </p>
            </div>
            <form action="index.php" method="post" />
            <p id="username">Username:</p>
            <input type="text" placeholder="Username" id="userinput" name="username" value="<?php echo($fiesta) ?>"/>
        </div>
        <div class="wrapper">
            <form action="index.php" method="post" />
			<?php 
				if ($teacher == True){
            		echo('<p id="password">Password:</p>');
					echo('<input type="password" placeholder=" Password" id="passinput" name="password" />');
				}
			?>
            <button id="submit" onclick="myFunction()">Submit</button>
            <p id="check"><?php echo($GLOBALS['message']);?></p>
        </div>
    </div>

    <script type="text/javascript" src="script.js"></script>
</body>

</html>
