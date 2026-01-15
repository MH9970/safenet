<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "safenet";

$conn = new mysqli("localhost","root", "","safenet");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Handle delete request for Central Foundations
if (isset($_GET['delete_central_id'])) {
    $delete_central_id = $_GET['delete_central_id'];
    $delete_sql = "DELETE FROM foundation WHERE f_id = $delete_central_id";
    if ($conn->query($delete_sql) === TRUE) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Error deleting central foundation: " . $conn->error;
    }
}

// Handle delete request for University Foundations
if (isset($_GET['delete_uni_id'])) {
    $delete_uni_id = $_GET['delete_uni_id'];
    $delete_sql = "DELETE FROM unifoundation WHERE uf_id = $delete_uni_id";
    if ($conn->query($delete_sql) === TRUE) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Error deleting university foundation: " . $conn->error;
    }
}



// Fetch data from the 'volunteer' table
$sql_central = "SELECT f_id, photo, name, description, page_link FROM foundation";
$result_central = $conn->query($sql_central);

$sql_uni = "SELECT uf_id, photo, name, description, page_link FROM unifoundation";
$result_uni = $conn->query($sql_uni);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="foundation.css">
    <style>
        /* CSS styles for the layout */
        .container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .card {
            width: 30vh;
            height:auto;
            margin: 2vh;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 10px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #f9f9f9;
        }
        .card img {
            width: 100%;
            height: 30vh;
            object-fit: cover;
            border-radius: 10px;
        }
        .card h3, .card p {
            margin: 5px 0;
        }
        .card button{
            margin:2vh;
            width:7vw;
            height:4vh;
            color:white;
            background-color: #007BFF;
            cursor: pointer;
            font-size:2vh;
            border-radius: 1vh;
            border:none;
        }
        .delete-button {
            margin-top: 10px;
            padding: 5px 10px;
            background-color: #e74c3c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .delete-button:hover {
            background-color: #c0392b;
        }
    </style>
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

        <div class="txt">
            <h1 class="txt1">Central Foundations</h1>
        </div>

        <!--for the div of central  foundations-->
        <div class="container1">
            <?php
        // Generate a div for each row of data
        if ($result_central->num_rows > 0) {
            while ($row = $result_central->fetch_assoc()) {
                echo "<div class='card'>";
                $imagePath = htmlspecialchars($row['photo']);
               echo "<img src='" . $imagePath . "' alt='Foundation Photo'  style='max-width:200px; max-height:200px;'>";
                echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
                echo '<p> ' . htmlspecialchars($row['description']) . '</p>';
                $page_Link = htmlspecialchars($row['page_link']);
        
                // If a page link is available, display the button to go to the foundation page
                if (!empty($page_Link)) {
                    echo '<button onclick="window.location.href=\'' . $page_Link . '\'">Read More</button>';
                }

                // Add delete button for Central Foundation
                echo '<form method="GET" action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '">';
                echo '<input type="hidden" name="delete_central_id" value="' . htmlspecialchars($row['f_id']) . '">';
                echo '<button class="delete-button" type="submit">Delete</button>';
                echo '</form>';
                echo '</div>';
            }
        } else {
            echo '<p>No central Foundation found.</p>';
        }

        ?>
        </div>


              <!--for the university foundations-->
              <div class="txt">
                <h1 class="txt1">University Foundations</h1>              
            </div>

            <div class="container">
        <?php
        if ($result_uni->num_rows > 0) {
            while ($row = $result_uni->fetch_assoc()) {
                echo "<div class='card'>";
                echo "<img src='" . htmlspecialchars($row['photo']) . "' alt='University Foundation Photo'>";
                echo "<h3>" . htmlspecialchars($row['name']) . "</h3>";
                echo "<p>" . htmlspecialchars($row['description']) . "</p>";
                if (!empty($row['page_link'])) {
                    echo "<button onclick=\"location.href='" . htmlspecialchars($row['page_link']) . "'\">Read More</button>";
                }
                echo '<form method="GET" action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '">';
                    echo '<input type="hidden" name="delete_uni_id" value="' . htmlspecialchars($row['uf_id']) . '">';
                    echo '<button class="delete-button" type="submit">Delete</button>';
                    echo '</form>';
                echo "</div>";
            }
        } else {
            echo "<p>No University Foundations Found.</p>";
        }
        ?>
              
                 

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