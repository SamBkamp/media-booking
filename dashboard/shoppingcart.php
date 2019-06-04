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
    }
}


if(isset($_GET["r"])){  
$r = $conn->real_escape_string($_GET["r"]);
    if(isset($_COOKIE["shopping"])){
        $yes = unserialize($_COOKIE["shopping"]);
        $key = array_search($r, $yes);
        unset($yes[$key]);
        setcookie("shopping", array_values(serialize($yes)), time() + (86400 * 30), "/");
    }else{
    }
}


if(isset($_GET["p"])){
    $p = $conn->real_escape_string($_GET["p"]);
    if (isset($_COOKIE{"shopping"})){
        if (empty(unserialize($_COOKIE["shopping"]))){
            echo("basket is empty");

        }
    }else {
        echo("Empty Basket");
        exit();
    }

    $num = 0;
    foreach (unserialize($_COOKIE["shopping"]) as $i){
        $num = $num +1;
    }
        if($num > 4){
            echo("you have too many thing booked");
            exit();
        }
    foreach (unserialize($_COOKIE["shopping"]) as $i){
        $amountCheck = $conn->query("SELECT name FROM bookingitems WHERE last='" . $conn->real_escape_string($_COOKIE["ident"]) . "'");
        $availCheck = "SELECT avail FROM bookingitems WHERE id = '" . $i . "'";

        //Amount booked in session check, exploded into good date format
        if($amountCheck->num_rows <= 4 and $num <= 4-$amountCheck->num_rows){
            $input = $_GET["datein"];
            $a = explode('.',$input);
            if ($a[0] > 31 or $a[1] > 12 or $a[2] < 19){
                echo("date");
                exit();
            }
            $result = $a[2].'-'.$a[1].'-'.$a[0];

            $input2 = $_GET["dateout"];
            $b = explode('.',$input2);
            if ($b[0] > 31 or $b[1] >  12 or $b[2] < 19){
                echo("date");
                exit();
            }
            $result2 = $b[2].'-'.$b[1].'-'.$b[0];

        
        }else {
            echo("you have too many thing booked");
            exit();
        }
        //date checking begins
        if (strtotime($result) < strtotime($result2)){
            echo("date");
            exit();
        }
        if (strtotime($result) < time()){
            echo("date");
            exit();
        }
        if ((strtotime($result2) - strtotime($result)) > strtotime("5 days")){
            echo("date");
            exit();
        }

        $selectionQuery = $conn->query($availCheck) or die($conn->error);
        $check = implode($selectionQuery->fetch_assoc());

        $firstItem = $conn->query("SELECT last FROM bookingitems WHERE id = '" . $i . "'") or die($conn->error);
        $firstItemList = implode($firstItem->fetch_assoc());
        
        if (strlen($firstItemList) > 2){
            $finishedArray = $firstItemList . "," . $_COOKIE["ident"];
            $dateData = $conn->query("SELECT date, dateout FROM bookingitems WHERE id = '" . $i . "'") or die($conn->error);
            while($row = $dateData->fetch_assoc()){
                $date = $row["date"] . "," . strtotime($result);
                $dateOut = $row["dateout"] . "," . strtotime($result2);
            }
        }else {
            $finishedArray = $_COOKIE["ident"];
            $date = strtotime($result);
            $dateOut = strtotime($result2);
        }



        $sql = "UPDATE bookingitems SET last='" . $conn->real_escape_string($finishedArray) . "', avail='Booked', date='" . $conn->real_escape_string($date) . "', dateout='" . $conn->real_escape_string($dateOut) . "' WHERE id='" . $i . "'"; 

            
        if ($conn->query($sql) === TRUE) {
            echo("");
        } else {
            echo("fail");
        }
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
}
    #echo("</table>");


?>