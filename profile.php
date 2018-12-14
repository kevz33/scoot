<?php 
  session_start();
    
  include 'database.php';
  $dbConn = getDatabaseConnection();
  
  
  function getImages() {
      global $dbConn;
      
      $sql = "SELECT * FROM pictures WHERE userID = :userID";
      $stmt = $dbConn->prepare($sql);
      $stmt->execute(array(":userID"=> $_SESSION['user_id']));
      $records = $stmt->fetchAll();
      
      $j = 0;
      echo "<div class='postedImages'>";
          
      for($i=0; $i < count($records); $i++) {
            echo "<img src='downloadFile.php?imageID=" . $records[$i]["imageID"] ."' width='300px'height='300px'". "' id='images'>";
            $j++; 
            
          if($j % 3 == 0) {
              echo "<br>";
          }
      }
      echo "</div>";
        
  }
  
  function getProfilePicture() {
    global $dbConn;
      
      $sql = "SELECT * FROM profile_pictures WHERE userID = :userID";
      $stmt = $dbConn->prepare($sql);
      $stmt->execute(array(":userID"=> $_SESSION['user_id']));
      $records = $stmt->fetchAll();
      
    //   echo "<br> records: <br>";
    //   print_r($records);
      
      if(count($records) == 0) {
            echo "<img src='images/avatar.png' class='profilePic' alt='Avatar' style='border-radius: 50%; width:10%'>";
      } else {
            echo "<img src='downloadProfilePicture.php?imageID=" . $records[0]["imageID"] . "' class='profilePic' style='border-radius: 50%; width:10%'>";
            }  
      }
      
  function getLimeData(){
    global $dbConn;
    $sql = "SELECT * FROM lime WHERE userID = :user_id";
    $stmt = $dbConn->prepare($sql);
    $stmt->execute(array(":user_id"=> $_SESSION['user_id']));
    $records = $stmt->fetchAll();
    if(count($records) == 1){
      echo "<br><div id= 'bio'><h3>Referral Code:<br> <h3>" . $records[0]["referralCode"] . " <br>History:<br> I've been on " . $records[0]['rides'] . " rides</div>";
    }
    
  }
      
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo "@{$_SESSION['username']}" ?> | Scoot</title>
    <link rel="stylesheet" type="text/css" href="styles/profilePageStyle.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="icon" type="image/png" sizes="96x96" href="icon/favicon-96x96.png">
  </head>
  
  <body>
        <h1><img src="images/scoot.png" id="logo" onclick="window.location.href='home.php'" style="cursor:pointer">
        
        <div id="nav_div">
            <nav>
              <a style="margin-right:200px"href="home.php"> Home </a>            
              <a href="logout.php"> Logout </a>
           </nav>
       </div>
       
       <select id = "settingsSelect">
            <option value="0">Settings</option>
            <option value="1">Change Username</option>
            <option value="2">Change Password</option>
            <option value="3">Delete Account</option>
        </select>
        
        <div id = "profileData">
        <?php
          getProfilePicture();
          echo "<br>";
          getLimeData();
        ?>
        
        <h2><?php echo "@{$_SESSION['username']}" ?></h2>
        
          <div align="center" class="postedImages">
              
              <?php
                getImages();
              ?>
            
        
        </div>
        </div>
       
  </body>
</html>

<script>
  $("#settingsSelect").change(onSettingsChange);
  
  function onSettingsChange(){
    if($("#settingsSelect").val() != "0"){
      if($("#settingsSelect").val() == "1"){
        var url = "usernameChange.php";
      }
      else if($("#settingsSelect").val() == "2"){
        var url = "passwordChange.php";
      }
      else if($("#settingsSelect").val() == "3"){
        var url = "deleteProfile.php";
      }
      window.location.replace(url);
    }
    
  }
</script>