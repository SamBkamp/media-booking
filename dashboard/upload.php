<?php
// if(isset($_COOKIE["shopping"])){
//     setcookie("shopping", "", time() - 3200, "/");
// }
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
                    }

                }else {
                    header("Location: ../");
                }
        ?>
        <link rel="stylesheet" type="text/css" href="uploadstyle.css"/>
                <title>Checkout items</title>
                <link rel="shortcut icon" type="image/ico" href="favicon.ico"/>
    </head>
    <body>
        <?php
        error_reporting(0);
        ini_set('display_errors', 0);


?>
<div id="grey">
    <div id="container">
        <div id="amp"></div> 
        <div id="wrapper">
        <h2 id="message">Success!</h2>
        <h3 id="warning"></h3>
        </div>
        <img src="success.png" id="success"/>
        <h4 id="redirect">Redirecting you back to the home page...</h4>
    </div>
</div>

        <!-- =START OF NAV= -->
      <div id="navWrapper">
        <img src="circle_placeholder.png" class="logoPlaceHolder"/>
                <img src="/resources/exit.png" id="addFile"/>

      </div>
    <!-- =END OF NAV= -->
      <div id="topNav">
      <?php
        
      ?>    
        <div id="welcomeMessage">
            
        <p id="welcome" class="welcome">Checkout Items</p>
            </div>
        </div>
        </div>
        <table id="table">
        <tr>
          <th class="fileName header">Equipment</th>
          <th class="owner header">Availability</th>
        </tr>
        <?php 
        foreach (unserialize($_COOKIE["shopping"]) as $i){
            $selection = "SELECT id, name, avail FROM bookingitems WHERE id = '" . $i . "'";
            $selectionQuery = $mysqli->query($selection) or die($mysqli->error); 
            while($row = $selectionQuery->fetch_assoc()) {
                if ($row["avail"] == "Booked"){
                    $color = 'red';
                    $yelp = "hidden";
                }else{
                    $color = 'green';
                    $yelp = "";
                }
                echo ("<tr class='hover'>
                <td class='files fileName'/> " . $row["name"] . "</td>
                <td class='owner files name " . $color . "' >" . $row["avail"] . " </td>
                </tr>");
            }    
        }
        

        ?>
      </table>
      <button class='button-two'><span>Book</span></button>

      

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script type="text/javascript" src="uploadscript.js"></script>

    </body>
</html>
