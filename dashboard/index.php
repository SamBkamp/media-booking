<!DOCTYPE html>
<html>
    <head>
        <?php
        $mysqli = new mysqli("localhost", "root", "","userbase");
                if (isset($_COOKIE["ident"])) {
                    if($_COOKIE["ident"] == '18bonnekampsb2'){
                        $usernameQuery = "SELECT id FROM userData WHERE username ='" . $_COOKIE["ident"] . "'";
                        $usernameResult = $mysqli->query($usernameQuery) or die($mysqli->error);
                        $usernameRow = implode($usernameResult->fetch_assoc());
                        $hash = md5($usernameRow . $_COOKIE["ident"]);
                        if ($hash == $_COOKIE["secure"]){

                        }else {
                            header("Location: ../");
                        }
                    }else {

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
  <div id="uploadFileDisplay">
                <div id="topBorder">
                <p id="errorMsg">Upload</p>
                </div>
                <form action="index.php" method="post" enctype="multipart/form-data">
                        <input type="file" multiple name="fileToUpload" class="fileToUpload" class="uploadStyle">
                        <input type="submit" value="Upload" name="submit" class="uploadButton" class="uploadStyle">
                </form>
                <form action="index.php" method="post">
                        <input name="newFolder" class="fileToUpload" class="folder">
                        <input type="submit" value="Upload" name="uploadFolder" class="uploadButton" class="folder">
                </form>
        </div>

        <div id="blur"></div>
        <!-- =START OF NAV= -->
      <div id="navWrapper">
        <img src="circle_placeholder.png" class="logoPlaceHolder"/>
                <img src="/media/addfiles.png" id="addFile"/>

      </div>
    <!-- =END OF NAV= -->
      <div id="topNav">
        <div id="welcomeMessage">
        <p id="welcome" class="welcome">Hey,  </p><strong class="welcome"><?php echo(" " . $_COOKIE["ident"]);?></strong>
        </div>
        </div>
        <table id="table">
        <tr>
          <th class="fileName header">Equipment</th>
          <th class="owner header">Availability</th>
          <th class="doctype header"></th>
        </tr>
        <?php 
            if($_COOKIE["ident"] == "18bonnekampsb2"){
                $selection = "SELECT name, avail FROM bookingitems WHERE avail = 'Booked'";
            }else{
                $selection = "SELECT name, avail FROM bookingitems";
            }
            $selectionQuery = $mysqli->query($selection) or die($mysqli->error); 
            while($row = $selectionQuery->fetch_assoc()) {
                if ($row["avail"] == "Booked"){
                    $color = 'red';
                }else{
                    $color = 'green';
                }
                echo ("<tr class='hover'>
                <td class='files fileName'/> " . $row["name"] . "</td>
                <td class='owner files name " . $color . "' >" . $row["avail"] . " </td>
                <td class='doctype'><img src='amp.jpg' class='filetype' /></td>
                </tr>");
            }    


        ?>
      </table>

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script type="text/javascript" src="script.js"></script>

    </body>
</html>
