<?php
    include 'database.php'; 

    

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
            <h3>Create New Account</h3>
            <form method="POST" class="login">
                <input type="text" name="username" id="username" placeholder="Username"></input>
                <input type="text" name="email" placeholder="Email"></input>
                <input type="password" name="password" id="password" placeholder="Password"></input>
                <input type="password" name="rePassword" id="rePassword" placeholder="Confirm Password"/>
                <span id="passConfirm"></span>
                <button type="button" name="create" value="Sign Up" id="signUpButton">Submit</button>
            </form> 
            
             <a href="index.php">Login</a>
        </div>
       

    </body>
</html>
<script>
    
    $("#signUpButton").click(onButtonClicked);
          
          function onButtonClicked(){
              
            if($("#password").val()==$("#rePassword").val()){  
             //console.log("same");
              var jsonData ={
             "username": $("#username").val(),
             "password": $("#password").val(),
             "rePassword": $("#rePassword").val()
            };
            
            $.ajax({
              url:"createAccountFunctions.php",
              type: "POST",
              dataType: "json",
              contentType: "application/json",
              data: JSON.stringify(jsonData),
              
            })
            .done(function(data){
             //console.log(data);
             console.log("Im done!");
              window.location.replace("index.php");
            })
            .always(function(xhr,status){
             
            });
            }else{
            document.getElementById("passConfirm").innerHTML = "Passwords Do Not Match!";
            //document.getElementById("passConfirm").className = "error";
            //match = false;
            return false;
            }
          }
          
         
</script>