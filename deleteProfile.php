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
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    </head>
    <body>
        <header>
            <div class="top">
                <img src="images/scoot.png" id="logo" onclick="window.location.href='home.php'" style="cursor:pointer">
            </div>
            
        </header>
        <nav id="nav">
        <a style='margin-right:200px'href='profile.php'> My Profile </a>
        <a href='logout.php'> Logout </a>
        </nav>
        <div class="center">
            <h3>Are you sure you want to delete your account?</h3>
            <br>
        
            <form method="POST" class="login">
                <input type="radio" name="answer" value="yes"> Yes
                <input type="radio" name="answer" value="no"> No<br>
                <br><br>
                <button type="button" id="submitBtn" value="submit">Submit</button>
            </form> 
        </div>
        
        <div class="error">
            
        </div>
       

    </body>
</html>

<script>
    $("#submitBtn").click(onButtonClicked);
    
    function onButtonClicked() {
            if($('input[name=answer]:checked').val() == "yes"){
            var jsonData = {
                "answer" : "yes"
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
                            window.location.replace("index.php");
                        }
                        else{
                            $(".error").empty();
                            $(".error").append("<h2>Error</h2>");
                        }
                        
                    })
                    
                    .always(function(data, status) {
                        console.log(data);
                    });

            
         }
    }
</script>