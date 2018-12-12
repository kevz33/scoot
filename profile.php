<?php 
  session_start();
    
  include 'database.php';
  $dbConn = getDatabaseConnection();
  
  
  function getImages() {
      global $dbConn;
      
      $sql = "SELECT * FROM pictures WHERE userID = :userID";
      $stmt = $dbConn->prepare($sql);
      $stmt->execute(array(":userID"=> $_SESSION['user_id']));
    //   $stmt->bindColumn('fileData', $data, PDO::PARAM_LOB);
    // $statement->execute(); 
//   $photoRecords = $statement->fetchAll();
      $records = $stmt->fetchAll();
        
         for($i=0; $i < count($records); $i++) 
      {
          echo "<div class='postedImages'>"  .  "<img src='downloadFile.php?imageID=" . $records[$i]["imageID"] . "' id='images'></div>";
      }
    //   if (!empty($records)){
    //         header('Content-Type:' . $record['fileType']);   //specifies the mime type
    //         header('Content-Disposition: inline;');
    //         echo $data; 
    //     } 
        
  }
  
  function getProfilePicture() {
    global $dbConn;
      
      $sql = "SELECT * FROM profile_pictures WHERE userID = :userID";
      $stmt = $dbConn->prepare($sql);
      $stmt->execute(array(":userID"=> $_SESSION['user_id']));
    //   $stmt->bindColumn('fileData', $data, PDO::PARAM_LOB);
    // $statement->execute(); 
//   $photoRecords = $statement->fetchAll();
      $records = $stmt->fetchAll();
      echo "<img src='downloadProfilePicture.php?imageID=" . $records[0]["imageID"] . "' class='profilePic' alt='Avatar' style='border-radius: 50%; width:10%'>";
  }
      
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Profile Page</title>
    <link rel="stylesheet" type="text/css" href="styles/profilePageStyle.css">
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->
    <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
  </head>
  <body>
        <h1><img src="images/scoot.png" id="logo" onclick="window.location.href='home.php'">
        
        <?php
          getProfilePicture();
        ?>
        <h2><?php echo "@{$_SESSION['username']}" ?></h2>
        
        <!--<div class="bio">-->
        <!--  <p>Lifelong writer. Gamer. Bacon lover. Devoted coffeeaholic. Professional alcohol practitioner. Food buff.</p>-->
        <!--</div>-->
        
          <div align="center" class="postedImages">
              
              <?php
              getImages();
      ?>
            
            <img src="images/lime1.jpg" id="images">
            <img src="images/lime2.jpg" id="images">
            <img src="images/lime3.jpg" id="images">
            <br>
            <img src="images/lime4.jpg" id="images">
            <img src="images/lime5.jpg" id="images">
            <img src="images/lime6.jpg" id="images">
        </div>
       
  </body>
</html>