<?php
session_start();
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
      echo "Stored in: " . $_FILES["fileName"]["tmp_name"];
      include 'database.php';
      $dbConn = getDatabaseConnection();
      $binaryData = file_get_contents($_FILES["fileName"]["tmp_name"]);
      $sql = "INSERT INTO pictures (imageID, userID, fileName, fileSize, fileType, fileData, uploadDate, description ) " . "  VALUES (NULL, :userID, :fileName, :fileSize, :fileType, :fileData, NOW(), :description) ";
      $stm=$dbConn->prepare($sql);
      $stm->execute(array (":userID"=>$_SESSION['user_id'], ":fileName"=>$_FILES["fileName"]["name"], ":fileSize"=>filesize($_FILES["fileName"]["tmp_name"]), ":fileType"=>$_FILES["fileName"]["type"], ":fileData"=>$binaryData, ":description"=>$_POST['description']));
      echo "<br />File saved into database <br /><br />";

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
      echo "Upload: " . $_FILES["fileName"]["name"] . "<br>";
      echo "Type: " . $_FILES["fileName"]["type"] . "<br>";
      echo "Size: " . ($_FILES["fileName"]["size"] / 1024) . " KB<br>";
      echo "Stored in: " . $_FILES["fileName"]["tmp_name"];
      include 'database.php';
      $dbConn = getDatabaseConnection();
      $binaryData = file_get_contents($_FILES["fileName"]["tmp_name"]);
      $sql = "INSERT INTO profile_pictures (imageID, userID, fileName, fileSize, fileType, fileData) " . "  VALUES (NULL, :userID, :fileName, :fileSize, :fileType, :fileData) ";
      $stm=$dbConn->prepare($sql);
      $stm->execute(array (":userID"=>$_SESSION['user_id'], ":fileName"=>$_FILES["fileName"]["name"], ":fileSize"=>filesize($_FILES["fileName"]["tmp_name"]), ":fileType"=>$_FILES["fileName"]["type"], ":fileData"=>$binaryData));
      echo "<br />File saved into database <br /><br />";

    }
    }
}

if (isset($_POST['uploadForm'])) {
    uploadPhoto();
}
?>

<form method="POST" enctype="multipart/form-data"> 
    Select file: <input type="file" name="fileName" /> <br />
    Description: <input type="text" name="description"/>
    <input type="submit"  name="uploadForm" value="Upload File" /> 
    
</form>
