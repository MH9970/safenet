<?php
// Database connection
$conn = new mysqli("localhost","root","","safenet");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Delete
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM volunteer WHERE v_id = $delete_id";
    $conn->query($delete_sql);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Handle Update (Exparties & Group Assign)
if (isset($_POST['update_id'])) {
    $update_id = $_POST['update_id'];
    $new_exparties = $conn->real_escape_string($_POST['exparties']);
    $new_group = $conn->real_escape_string($_POST['group_assign']);
    $update_sql = "UPDATE volunteer SET exparties='$new_exparties', group_assign='$new_group' WHERE v_id=$update_id";
    $conn->query($update_sql);

    // Redirect to turn off edit mode
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Handle Search by v_id
$search_id = isset($_GET['search_id']) ? intval($_GET['search_id']) : '';
$sql = "SELECT v_id, full_name, email, locations, date_of_birth, exparties, group_assign, gender FROM volunteer";
if ($search_id) {
    $sql .= " WHERE v_id = $search_id";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Volunteer Data</title>
<link rel="stylesheet" href="volunteer.css">
<style>
.container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
}
.card {
    width: 30vh;
    height: auto;
    margin:3vh;
    border: 1px solid #ccc;
    border-radius: 10px;
    padding: 10px;
    text-align: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    background-color: #f9f9f9;
    position: relative;
}
.card h3, .card p {
    margin: 5px 0;
}
.delete-button, .change-button, .save-button {
    margin-top: 10px;
    padding: 5px 10px;
    border: none;
    border-radius: 5px;
    color: #fff;
    cursor: pointer;
}
.delete-button { background-color: #e74c3c; }
.delete-button:hover { background-color: #c0392b; }
.change-button { background-color: #3498db; text-decoration: none; display:inline-block; padding:5px 10px; border-radius:5px; }
.change-button:hover { background-color: #2980b9; }
.save-button { background-color: #2ecc71; }
.save-button:hover { background-color: #27ae60; }

.search-bar {
    text-align: center;
    margin: 20px;
}
.search-bar input[type="number"] {
    padding: 5px;
    width: 200px;
    font-size: 16px;
}
.search-bar button {
    padding: 6px 12px;
    font-size: 16px;
}
input.edit-input {
    width: 90%;
    padding: 4px;
    margin: 5px 0;
    font-size: 14px;
}
</style>
</head>
<body>
<div class="parent">
    <div id="bar">
        <img src="logo.png" class="logo">
        <h2 style="margin-top:1vh; margin-left:2vh ;font-size:6vh;">
            <a href="ahome.php" class="home-link">SafeNet</a>
        </h2>
        <button class="btn1" onclick="location.href='svolunteer.php'">Volunteer</button>         
        <button class="btn" onclick="location.href='apost.php'">Post</button>      
        <button class="btn" onclick="location.href='afoundation.php'">Foundation</button>        
        <button class="btn" onclick="location.href='adonation.html'">Donation</button>
        <button class="btn" onclick="location.href='acrisis.php'">Crisis Map</button>        
        <button class="btn" onclick="location.href='acreate_event.php'">Create Event</button>
        <button class="btn" onclick="location.href='anews.php'">Newsroom</button>
        <button class="btn2" onclick="location.href='home.html'">Log Out</button>                      
    </div>

    <h1 class="txt">Volunteers Data</h1>

    <!-- Search Bar -->
    <div class="search-bar">
        <form method="GET" action="">
            <input type="number" name="search_id" placeholder="Enter Volunteer ID" value="<?= htmlspecialchars($search_id) ?>">
            <button type="submit">Search</button>
            <button type="button" onclick="window.location.href='<?= $_SERVER['PHP_SELF'] ?>'">Reset</button>
        </form>
    </div>

    <div class="container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $isEditing = isset($_GET['edit_id']) && $_GET['edit_id'] == $row['v_id'];
                echo '<div class="card">';
                echo '<p>ID: ' . htmlspecialchars($row['v_id']) . '</p>';
                echo '<h3>' . htmlspecialchars($row['full_name']) . '</h3>';
                echo '<p>Email: ' . htmlspecialchars($row['email']) . '</p>';
                echo '<p>Location: ' . htmlspecialchars($row['locations']) . '</p>';
                echo '<p>Date of Birth: ' . htmlspecialchars($row['date_of_birth']) . '</p>';
                echo '<p>Gender: ' . htmlspecialchars($row['gender']) . '</p>';

                // Display or edit Exparties & Group Assign
                if ($isEditing) {
                    echo '<form method="POST" action="">';
                    echo '<input type="hidden" name="update_id" value="' . $row['v_id'] . '">';
                    echo '<input class="edit-input" type="text" name="exparties" value="' . htmlspecialchars($row['exparties']) . '" placeholder="Change Exparties">';
                    echo '<input class="edit-input" type="text" name="group_assign" value="' . htmlspecialchars($row['group_assign']) . '" placeholder="Change Group Assign">';
                    echo '<button class="save-button" type="submit">Save</button>';
                    echo '</form>';
                } else {
                    echo '<p>Exparties: ' . htmlspecialchars($row['exparties']) . '</p>';
                    echo '<p>Group Assign: ' . htmlspecialchars($row['group_assign']) . '</p>';
                    echo '<a href="?edit_id=' . $row['v_id'] . '" class="change-button">Change</a>';
                }

                // Delete Button
                echo '<form method="GET" action="" style="margin-top:5px;">';
                echo '<input type="hidden" name="delete_id" value="' . $row['v_id'] . '">';
                echo '<button class="delete-button" type="submit">Delete</button>';
                echo '</form>';

                echo '</div>';
            }
        } else {
            echo '<p>No data found.</p>';
        }
        $conn->close();
        ?>
    </div>
</div>
</body>
</html>
