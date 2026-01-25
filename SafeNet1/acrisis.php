<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disaster Data Form</title>
    <link rel="stylesheet" href="crisis_map.css">
</head>
<body>
<div id="parent">
<div id="bar">
            <img src="logo.png" class="logo">
            <h2 style="margin-top:1vh; margin-left:2vh ;font-size:6vh;  "> <a href="ahome.php" class="home-link">SafeNet</a></h2>
              <button class="btn1" onclick="location.href='svolunteer.php'">Volunteer</button>         
             <button class="btn" onclick="location.href='apost.php'">post</button>      
              <button class="btn" onclick="location.href='afoundation.php'">Foundation</button>        
              <button class="btn" onclick="location.href='adonation.html'">Donation</button>
              <button class="btn" onclick="location.href='acrisis.php'">Crisis Map</button>        
              <button class="btn" onclick="location.href='acreate_event.php'">Create Event</button>
              <button class="btn" onclick="location.href='anews.php'">Newsroom</button>
              <button class="btn2" onclick="location.href='home.html'">log out</button>                      
        </div>
    <?php
include("config.php");

// Define the start year internally
$start_year = 2000; // Example: Data collection started in 2000

if (isset($_POST['submit'])) {
    // Fetch form inputs
    $month = $_POST['month'];
    $year = $_POST['year'];
    $flood = $_POST['flood'];
    $cyclone = $_POST['cyclone'];
    $earthquake = $_POST['earthquake'];

    // Calculate the number of years
    $num_years = $year - $start_year + 1;

    // Check if the month already exists
    $check_query = "SELECT * FROM disaster_region WHERE month = '$month'";
    $check_result = mysqli_query($con, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Update the existing row for this month
        $update_query = "
            UPDATE disaster_region 
            SET flood = flood + $flood, 
                cyclone = cyclone + $cyclone, 
                earthquake = earthquake + $earthquake 
            WHERE month = '$month'
        ";
        mysqli_query($con, $update_query) or die("Error occurred while updating data");
        echo "<div class='message'>
                <p>Data updated successfully for $month!</p>
              </div>";
    } else {
        // Insert the data into the disaster_region table
        $insert_query = "
            INSERT INTO disaster_region(month, year, flood, cyclone, earthquake) 
            VALUES('$month', '$year', '$flood', '$cyclone', '$earthquake')
        ";
        mysqli_query($con, $insert_query) or die("Error occurred while inserting data");
        echo "<div class='message'>
                <p>Data inserted successfully for $month!</p>
              </div>";
    }

    // Calculate averages
    $avg_flood = $flood / $num_years;
    $avg_cyclone = $cyclone / $num_years;
    $avg_earthquake = $earthquake / $num_years;

    // Update averages for the specific month
    $avg_query = "
        UPDATE disaster_region 
        SET avg_flood = '$avg_flood', 
            avg_cyclone = '$avg_cyclone', 
            avg_earthquake = '$avg_earthquake' 
        WHERE month = '$month'
    ";
    mysqli_query($con, $avg_query) or die("Error occurred while updating averages");

    // Display success message
    echo "<div class='message'>
            <p>Average Flood: " . number_format($avg_flood, 2) . "</p>
            <p>Average Cyclone: " . number_format($avg_cyclone, 2) . "</p>
            <p>Average Earthquake: " . number_format($avg_earthquake, 2) . "</p>
          </div>";
    echo "<a href='acrisis.php'><button class='btnb'>Back now</button>";
} else {
?>
    <main>
        <div class="wrapper">
            <form action="" method="POST">
                <h1 style="text-align:center; margin:3vh">Disaster Data Registration</h1>
                <div class="container">
                <div class="input-box1">
            
                    <select name="month" id="month" required>
                    <option value="" disabled selected>Choose a month</option>
                        <option value="Jan-feb">Jan-Feb</option>
                        <option value="march-April">March-April</option>
                        <option value="May-June">May-June</option>
                        <option value="Jul-Aug">Jul-Aug</option>
                        <option value="Sep-Oct">Sep-Oct</option>
                        <option value="Nov-Dec">Nov-Dec</option>                       
                    </select>
                </div>

                <div class="input-box">
                    <input type="number" class="input" name="year" placeholder="Current Year" required min="2001">
                </div>

                <div class="input-box">
                    <input type="number" step="0.01" class="input" name="flood" placeholder="Flood Count" required min="0">
                </div>

                <div class="input-box">
                    <input type="number" step="0.01" class="input" name="cyclone" placeholder="Cyclone Count" required min="0">
                </div>

                <div class="input-box">
                    <input type="number" step="0.01" class="input" name="earthquake" placeholder="Earthquake Count" required min="0">
                </div>

                <button type="submit" name="submit" class="regbtn">Register</button>
      </div>
            </form>
        </div>
        <?php } ?>
    </main>
     <!-- Footer content  -->
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
