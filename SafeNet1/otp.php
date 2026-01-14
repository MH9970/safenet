<?php
// Include the database connection
include('config.php');

// Start session to store temporary data
session_start();

$name = $email = $amount = $otp = "";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'])) {
    // Get form data
    $name = htmlspecialchars($_POST['fName']);
    $email = htmlspecialchars($_POST['email']);
    $amount = htmlspecialchars($_POST['amount']);

    // Generate OTP
    $otp = rand(100000, 999999);

    // Store details and OTP in the session
    $_SESSION['donation_data'] = [
        'name' => $name,
        'email' => $email,
        'amount' => $amount,
        'otp' => $otp,
    ];

    // Send OTP via email
    $subject = "Your Donation OTP";
    $message = "Dear $name,\n\nYour OTP for the donation is: $otp\n\nThank you for donating!";
    $headers = "From: no-reply@yourdomain.com";

    if (mail($email, $subject, $message, $headers)) {
        echo "OTP has been sent to your email: $email<br>";
    } else {
        echo "Failed to send the OTP email.";
    }

    // For testing purposes (remove in production)
    echo "Your OTP (for testing): $otp";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter OTP</title>
</head>
<body>
    <div style="backgroud-color:white">
        <form method="POST" action="storedata.php">
        <label for="otp">Enter the OTP:</label>
        <input type="number" name="entered_otp" placeholder="Enter OTP" required>
        <button type="submit" name="verify_otp">Verify OTP</button>
    </form>


    </div>


</body>
</html>
