<?php

$start = array();
$conn = new mysqli("localhost", "root", "", "userbase");


if(isset($_GET["q"])){
    $q = $_GET["q"];
    if(isset($_COOKIE["shopping"])){
        $yes = unserialize($_COOKIE["shopping"]);
        array_push($yes, $q);
        setcookie("shopping", serialize($yes), time() + (86400 * 30), "/");
    }else{
        array_push($start, $q);
        setcookie("shopping", serialize($start), time() + (86400 * 30), "/");
        echo($start);
    }
}


if(isset($_GET["r"])){  
$r = $_GET["r"];
    if(isset($_COOKIE["shopping"])){
        $yes = unserialize($_COOKIE["shopping"]);
        $key = array_search($r, $yes);
        unset($yes[$key]);
        setcookie("shopping", array_values(serialize($yes)), time() + (86400 * 30), "/");
    }else{
    }
}


if(isset($_GET["p"])){
    $p = $_GET["p"];
    if (isset($_COOKIE{"shopping"})){
        if (empty(unserialize($_COOKIE["shopping"]))){
            echo("basket is empty");

        }else{
            }
            $num = 0;
            foreach (unserialize($_COOKIE["shopping"]) as $i){
                $num = $num +1;
                
            } if($num > 4){
                echo("you have too many thing booked");
                exit();
            } else {

            }
                $amountCheck = $conn->query("SELECT name FROM bookingitems WHERE last='" . $_COOKIE["ident"] . "'");
                $availCheck = "SELECT avail FROM bookingitems WHERE id = '" . $i . "'";
                if($amountCheck->num_rows <= 4 and $num <= 4-$amountCheck->num_rows){    
                
                }else {
                    echo("you have too many thing booked");
                    exit();
                }

                foreach (unserialize($_COOKIE["shopping"]) as $i){
                    $selectionQuery = $conn->query($availCheck) or die($conn->error);
                    $check = implode($selectionQuery->fetch_assoc());
                    
                    if ($check == "Available"){
                        $sql2 = "UPDATE bookingitems SET last='" . $_COOKIE["ident"] . "' WHERE id='" . $i . "'"; 
                        $sql3 = "UPDATE bookingitems SET avail='Booked' WHERE id='" . $i . "'";
                        $sql = "UPDATE bookingitems SET date='" . strtotime($_GET["datein"]) . "' WHERE id='" . $i . "'";
                        $sql4 = "UPDATE bookingitems SET dateout='" . strtotime($_GET["dateout"]) . "' WHERE id='" . $i . "'";

                        
                        if ($conn->query($sql) === TRUE) {
                            $uploadok = "succ";
                        } else {
                            $uploadok = "fail";
                        }
                        if ($conn->query($sql2) === TRUE) {
                            $uploadok2 = "succ";
                        } else {
                            $uploadok2 = "fail";
                        }
                        if ($conn->query($sql3) === TRUE) {
                            $uploadok3 = "succ";
                        } else {
                            $uploadok3 = "fail";
                        }
                        if ($conn->query($sql4) === TRUE) {
                            $uploadok4 = "succ";
                        } else {
                            $uploadok4 = "fail";
                        }
                        if ($uploadok == "succ" and $uploadok2 == "succ" and $uploadok3 == "succ" and $uploadok4 == "succ"){
                            echo("");
                        }else{
                            echo($uploadok2 . " + " . $uploadok3);
                        }

                    }else {
                        echo("some items you chose have already been booked");
                    }
            
        }
    }else{
        echo("Empty Basket");
    }
}


if(isset($_POST["message"])){
    if($_POST["message"] != ""){
        $insertion = "INSERT INTO complaints (message, user) VALUES ('" . $conn->real_escape_string($_POST["message"]) . "','" . $conn->real_escape_string($_COOKIE["ident"]) . "')";
        if ($conn->query($insertion) === TRUE) {
            echo("thanks for your feedback!");
        } else {
            echo("works");
        }
    }else {
        echo("please don't leave the field blank");
    }
}

?>