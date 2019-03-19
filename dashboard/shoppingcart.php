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

$p = $_GET["p"];
if(isset($p)){
    if (isset($_COOKIE{"shopping"})){
        if (empty(unserialize($_COOKIE["shopping"]))){
            echo("basket is empty");

        }else{
            foreach (unserialize($_COOKIE["shopping"]) as $i){
                $availCheck = "SELECT avail FROM bookingitems WHERE id = '" . $i . "'";
                $selectionQuery = $conn->query($availCheck) or die($conn->error);
                $check = implode($selectionQuery->fetch_assoc());
                if ($check == "Available"){
                    $sql = "UPDATE bookingitems SET date= '" . strtotime(date("d.m.y")) . "' WHERE id='" . $i . "'"; 
                    $sql2 = "UPDATE bookingitems SET last='" . $_COOKIE["ident"] . "' WHERE id='" . $i . "'"; 
                    $sql3 = "UPDATE bookingitems SET avail='Booked' WHERE id='" . $i . "'"; 
                    if ($conn->query($sql) === TRUE) {
                        $uploadok = 1;
                    } else {
                        $uploadok = 0;
                    }
                    if ($conn->query($sql2) === TRUE) {
                        $uploadok2 = 1;
                    } else {
                        $uploadok2 = 0;
                    }
                    if ($conn->query($sql3) === TRUE) {
                        $uploadok3 = 1;
                    } else {
                        $uploadok3 = 0;
                    }
                    if ($uploadok == 1 and $uploadok2 == 1 and $uploadok3 == 1){
                        echo("everything-ok");
                    }else{

                    }
                }else {
                    echo("some items you chose have already been booked");
                }
            }
        }
    }else{
        echo("Empty Basket");
    }
}
?>