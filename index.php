<?php

include 'loginFunctions.php'; 

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Scoot</title>
        <link rel="stylesheet" type="text/css" href="styles/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
                <input type="password" name="password" id="password" placeholder="Password"></input><span id="Invalid"></span>
                <button type="button" id="submitBtn" value="Login">Submit</button>
            </form> 
            
            <a href="createAccount.php">Create New Account</a>
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
                            document.getElementById("Invalid").innerHTML = "Invalid Credentials";
                        }
                        else{
                            window.location.replace("home.php");
                        }
                        
                    })
                    
                    .always(function(xhr, status) {
                        
                    });

            
        }
</script>