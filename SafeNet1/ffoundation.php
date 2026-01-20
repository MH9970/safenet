
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="ffoundation.css">
    
</head>
<body>
<div id="parent">
<div id="bar">
            <img src="logo.png" class="logo">
            <h2 style="margin-top:1vh; margin-left:2vh ;font-size:6vh;  "> <a href="home.php" class="home-link">SafeNet</a></h2>
              <button class="btn1" onclick="location.href='fvolunteer.php'">Volunteer</button>         
             <button class="btn" onclick="location.href='fpost.php'">post</button>      
              <button class="btn" onclick="location.href='ffoundation.php'">Foundation</button>                     
              <button class="btn" onclick="location.href='fcrisis_map.php'">Crisis Map</button>        
              <button class="btn" onclick="location.href='funews.php'">Newsroom</button>
              <button class="btn2" onclick="location.href='home.html'">log out</button>                      
        </div>
        <?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['submit_central'])) {
        // Central foundation form
        $table = "foundation"; 
    } elseif (isset($_POST['submit_university'])) {
        // University foundation form
        $table = "unifoundation"; 
    } else {
        die("Invalid form submission.");
    } 

    $link = $_POST['link'];
    $description = $_POST['description'];
    $name = $_POST['name'];

    $photo = null;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $targetDir = "safeNet1/uploads/"; // Directory where the file will be stored
        $fileName = basename($_FILES['photo']['name']);
        $targetFile = $targetDir . $fileName;
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // Allow only certain file formats
        
        if (in_array($fileType, ['jpg', 'png', 'jpeg', 'gif'])) {
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
                $photo = $targetFile; // Store the file path in the database
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "Only JPG, JPEG, PNG, and GIF files are allowed.";
        }
    }

    // Prepared statement to prevent SQL injection
    $stmt = $con->prepare("INSERT INTO  $table (page_link, photo,description, name) VALUES (?, ?, ?,?)");
    $stmt->bind_param("ssss", $link,$photo, $description, $name);

    if ($stmt->execute()) {
        header('Location: posts.html'); 

               }
               else {
                echo "Error: " . $stmt->error;
            }
        
            $stmt->close();
            $con->close();
             }
?>

  

      
       <div class="display">

     <!---fir the left div of display-->

       <div class="left">

        <!----for the central founation form-->

       <h1 class="txt">Register AS A Central Foundation</h1>

        <form action="" method="POST" enctype="multipart/form-data">

        <label for="photo">Upload Photo:</label>
        <input type="file" id="photo" name="photo" accept="image/*">

        <label for="time">Name:</label>
    <input type="text" id="name" name="name" required>

    <label for="description">Description:</label>
    <input type="text" id="description" name="description" required>

    <label for="link">News Link:</label>
    <input type="text" id="link" name="link" required>
    
    <button type="submit" name="submit_central" class="regbtn"><label href="">submit</label></button>
   </form>
   </div>

            <!---fir the right div of display-->

   <div class="right">
   <h1 class="txt">Register AS A University Foundation</h1>

  <!----for the university founation form-->
    
   <form action="" method="POST" enctype="multipart/form-data">

        <label for="photo">Upload Photo:</label>
        <input type="file" id="photo" name="photo" accept="image/*">

        <label for="time">Name:</label>
    <input type="text" id="name" name="name" required>

    <label for="description">Description:</label>
    <input type="text" id="description" name="description" required>

    <label for="link">News Link:</label>
    <input type="text" id="link" name="link" required>
    
    <button type="submit" name="submit_university" class="regbtn"><label href="">submit</label></button>
   </form>
   </div>
   </div>
    
      <!--for the footer-->
      <div class="footer">
            <div class="photo">
                <img src="logo.png"  class="logo2">
            <h1 style="font-size: 3.5vh; margin-left:7vh">SafeNet</h1>
            </div>
            <div class="first-div">
                <p style="font-size:3.5vh; font-weight: bold">User :</p><br>
                <p class="small_text">Create an Account.</p><br>
                <p class="small_text"> Create an Event.</p><br>
                <p class="small_text">Be a volunteer.</p><br>
                <p class="small_text">Anyone can Donate.</p><br>

            </div>
            <div class="second_div">
                <p style="font-size:3.5vh; font-weight: bold">Founmdation :</p><br>
                <p class="small_text">Create an Account.</p><br>
                <p class="small_text"> Analyze Crisis map.</p><br>  
            </div>

            <div class="third_div">
                <p style="font-size:3.5vh; font-weight: bold">Contact us :</p><br>
                <p class="small_text">Need any support call to 01347832465723.</p><br>
                <p class="small_text">or email saifnet72@gmail.com.</p><br>
            </div>

            <div class="fourth_div">
                <p style="font-size:3.5vh; font-weight: bold">Follow us on :</p><br>
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