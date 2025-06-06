<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    header('Location: login.php'); 
    exit;
}


$select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
$select_profile->execute([$user_id]);

if ($select_profile->rowCount() > 0) {
    $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
} else {
    $fetch_profile = null; 
}


$select_orders = $conn->prepare("SELECT * FROM orders WHERE user_id = ?");
$select_orders->execute([$user_id]);
$total_orders = $select_orders->rowCount();


$select_message = $conn->prepare("SELECT * FROM message WHERE user_id = ?");
$select_message->execute([$user_id]);
$total_message = $select_message->rowCount();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coffee_nai</title>
    <link rel="stylesheet" type="text/css" href="css/home_style.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
</head>
<body>
<?php include 'components/user_header.php'; ?>

<div class="myprofile">
    <div class="heading">
        <h1>Profile Details</h1>
    </div>
    <div class="detail">
        <div class="user">
            <?php if ($fetch_profile): ?>
                <img src="<?= file_exists('uploaded_files/' . $fetch_profile['image']) ? 'uploaded_files/' . $fetch_profile['image'] : 'default-profile.png'; ?>" alt="Profile Image">
                <h3><?= htmlspecialchars($fetch_profile['name']); ?></h3>
                <p>User</p>
                <a href="update.php" class="btn">Update Profile</a>
            <?php else: ?>
                <h3>User profile not found</h3>
                <p>Please update your profile or contact support.</p>
            <?php endif; ?>
        </div>
        <div class="box-container">
            <div class="box">
                <div class="flex">
                    <i class="bx bxs-folder-minus"></i>
                    <h3><?= $total_orders ?></h3>
                </div>
                <a href="order.php" class="btn">View Orders</a>
            </div>
            <div class="box">
                <div class="flex">
                    <i class="bx bxs-chat"></i>
                    <h3><?= $total_message ?></h3>
                </div>
                <a href="message.php" class="btn">View Messages</a>
            </div>
        </div>
    </div>
            </div>


<?php include 'components/admin_footer.php'; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="js/admin_script.js"></script>
    <?php include 'components/alert.php'; ?>


</body>
</html>