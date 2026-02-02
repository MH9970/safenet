<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="event_form.css">
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
        <div class="instruct">
               <h1>Some instruction for create an Event :</h1> <br>
               <p class="txt">1.Prioritize your safety. <br> <br>
            
            2.Unskilled individuals should avoid entering affected areas and engaging in activities like swimming or running <br>  <br>
            
            3.Ensure all team members are physically and mentally prepared.<br>  <br>
            
            4.Stay informed about the latest situation in the affected area to minimize risks. <br> 
        </p>
              
             </div>

            
		<?php
   include("config.php");  // Include the database connection file

  if (isset($_POST['submit'])) {
    // Get the data from the form
    $group_name = $_POST['fName'];
    $from_location = $_POST['from'];
    $to_location = $_POST['to'];
    $start_date = $_POST['sdate'];
    $end_date = $_POST['edate'];
    $start_time = $_POST['time'];
    $volunteer = isset($_POST['hire']) ? $_POST['hire'] : (isset($_POST['NotHire']) ? $_POST['NotHire'] : '');
    $details = $_POST['details'];

    // Verify if the event already exists based on the to_location, start_date, and start_time
    $verify_query = mysqli_query($con, "SELECT * FROM event_form WHERE to_location='$to_location' AND start_date='$start_date' AND s_time='$start_time'");

    if (mysqli_num_rows($verify_query) != 0) {

        // If a similar event exists, show the message

        echo "<div class='message'>
                 <p>An event with the same location, start date, and start time already exists.</p>
              </div> <br>";
        echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button></a>";
    } 
    else {
        // If no similar event exists, insert the new event into the database

        mysqli_query($con,"INSERT INTO event_form (group_name, from_location, to_location, start_date, end_date, s_time, volunteer, description) 
                         VALUES ('$group_name', '$from_location', '$to_location', '$start_date', '$end_date', '$start_time', '$volunteer', '$details')") or die("Erroe Occured");;
           echo "Event launched successfully <br>";
       echo "<a href='create_event.html'><button class='btnbac'>Back now</button>";  
    }
} else {
    // If the form hasn't been submitted yet, show the form
?>
    <!--for the form of create event-->
    <main>

		<div class="wrapper">
		<form action="" method="POST">
			<h1>Create a event</h1>
		

			<div class="input-box">
				<input type="text" name="fName" placeholder="Event Name">
			</div>

			<div class="input-box">
				<input type="text" name="from" placeholder="where are you from?" required>
			</div>

			<div class="input-box">
				<input type="text" name="to" placeholder="Where are you going?" required>	
			</div>

			<div class="input-box">
				<label>Start Date</label><br>
				<input type="date" name="sdate" placeholder="" required>
			</div>

			<div class="input-box">
				<label>End Date</label><br>
				<input type="date" name="edate" placeholder="" required>
			</div>
			<div class="input-box">
				<label>start time</label><br>
				<input type="time" name="time" placeholder="time" required>
			</div>

			<div class="input-box" name="volunteer">
				<label>Do you want take volanteer?</label><br>
				<label>Yes</label>
				<input type="checkbox" name="hire" value="Hire">
				<label>No</label>
				<input type="checkbox" name="NotHire" value="NotHire">
			</div>


			<div class="input-box">
				<textarea name="details" placeholder="Details about event"></textarea>
			</div>


			<button type="submit" name="submit" class="regbtn"><label href="">Launch</label></button>

		</form>
	</div>
	<?php } ?>
    </main>

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