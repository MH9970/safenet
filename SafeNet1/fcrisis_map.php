<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      //for the first chart disaster region.
      google.charts.setOnLoadCallback(drawChart1);

      function drawChart1() {
        var data = google.visualization.arrayToDataTable([
          ['Region', 'Flood', 'Cyclone', 'Earthquake'],
          <?php
            include("config.php");
             
            $query = "SELECT dp_id, Region, Flood, Cyclone, Earthquake FROM disaster_type ORDER BY Region";
        $result = mysqli_query($con, $query);

        // Check if data exists and format it for JavaScript
        while ($row = mysqli_fetch_assoc($result)) {
          echo "['" . $row['Region'] . "', " . $row['Flood'] . ", " . $row['Cyclone'] . ", " . $row['Earthquake'] . "],";
        }
      ?>
    ]);
   
        var options = {
          chart: {
            title: 'Type of disaster per region',
            
          },
          bars: 'vertical' // Required for Material Bar Charts.
        };

        var chart = new google.charts.Bar(document.getElementById('barchart_material1'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }

    // for the second chart.
      google.charts.setOnLoadCallback(drawChart2);

      function drawChart2() {
        var data = google.visualization.arrayToDataTable([
          ['Month', 'Flood', 'Cyclone', 'Earthquake'],
          <?php
            include("config.php");
             
            $query = "SELECT dr_id, Month, Flood, Cyclone, Earthquake FROM disaster_region ";
        $result = mysqli_query($con, $query);

        // Check if data exists and format it for JavaScript
        while ($row = mysqli_fetch_assoc($result)) {
          echo "['" . $row['Month'] . "', " . $row['Flood'] . ", " . $row['Cyclone'] . ", " . $row['Earthquake'] . "],";
        }
      ?>
    ]);
   
        var options = {
          chart: {
            title: 'Time period iof disaster in month.',
            
          },
          bars: 'vertical' // Required for Material Bar Charts.
        };

        var chart = new google.charts.Bar(document.getElementById('barchart_material2'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>

     <link rel="stylesheet" href="fcrisis_map.css">

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

        <div class="head">
            <h1>Crisis Map</h1>
        </div>
        <h1 class="txt">Disaster Affected area :</h1>
     <div id="barchart_material1" style="width: 900px; margin-left:20vw; box-shadow:1.5vh; border-color:gray; height: 500px;"></div>
     <h1 class="txt">Time period of Disaster  :</h1>
     <div id="barchart_material2" style="width: 900px; margin-left:20vw; height: 500px;"></div>
    

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