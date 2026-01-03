<?php
$conn = new mysqli("localhost", "root", "", "safenet");
if ($conn->connect_error) {
    die("Database connection failed");
}

// ================= VOLUNTEER AGE DATA =================
$age17_20 = 0;
$age21_25 = 0;

$ageSql = "
SELECT 
  CASE
    WHEN (YEAR(CURDATE()) - date_of_birth) BETWEEN 17 AND 20 THEN '17-20'
    WHEN (YEAR(CURDATE()) - date_of_birth) BETWEEN 21 AND 25 THEN '21-25'
  END AS age_group,
  COUNT(*) AS total
FROM volunteer
WHERE (YEAR(CURDATE()) - date_of_birth) BETWEEN 17 AND 25
GROUP BY age_group
";
$ageRes = $conn->query($ageSql);
while ($row = $ageRes->fetch_assoc()) {
    if ($row['age_group'] == '17-20') $age17_20 = $row['total'];
    if ($row['age_group'] == '21-25') $age21_25 = $row['total'];
}

// ================= POST STATISTICS =================
$postSql = "
SELECT
  SUM(react_count) AS reacts,
  SUM(JSON_LENGTH(comments)) AS comments,
  SUM(JSON_LENGTH(likes)) AS likes,
  SUM(JSON_LENGTH(loves)) AS loves
FROM post
";
$post = $conn->query($postSql)->fetch_assoc();

// ================= DONATION DATA =================
$donations = [0,0,0,0]; // <500, <1000, <1500, >1500
$donationSql = "SELECT amount FROM donation";
$donationRes = $conn->query($donationSql);
while($row = $donationRes->fetch_assoc()){
    $amt = $row['amount'];
    if($amt < 500) $donations[0]++;
    else if($amt < 1000) $donations[1]++;
    else if($amt < 1500) $donations[2]++;
    else $donations[3]++;
}

// ================= EVENT DATA =================
$events = [];
$eventSql = "SELECT COUNT(*) AS total, group_name FROM event_form GROUP BY group_name";
$eventRes = $conn->query($eventSql);
while($row = $eventRes->fetch_assoc()){
    $events[] = ['group' => $row['group_name'], 'total' => $row['total']];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>SafeNet Admin Dashboard</title>
    <link rel="stylesheet" href="ahome.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

<!-- NAVBAR -->
<div id="parent">
    <div id="bar">
        <img src="logo.png" class="logo">
        <h2 style="margin-top:1vh; margin-left:2vh; font-size:6vh;">
            <a href="home.php" class="home-link">SafeNet</a>
        </h2>

        <button class="btn1" onclick="location.href='svolunteer.php'">Volunteer</button>
        <button class="btn" onclick="location.href='apost.php'">Post</button>
        <button class="btn" onclick="location.href='afoundation.php'">Foundation</button>
        <button class="btn" onclick="location.href='adonation.html'">Donation</button>
        <button class="btn" onclick="location.href='acrisis.php'">Crisis Map</button>
        <button class="btn" onclick="location.href='acreate_event.html'">Create Event</button>
        <button class="btn" onclick="location.href='anews.php'">Newsroom</button>
        <button class="btn2" onclick="location.href='home.html'">Log out</button>
    </div>
</div>

<h1 class="title">Admin Dashboard</h1>

<!-- ===== CHART SECTION ===== -->
<div class="dashboard">

    <div class="card">
        <h3>Volunteer Age Distribution</h3>
        <canvas id="volunteerChart"></canvas>

        <div class="mini-card">
            <p>17–20 Years: <b><?= $age17_20 ?></b></p>
            <p>21–25 Years: <b><?= $age21_25 ?></b></p>
            <p>Total: <b><?= $age17_20 + $age21_25 ?></b></p>
        </div>
    </div>

    <div class="card">
        <h3>Post Interaction Statistics</h3>
        <canvas id="postChart"></canvas>

        <div class="mini-card">
            <p>Reacts: <b><?= $post['reacts'] ?></b></p>
            <p>Comments: <b><?= $post['comments'] ?></b></p>
            <p>Likes: <b><?= $post['likes'] ?></b></p>
            <p>Loves: <b><?= $post['loves'] ?></b></p>
        </div>
    </div>

</div>

<!-- ===== VOLUNTEER MANAGEMENT SECTION ===== -->
<div class="manage-section">
    <div class="manage-text">
        <h2>How to Manage Volunteer Cards</h2>
        <p>
            Managing volunteers efficiently is essential for ensuring smooth operations
            during emergency response and social activities. The admin can review volunteer
            profiles, verify information, and assign groups based on expertise and location.
        </p>

        <ul>
            <li>✔ Review volunteer details regularly</li>
            <li>✔ Verify age, location, and skills</li>
            <li>✔ Assign volunteers to suitable groups</li>
            <li>✔ Remove inactive or invalid records</li>
            <li>✔ Update volunteer status when needed</li>
        </ul>
    </div>

    <div class="manage-image">
        <img src="volunteer.jpg" alt="Volunteer Management">
    </div>
</div>

<!-- ===== POST MANAGEMENT SECTION ===== -->
<div class="manage-section">
    <div class="manage-image">
        <img src="post.jpg" alt="Post Management">
    </div>

    <div class="manage-text">
        <h2>How to Manage Post Portal</h2>
        <p>
            The post portal allows administrators to monitor community activity and ensure
            responsible information sharing. Proper management helps prevent misinformation
            and keeps important updates visible.
        </p>

        <ul>
            <li>✔ Review posts regularly</li>
            <li>✔ Monitor likes, comments, and reactions</li>
            <li>✔ Remove inappropriate or misleading posts</li>
            <li>✔ Promote important emergency announcements</li>
            <li>✔ Maintain community guidelines</li>
        </ul>
    </div>
</div>

<!-- ===== DONATION & EVENT CHARTS ===== -->
<div class="dashboard">
    <div class="card">
        <h3>Donation Amount Distribution</h3>
        <canvas id="donationChart"></canvas>
    </div>

    <div class="card">
        <h3>Event Participation</h3>
        <canvas id="eventChart"></canvas>
    </div>
</div>

<!-- ===== DONATION MANAGEMENT SECTION ===== -->
<div class="manage-section">
    <div class="manage-image">
        <img src="don.jpg" alt="Donation Management">
    </div>

    <div class="manage-text">
        <h2>How to Manage Donations</h2>
        <p>
            Admin can monitor donations, verify payment details, and track donor contributions.
            Proper management ensures transparency and smooth fund allocation for projects.
        </p>

        <ul>
            <li>✔ Verify donation amounts and donor details</li>
            <li>✔ Categorize donations based on amount</li>
            <li>✔ Keep track of total funds collected</li>
            <li>✔ Allocate funds to appropriate causes</li>
            <li>✔ Maintain donation records securely</li>
        </ul>
    </div>
</div>

<script>
// Volunteer Chart
new Chart(document.getElementById('volunteerChart'), {
    type: 'doughnut',
    data: {
        labels: ['17–20', '21–25'],
        datasets: [{
            data: [<?= $age17_20 ?>, <?= $age21_25 ?>],
            backgroundColor: ['#4CAF50', '#2196F3']
        }]
    }
});

// Post Chart
new Chart(document.getElementById('postChart'), {
    type: 'bar',
    data: {
        labels: ['Reacts', 'Comments', 'Likes', 'Loves'],
        datasets: [{
            data: [
                <?= $post['reacts'] ?>,
                <?= $post['comments'] ?>,
                <?= $post['likes'] ?>,
                <?= $post['loves'] ?>
            ],
            backgroundColor: '#FF9800'
        }]
    }
});

// Donation Chart
new Chart(document.getElementById('donationChart'), {
    type: 'bar',
    data: {
        labels: ['<500', '<1000', '<1500', '>1500'],
        datasets: [{
            label: 'Donations',
            data: [<?= implode(',', $donations) ?>],
            backgroundColor: ['#4CAF50', '#2196F3', '#FFC107', '#FF5722']
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true } }
    }
});

// Event Chart
const eventLabels = <?= json_encode(array_column($events, 'group')) ?>;
const eventData = <?= json_encode(array_column($events, 'total')) ?>;

new Chart(document.getElementById('eventChart'), {
    type: 'line',
    data: {
        labels: eventLabels,
        datasets: [{
            label: 'Events Count',
            data: eventData,
            fill: false,
            borderColor: '#2196F3',
            tension: 0.2
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true } }
    }
});
</script>

</body>
</html>
