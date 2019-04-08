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
    <h3 id="title">Have a teacher scan this code to return your equipment</h3>
    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http://localhost/dashboard/return.php?r=<?php echo(htmlspecialchars($_COOKIE["ident"])) ?>" id="qrcode"/>
    <input disabled="disabled" value="http://localhost/dashboard/return.php?r=<?php echo($_COOKIE["ident"]) ?>" id="copyPaste">
    </div>
</div>
        <!-- =START OF NAV= -->
      <div id="navWrapper">
        <img src="https://alumni.sis.edu.hk/site/SIS/upload/mw_data/file/mw_data_53312_586dbce1a6091.png" class="logoPlaceHolder"/>
        <img src="/resources/exit.png" id="addFile"/>
        <div id="spacer"></div>
        <img src="/resources/caution.png" id="report"/>
        
        
      </div>
    <!-- =END OF NAV= -->
      <div id="topNav">
      <?php
        
      ?>
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
        </div>
        </div>
        <table id="table">
        <tr>
            <th class="dividers">Mics</th>
            <th class="owner files name"></th>
            <th class="doctype"></th>
        </tr>
        <?php 
            
                $selection = "SELECT id, name, avail, date FROM bookingitems WHERE type='mic' ORDER BY id";
                $amountCheck = $mysqli->query("SELECT name FROM bookingitems WHERE last='" . $_COOKIE["ident"] . "'");
            $selectionQuery = $mysqli->query($selection) or die($mysqli->error); 
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
                <td class='files fileName'/> " . $row["name"] . "</td>
                <td class='owner files name " . $color . "' >" . $in  ."</td>
                <td class='doctype'><div class=' " . $yelp . " fileType' onClick='booking(\"" . $row["name"] . "\", \"" . $row["id"] . "\")'><button class='button-two' id='" . $row["id"] . "'><span>Book</span></button></div></td>
                </tr>");
            }    


        ?>
        <tr>
            <th class="dividers">Cameras</th>
            <th class="owner files name"></th>
            <th class="doctype"></th>
        </tr>
        <?php 
            
                $selection = "SELECT id, name, avail, date FROM bookingitems WHERE type='cam' ORDER BY id";
            $selectionQuery = $mysqli->query($selection) or die($mysqli->error); 
            while($row = $selectionQuery->fetch_assoc()) {
                if ($row["avail"] == "Booked"){
                    $color = 'red';
                    $yelp = "hidden";
                    $in = "Available on " . Date('d-m-y', $row["date"]);
                    
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


        ?>
         <tr>
            <th class="dividers">Accessories</th>
            <th class="owner files name"></th>
            <th class="doctype"></th>
        </tr>
        <?php 
            
                $selection = "SELECT id, name, avail, date FROM bookingitems WHERE type='acc' ORDER BY id";
            $selectionQuery = $mysqli->query($selection) or die($mysqli->error); 
            while($row = $selectionQuery->fetch_assoc()) {
                if ($row["avail"] == "Booked"){
                    $color = 'red';
                    $yelp = "hidden";
                    $in = "Available on " . Date('d-m-y', $row["date"]);
                    
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


        ?>
      </table>

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script type="text/javascript" src="script.js"></script>

    </body>
</html>
