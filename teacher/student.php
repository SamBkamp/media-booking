<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="studentstyle.css"/>
<title>Return Student</title>
</head>
<body>

<?php
$mysqli = new mysqli("localhost", "root", "", "userbase");

if (isset($_COOKIE["ident"])) {
    if(isset($_COOKIE["secure"])){

        $usernameQuery = "SELECT id FROM userData WHERE username ='" . $_COOKIE["ident"] . "'";
        $usernameResult = $mysqli->query($usernameQuery) or die($mysqli->error);
        $usernameRow = implode($usernameResult->fetch_assoc());
        $hash = md5($usernameRow . $_COOKIE["ident"]);

        if ($hash == $_COOKIE["secure"]){
            
        }else {
            header("Location: /");
        }
    }else {
        header("Location: /");
    }

}

    if(isset($_GET["r"]) and isset($_GET["c"])){
        if(sha1($_GET["r"] . date("dmy")) == $_GET["c"]){

            $sql = "UPDATE bookingitems SET `date`='', avail='Available', dateout='', `last`='' WHERE `last`='" . $_GET["r"] . "'"; 
            if ($mysqli->query($sql) === TRUE) {
                echo("<b><h1 id='mainhello'>Success</h1></b>");
                echo("<h3 id=subheading>You have returned the items of  '" . $_GET["r"] ."'</h3>");
            } else {
                echo("Error: 0x696e73657274657272 " . $mysqli->error);
                echo("<br>");
                echo("<br>");
                echo("This is an error, please contact samuel@bonnekamp.net with the error message above");
            }
        }else {
            header("Location: /invalid");
        }
    }

?>
</body>