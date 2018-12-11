<?php
  session_start();
  include 'database.php';
  $dbConn = getDatabaseConnection();
 $sql = "SELECT posts.text, posts.dateUpload, users.username
        FROM `posts`
        LEFT JOIN `users` on posts.userID = users.user_id;"; 
  $statement = $dbConn->prepare($sql); 
  $statement->execute(); 
  $postRecords = $statement->fetchAll();
  
$dbConn = getDatabaseConnection();
 $sql = "SELECT pictures.description, pictures.uploadDate, pictures.imageID, users.username
        FROM `pictures`
        LEFT JOIN `users` on pictures.userID = users.user_id;"; 
  $statement = $dbConn->prepare($sql); 
  $statement->execute(); 
  $photoRecords = $statement->fetchAll();
  
  $combinedRecords = array_merge($postRecords, $photoRecords);
  
  
  function date_compare($a, $b)
{
    $t1 = strtotime($a[1]);
    $t2 = strtotime($b[1]);
    return $t1 - $t2;
}    
usort($combinedRecords, 'date_compare');
$records = array_reverse($combinedRecords);

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Home Page</title>
    <link rel="stylesheet" type="text/css" href="styles/homePageStyle.css">
    
  </head>
  <body>
        <h1><img src="images/scoot.png" id="logo">
         
        <div id="home">
          <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

            <form action="">
              <input type="search">
              <i class="fa fa-search"></i>
            </form>
        <nav>
          <a style="margin-right:200px"href="profile.php"> My Profile </a>
        
          <a href="index.html"> Logout </a>
       </nav>
        </h1>
        <br><br>
        <div id="posts">
          <?php
            for($i=0; $i < count($records); $i++){
              if(isset($records[$i]['text'])){
                echo "<div class='new_post'>" . $records[$i]['username'] . ":     " . $records[$i]["text"] . "</div>";
              }
              else{
                echo "<div class='new_post'>" . $records[$i]['username'] . ": " . $records[$i]['description'] .  "<img src='downloadFile.php?imageID=" . $records[$i]["imageID"] . "' width='175' height='200'></div>";
              }
              echo "<br>";
              
            }
          ?>
        </div>
  </body>
</html>