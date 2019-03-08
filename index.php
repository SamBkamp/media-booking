<?php 
error_reporting(0);
ini_set('display_errors', 0);
$mysqli = new mysqli("localhost", "phpmyadmin", "diffie", "phpmyadmin");
	if (isset($_COOKIE["user"]) || isset($_COOKIE["secret"])) {
		$usernameQuery = "SELECT special FROM userData WHERE username ='" . $_COOKIE["user"] . "'";
		$usernameResult = $mysqli->query($usernameQuery);
		$usernameRow = implode($usernameResult->fetch_assoc());
			if ($usernameRow === $_COOKIE["secret"]) {
				header("Location:/dashboard/index.php");
			} else {
			}
	}
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
} 
if(isset($_POST["username"])){
	$username = $_POST["username"];
	$GLOBALS["message"] = "";
	$approval = "SELECT approval FROM userData WHERE username ='" . $username . "'";
	$approvalQuery = $mysqli->query($approval);
	$ok = implode($approvalQuery->fetch_assoc());
	
	
	
	$username = $_POST["username"];
	$password = $_POST["password"];
		
	$saltQuery = "SELECT salt FROM userData WHERE username ='" . $username . "'";
	$saltResult = $mysqli->query($saltQuery);
	$saltRow = implode($saltResult->fetch_assoc());
		
	$hashedPassword = hash('sha256', $password . $saltRow);
	$passQuery = "SELECT password FROM userData WHERE username ='" . $username . "'";
	$passResult = $mysqli->query($passQuery);
	$passRow = implode($passResult->fetch_assoc());
		
	if ($hashedPassword === $passRow){
		if($ok == "yes"){
			$emailSearch = "SELECT email FROM userdata WHERE username = '" . $username . "'";
			$emailQuery = $mysqli->query($emailSearch);
			$emailResult = implode($emailQuery->fetch_assoc());
			$special = sha1($emailResult . $saltRow);
			$insertion = "UPDATE userdata SET special = '$special' WHERE username = '$username'";
			
			if ($mysqli->query($insertion) === TRUE) {
				setcookie("user", $username, time() + (86400 * 30), "/");
				setcookie("secret", $special, time() + (86400 * 30), "/");
				header("Location:/dashboard/index.php");
			}
			 else {
				$GLOBALS["message"] = "something happened on our end. 0x7370656369616c736574";
			}
		}
		elseif($ok == "no"){
			$GLOBALS['message'] = "you have not yet been accepted by an admin";
		} elseif($ok == "stop"){
			$GLOBALS['message'] = "You have been declined by an admin";
		}else{
			$GLOBALS['message'] = "there was something wrong on our end: 0x617070726f76650d0a";
		}
			
	} else {
		$GLOBALS["message"] = "Incorrect Username and Password combination";
	}
		
	
}

?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>Bkamp's Data Centre</title>
	<link rel="shortcut icon" type="image/ico" href="favicon.ico"/>
	<?php
	
	?>
</head>

<body>
<?php
error_reporting(0);
ini_set('display_errors', 0);

?>
    <!--   =START OF NAV= -->
      <div id="title">
        <h1>Bkamp's Data Centre</h1>
        <hr id="break">
        <div id="nav">
            <div class="files">
                <a href="http://bkamp.hopto.org" class="links">
                    <p class="sidebar">Files</p>
                </a>
            </div>
            <a href="/maintenence">
                <div class="files" id="comingSoon">
                    <p class="sidebar links">Coming Soon</p>
                </div>
            </a>
            <a href="/maintenence">
                <div class="files" id="right">
                    <p class="sidebar links">Coming Soon?</p>
                </div>
            </a>
        </div>
    </div>
    <!--   =END OF NAV= -->

    <div id="login">
        <div class="wrapper">
            <div id="tab">
                <p class="log">
                    <p class="log" id="logged">Login </p>
                    <p class="log" id="slash"> // </p>
                    <a href="/#signup">
                        <p class="log" id="SignUp"> Sign Up</p>
                    </a>
                </p>
            </div>
            <form action="index.php" method="post" />
            <p id="username">Username:</p>
            <input type="text" placeholder="Username" id="userinput" name="username" />
        </div>
        <div class="wrapper">
            <form action="index.php" method="post" />
            <p id="password">Password:</p>
            <input type="password" placeholder=" Password" id="passinput" name="password" />
            <button id="submit" onclick="myFunction()">Submit</button>
            <p id="check"><?php echo($GLOBALS['message']);?></p>
        </div>
    </div>

    <script type="text/javascript" src="script.js"></script>
</body>

</html>
