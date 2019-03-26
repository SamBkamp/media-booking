<?php 
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
	die("This is an error, please report it via email to samuel@bonnekamp.net or via the report page on the dashboard if you can get there");
} 
#make sure the mysql server is still alive

if(isset($_GET["user"]) and isset($_GET["oauth"])){
    if(sha1($_GET["user"] . date("dmy")) == $_GET["oauth"]){
        echo("nice");
    }else{
        echo("wrong");
    }
}else {
    echo("malformed query");
}
	

#main body of the script, wow I actually commented this!
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="signstyle.css" />
    <title>Signup</title>
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
                    <p class="log" id="logged">Signup</p>
                </p>
            </div>
            <form action="index.php" method="post">
            <p id="username">VLE username:</p>
            <input type="text" placeholder="Username" id="userinput" name="username" value="<?php echo($fiesta) ?>"/>
        </div>
        <div class="wrapper">
            <form action="index.php" method="post">
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

    <script type="text/javascript" src="noscript.js"></script>
</body>

</html>
