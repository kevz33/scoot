<?php

// connect to our mysql database server

function getDatabaseConnection() {
    
    
    if($_SERVER['SEVER_NAME'] =="mikal-cst336-mikal.c9users.io"){
    $host = "localhost";
    $username = "Mikal";
    $password = "847Themikeman"; // best practice: define this in a separte file
    $dbname = "meme_lab"; 
    
    }else{
        $host = "us-cdbr-iron-east-01.cleardb.net";
    $username = "baa5d52535b2e7";
    $password = "99df1e31"; // best practice: define this in a separte file
    $dbname = "heroku_b659feb23887a6f"; 
        
    }
    
    // Create connection
    $dbConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $dbConn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $dbConn; 
}

// temporary test code
//$dbConn = getDatabaseConnection(); 
 

?>
