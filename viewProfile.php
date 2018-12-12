<!--  if (count($records) == 1) {-->
<!--        // login successful-->
<!--        $_SESSION['user_id'] = $records[0]['user_id']; -->
<!--        $_SESSION['username'] = $records[0]['username']; -->
<!--        header('Location: index.php');-->
        
<!--    }  else {-->
<!--        echo "<div class='error'>Username and password are invalid </div>"; -->
<!--    }-->
<!--}-->
function searchForUser() {
    global $dbConn; 
    
    $sql = "SELECT 
        users.username
      FROM users "; 
    
    if(isset($_POST['search'])) {
      // query the databse for any records that match this search
      $sql .= " AND (username LIKE '%{$_POST['search']}%')";
    } 
    
    $statement = $dbConn->prepare($sql); 
    $statement->execute(); 
    $records = $statement->fetchOne(); 
    
    return $records; 
}
function displayMemes($records) {
  echo '<div class="memes-container">'; 
    
      
  foreach ($records as $record) {
       $memeURL = $record['meme_url']; 
       echo  '<div class="meme-div" style="background-image:url('. $memeURL .')">'; 
       echo  '<h2 class="line1">' . $record["line1"] . '</h2>'; 
       echo  '<h2 class="line2">' . $record["line2"] . '</h2>'; 
       echo  '</div>'; 
  }
  
  echo '<div style="clear:both"></div>'; 
  echo '</div>'; 
}

<?php 
  session_start();
    
  include 'database.php';
  $dbConn = getDatabaseConnection();
  print_r($_SESSION);
  
  
  function getImages() {
      global $dbConn;
      
      $sql = "SELECT * FROM users WHERE username = :username";
      $stmt = $dbConn->prepare($sql);
      $stmt->execute(array(":username"=> $_SESSION['username']));
    //   $stmt->bindColumn('fileData', $data, PDO::PARAM_LOB);
    // $statement->execute(); 
//   $photoRecords = $statement->fetchAll();
      $records = $stmt->fetchAll();
      echo $records;
      
      echo "<br>";
      echo "records: <br>";
        //  print_r($records);
        
        
        
        
        
         
         for($i=0; $i < count($records); $i++) 
      {
          echo "<div class='postedImages'>"  .  "<img src='?imageID=" . $records[$i]["imageID"] . "' ></div>";
      }
    //   if (!empty($records)){
    //         header('Content-Type:' . $record['fileType']);   //specifies the mime type
    //         header('Content-Disposition: inline;');
    //         echo $data; 
    //     } 
        
  }
       getImages();
      

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
        
        <img src="images/avatar.png" class="profilePic" alt="Avatar" style="border-radius: 50%; width:10%">
        
        <h2><?php echo "@{$_SESSION['username']}" ?></h2>
        
        <!--<div class="bio">-->
        <!--  <p>Lifelong writer. Gamer. Bacon lover. Devoted coffeeaholic. Professional alcohol practitioner. Food buff.</p>-->
        <!--</div>-->
        
          <div align="center" class="postedImages">
              
              <?php
              for($i=0; $i < count($records); $i++) 
      {
        //   echo "<div class='postedImages'>";
        //   echo "<img src='getImages.php?imageID=" . $records[$i]["imageID"] . "' >";
        //   echo "</div>";
      }
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