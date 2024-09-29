<?php
session_start();

// Check if user data is present in session
if (!isset($_SESSION['user_data'])) {
    header('Location: register.php');
    exit();
}

if (isset($_POST['avail'])) {
    // Store selected plan in session
    $_SESSION['user_data']['plan'] = $_POST['plan'];
    header('Location: payment.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose a Subscription Plan</title>
    <link rel="stylesheet" href="styles.css"> <!-- Add your CSS file here -->
</head>
<body>
    <div class="subscription-container">
        <h3>Select a Premium Membership Plan</h3>
        <form action="" method="post">
            <div class="plan">
                <input type="radio" id="plan1" name="plan" value="3_months_399" required>
                <label for="plan1">Buy premium for 3 months for only ₱399</label>
            </div>
            <div class="plan">
                <input type="radio" id="plan2" name="plan" value="6_months_599">
                <label for="plan2">Buy premium for 6 months for only ₱599</label>
            </div>
            <div class="plan">
                <input type="radio" id="plan3" name="plan" value="12_months_999">
                <label for="plan3">Buy premium for 12 months for only ₱999</label>
            </div>
            <div class="button-container">
                <input type="submit" name="avail" value="Avail" class="form-btn">
            </div>
        </form>
    </div>
</body>
</html>
