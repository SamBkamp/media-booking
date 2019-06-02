<?php
    if(isset($_COOKIE["shopping"])){
        setcookie("shopping", "", time() - 3200, "/");
    }
#cleaned I think

?>

<!DOCTYPE html>
<html>
    <head>
        <?php
        $mysqli = new mysqli("localhost", "root", "","userbase");
        if ($mysqli->connect_error) {
            echo("Connection failed: 0x636f6e6572726f72 (" . $mysqli->connect_error . ")");
            echo("<br>");
            echo("<br>");
            die("This is an error, please report it via email to samuel@bonnekamp.net");
        } 
                if (isset($_COOKIE["ident"])) {
                    if(isset($_COOKIE["secure"])){
                        $usernameQuery = "SELECT id FROM userData WHERE username ='" . $_COOKIE["ident"] . "'";
                        $usernameResult = $mysqli->query($usernameQuery) or die($mysqli->error);
                        $usernameRow = implode($usernameResult->fetch_assoc());
                        $hash = md5($usernameRow . $_COOKIE["ident"]);
                        if ($hash == $_COOKIE["secure"]){
                            header("Location: ../teacher");
                        }else {
                            header("Location: ../");
                        }
                    }else {
                        $ident = $_COOKIE["ident"];
		                $glasses = "SELECT id FROM userData WHERE username = '" . $mysqli->real_escape_string($ident) . "'"; #takes the id based on the ident cookie
		                $glassesQuery = $mysqli->query($glasses) or die($mysqli->error);
		                if ($glassesQuery->num_rows > 0){
                        }else{
                            header("Location: ../");
                        }
                    }

                }else {
                    header("Location: ../");
                }
                
        ?>
        <link rel="stylesheet" type="text/css" href="style.css"/>
                <title>Dashboard</title>
                <link rel="shortcut icon" type="image/ico" href="favicon.ico"/>
    </head>
    <body>
        <?php
        error_reporting(0);
        ini_set('display_errors', 0);

?>
<!-- overlay -->
<div id="grey">
    

    <div id="container">
        <img src="/resources/multiply.png" id="closeWindow"/>
        <h3 id="title">Have a teacher scan this code to return your equipment</h3>
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http://localhost:8080/teacher/student.php?r=<?php echo(htmlspecialchars($_COOKIE["ident"])) ?>&c=<?php echo(sha1($_COOKIE["ident"] . date("dmy")))?>" id="qrcode"/>
        <input id="joinClass" value="http://localhost:8080/teacher/student.php?r=<?php echo(htmlspecialchars($_COOKIE["ident"])) ?>&c=<?php echo(sha1($_COOKIE["ident"] . date("dmy")))?>">
        <button id="copy" type="button">Copy in clipboard<span class="copiedtext" aria-hidden="true">Copied</span></button>
    </div>
</div>
        <!-- =START OF NAV= -->
      <div id="navWrapper">
        <a href="../"><img src="/resources/sislogo.png" class="logoPlaceHolder"/></a>
        <img src="/resources/exit.png" id="addFile"/>
        <div id="spacer"></div>
        <img src="/resources/caution.png" id="report"/>
        
        
      </div>
    <!-- =END OF NAV= -->
      <div id="topNav">
      <div id="reported">
                <h3 id="op">Opinions/Bugs? let us know!</h3>
                <textarea id="areaText" placeholder="type here..."></textarea>
                <button id="sumbutton">Submit</button>
                <p id="errno"></p>
      </div>
        <div id="welcomeMessage">
        <p id="welcome" class="welcome">Hey, <span class="welcome"><strong><?php echo(htmlspecialchars($_COOKIE["ident"]));?></strong></span></p>
            <div id="userBar">
                <a href="upload.php"><div id="shoppingBasket"><img src="shopping-basket.png" id="basketico"/></div></a>
                <div id="return"><img src="returnequip.png" id="returnico"/></div>
            </div>
            <input id="searchBar" placeholder="search...">
        </div>
        </div>
        
        <table id="table">  
            <div id="cleared">

                <?php 
                    $typeQuery = $mysqli->query("SELECT DISTINCT type FROM bookingitems") or die($mysqli->error);
                    while($types = $typeQuery->fetch_assoc()){
                        echo("<tr>
                        <th class='dividers'>" . $types["type"] . "</th>
                        <th class='owner files name'></th>
                        <th class='doctype'></th>
                        </tr>
                        ");
                        $selection = "SELECT id, name, avail, date, dateout FROM bookingitems WHERE type='". $types["type"] ."' ORDER BY id";
                        $amountCheck = $mysqli->query("SELECT last FROM bookingitems WHERE avail='Booked'");
                        $selectionQuery = $mysqli->query($selection) or die($mysqli->error);
                        $amount = 0; 
                        while($row = $selectionQuery->fetch_assoc()) {
                            $dateRaw = explode(",", $row["date"]);
                            while ($amountels = $amountCheck->fetch_assoc()){
                                $dataName = explode(",", $amountels["last"]);
                                foreach ($dataName as $i){
                                    if ($i == $_COOKIE["ident"]){
                                        $amount = $amount + 1;
                                    }
                                }
                                if($amount > 3){
                                    $yelp = "hidden";
                                }else {
                                    $yelp = "";
                                    echo($amount);
                                }
                            }
                        
                            
                            
                            if ($row["avail"] == "Booked"){
                                $color = 'red';
                                $in = "Available on " . Date('d-m-y', $dateRaw[0]);
                            }else{
                                $color = 'green';
                                $in = "Available";
                                
                            }
                            echo ("<tr class='hover'>
                            <td class='files fileName'/> " . $row["name"] . "</td>
                            <td class='owner files name " . $color . "' >" . $in  ."</td>
                            <td class='doctype'><div class=' " . $yelp . " fileType' onClick='booking(\"" . $row["name"] . "\", \"" . $row["id"] . "\")'><button class='button-two' id='" . $row["id"] . "'><span>Book</span></button></div></td>
                            </tr>");
                        }    
                    }

                ?>
            </div>
        </table>
            

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script type="text/javascript" src="script.js"></script>

    </body>
</html>
