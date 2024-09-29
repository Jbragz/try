<?php
session_start();

if (!isset($_SESSION['user_data']['payment_method'])) {
    header('Location: payment.php');
    exit();
}

// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'dwos');

if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}

if (isset($_POST['confirm_payment'])) {
    // Insert the user into the database
    $name = $_SESSION['user_data']['name'];
    $email = $_SESSION['user_data']['email'];
    $password = $_SESSION['user_data']['password'];
    $plan = $_SESSION['user_data']['plan'];
    $payment_method = $_SESSION['user_data']['payment_method'];
    $user_type = $_SESSION['user_data']['user_type'];

    $insert = "INSERT INTO users (user_name, email, password, user_type, plan, payment_method) 
               VALUES ('$name', '$email', '$password', '$user_type', '$plan', '$payment_method')";

    if (mysqli_query($conn, $insert)) {
        // Destroy session after successful insertion
        session_destroy();
        header('Location: login.php');
        exit();
    } else {
        echo 'Error: ' . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Payment</title>
    <link rel="stylesheet" href="styles.css"> <!-- Add your CSS file here -->
</head>
<body>
    <div class="confirmation-container">
        <h3>Confirm Your Payment</h3>
        <p>You have selected the <?php echo $_SESSION['user_data']['plan']; ?> plan.</p>
        <p>Payment Method: <?php echo $_SESSION['user_data']['payment_method']; ?></p>
        <form action="" method="post">
            <!-- Here you would typically show some payment details/confirmation steps -->
            <div class="button-container">
                <input type="submit" name="confirm_payment" value="Confirm Payment" class="form-btn">
            </div>
        </form>
    </div>
</body>
</html>
