<?php
    if(isset($_COOKIE["shopping"])){
        setcookie("shopping", "", time() - 3200, "/");
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <?php
        $mysqli = new mysqli("localhost", "root", "","userbase");
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
        #error_reporting(0);
        #ini_set('display_errors', 0);

?>
<!-- overlay -->
<div id="grey">
    

    <div id="container">
    <h3 id="title">Have a teacher scan this code to return your equipment</h3>
    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http://localhost/dashboard/return.php?r=<?php echo($_COOKIE["ident"]) ?>" id="qrcode"/>
    <input disabled="disabled" value="http://localhost/dashboard/return.php?r=<?php echo($_COOKIE["ident"]) ?>" id="copyPaste">
    </div>
</div>
        <!-- =START OF NAV= -->
      <div id="navWrapper">
        <img src="/resources/sislogo.png" class="logoPlaceHolder"/>
        <img src="/resources/exit.png" id="addFile"/>
        <img src="/resources/caution.png" id="report"/>
        
      </div>
    <!-- =END OF NAV= -->
      <div id="topNav">
      <?php
        
      ?>
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
          <th class="fileName header">Equipment</th>
          <th class="owner header">Availability</th>
          <th class="doctype header"></th>
        </tr>
        <?php 
            if($_COOKIE["ident"] == "teacher"){
                $selection = "SELECT id, name, avail, date FROM bookingitems WHERE avail = 'Booked'";
            }else{
                $selection = "SELECT id, name, avail, date FROM bookingitems";
            }
            $selectionQuery = $mysqli->query($selection) or die($mysqli->error); 
            while($row = $selectionQuery->fetch_assoc()) {
                if ($row["avail"] == "Booked"){
                    $color = 'red';
                    $yelp = "hidden";
                    $in = "Available on " . Date('d-m-y', strtotime("+4 days", $row["date"]));
                    
                }else{
                    $color = 'green';
                    $yelp = "";
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
