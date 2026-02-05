<?php 
session_start();
include("config.php");

$error_message = '';

// Handle login form submission
if(isset($_POST['login'])){
    $email = mysqli_real_escape_string($con,$_POST['email']);
    $password = mysqli_real_escape_string($con,$_POST['password']);

    $result = mysqli_query($con,"SELECT * FROM admin WHERE email='$email' AND password='$password'") or die("Select Error");
    $row = mysqli_fetch_assoc($result);

    if(is_array($row) && !empty($row)){
        $_SESSION['valid'] = $row['email'];
        $_SESSION['name'] = $row['name'];            
        $_SESSION['admin_id'] = $row['admin_id'];

        // Redirect to admin home
        header("Location: ahome.php");
        exit();
    } else {
        $error_message = "Wrong Username or Password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login</title>
<link rel="stylesheet" href="login.css">
<style>
.password-box { position: relative; }
.toggle-eye {
    position: absolute;
    right: 18px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    font-size: 22px;
    color: black;
}
.error-text {
    color: red;
    font-size: 14px;
    margin-bottom: 8px;
}
</style>
</head>
<body>

<div id="parent">

    <?php if($error_message): ?>
        <div class="error-text"><?= $error_message ?></div>
    <?php endif; ?>

    <div class="wrapper">
        <form action="" method="POST">
            <h1 style="color:black">Login as Admin</h1>

            <div class="input-box">
                <input type="email" name="email" placeholder="Enter your email" 
                       autocomplete="new-email" 
                       value="<?= isset($email) ? htmlspecialchars($email) : '' ?>" required>
            </div>

            <div class="input-box password-box">
                <input type="password" id="password" name="password" placeholder="Password" required>
                <span class="toggle-eye" onclick="togglePassword('password')">👁</span>
            </div>

            <div class="remember-forgot">
                <label><input type="checkbox" name="r-check"> Remember me</label>
            </div>

            <button type="submit" name="login" class="logbtn">Login</button>
        </form>
    </div>
</div>

<script>
function togglePassword(id){
    const field = document.getElementById(id);
    field.type = field.type === "password" ? "text" : "password";
}
</script>

</body>
</html>
