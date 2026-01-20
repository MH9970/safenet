<?php
// Include the database connection
include('config.php');

// Check for deletion (if `delete_id` is set in URL)
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    
    // Query to delete the event from the database
    $delete_sql = "DELETE FROM event_form WHERE event_id = $delete_id";
    if ($con->query($delete_sql) === TRUE) {
        // If deletion is successful, redirect to the same page to refresh the events
        header("Location: event_page.php");
        exit();
    } else {
        echo "Error deleting record: " . $con->error;
    }
}

// Query to fetch all events from the 'event_form' table
$sql = "SELECT * FROM event_form";
$result = $con->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Table</title>
    <link rel="stylesheet" href="acreate_event.css"> <!-- Add your CSS file here -->
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
              <button class="btn" onclick="location.href='acreate_event.html'">Create Event</button>
              <button class="btn" onclick="location.href='anews.php'">Newsroom</button>
              <button class="btn2" onclick="location.href='home.html'">log out</button>                      
        </div>


    <h1>Event Details</h1>
    <table border="1" cellspacing="0" cellpadding="10">
        <thead>
            <tr>
                <th>Event ID</th>
                <th>Group Name</th>
                <th>From Location</th>
                <th>To Location</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Start Time</th>
                <th>Volunteer</th>
                <th>Description</th>
                <th>Action</th> <!-- Column for Delete Button -->
            </tr>
        </thead>
        <tbody>
            <?php
            // Check if there are any events
            if ($result->num_rows > 0) {
                // Output each event as a table row
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['event_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['group_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['from_location']); ?></td>
                        <td><?php echo htmlspecialchars($row['to_location']); ?></td>
                        <td><?php echo htmlspecialchars($row['start_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['end_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['s_time']); ?></td>
                        <td><?php echo htmlspecialchars($row['volunteer']); ?></td>
                        <td><?php echo htmlspecialchars($row['description']); ?></td>
                        <td>
                            <!-- Delete Button -->
                            <a href="event_page.php?delete_id=<?php echo $row['event_id']; ?>" 
                               onclick="return confirm('Are you sure you want to delete this event?')">Delete</a>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                echo "<tr><td colspan='10'>No events available.</td></tr>";
            }
            ?>
        </tbody>
    </table>
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
