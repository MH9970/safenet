<?php 
session_start();
include("config.php");

/* ================= SESSION TIMEOUT ================= */
if (isset($_SESSION['start_time'])) {
    if ((time() - $_SESSION['start_time']) > $_SESSION['timeout']) {
        session_unset();
        session_destroy();
        header("Location: login.php?message=Session expired, please log in again.");
        exit();
    } else {
        $_SESSION['start_time'] = time();
    }
}

/* ================= LOGIN HANDLER ================= */
if (isset($_POST['login'])) {

    $email    = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    $result = mysqli_query(
        $con,
        "SELECT * FROM log_in WHERE email='$email' AND password='$password'"
    );

    $row = mysqli_fetch_assoc($result);

    if ($row) {
        // Sessions
        $_SESSION['valid']      = $row['email'];
        $_SESSION['first_name'] = $row['f_name'];
        $_SESSION['last_name']  = $row['l_name'];            
        $_SESSION['log_id']     = $row['log_id'];
        $_SESSION['start_time'] = time();
        $_SESSION['timeout']    = 30 * 60;

        /* ========== REMEMBER ME (FIXED) ========== */
        if (isset($_POST['r-check'])) {
            setcookie(
                "user_email",
                $row['email'],
                time() + (7 * 24 * 60 * 60),
                "/"
            );
        } else {
            // delete cookie if unchecked
            setcookie("user_email", "", time() - 3600, "/");
        }

        header("Location: home.php");
        exit();

    } else {
        $error_message = "Wrong Email or Password";
    }
}

/* ================= MESSAGE ================= */
if (isset($_GET['message'])) {
    $error_message = $_GET['message'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
<link rel="stylesheet" href="login.css">

<style>
.password-box {
    position: relative;
}
.toggle-eye {
    position: absolute;
    right: 18px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    font-size: 22px;
}
</style>
</head>

<body>
<div id="parent">
 

    <?php if (isset($error_message)) { ?>
        <div class="message">
            <p><?= htmlspecialchars($error_message) ?></p>
        </div>
    <?php } ?>

    <div class="wrapper">
        <form method="POST" autocomplete="off">
            <h1 class="user">Login as User</h1>

            <!-- EMAIL -->
            <div class="input-box">
                <input type="email"
                       name="email"
                       placeholder="Enter your email"
                       autocomplete="off"
                       value="<?= isset($_COOKIE['user_email']) ? htmlspecialchars($_COOKIE['user_email']) : '' ?>"
                       required>
            </div>

            <!-- PASSWORD -->
            <div class="input-box password-box">
                <input type="password"
                       id="password"
                       name="password"
                       placeholder="Password"
                       autocomplete="new-password"
                       required>
                <span class="toggle-eye" onclick="togglePassword('password')">👁</span>
            </div>

            <!-- REMEMBER ME (ALWAYS UNCHECKED INITIALLY) -->
            <div class="remember-forgot">
                <label>
                    <input type="checkbox" name="r-check" autocomplete="off">
                    Remember me
                </label>
            </div>

            <button type="submit" name="login" class="logbtn">Login</button>
        </form>
    </div>
</div>

<script>
function togglePassword(id) {
    const field = document.getElementById(id);
    field.type = field.type === "password" ? "text" : "password";
}
</script>

</body>
</html>
