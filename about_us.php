<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}

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
    
    <div class="banner">
        <div class="detail">
            <h1>about us</h1>
            <p>Welcome to "Coffee_Nai", a multi-seller platform offering the finest selection of premium
                 coffees from around the world. Discover a wide range of blends, from bold dark roasts to smooth 
                 light brews, all sourced from passionate sellers. Each seller brings unique flavors and expertise, 
                 ensuring a fresh coffee experience every time. Enjoy secure shopping, fast delivery, and top-notch 
                 customer service.<br> Join us at "Coffee_Nai" and explore the best in coffee!</p>
            <span> <a href="home.php">home</a><i class="bx bx-right-arrow-alt"></i>About us </span>
        </div>
    </div>


    <?php include 'components/admin_footer.php'; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="js/admin_script.js"></script>
    <?php include 'components/alert.php'; ?>

</body>

</html>