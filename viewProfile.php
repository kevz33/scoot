<script>
  var username = window.location.hash.substring(1);
  document.cookie = "theirUsername = " + username;
  if( window.localStorage )
  {
    if( !localStorage.getItem('firstLoad') )
    {
      localStorage['firstLoad'] = true;
      window.location.reload();
    }  
    else
      localStorage.removeItem('firstLoad');
}
</script>
<?php 
  session_start();
    
  include 'database.php';
  $dbConn = getDatabaseConnection();
  
  
  function getImages() {
      global $dbConn;
      
      $sql = "SELECT pictures.imageID, users.username 
              FROM `pictures` 
              LEFT JOIN `users` on pictures.userID = users.user_id
              WHERE users.username = :username";
      $stmt = $dbConn->prepare($sql);
      $stmt->execute(array(":username"=> $_COOKIE['theirUsername']));
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
      
      $sql = "SELECT profile_pictures.imageID, users.username 
              FROM `profile_pictures` 
              LEFT JOIN `users` on profile_pictures.userID = users.user_id
              WHERE users.username = :username";
              
      $stmt = $dbConn->prepare($sql);
      $stmt->execute(array(":username"=> $_COOKIE['theirUsername']));
      $records = $stmt->fetchAll();
      
      if(count($records) >= 1){
        echo "<img src='downloadProfilePicture.php?imageID=" . $records[0]["imageID"] . "' class='profilePic' alt='Avatar' style='border-radius: 50%; width:10%'>";
      }
      else{
        echo "<img src='images/avatar.png' class='profilePic' style='border-radius: 50%; width:10%'>";
      }
      
  }
      
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo "@" . $_COOKIE['theirUsername']; ?> | Scoot</title>
    <link rel="stylesheet" type="text/css" href="styles/profilePageStyle.css">
    <link rel="icon" type="image/png" sizes="96x96" href="icon/favicon-96x96.png">
  </head>
  
  <body>
        <h1><img src="images/scoot.png" id="logo" onclick="window.location.href='home.php'" style="cursor:pointer"></h1>
        
        <div id="nav_div">
            <nav>
              <a style="margin-right:200px"href="home.php"> Home </a>            
              <a href="logout.php"> Logout </a>
           </nav>
       </div>
        
        <?php
          getProfilePicture();
        ?>
        
        <h2><?php echo "@{$_COOKIE['theirUsername']}"; ?></h2>
        
          <div align="center" class="postedImages">
              
              <?php
                getImages();
              ?>
            
        </div>
       
  </body>
</html>