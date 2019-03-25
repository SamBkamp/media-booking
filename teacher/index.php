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
                            
                        }else {
                            header("Location: ../");
                        }
                    }else {
                        header("Location: ../dashboard");
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
    <h3 id="title"></h3>
    <input id="joinClass" value="amp" type="disabled"/>
    
    </div>
</div>
        <!-- =START OF NAV= -->
      <div id="navWrapper">
        <img src="/resources/sislogo.png" class="logoPlaceHolder"/>
        <img src="/resources/exit.png" id="addFile"/>
        <img src="/resources/add.png" id="studentAdd">

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
          <th class="header lastUser">Borrower</th>
          <th class="owner header">Availability</th>
          <th class="doctype header"></th>
        </tr>
        <?php 
                $selection = "SELECT id, name, avail, date, last FROM bookingitems WHERE avail = 'Booked'";
            $selectionQuery = $mysqli->query($selection) or die($mysqli->error); 
            while($row = $selectionQuery->fetch_assoc()) {
                if ($row["avail"] == "Booked"){
                    $color = 'red';
                    $chose = 'Return';
                    $in = "Due Back " . Date('d-m-y', strtotime("+4 days", $row["date"]));
                    
                }else{
                    $color = 'green';
                    $in = "Available";
                    $chose = 'Book';
                }
                echo ("<tr class='hover'>
                <td class='files fileName'> " . $row["name"] . "</td>
                <td class='files lastUser'> " . $row["last"] . "</td>
                <td class='owner files name " . $color . "' >" . $in  ."</td>
                <td class='doctype'><div class='fileType' onClick='booking(\"" . md5($_COOKIE["secure"]) . "\", \"" . $row["id"] . "\", \"" . $_COOKIE["ident"] . "\")'><button class='button-two' id='" . $row["id"] . "'><span>" . $chose ."</span></button></div></td>
                </tr>");
            }    


        ?>
      </table>

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script type="text/javascript" src="script.js"></script>

    </body>
</html>
