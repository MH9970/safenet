<?php
session_start();
include("config.php");

// Check login
if (!isset($_SESSION['log_id'])) {
    echo '<script>
        if (confirm("You are not logged in. Log in as user? OK = user, Cancel = foundation")) {
            window.location.href = "login.php";
        } else {
            window.location.href = "flog.php";
        }
    </script>';
    exit;
}

$log_id = $_SESSION['log_id'];

// Handle post creation
if (isset($_POST['submit_post'])) {
    $description = $_POST['description'];
    $photo = $_FILES['photo']['name'];
    move_uploaded_file($_FILES['photo']['tmp_name'], "uploads/$photo");

    mysqli_query($con, "INSERT INTO post (description, photo, log_id, comments, likes, loves)
                        VALUES ('$description', '$photo', $log_id, '[]', '[]', '[]')");
    header("Location: post.php"); 
    exit;
}

// AJAX: reactions
if (isset($_POST['react_post'])) {
    $post_id = $_POST['post_id'];
    $type = $_POST['type'];

    $res = mysqli_query($con, "SELECT likes, loves FROM post WHERE post_id=$post_id");
    $row = mysqli_fetch_assoc($res);
    $likes = json_decode($row['likes'], true) ?: [];
    $loves = json_decode($row['loves'], true) ?: [];

    if ($type === 'like') {
        if(in_array($log_id, $likes)) $likes = array_diff($likes, [$log_id]);
        else $likes[] = $log_id;
    }
    if ($type === 'love') {
        if(in_array($log_id, $loves)) $loves = array_diff($loves, [$log_id]);
        else $loves[] = $log_id;
    }

    mysqli_query($con, "UPDATE post SET likes='".json_encode(array_values($likes))."',
                        loves='".json_encode(array_values($loves))."' WHERE post_id=$post_id");

    echo json_encode(['likes'=>count($likes),'loves'=>count($loves)]);
    exit;
}

// AJAX: comments
if (isset($_POST['submit_comment'])) {
    $post_id = $_POST['post_id'];
    $comment_text = $_POST['comment'];

    $res = mysqli_query($con, "SELECT comments FROM post WHERE post_id=$post_id");
    $row = mysqli_fetch_assoc($res);
    $comments = json_decode($row['comments'], true) ?: [];

    $comments[] = ['user_id' => $log_id, 'comment' => $comment_text];
    mysqli_query($con, "UPDATE post SET comments='".json_encode($comments)."' WHERE post_id=$post_id");

    $u = mysqli_fetch_assoc(mysqli_query($con, "SELECT f_name,l_name,photo FROM log_in WHERE log_id=$log_id"));
    echo json_encode([
        'f_name'=>$u['f_name'],
        'l_name'=>$u['l_name'],
        'photo'=>$u['photo'],
        'comment'=>$comment_text
    ]);
    exit;
}

// Fetch posts
$query = "SELECT p.*, l.f_name, l.l_name, l.photo AS user_photo 
          FROM post p JOIN log_in l ON p.log_id = l.log_id 
          ORDER BY p.post_id DESC";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SafeNet Post Portal</title>
<link rel="stylesheet" href="post.css">
<style>
/* General post styling */
#container{ max-width:900px; margin:20px auto; padding:10px; }
.post-create-area{ margin-bottom:30px; }
textarea{ width:100%; padding:10px; border-radius:5px; border:1px solid #ccc; resize:none; }
button{ padding:8px 16px; border:none; background:#007bff; color:white; border-radius:5px; cursor:pointer; }
.post { border:1px solid #ddd; padding:10px; margin-bottom:20px; border-radius:8px; background:#fafafa; }
.user-photo{ width:50px; height:50px; border-radius:50%; }
.post-header{ display:flex; align-items:center; gap:10px; }
.post-id{ font-size:12px; color:#555; }
.post-description{ font-size:16px; line-height:1.5; margin-top:8px; white-space:pre-wrap; }
.see-more{ color:#1877f2; cursor:pointer; font-weight:500; }
.post-photo{ width:100%; margin-top:10px; border-radius:8px; }
.reaction-bar{ display:flex; align-items:center; gap:10px; margin-top:8px; }
.reaction-bar span{ cursor:pointer; user-select:none; }
.comment-section{ display:none; margin-top:8px; }
.comment-box{ max-height:150px; overflow-y:auto; margin-bottom:5px; }
.comment-box .comment-item{ display:flex; align-items:center; gap:8px; margin-top:5px; }
.comment-box .comment-item img{ width:30px; height:30px; border-radius:50%; }
.comment-box .comment-text{ font-size:14px; }
.comment-form{ display:flex; align-items:center; gap:5px; }
.comment-form textarea{ flex:1; height:30px; border-radius:5px; padding:5px; resize:none; }
.comment-form button{ width:30px; height:30px; border:none; background:#007bff; color:white; border-radius:50%; cursor:pointer; }
.active{ font-weight:bold; }
</style>
</head>
<body>

<div id="parent">
    <div id="bar">
        <img src="logo.png" class="logo">
        <h2 style="margin-top:1vh; margin-left:2vh ;font-size:6vh;">
            <a href="home.php" class="home-link">SafeNet</a>
        </h2>
        <button class="btn1" onclick="location.href='fvolunteer.php'">Volunteer</button>         
             <button class="btn" onclick="location.href='fpost.php'">post</button>      
              <button class="btn" onclick="location.href='ffoundation.php'">Foundation</button>                     
              <button class="btn" onclick="location.href='fcrisis_map.php'">Crisis Map</button>        
              <button class="btn" onclick="location.href='funews.php'">Newsroom</button>
              <button class="btn2" onclick="location.href='home.html'">log out</button>                      
    </div>
</div>

<div id="container">
    <div class="post-create-area">
        <h2>Create a Post</h2>
        <form action="post.php" method="POST" enctype="multipart/form-data">
            <textarea name="description" placeholder="Write your post..." required></textarea><br><br>
            <input type="file" name="photo" required><br><br>
            <button type="submit" name="submit_post">Post</button>
        </form>
    </div>

    <div id="posts">
        <h2>User Posts</h2>
        <?php while($row=mysqli_fetch_assoc($result)):
            $comments = json_decode($row['comments'], true) ?: [];
            $likes = json_decode($row['likes'], true) ?: [];
            $loves = json_decode($row['loves'], true) ?: [];
        ?>
        <div class="post" data-postid="<?= $row['post_id'] ?>">
            <div class="post-header">
                <img src="uploads/<?= $row['user_photo'] ?>" class="user-photo">
                <div>
                    <h3><?= $row['f_name'].' '.$row['l_name'] ?></h3>
                    <div class="post-id">Post ID: <?= $row['post_id'] ?></div>
                </div>
            </div>

            <div class="post-description" data-full="<?= htmlspecialchars($row['description']) ?>">
                <?= nl2br(substr($row['description'], 0, 250)) ?>
                <?php if (strlen($row['description']) > 250): ?>
                    <span class="see-more" onclick="toggleText(this)">See more</span>
                <?php endif; ?>
            </div>

            <img src="uploads/<?= $row['photo'] ?>" class="post-photo">

            <div class="reaction-bar">
                <span class="react-btn <?= in_array($log_id,$likes)?'active':'' ?>" data-type="like">👍 <?= count($likes) ?></span>
                <span class="love-btn <?= in_array($log_id,$loves)?'active':'' ?>" data-type="love">❤️ <?= count($loves) ?></span>
                <span class="comment-btn" onclick="toggleComment(this)">💬 Comment</span>
            </div>

            <div class="comment-section">
                <div class="comment-box">
                    <?php foreach($comments as $c):
                        $u = mysqli_fetch_assoc(mysqli_query($con, "SELECT f_name,l_name,photo FROM log_in WHERE log_id=".$c['user_id']));
                    ?>
                    <div class="comment-item">
                        <img src="uploads/<?= $u['photo'] ?>">
                        <div class="comment-text"><strong><?= $u['f_name'].' '.$u['l_name'] ?></strong>: <?= $c['comment'] ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <form class="comment-form">
                    <textarea placeholder="Write a comment..."></textarea>
                    <button type="submit">➤</button>
                </form>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<script>
// Toggle comment section
function toggleComment(el){
    const section = el.closest('.post').querySelector('.comment-section');
    section.style.display = section.style.display==='block'?'none':'block';
}

// Reaction AJAX
document.querySelectorAll('.react-btn, .love-btn').forEach(btn=>{
    btn.addEventListener('click', function(){
        const postId = this.closest('.post').dataset.postid;
        const type = this.dataset.type;
        fetch('post.php',{
            method:'POST',
            headers:{'Content-Type':'application/x-www-form-urlencoded'},
            body:'react_post=1&post_id='+postId+'&type='+type
        }).then(res=>res.json())
        .then(data=>{
            const parent = this.parentElement;
            parent.querySelector('.react-btn').textContent = '👍 '+data.likes;
            parent.querySelector('.love-btn').textContent = '❤️ '+data.loves;          
            this.classList.toggle('active');
        });
    });
});

// Comment AJAX
document.querySelectorAll('.comment-form').forEach(form=>{
    form.addEventListener('submit', function(e){
        e.preventDefault();
        const postId = this.closest('.post').dataset.postid;
        const textarea = this.querySelector('textarea');
        const comment = textarea.value.trim();
        if(comment==='') return;

        fetch('post.php',{
            method:'POST',
            headers:{'Content-Type':'application/x-www-form-urlencoded'},
            body:'submit_comment=1&post_id='+postId+'&comment='+encodeURIComponent(comment)
        }).then(res=>res.json())
        .then(data=>{
            const box = this.previousElementSibling;
            const div = document.createElement('div');
            div.className='comment-item';
            div.innerHTML = `<img src="uploads/${data.photo}"><div class="comment-text"><strong>${data.f_name} ${data.l_name}</strong>: ${data.comment}</div>`;
            box.appendChild(div);
            textarea.value='';
        });
    });
});

// See more / less
function toggleText(el){
    const div = el.parentElement;
    const fullText = div.dataset.full;

    if(el.innerText === "See more"){
        div.innerHTML = fullText.replace(/\n/g, "<br>") +
            ' <span class="see-more" onclick="toggleText(this)">See less</span>';
    }else{
        div.innerHTML = fullText.substring(0,250).replace(/\n/g, "<br>") +
            ' <span class="see-more" onclick="toggleText(this)">See more</span>';
    }
}
</script>

</body>
</html>
