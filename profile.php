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
            echo "<img src='downloadFile.php?imageID=" . $records[$i]["imageID"] . "' id='images'>";
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
      echo "<div id= 'bio'><p>Referral Code: " . $records[0]["referralCode"] . "     I've been on " . $records[0]['rides'] . " rides</p></div>";
    }
    
  }
      
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo "@{$_SESSION['username']}" ?> | Scoot</title>
    <link rel="stylesheet" type="text/css" href="styles/profilePageStyle.css">
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
       
  </body>
</html>