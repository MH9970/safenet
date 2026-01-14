<?php
// Include the database connection
include('config.php');

// Get the foundation_id from the query string
$foundation_id = isset($_GET['f_id']) ? $con->real_escape_string($_GET['f_id']) : null;

// Initialize foundation name
$foundation_name = "";

// If foundation_id is provided, query the database to get the foundation name
if ($foundation_id) {
    // Create the SQL query
    $sql = "SELECT name FROM foundation WHERE f_id = $foundation_id";

    // Execute the query
    $result = $con->query($sql);

    // If a record is found, fetch the foundation name
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $foundation_name = $row['name'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="donationp.css">
</head>
<body>
    <div id="parent">
    <div id="bar">
            <img src="logo.png" class="logo">
            <h2 style="margin-top:1vh; margin-left:2vh ;font-size:6vh;  ">SafeNet</h2>
              <button class="btn1" onclick="location.href='volunteer.html'">Volunteer</button>         
             <button class="btn" onclick="location.href='post.php'">post</button>      
              <button class="btn" onclick="location.href='foundation.html'">Foundation</button>        
              <button class="btn" onclick="location.href='donation.html'">Donation</button>
              <button class="btn" onclick="location.href='crisis_map.php'">Crisis Map</button>        
              <button class="btn" onclick="location.href='create_event.html'">Create Event</button>
              <button class="btn" onclick="location.href='unews.php'">Newsroom</button>
              <button class="btn2" onclick="location.href='home.html'">log out</button>                      
        </div>

        <div class="txt">
            <h1>Donation Portal</h1>
           </div>
           <div class="txt1">
            <h1>Donate to  <?php echo htmlspecialchars($foundation_name) ; ?> :</h1>
           </div>
           <!--for the paisa of doination-->
           <div class="donateamount">
            <div class="amount">
                <div class="paisa">
                <button type="button" class="btnd" onclick="setAmount(100)">100</button>
                </div>
                <div class="paisa">
                <button type="button" class="btnd" onclick="setAmount(50)">50</button>
                </div>
                <div class="paisa">
                <button type="button" class="btnd" onclick="setAmount(100)">100</button>
                </div>                             
               </div>

               <div class="amount">
                
                <div class="paisa">
                <button type="button" class="btnd" onclick="setAmount(150)">150</button>
                </div>
                <div class="paisa">
                <button type="button" class="btnd" onclick="setAmount(200)">200</button>
                </div>
                <div class="paisa">
                <button type="button" class="btnd" onclick="setAmount(300)">300</button>
                </div>               
                
               </div>
               <div class="amount">
                
                <div class="paisa">
                <button type="button" class="btnd" onclick="setAmount(400)">400</button>
                </div>
                <div class="paisa">
                <button type="button" class="btnd"onclick="setAmount(500)">500</button>
                </div>
                <div class="paisa">
                <button type="button" class="btnd" onclick="setAmount(600)">600</button>
                </div>               
                
               </div>
               <div class="amount">
                
                <div class="paisa">
                <button type="button" class="btnd" onclick="setAmount(800)">800</button>
                </div>
                <div class="paisa">
                <button type="button" class="btnd" onclick="setAmount(1000)">1000</button>
                </div>
                <div class="paisa">
                <button type="button" class="btnd" onclick="setAmount(1500)">1500</button>
                </div>               
                
               </div>
               <div class="amount">
                
                <div class="paisa">
                <button type="button" class="btnd"onclick="setAmount(2000)">2000</button>
                </div>
                <div class="paisa">
                <button type="button" class="btnd" onclick="setAmount(2500)">2500</button>
                </div>
                <div class="paisa">
                <button type="button" class="btnd" onclick="setAmount(3000)">3000</button>
                </div>               
                
               </div>
               <div class="amount">
                
                <div class="paisa">
                <button type="button" class="btnd" onclick="setAmount(4000)">4000</button>
                </div>
                <div class="paisa">
                <button type="button" class="btnd" onclick="setAmount(5000)">5000</button>
                </div>
                <div class="paisa">
                <button type="button" class="btnd" onclick="setAmount(1200)">1200</button>
                </div>               
                
               </div>
           </div>


           <form method="POST" action="otp.php">
    <div class="boxes">
        <div class="input-box">
      
            <input type="text" name="fName" placeholder="Name" required>
        </div>

        <div class="input-box">
        <input type="email" name="email" placeholder="Enter your email" required>
        </div>

        <div class="input-box">
            <input type="number" name="amount" placeholder="Amount" required>
        </div>
    </div>

    <button type="submit" class="txta" name="Donate" >Donate</button>
</form>
          
       
          
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

          </div><!--footer-->
        </div>
        
        <script>
    function setAmount(value) {
        const amountInput = document.querySelector('input[name="amount"]');
        if (amountInput) {
            amountInput.value = value; // Set the input value
        }
    }
</script>
<!--parent-->
</body>
</html>