<?php 
// include 'database.php';
// $dbConn = getDatabaseConnection();

// $username = POST['username'];

// function getUsername() {
//   global $dbConn;
  
//     $sql = "SELECT * FROM `users` WHERE username"; 
//     $statement = $dbConn->prepare($sql); 
//     $statement->execute();

//     $records = $statement->fetchAll(); 
// }

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
        
        <h2>User's Name</h2>
        <h3>@username</h3>
        
        <div class="bio">
          <p>Lifelong writer. Gamer. Bacon lover. Devoted coffeeaholic. Professional alcohol practitioner. Food buff.</p>
        </div>
        
          <div align="center" class="postedImages">
            
            <img src="images/lime1.jpg" id="images" onclick="imagePopUp()">
            <img src="images/lime2.jpg" id="images">
            <img src="images/lime3.jpg" id="images">
            <br>
            <img src="images/lime4.jpg" id="images">
            <img src="images/lime5.jpg" id="images">
            <img src="images/lime6.jpg" id="images">
        </div>
       
  </body>
</html>