<?php 
    session_start();
  include 'database.php';
  $dbConn = getDatabaseConnection();
   
  function getImage() {
      global $dbConn;
  $sql = "SELECT * FROM pictures WHERE userID = :userID";
  $stmt = $dbConn->prepare($sql);
  $stmt->execute(array(":imageID"=> $_SESSION['user_id']));
  $stmt->bindColumn('fileData', $data, PDO::PARAM_LOB);
  $record = $stmt->fetch(PDO::FETCH_BOUND);
     
  if (!empty($record)){
        header('Content-Type:' . $record['fileType']);   //specifies the mime type
        header('Content-Disposition: inline;');
        echo $data; 
    } $records;
    
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
        <h1><img src="images/scoot.png" id="logo">
        
        <img src="images/avatar.png" class="profilePic" alt="Avatar" style="border-radius: 50%; width:10%">
        
        <h2><?php echo "@{$_SESSION['username']}" ?></h2>
        
        <!--<div class="bio">-->
        <!--  <p>Lifelong writer. Gamer. Bacon lover. Devoted coffeeaholic. Professional alcohol practitioner. Food buff.</p>-->
        <!--</div>-->
        
          <div align="center" class="postedImages">
            
            <img src="getImage()" id="images">
            <img src="images/lime2.jpg" id="images">
            <img src="images/lime3.jpg" id="images">
            <br>
            <img src="images/lime4.jpg" id="images">
            <img src="images/lime5.jpg" id="images">
            <img src="images/lime6.jpg" id="images">
        </div>
       
  </body>
</html>