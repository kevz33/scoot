<?php
session_start();
include 'database.php';
function filterUploadedFile() {
  $allowedTypes = array("text/plain","image/png");
  $allowedExtensions = array("txt", "png");
  $allowedSize = 1000;
  $filterError = "";
  if (!in_array($_FILES["fileName"]["type"],  $allowedTypes ) ) {
        $filterError = "Invalid type. <br>";
   }

  $fileName = $_FILES["fileName"]["name"];
   if (!in_array(substr($fileName,strrpos($fileName,".")+1), $allowedExtensions) ) {
       $filterError = "Invalid extension. <br>"; 
    }
   
   if ($_FILES["fileName"]["size"]  > $allowedSize  ) {
        $filterError .= "File size too big. <br>";
    }
    return $filterError;
}

function savePostToDatabase() {
    $dbConn = getDatabaseConnection();
    $sql = "INSERT INTO `posts` 
      (`postID`, `userID`, `text`, `dateUpload`) 
      VALUES 
      (NULL, :userID , :text, NOW());"; 
 
    $statement = $dbConn->prepare($sql); 
    $statement->execute(array(":userID"=>$_SESSION['user_id'], ":text"=>$_POST['text'])); 
    echo "<h2>Success</h2>";
    
}



function uploadPhoto() {
    $filterError = filterUploadedFile();
     if (!empty($filterError)) {
        if ($_FILES["fileName"]["error"] > 0) {
            echo "Error: " . $_FILES["fileName"]["error"] . "<br>";
        }
    else {
      echo "Upload: " . $_FILES["fileName"]["name"] . "<br>";
      echo "Type: " . $_FILES["fileName"]["type"] . "<br>";
      echo "Size: " . ($_FILES["fileName"]["size"] / 1024) . " KB<br>";
      $dbConn = getDatabaseConnection();
      $binaryData = file_get_contents($_FILES["fileName"]["tmp_name"]);
      $sql = "INSERT INTO pictures (imageID, userID, fileName, fileSize, fileType, fileData, uploadDate, description ) " . "  VALUES (NULL, :userID, :fileName, :fileSize, :fileType, :fileData, NOW(), :description) ";
      $stm=$dbConn->prepare($sql);
      $stm->execute(array (":userID"=>$_SESSION['user_id'], ":fileName"=>$_FILES["fileName"]["name"], ":fileSize"=>filesize($_FILES["fileName"]["tmp_name"]), ":fileType"=>$_FILES["fileName"]["type"], ":fileData"=>$binaryData, ":description"=>$_POST['description']));
      echo "Success";

    }
    }
} //endIf form submission

function uploadProfilePhoto(){
    $filterError = filterUploadedFile();
     if (!empty($filterError)) {
        if ($_FILES["fileName"]["error"] > 0) {
            echo "Error: " . $_FILES["fileName"]["error"] . "<br>";
        }
    else {
      $dbConn = getDatabaseConnection();
      $binaryData = file_get_contents($_FILES["fileName"]["tmp_name"]);
      $sql = "INSERT INTO profile_pictures (imageID, userID, fileName, fileSize, fileType, fileData) " . "  VALUES (NULL, :userID, :fileName, :fileSize, :fileType, :fileData) ";
      $stm=$dbConn->prepare($sql);
      $stm->execute(array (":userID"=>$_SESSION['user_id'], ":fileName"=>$_FILES["fileName"]["name"], ":fileSize"=>filesize($_FILES["fileName"]["tmp_name"]), ":fileType"=>$_FILES["fileName"]["type"], ":fileData"=>$binaryData));
      echo "Success";

    }
    }
}

if (isset($_POST['uploadPhoto'])) {
    uploadPhoto();
}

if(isset($_POST['uploadText'])){
    savePostToDatabase();
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Scoot</title>
    <link rel="stylesheet" type="text/css" href="styles/uploadStyles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </head>
  <body>
        <h1><img src="images/scoot.png" id="logo" style="cursor: pointer;" onclick="window.location.href='home.php'">
         <br><br><br>
        <div id="home">
        <nav>
          <a style="margin-right:200px"href="profile.php"> My Profile </a>
        
          <a href="logout.php"> Logout </a>
       </nav>

       <br>
       <br>
       <br>
       </div>
      
        </h1>
        <br>
        <div id = "wrapper">
        <div id = "imageForm">
            <h2>Post an Image</h2>
            <form method="POST" enctype="multipart/form-data"> 
            
                <input type="file" name="fileName" /> <br />
                <br>
                
                <textarea rows="4" cols="50" type="text" name="description" placeholder="Insert Caption"></textarea>
                <br><br>
                <input type="submit"  name="uploadPhoto" class="notWhite" value="Post" /> 
            </form>
        </div>

        <div id = "textForm">
            <h2>Text Post</h2>
            <form method="POST"> 
                <br><br>
                <textarea rows="4" cols="50" type="text" name="text" placeholder="How was your Scoot?"></textarea>
                <br><br>
                <input type="submit"  name="uploadText" value="Post" class="notWhite" /> 
            </form>
        </div>
        </div>
  </body>
</html>

