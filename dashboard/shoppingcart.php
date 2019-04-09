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
                    $input = $_GET["datein"];
                        $a = explode('.',$input);
                        $result = $a[2].'-'.$a[1].'-'.$a[0];

                        $input2 = $_GET["dateout"];
                        $b = explode('.',$input2);
                        $result2 = $b[2].'-'.$b[1].'-'.$b[0];

                
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
                        $sql = "UPDATE bookingitems SET date='" . strtotime($result) . "' WHERE id='" . $i . "'";
                        $sql4 = "UPDATE bookingitems SET dateout='" . strtotime($result2) . "' WHERE id='" . $i . "'";

                        
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

if(isset($_POST["searchTerm"])){
    
    $selection = "SELECT id, name, avail, date FROM bookingitems WHERE name LIKE '%" . $conn->real_escape_string($_POST["searchTerm"]) . "%'";
    $amountCheck = $conn->query("SELECT name FROM bookingitems WHERE last='" . $conn->real_escape_string($_COOKIE["ident"]) . "'");
    $selectionQuery = $conn->query($selection) or die($conn->error);
    #echo("<table id='table'>");
    echo ("<tr>
        <th class=\"dividers\">Results for \"" . htmlspecialchars($_POST["searchTerm"]) . "\"</th>
        <th class=\"owner files name\"></th>
        <th class=\"doctype\"></th>
    </tr>");
    while($row = $selectionQuery->fetch_assoc()) {
        if ($row["avail"] == "Booked"){
            $color = 'red';
            $yelp = "hidden";
            $in = "Available on " . Date('d-m-y', $row["date"]);
        
        }else{
            $color = 'green';
            $in = "Available";
            if($amountCheck->num_rows > 3){
                $yelp = "hidden";
            }else {
                $yelp = "";
            }
        }
        
        echo ("<tr class='hover'>
        <td class='files fileName'> " . $row["name"] . "</td>
        <td class='owner files name " . $color . "' >" . $in  ."</td>
        <td class='doctype'><div class=' " . $yelp . " fileType' onClick='booking(\"" . $row["name"] . "\", \"" . $row["id"] . "\")'><button class='button-two' id='" . $row["id"] . "'><span>Book</span></button></div></td>
        </tr>");
    }
    #echo("</table>");
}

?>