<?php

session_start(); 
include 'database.php'; 
$dbConn = getDatabaseConnection(); 

function validate($username, $password) {
    
    global $dbConn; 
    $dbConn = getDatabaseConnection(); 
    
    $sql = "SELECT * FROM `users` WHERE username=:username AND password=SHA(:password)"; 
    $statement = $dbConn->prepare($sql); 
    $statement->execute(array(':username' => $username, ':password' => $password));

    $records = $statement->fetchAll(); 
    
    
    if (count($records) >= 1) {
        // login successful
        $_SESSION['user_id'] = $records[0]['user_id']; 
        $_SESSION['username'] = $records[0]['username']; 
        header('Location: home.html');
        
    }  else {
        echo "<div class='error'>Username and password are invalid </div>"; 
    }
    
    
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Scoot</title>
        <link rel="stylesheet" type="text/css" href="styles/style.css">
    </head>
    <body>
        <header>
            <div class="top">
                <img src="images/scoot.png" id="logo">
            </div>
            
        </header>
        
        <?php 
            if (isset($_POST['username'])) {
                validate($_POST['username'], $_POST['password']);  
            }
        ?>
        
        <div class="center">
            <h3>Let's Scoot!</h3>
            <form method="POST" class="login">
                <input type="text" name="username" placeholder="Username"></input>
                <input type="password" name="password" placeholder="Password"></input>
                <input type="submit" value="Login">
            </form> 
            
            <a href="createAccount.php">Create New Account</a>
        </div>
       

    </body>
</html>