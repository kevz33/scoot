<?php
    
  session_start();
  //include 'functions.php';
  //include 'viewprofile.php';
  include 'database.php';
  $dbConn = getDatabaseConnection();
 $sql = "SELECT posts.text, posts.dateUpload, users.username
        FROM `posts`
        LEFT JOIN `users` on posts.userID = users.user_id;"; 
  $statement = $dbConn->prepare($sql); 
  $statement->execute(); 
  $postRecords = $statement->fetchAll();
  
$dbConn = getDatabaseConnection();
 $sql = "SELECT pictures.description, pictures.uploadDate, pictures.imageID, users.username
        FROM `pictures`
        LEFT JOIN `users` on pictures.userID = users.user_id;"; 
  $statement = $dbConn->prepare($sql); 
  $statement->execute(); 
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





global $wp_query; // you can remove this line if everything works for you
 
// don't display the button if there are not enough posts
if (  $wp_query->max_num_pages > 1 )
	echo '<div class="misha_loadmore">More posts</div>';
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Home Page</title>
    <link rel="stylesheet" type="text/css" href="styles/homePageStyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </head>
  <body>
        <h1><img src="images/scoot.png" id="logo">
         
        <div id="home">
          <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

            <form id="search" action="viewprofile.php">
              <input type="search" placeholder="Search for User">
              <i class="fa fa-search"></i>
            </form>
        <nav>
          <a style="margin-right:200px"href="profile.php"> My Profile </a>
        
          <a href="logout.php"> Logout </a>
       </nav>

       <br>
       <br>
       <br>
      
       <button id="postImageBtn">Post Image</button>
       </div>
      
        </h1>
        <br><br>
        <div id="posts">
          <?php
            for($i=0; $i < count($records); $i++){
              if(isset($records[$i]['text'])){
                echo "<div align='center''border:.5px' class='new_post'>" . $records[$i]['username'] . ":     " . $records[$i]["text"] . "</div>";
              }
              else{
                //echo "<div align='center' class='new_post'>";
                //echo "@" . $records[$i]['username']  . "<br>" . "<img src='downloadFile.php?imageID=". $records[$i]['imageID']  . "' width='287' height='287'>"  ."<br>" . $records[$i]['description'] . "</div>";
                echo "<div align='center'text-align:'left' class='new_post'>"."@" . $records[$i]['username']  . "<br>" . "<img src='downloadFile.php?imageID=". $records[$i]['imageID']  . "' width='287' height='287'>"  ."<br>" . $records[$i]['description'] . "</div>";
              }
              echo "<br>";
              
            }
          ?>
        </div>
  </body>
</html>

<script>
  $("#postImageBtn").click(postImageBtnClicked);
  
  function postImageBtnClicked() {
    window.location.replace("uploadFile.php");
  }
</script>

