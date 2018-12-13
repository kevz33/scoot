<?php

include 'database.php';

session_start();

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
    echo "Not Supported";
    break;
  case 'POST':
    // Get the body json that was sent
    $rawJsonString = file_get_contents("php://input");

    //var_dump($rawJsonString);

    // Make it a associative array (true, second param)
    $jsonData = json_decode($rawJsonString, true);

    $data = searchDatabase($jsonData["searched"], $jsonData["filter"]);
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
?>

<?php


function searchDatabase($searched, $filter){
  if($filter == "None"){
    $dbConn = getDatabaseConnection();
    $sql = "SELECT posts.text, posts.dateUpload, users.username 
    FROM `posts` 
    LEFT JOIN `users` on posts.userID = users.user_id
    WHERE posts.text like '%" . $searched . "%'
    OR users.username like :searched;";
    $statement = $dbConn->prepare($sql); 
    
    $statement->execute(array(':searched'=>$searched)); 
    $postRecords = $statement->fetchAll();
    
    $dbConn = getDatabaseConnection();
    $sql = "SELECT pictures.description, pictures.uploadDate, pictures.imageID, users.username
            FROM `pictures`
            LEFT JOIN `users` on pictures.userID = users.user_id
            WHERE pictures.description like '%" . $searched . "%'
            OR users.username like :searched;"; 
    $statement = $dbConn->prepare($sql); 
    $statement->execute(array(':searched'=>$searched)); 
    $photoRecords = $statement->fetchAll();
  
    $combinedRecords = array_merge($postRecords, $photoRecords);
    function date_compare($a, $b)
    {
      $t1 = strtotime($a[1]);
      $t2 = strtotime($b[1]);
      return $t1 - $t2;
    }    
    usort($combinedRecords, 'date_compare');
    $records = array_reverse($combinedRecords);
    return $records;
  }
  else if($filter == "username"){
    $dbConn = getDatabaseConnection();
    $sql = "SELECT posts.text, posts.dateUpload, users.username 
    FROM `posts` 
    LEFT JOIN `users` on posts.userID = users.user_id
    WHERE users.username = :username";
    $statement = $dbConn->prepare($sql); 
    
    $statement->execute(array(':username'=>$searched)); 
    $postRecords = $statement->fetchAll();
    
    $sql = "SELECT pictures.imageID, users.username 
              FROM `pictures` 
              LEFT JOIN `users` on pictures.userID = users.user_id
              WHERE users.username = :username";
      $stmt = $dbConn->prepare($sql);
      $stmt->execute(array(":username"=> $searched));
      $photoRecords = $stmt->fetchAll();
      
    $combinedRecords = array_merge($postRecords, $photoRecords);
    function date_compare($a, $b)
    {
      $t1 = strtotime($a[1]);
      $t2 = strtotime($b[1]);
      return $t1 - $t2;
    }    
    usort($combinedRecords, 'date_compare');
    $records = array_reverse($combinedRecords);
    return $records;
  }
  
  else if($filter == "text"){
    $dbConn = getDatabaseConnection();
    $sql = "SELECT posts.text, posts.dateUpload, users.username 
    FROM `posts` 
    LEFT JOIN `users` on posts.userID = users.user_id
    WHERE posts.text like '%" . $searched . "%';";
    $statement = $dbConn->prepare($sql); 
    
    $statement->execute(); 
    $postRecords = $statement->fetchAll();
    function date_compare($a, $b)
    {
      $t1 = strtotime($a[1]);
      $t2 = strtotime($b[1]);
      return $t1 - $t2;
    }    
    usort($postRecords, 'date_compare');
    $records = array_reverse($postRecords);
    return $records;
      
  }
  else if($filter == "image"){
    $dbConn = getDatabaseConnection();
    $sql = "SELECT pictures.description, pictures.uploadDate, pictures.imageID, users.username
            FROM `pictures`
            LEFT JOIN `users` on pictures.userID = users.user_id
            WHERE pictures.description LIKE '%" . $searched . "%';"; 
    $statement = $dbConn->prepare($sql); 
    $statement->execute(); 
    $photoRecords = $statement->fetchAll();
  
    function date_compare($a, $b)
    {
      $t1 = strtotime($a[1]);
      $t2 = strtotime($b[1]);
      return $t1 - $t2;
    }    
    usort($photoRecords, 'date_compare');
    $records = array_reverse($photoRecords);
    return $records;
  }
}
    

?>