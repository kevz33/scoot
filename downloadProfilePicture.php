<?php

 include 'database.php';
$dbConn = getDatabaseConnection();
 $sql = "SELECT * FROM profile_pictures WHERE imageID = :imageID"; 
 $stmt = $dbConn->prepare($sql);
 $stmt->execute(array(":imageID"=> $_GET['imageID']));
 $stmt->bindColumn('fileData', $data, PDO::PARAM_LOB);
 $record = $stmt->fetch(PDO::FETCH_BOUND);
 
 if (!empty($record)){
    header('Content-Type:' . $record['fileType']);   //specifies the mime type
    header('Content-Disposition: inline;');
    echo $data; 
  } 
?>
