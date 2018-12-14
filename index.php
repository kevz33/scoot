<?php
session_start();
include 'loginFunctions.php'; 

if(isset($_POST['guestBtn'])){
    $_SESSION['loggedIn'] = "No";
    header('Location: home.php');
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Login | Scoot</title>
        <link rel="stylesheet" type="text/css" href="styles/style.css">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link rel="icon" type="image/png" sizes="96x96" href="icon/favicon-96x96.png">
    </head>
    <body>
        <header>
            <div class="top">
                <img src="images/scoot.png" id="logo">
            </div>
            
        </header>
        
        <div class="center">
            <h3>Let's Scoot!</h3>
            <form method="POST" class="login">
                <input type="text" name="username" id ="username" placeholder="Username"></input>
                <input type="password" name="password" id="password" placeholder="Password"></input>
                <button type="button" id="submitBtn" value="Login">Submit</button>
            </form> 
            <br>
            <div class = "error">
            
            </div>
            
            <a href="createAccount.php">Create New Account</a>
            <br>
            <form method="POST" class = "login">
                <input type="submit" name="guestBtn" value="Continue as Guest">
            </form>
        </div>
       

    </body>
</html>

<script>
    $("#submitBtn").click(onButtonClicked);
    
    function onButtonClicked() {
            var jsonData = {
                "username": $("#username").val(),
                "password" : $("#password").val()
            };

            $.ajax({
                    // The URL for the request
                    url: "loginFunctions.php",

                    // Whether this is a POST or GET request
                    type: "POST",

                    // The type of data we expect back
                    dataType: "json",

                    contentType: "application/json",

                    data: JSON.stringify(jsonData),
                    
            })
                    .done(function(data) {
                        if(data["data"] == false){
                            $(".error").empty();
                           $(".error").html("Invalid Credentials<br>");
                        }
                        else{
                            window.location.replace("functions.html");
                        }
                        
                    })
                    
                    .always(function(xhr, status) {
                        
                    });

            
        }
</script>