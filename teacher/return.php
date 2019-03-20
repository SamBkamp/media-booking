<?php
$mysqli = new mysqli("localhost", "root", "","userbase");

if (isset($_GET["item"])){
    if(isset($_GET["auth"])){
        $usernameQuery = "SELECT id FROM userData WHERE username ='" . $_GET["ident"] . "'";
        $usernameResult = $mysqli->query($usernameQuery) or die($mysqli->error);
        $usernameRow = implode($usernameResult->fetch_assoc());
        $hash = md5(md5($usernameRow . $_COOKIE["ident"]));
        if ($hash == $_GET["auth"]){
            $sql = "UPDATE bookingitems SET date= '' WHERE id='" . $_GET["item"] . "'"; 
            $sql2 = "UPDATE bookingitems SET last = '' WHERE id='" . $_GET["item"] .  "'";
            $sql3 = "UPDATE bookingitems SET avail='Available' WHERE id='" . $_GET["item"] . "'"; 

            if ($mysqli->query($sql) === TRUE) {
                $uploadok = 1;
            } else {
                $uploadok = 0;
            }
            if ($mysqli->query($sql2) === TRUE){
                $uploadok2 = 1;
            }
            if ($mysqli->query($sql3) === TRUE) {
                $uploadok3 = 1;
            } else {
                $uploadok3 = 0;
            }
            if ($uploadok == 1 and $uploadok2 and $uploadok3 == 1){
                echo("everything-ok");
            }else{
                echo("something when wrong");
            }
        }
    }else {
        echo("Authentication Failure; No Auth key");
    }
}

?>