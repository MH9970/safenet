<?php
include 'config.php';

$sql = "SELECT * FROM news ORDER BY time DESC";
$result = $con->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="unews.css">
</head>
<body>
<div id="parent">
<div id="bar">
            <img src="logo.png" class="logo">
            <h2 style="margin-top:1vh; margin-left:2vh ;font-size:6vh;  "> <a href="home.php" class="home-link">SafeNet</a></h2>
              <button class="btn1" onclick="location.href='volunteer.html'">Volunteer</button>         
             <button class="btn" onclick="location.href='post.php'">post</button>      
              <button class="btn" onclick="location.href='ufoundation.php'">Foundation</button>        
              <button class="btn" onclick="location.href='donation.html'">Donation</button>
              <button class="btn" onclick="location.href='crisis_map.php'">Crisis Map</button>        
              <button class="btn" onclick="location.href='create_event.html'">Create Event</button>
              <button class="btn" onclick="location.href='unews.php'">Newsroom</button>
              <button class="btn2" onclick="location.href='home.html'">log out</button>                      
        </div>

        <div class="news-grid">
     <?php
   if ($result->num_rows > 0) {

      while($row = $result->fetch_assoc()) {
        
        $photo = $row['photo']; 
        $description = $row['dedscription'];
        $time = $row['time'];
          echo '
         <div class="news-item">
              <a href="' . $row['link'] . '" target="_blank">
                    <img src="' . ($photo ? $photo : 'default.jpg') . '" alt="News Image" class="news-image">
                 <h3>' . $row['dedscription'] . '</h3>
                  <p style="color:gray"><b>Published on: ' . $row['time'] . '</b></p>
              </a>
          </div>';
     }
   } else {
      echo "<p>No news available.</p>";
  }
  $con->close();
  ?>
</div>
    

      <div class="footer">
            <div class="photo">
                <img src="logo.png"  class="logo2">
            <h1 style="font-size: 3.5vh; margin-left:7vh">SafeNet</h1>
            </div>
            <div class="first-div">
                <p style="font-size:3.5vh;  color:black; font-weight: bold">User :</p><br>
                <p class="small_text">Create an Account.</p><br>
                <p class="small_text"> Create an Event.</p><br>
                <p class="small_text">Be a volunteer.</p><br>
                <p class="small_text">Anyone can Donate.</p><br>

            </div>
            <div class="second_div">
                <p style="font-size:3.5vh; color:black; font-weight: bold">Foundation :</p><br>
                <p class="small_text">Create an Account.</p><br>
                <p class="small_text"> Analyze Crisis map.</p><br>  
            </div>

            <div class="third_div">
                <p style="font-size:3.5vh; color:black; font-weight: bold">Contact us :</p><br>
                <p class="small_text">Need any support call to 01347832465723.</p><br>
                <p class="small_text">or email saifnet72@gmail.com.</p><br>
            </div>

            <div class="fourth_div">
                <p style="font-size:3.5vh; color:black; font-weight: bold">Follow us on :</p><br>
                <div class="conimg">
                    <img src="fb.png" class="imgf">
                    <img src="lnkdin.png" class="imgf">
                    <img src="youtub.png" class="imgf">
                    <img src="insta.jpg" class="imgf">
                </div>
            </div>

          </div>
          
    </div>
</body>
</html>