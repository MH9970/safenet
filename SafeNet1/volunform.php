<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Volunteer Registration</title>
<link rel="stylesheet" href="volunform.css">
<style>
/* Error text below fields */
.error-text {
    color: red;
    font-size: 13px;
    margin-top: 4px;
}

/* Centered modal box */
.success-modal {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: #69a0b0;
    color: white;
    padding: 30px 40px;
    font-size: 18px;
    border-radius: 8px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.3);
    opacity: 0;
    animation: fadeIn 0.5s forwards;
    text-align: center;
    z-index: 9999;
}

/* Fade-in animation */
@keyframes fadeIn {
    to { opacity: 1; }
}
</style>
</head>
<body>

<div id="parent">
<?php
include("config.php");

$dobError = '';
$emailError = '';
$successMsg = '';

if (isset($_POST['submit'])) {

    $full_name = $_POST['fName'];
    $email     = $_POST['email'];
    $locations = $_POST['location'];
    $DOB       = $_POST['DOB'];
    $experties = $_POST['experties'];
    $gender    = $_POST['gender'];

    // --- AGE CHECK ---
    $birthDate = new DateTime($DOB);
    $today = new DateTime();
    $age = $today->diff($birthDate)->y;

    if ($age < 17) {
        $dobError = 'You are underaged. Minimum age is 17.';
    }

    // --- EMAIL CHECK ---
    $verify_query = mysqli_query($con, "SELECT email FROM volunteer WHERE email='$email'");
    if(mysqli_num_rows($verify_query) !=0){
        $emailError = 'This email is used, try another one please!';
    }

    // --- INSERT INTO DATABASE IF NO ERRORS ---
    if ($dobError === '' && $emailError === '') {
        mysqli_query($con, "INSERT INTO volunteer
            (full_name, email, locations, date_of_birth, exparties, gender)
            VALUES ('$full_name','$email','$locations','$DOB','$experties','$gender')")
            or die("Error Occurred");

        $successMsg = 'Registration successful! Redirecting...';
    }
}
?>

<main>
<div class="wrapper">
<form action="" method="POST">

<h1>Registration</h1>

<div class="input-box">
    <input type="text" name="fName" placeholder="Full Name" value="<?= isset($full_name)?htmlspecialchars($full_name):'' ?>" required>
</div>

<div class="input-box">
    <input type="email" name="email" placeholder="Email" autocomplete="new-email" 
        value="<?= isset($email)?htmlspecialchars($email):'' ?>" required>
    <?php if ($emailError !== ''): ?>
        <div class="error-text"><?= $emailError ?></div>
    <?php endif; ?>
</div>

<div class="input-box">
    <input type="text" name="location" placeholder="Location" value="<?= isset($locations)?htmlspecialchars($locations):'' ?>" required>
</div>

<div class="input-box">
    <label>Date of Birth</label><br>
    <input type="date" name="DOB" value="<?= isset($DOB)?htmlspecialchars($DOB):'' ?>" required>
    <?php if ($dobError !== ''): ?>
        <div class="error-text"><?= $dobError ?></div>
    <?php endif; ?>
</div>

<div class="input-box">
    <input type="text" name="experties" placeholder="Expertise" value="<?= isset($experties)?htmlspecialchars($experties):'' ?>" required>
</div>

<select class="input-box" name="gender" required>
    <option value="">Select gender</option>
    <option value="Male" <?= (isset($gender) && $gender=='Male')?'selected':'' ?>>Male</option>
    <option value="Female" <?= (isset($gender) && $gender=='Female')?'selected':'' ?>>Female</option>
    <option value="Other" <?= (isset($gender) && $gender=='Other')?'selected':'' ?>>Other</option>
</select>

<button type="submit" name="submit" class="regbtn">Register</button>

</form>
</div>
</main>

<?php if ($successMsg !== ''): ?>
    <!-- Centered modal box -->
    <div class="success-modal"><?= $successMsg ?></div>
    <script>
        // Redirect to volunteer.html after 3 seconds
        setTimeout(() => {
            window.location.href = 'volunteer.html';
        }, 3000);
    </script>
<?php endif; ?>

</div>
</body>
</html>
