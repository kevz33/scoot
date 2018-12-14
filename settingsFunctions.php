<?php
session_start(); 
include 'database.php'; 
$httpMethod = strtoupper($_SERVER['REQUEST_METHOD']);


switch($httpMethod) {
  case "OPTIONS":
    // Allows anyone to hit your API, not just this c9 domain
    header("Access-Control-Allow-Headers: X-ACCESS_TOKEN, Access-Control-Allow-Origin, Authorization, Origin, X-Requested-With, Content-Type, Content-Range, Content-Disposition, Content-Description");
    header("Access-Control-Allow-Methods: POST, GET");
    header("Access-Control-Max-Age: 3600");
    exit();
  case "GET":
    // Allow any client to access
    header("Access-Control-Allow-Origin: *");
    
    http_response_code(401);
    //echo "Not Supported";
    
    break;
  case 'POST':
    // Get the body json that was sent
    $rawJsonString = file_get_contents("php://input");

    //var_dump($rawJsonString);

    // Make it a associative array (true, second param)
    $jsonData = json_decode($rawJsonString, true);
    
    if(isset($jsonData["newUsername"])){
        $data = changeUsername($jsonData["newUsername"], $jsonData["password"]);
    }
    
    elseif(isset($jsonData["newPassword"])){
        $data = changePassword($jsonData["password"], $jsonData["newPassword"]);
    }
    elseif(isset($jsonData["answer"])){
        $data = deleteUser();
    }

    
    
    $results = ["statusCode" => "0",
                "data" => $data];

    // Allow any client to access
    header("Access-Control-Allow-Origin: *");
    // Let the client know the format of the data being returned
    header("Content-Type: application/json");

    // Sending back down as JSON
    echo json_encode($results);

    break;
  case 'PUT':
    // Allow any client to access
    header("Access-Control-Allow-Origin: *");
    
    http_response_code(401);
    echo "Not Supported";
    break;
  case 'DELETE':
    // Allow any client to access
    header("Access-Control-Allow-Origin: *");
    
    http_response_code(401);
    break;
}

function changeUsername($newUsername, $password){
    
    $dbConn = getDatabaseConnection(); 
    $sql = "SELECT * FROM `users` WHERE username=:newUsername"; 
    $statement = $dbConn->prepare($sql); 
    $statement->execute(array(':newUsername' => $newUsername));
    $records = $statement->fetchAll();
    if( count($records) == 0){
        $dbConn = getDatabaseConnection(); 
        
        $sql = "SELECT * FROM `users` WHERE username = :username AND password=SHA(:password)"; 
        $statement = $dbConn->prepare($sql); 
        $statement->execute(array(':username' => $_SESSION['username'], ':password' => $password));
    
        $records = $statement->fetchAll(); 
        if(count($records) == 0){
            return "Invalid password";
        }
        else{
            $dbConn = getDatabaseConnection(); 
            $sql = "UPDATE users 
                    SET username = :newUsername 
                    WHERE username = :username AND password=SHA(:password)";
            $statement = $dbConn->prepare($sql); 
            $statement->execute(array(':newUsername' => $newUsername, ':username' => $_SESSION['username'], ":password" => $password));
            $_SESSION['username'] = $newUsername;
            return "true";
        }
    }
    else{
        return "Username already exists";
    }
    
    }
    
function changePassword($password, $newPassword){
    $dbConn = getDatabaseConnection(); 
        
    $sql = "SELECT * FROM `users` WHERE username = :username AND password=SHA(:password)"; 
    $statement = $dbConn->prepare($sql); 
    $statement->execute(array(':username' => $_SESSION['username'], ':password' => $password));
    
    $records = $statement->fetchAll(); 
    if(count($records) == 0){
        return "Invalid password";
    }
    else{
        $dbConn = getDatabaseConnection(); 
        $sql = "UPDATE users 
               SET password = SHA(:newPassword) 
               WHERE username = :username AND password=SHA(:password)";
        $statement = $dbConn->prepare($sql); 
        $statement->execute(array(':newPassword' => $newPassword, ':username' => $_SESSION['username'], ":password" => $password));
        $_SESSION['username'] = $newUsername;
        return "true";
    }
}

function deleteUser(){
    $dbConn = getDatabaseConnection(); 
        
    $sql = "DELETE FROM lime WHERE userID=:userID;
            DELETE FROM pictures WHERE userID=:userID;
            DELETE FROM posts WHERE userID=:userID;
            DELETE FROM profile_pictures WHERE userID=:userID;
            DELETE FROM users WHERE user_id=:userID;"; 
    $statement = $dbConn->prepare($sql); 
    $statement->execute(array(':userID' => $_SESSION['user_id']));
    
    return "true";
}
?>