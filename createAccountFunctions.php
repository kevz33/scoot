<?php
session_start(); 
include 'database.php'; 
//$dbConn = getDatabaseConnection(); 
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

    $data = createUser($jsonData["username"], $jsonData["password"], $jsonData["rePassword"]);
    
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

function createUser($username, $password, $rePassword){

    //$dbConn = getDatabaseConnection(); 
        //echo "im here!";
        //$userCheck;
        $dbConn = getDatabaseConnection(); 

        //$dbConn = getDatabaseConnection();
        $sql = "INSERT INTO `users` (`user_id`, `username`, `password`) VALUES ('@NextId', '$username', SHA1('$password'))";
        $statement = $dbConn->prepare($sql); 
        $statement->execute(); 
        
        return $records;
    
    }
?>