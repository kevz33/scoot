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
        <title>Scoot</title>
        <link rel="stylesheet" type="text/css" href="styles/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    </head>
    <body>
        <header>
            <div class="top">
                <img src="images/scoot.png" id="logo" onclick="window.location.href='home.php'" style="cursor:pointer">
            </div>
            
        </header>
        
        <a style='margin-right:200px'href='profile.php'> My Profile </a>
        
        <a href='logout.php'> Logout </a>
        
        <div class="center">
            <h3>Change Username</h3>
            <form method="POST" class="login">
                <input type="text" name="newUsername" id ="newUsername" placeholder="New Username"></input>
                <input type="password" name="password" id="password" placeholder="Password"></input><span id="Invalid"></span>
                <button type="button" id="submitBtn" value="change">Change</button>
            </form> 
        </div>
        
        <div class="error">
            
        </div>
       

    </body>
</html>

<script>
    $("#submitBtn").click(onButtonClicked);
    
    function onButtonClicked() {
            var jsonData = {
                "newUsername": $("#newUsername").val(),
                "password" : $("#password").val()
            };

            $.ajax({
                    // The URL for the request
                    url: "settingsFunctions.php",

                    // Whether this is a POST or GET request
                    type: "POST",

                    // The type of data we expect back
                    dataType: "json",

                    contentType: "application/json",

                    data: JSON.stringify(jsonData),
                    
            })
                    .done(function(data) {
                        if(data["data"] == "true"){
                            $(".error").empty();
                            $(".center").empty();
                            $(".center").html("<h2>Username Changed</h2>");
                        }
                        else{
                            $(".error").empty();
                            $(".error").append("<h2>" + data["data"] + "</h2>");
                        }
                        
                    })
                    
                    .always(function(data, status) {
                    });

            
        }
</script>