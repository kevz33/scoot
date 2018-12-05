<?php
    include 'database.php'; 
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password2 = $_POST['rePassword'];
    

    if(isset($_POST['create'])){
        
        if($password == $password2){
            
        $dbConn = getDatabaseConnection();
        $sql = "INSERT INTO `users` (`user_id`, `username`, `password`) VALUES ('@NextId', '$username', SHA1('$password'))";
        $statement = $dbConn->prepare($sql); 
        $statement->execute(); 
        
        header( 'Location: index.php' );
        
        }else{
            echo "<div class='error'> Passwords do not match </div>"; 
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
        
        <div class="center">
            <h3>Create New Account</h3>
            <form method="POST" class="login">
                <input type="text" name="username" placeholder="Username"></input>
                <input type="text" name="email" placeholder="Email"></input>
                <input type="password" name="password" placeholder="Password"></input>
                <input type="password" name="rePassword" placeholder="Confirm Password"/>
                <input type="submit" name="create" value="Sign Up">
            </form> 
            
             <a href="index.php">Login</a>
        </div>
       

    </body>
</html>