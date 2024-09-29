<?php
session_start();
include('dwos.php');

function getLoggedInUserInfo($conn) {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // Debugging output
        error_log("Fetching user info for User ID: " . $user_id);

        // Prepare and execute the query to fetch the username and image
        $stmt = $conn->prepare("SELECT user_name, image FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }

        $stmt->close();
    }
    return null; // Return null if no user is logged in
}

$user_info = getLoggedInUserInfo($conn); // Fetch the logged-in user's info
$user_name = $user_info['user_name'] ?? ''; // Fallback to empty string if not set

// Assuming $conn is your database connection and $user_id is already defined
$image_path_query = "SELECT image FROM users WHERE user_id = ?";
$stmt = $conn->prepare($image_path_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$image_path_result = $stmt->get_result();

if ($image_path_result && $image_path_result->num_rows > 0) {
    $image_row = $image_path_result->fetch_assoc();
    $profile_image = htmlspecialchars($image_row['image']);
} else {
    // Default image path if not found in the database
    $profile_image = "image/depult.jpg";
}

$stmt->close();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="adminnavbar.css" />
    <title>Admin Navbar</title>
    <style>
    .profile { 
        display: inline-block; 
        position: relative; 
    }

    .toggleDropdown{
        background: #03F8F8;
    }

    .dropdown-content { 
        display: none; 
        position: absolute; 
        background-color: #f9f9f9; 
        min-width: 75px; 
        left: 50%; /* Center horizontally */
        transform: translateX(-50%); /* Offset by half its width */
        z-index: 1000; /* Ensure it appears above other content */
    }
    .dropdown-content a { 
        color: black; 
        padding: 5px 10px; 
        text-decoration: none; 
        display: block; 
    }
    .show { 
        display: block; 
    }
</style>

</head>
<body>
    <nav>
        <div class="nav__logo">
            <a href=""><img src="image/dwoslogo.png" alt="Water Ordering System Logo" /></a>
        </div> 
        <div class="nav__menu">
            <ul class="nav__links">
                <li><a href="adminpage.php">HOME</a></li>
                <li><a href="station.php">STATION</a></li>
                <li><a href="subscription.php">SUBSCRIPTION</a></li>
                <li><a href="users.php">USERS</a></li>
            </ul>
            <div class="profile">
                <span><?php echo htmlspecialchars($user_name); ?></span>
                <div class="profile-dropdown">
                <img src="<?php echo htmlspecialchars($profile_image); ?>" alt="Profile" onclick="toggleDropdown()" class="profile-image" />
                    <div class="dropdown-content" id="myDropdown">
                        <a href="manage_account.php">Manage Account</a>
                        <a href="logout.php">Log Out</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <script>
        function toggleDropdown() {
            document.getElementById("myDropdown").classList.toggle("show");
        }
        window.onclick = function(event) {
            if (!event.target.matches('.profile img')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
    </script>
</body>
</html>
