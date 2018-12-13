<?php 
  session_start();
    
  include 'database.php';
  $dbConn = getDatabaseConnection();
  
  
  function getImages() {
      global $dbConn;
      
      $sql = "SELECT * FROM pictures WHERE userID = :userID";
      $stmt = $dbConn->prepare($sql);
      $stmt->execute(array(":userID"=> $_SESSION['user_id']));
      $records = $stmt->fetchAll();
      
      $j = 0;
      echo "<div class='postedImages'>";
          
      for($i=0; $i < count($records); $i++) {
            echo "<img src='downloadFile.php?imageID=" . $records[$i]["imageID"] . "' id='images'>";
            $j++; 
            
          if($j % 3 == 0) {
              echo "<br>";
          }
      }
      echo "</div>";
        
  }
  
  function getProfilePicture() {
    global $dbConn;
      
      $sql = "SELECT * FROM profile_pictures WHERE userID = :userID";
      $stmt = $dbConn->prepare($sql);
      $stmt->execute(array(":userID"=> $_SESSION['user_id']));
      $records = $stmt->fetchAll();
      
    //   echo "<br> records: <br>";
    //   print_r($records);
      
      if(count($records) == 0) {
            echo "<img src='images/avatar.png' class='profilePic' alt='Avatar' style='border-radius: 50%; width:10%'>";
      } else {
            echo "<img src='downloadProfilePicture.php?imageID=" . $records[0]["imageID"] . "' class='profilePic' style='border-radius: 50%; width:10%'>";
            }  
      }
      
  function getLimeData(){
    global $dbConn;
    $sql = "SELECT * FROM lime WHERE userID = :user_id";
    $stmt = $dbConn->prepare($sql);
    $stmt->execute(array(":user_id"=> $_SESSION['user_id']));
    $records = $stmt->fetchAll();
    if(count($records) == 1){
      echo "<br><div id= 'bio'><h3>Referral Code: " . $records[0]["referralCode"] . "     I've been on " . $records[0]['rides'] . " rides</h3></div>";
    }
    
  }
      
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo "@{$_SESSION['username']}" ?> | Scoot</title>
    <link rel="stylesheet" type="text/css" href="styles/profilePageStyle.css">
    <link rel="icon" type="image/png" sizes="96x96" href="icon/favicon-96x96.png">
  </head>
  
  <body>
        <h1><img src="images/scoot.png" id="logo" onclick="window.location.href='home.php'" style="cursor:pointer">
        <div class="custom-select" style="width:200px;">
          <select>
            <option value="0">Settings</option>
            <option value="1">Change Username</option>
            <option value="2">Change Password</option>
            <option value="3">Delete Account</option>
          </select>
        </div>
        
        <script>
          var x, i, j, selElmnt, a, b, c;
/* Look for any elements with the class "custom-select": */
x = document.getElementsByClassName("custom-select");
for (i = 0; i < x.length; i++) {
  selElmnt = x[i].getElementsByTagName("select")[0];
  /* For each element, create a new DIV that will act as the selected item: */
  a = document.createElement("DIV");
  a.setAttribute("class", "select-selected");
  a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
  x[i].appendChild(a);
  /* For each element, create a new DIV that will contain the option list: */
  b = document.createElement("DIV");
  b.setAttribute("class", "select-items select-hide");
  for (j = 1; j < selElmnt.length; j++) {
    /* For each option in the original select element,
    create a new DIV that will act as an option item: */
    c = document.createElement("DIV");
    c.innerHTML = selElmnt.options[j].innerHTML;
    c.addEventListener("click", function(e) {
        /* When an item is clicked, update the original select box,
        and the selected item: */
        var y, i, k, s, h;
        s = this.parentNode.parentNode.getElementsByTagName("select")[0];
        h = this.parentNode.previousSibling;
        for (i = 0; i < s.length; i++) {
          if (s.options[i].innerHTML == this.innerHTML) {
            s.selectedIndex = i;
            h.innerHTML = this.innerHTML;
            y = this.parentNode.getElementsByClassName("same-as-selected");
            for (k = 0; k < y.length; k++) {
              y[k].removeAttribute("class");
            }
            this.setAttribute("class", "same-as-selected");
            break;
          }
        }
        h.click();
    });
    b.appendChild(c);
  }
  x[i].appendChild(b);
  a.addEventListener("click", function(e) {
    /* When the select box is clicked, close any other select boxes,
    and open/close the current select box: */
    e.stopPropagation();
    closeAllSelect(this);
    this.nextSibling.classList.toggle("select-hide");
    this.classList.toggle("select-arrow-active");
  });
}

function closeAllSelect(elmnt) {
  /* A function that will close all select boxes in the document,
  except the current select box: */
  var x, y, i, arrNo = [];
  x = document.getElementsByClassName("select-items");
  y = document.getElementsByClassName("select-selected");
  for (i = 0; i < y.length; i++) {
    if (elmnt == y[i]) {
      arrNo.push(i)
    } else {
      y[i].classList.remove("select-arrow-active");
    }
  }
  for (i = 0; i < x.length; i++) {
    if (arrNo.indexOf(i)) {
      x[i].classList.add("select-hide");
    }
  }
}

/* If the user clicks anywhere outside the select box,
then close all select boxes: */
document.addEventListener("click", closeAllSelect);
        </script>
        
        <div id="nav_div">
            <nav>
              <a style="margin-right:200px"href="home.php"> Home </a>            
              <a href="logout.php"> Logout </a>
           </nav>
       </div>
        
        <?php
          getProfilePicture();
          echo "<br>";
          getLimeData();
        ?>
        
        <h2><?php echo "@{$_SESSION['username']}" ?></h2>
        
          <div align="center" class="postedImages">
              
              <?php
                getImages();
              ?>
            
        
        </div>
       
  </body>
</html>