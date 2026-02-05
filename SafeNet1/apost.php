<?php
include('config.php');

// Search logic
$search_id = "";
if (isset($_GET['search_id']) && !empty($_GET['search_id'])) {
    $search_id = intval($_GET['search_id']);
    $sql = "SELECT * FROM post WHERE post_id = $search_id";
} else {
    $sql = "SELECT * FROM post";
}
$result = $con->query($sql);

// Delete
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $con->query("DELETE FROM post WHERE post_id=$delete_id");
    header("Location: apost.php");
    exit();
}

// Update
if (isset($_POST['update_post'])) {
    $post_id = intval($_POST['post_id']);
    $description = $con->real_escape_string($_POST['description']);
    if (!empty($_FILES['photo']['name'])) {
        $photo = time() . "_" . $_FILES['photo']['name'];
        move_uploaded_file($_FILES['photo']['tmp_name'], "uploads/$photo");
        $con->query("UPDATE post SET description='$description', photo='$photo' WHERE post_id=$post_id");
    } else {
        $con->query("UPDATE post SET description='$description' WHERE post_id=$post_id");
    }
    header("Location: apost.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Post Cards</title>
<link rel="stylesheet" href="apost.css">

<style>
    
/* ===== SEARCH BOX ===== */
.search-container {
   
    margin-left:-0vw;
    margin-top: -0px;
}
.search-container input {
    width: 150px;
    padding: 5px 8px;
    border: 2px solid #007bff;
    border-radius: 15px;
    outline: none;
    font-size: 14px;
    transition: 0.3s;
}
.search-container input:focus { border-color: #0056b3; }
.search-container button {
    padding: 5px 12px;
    background: #007bff;
    border: none;
    border-radius: 15px;
    color: white;
    font-weight: bold;
    font-size: 14px;
    cursor: pointer;
    transition: background 0.3s;
}
.search-container button:hover { background: #0056b3; }

/* ===== CARD EDIT STYLES ===== */
.card textarea {
    width: 100%;
    height: 100px;
    border: 2px solid #007bff;
    border-radius: 10px;
    padding: 8px;
    font-size: 16px;
    outline: none;
    resize: vertical;
}

/* ===== CHANGE BUTTON ===== */
.change-btn {
    padding: 6px 16px;
    border-radius: 25px;
    border: none;
    cursor: pointer;
    font-weight: bold;
    margin-top: 5px;
    background: linear-gradient(45deg, #28a745, #218838);
    color: white;
    transition: 0.3s;
}
.change-btn:hover { background: linear-gradient(45deg, #218838, #1e7e34); }

/* ===== FILE CHOOSE BUTTON ===== */
.file-btn-wrapper {
    text-align: center;
    margin-top: 8px;
}
.file-btn {
    display: inline-block;
    background: #17a2b8;
    color: white;
    padding: 6px 14px;
    border-radius: 25px;
    font-weight: bold;
    cursor: pointer;
    font-size: 14px;
}
.file-btn:hover { background: #138496; }
.file-btn input[type="file"] {
    display: none;
}

/* ===== POSTED NEWS & SEE POST BUTTONS ===== */
.fixed-title-btn {
   position: relative;
    display:flex;
    width:7.vw;
    top: 2.8vh;
    left: 25vw;
    padding: 10px 20px;
    font-size: 18px;
    background: #007bff;
    color: white;
    border: none;
    border-radius: 25px;
    cursor: pointer;
    z-index: 999;
    transition: 0.3s;
    text-decoration: none;
}
.fixed-title-btn:hover { background: #0056b3; }

.see-post-btn {
    position: relative;
    display:flex;
    width:7.vw;
    top: vh;
    left: 20vw;
    padding: 10px 20px;
    font-size: 18px;
    background: #007bff;
    color: white;
    border: none;
    border-radius: 25px;
    cursor: pointer;
    z-index: 999;
    transition: 0.3s;
    text-decoration: none;
}
}
.see-post-btn:hover { background: #218838; }

/* ===== TOP BAR ===== */
.top-bar {
    position: sticky;
    top: 0;
    background-color: #e0e0e0; /* gray background */
    padding: 10px 20px;
    z-index: 1000;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
}

/* Wrapper inside top bar to align buttons + search */
.top-buttons-wrapper {
    display: flex;
    align-items: center;
    justify-content: space-between; /* left buttons, right search */
    flex-wrap: wrap;
}

/* Left buttons group */
.buttons-left {
    display: flex;
    gap: 15px; /* space between two buttons */
}

/* Common button styles */
.fixed-btn {
    padding: 10px 20px;
    border-radius: 25px;
    text-decoration: none;
    color: white;
    font-weight: bold;
    font-size: 16px;
    transition: 0.3s;
}

/* Individual button colors */
.posted-btn { background: #007bff; }
.posted-btn:hover { background: #0056b3; }


</style>
</head>

<body>
<div id="parent">

<!-- ===== HEADER / NAVBAR (unchanged) ===== -->
<div id="bar">
    <img src="logo.png" class="logo">
    <h2 style="margin-top:1vh; margin-left:2vh ;font-size:6vh;">
        <a href="ahome.php" class="home-link">SafeNet</a>
    </h2>
    <button class="btn1" onclick="location.href='svolunteer.php'">Volunteer</button>         
    <button class="btn" onclick="location.href='apost.php'">post</button>      
    <button class="btn" onclick="location.href='afoundation.php'">Foundation</button>        
    <button class="btn" onclick="location.href='adonation.html'">Donation</button>
    <button class="btn" onclick="location.href='acrisis.php'">Crisis Map</button>        
    <button class="btn" onclick="location.href='acreate_event.php'">Create Event</button>
    <button class="btn" onclick="location.href='anews.php'">Newsroom</button>
    <button class="btn2" onclick="location.href='home.html'">log out</button>                      
</div>

<div class="top-bar">
    <div class="top-buttons-wrapper">
        <div class="buttons-left">
            <a href="apost.php" class="fixed-btn posted-btn">Posted News</a>
            <a href="adminpost.php" class="fixed-btn see-post-btn">See the Post</a>
        </div>

        <div class="search-container">
            <form method="GET" action="apost.php">
                <input type="text" name="search_id" placeholder="Search Post ID" value="<?php echo htmlspecialchars($search_id); ?>">
                <button type="submit">Search</button>
            </form>
        </div>
    </div>
</div>

</h1>


<div class="container">

<?php
$edit_id = isset($_GET['edit_id']) ? intval($_GET['edit_id']) : null;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        ?>
        <div class="card">

        <?php if ($edit_id == $row['post_id']) { ?>

            <!-- EDIT MODE -->
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="post_id" value="<?php echo $row['post_id']; ?>">

                <img src="uploads/<?php echo $row['photo']; ?>" style="width:100%; margin-bottom:8px;">

                <textarea name="description" required><?php echo htmlspecialchars($row['description']); ?></textarea>

                <!-- Styled file choose -->
                <div class="file-btn-wrapper">
                    <label class="file-btn">
                        Browse
                        <input type="file" name="photo">
                    </label>
                </div>

                <button type="submit" name="update_post" class="change-btn">Save</button>
                <a href="apost.php" class="change-btn" style="background: #6c757d;">Cancel</a>
            </form>

        <?php } else { ?>

            <!-- NORMAL VIEW -->
            <img src="uploads/<?php echo htmlspecialchars($row['photo']); ?>">
            <h3><?php echo htmlspecialchars($row['description']); ?></h3>
            <p>Post ID: <?php echo htmlspecialchars($row['post_id']); ?></p>

            <a href="apost.php?edit_id=<?php echo $row['post_id']; ?>" class="change-btn">Change</a>
            <a href="apost.php?delete_id=<?php echo $row['post_id']; ?>" 
               class="delete-button"
               onclick="return confirm('Are you sure you want to delete this post?')">Delete</a>

        <?php } ?>

        </div>
        <?php
    }
} else {
    echo "<p>No posts available.</p>";
}
?>
</div>

<!-- ===== FOOTER (unchanged) ===== -->
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

</body>
</html>
