<?php
    include 'database.php'; 

    

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Create Account | Scoot</title>
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
            <h3>Create New Account</h3>
            <form method="POST" class="login">
                <input type="text" name="username" id="username" placeholder="Username"></input>
                <span id="#error-message"></span>
                <input type="password" name="password" id="password" placeholder="Password"></input>
                <input type="password" name="rePassword" id="rePassword" placeholder="Confirm Password"/>
                <span id="passConfirm"></span>
                <button type="button" name="create" value="Sign Up" id="signUpButton">Submit</button>
            </form> 
            <br>
             <a href="index.php">Login</a>
        </div>
       

    </body>
</html>
<script>


    $("#username")
            .change(function(e) {
                var userData = {
                    "username": $("#username").val()
                };
                
                //console.log(userData); 

                $.ajax({
                        url: "verify.php",
                        type: "POST",
                        dataType: "json",
                        contentType: "application/json",
                        data: JSON.stringify(userData)
                    })
                    .done(function(data) {
                        console.log("Was user found?", data.found);
                        if (!data.found) {
                            $("#error-message").html("Username not found"); 
                            document.getElementById("#error-message").innerHTML = "Username Available!";
                        } else {
                            $("#error-message").html("Username found"); 
                            document.getElementById("#error-message").innerHTML = "Username Taken!";
                        }
                    })
                    .fail(function(xhr, status, errorThrown) {
                        console.log(errorThrown)
                        console.log("error", xhr.responseText);
                    });
                
            });
    
    $("#signUpButton").click(onButtonClicked);
          
          function onButtonClicked(){
              
            if($("#password").val()!=$("#rePassword").val()){
                document.getElementById("passConfirm").innerHTML = "Passwords Do Not Match!";
            //document.getElementById("passConfirm").className = "error";
            //match = false;
            return false;
            
            }
            if( document.getElementById("#error-message").innerHTML == "Username Taken!"){
                return false;
            }
            if($("#password").val() ==""){
                return false;
            }
           
            //document.getElementById("passConfirm").innerHTML = "Passwords Okay!";
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
            
          }
          
          
         
</script>