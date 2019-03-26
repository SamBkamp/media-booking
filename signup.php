<?php 
// error_reporting(0);
// ini_set('display_errors', 0);
$mysqli = new mysqli("localhost", "root", "", "userbase");
$GLOBALS['message'] = "";
#just a bunch of stuff to initialise the system

if ($mysqli->connect_error) {
	echo("Connection failed: 0x636f6e6572726f72 (" . $mysqli->connect_error . ")");
	echo("<br>");
	echo("<br>");
	die("This is an error, please report it via email to samuel@bonnekamp.net or via the report page on the dashboard if you can get there");
} 
#make sure the mysql server is still alive
$signinok = 0;

if(isset($_GET["user"]) and isset($_GET["oauth"])){
    if(sha1($_GET["user"] . date("dmy")) == $_GET["oauth"]){
        $signinok = 1;
    }else{
        header("Location:index.php");
    }
}else {
    echo("malformed query");
}

if (isset($_POST["username"])){
    if($signinok == 1){
        $insertion = "INSERT INTO userData(username, password, teacher) VALUES('" . $_POST["username"] . "', '', 0)"; 
        if ($mysqli->query($insertion) === TRUE) {
            $GLOBALS['message'] = "success";
            header("Location: index.php");
        } else {
            $GLOBALS['message'] = $mysqli->error;
        }
    }else {
        echo("either something has gone really wrong, or you're trying to hack me. In the latter case, nice try.");
    }
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
            <form action="signup.php" method="post">
            <p id="username">VLE username:</p>
            <input type="text" placeholder="Username" id="userinput" name="username" value=""/>
            
        </div>
        <div class="wrapper">
            <button id="submit" >Submit</button>
            </form>
            <p id="check"><?php echo($GLOBALS['message']);?></p>
        </div>
    </div>

    <script type="text/javascript" src="signscript.js"></script>
    
</body>

</html>
