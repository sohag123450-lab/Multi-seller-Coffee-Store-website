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
    <div class="slider-container">
        <div class="slider">
            <div class="slideBox active">
                <div class="textBox">
                    <h1>"Fresh coffee, bold flavor, your perfect brew!"</h1>
                    <a href="menu.php" class="btn">shop now</a>
                </div>
                <div class="imgBox">
                    <img src="image/slider3.jpg">
                </div>
            </div>
            <div class="slideBox">
                <div class="textBox">
                    <h1>"Awaken your senses with our premium coffee!"</h1>
                    <a href="menu.php" class="btn">shop now</a>
                </div>
                <div class="imgBox">
                    <img src="image/slider4.jpg">
                </div>
            </div>
            <div class="slideBox">
                <div class="textBox">
                    <h1>"Experience joy in every sip"</h1>
                    <a href="menu.php" class="btn">shop now</a>
                </div>
                <div class="imgBox">
                    <img src="image/slider5.jpg">
                </div>
            </div>
        </div>
        <ul class="controls">
            <li onclick="nextSlide();" class="next"> <i class="bx bx-right-arrow-alt"></i></li>
            <li onclick="prevSlide();" class="prev"> <i class="bx bx-left-arrow-alt"></i></li>
        </ul>
    </div>


    
    <div class="service">
        <h2>services</h2>
        <div class="box-container">
            
            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="image/services.png" class="img1">
                        <img src="image/services (1).png" class="img2">
                    </div>
                </div>
                <div class="detail">
                    <h4>delivery</h4>
                    <span>100% secure</span>
                </div>
            </div>
            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="image/services (2).png" class="img1">
                        <img src="image/services (3).png" class="img2">
                    </div>
                </div>
                <div class="detail">
                    <h4>payment</h4>
                    <span>100% secure</span>
                </div>
            </div>
            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="image/services (5).png" class="img1">
                        <img src="image/services (6).png" class="img2">
                    </div>
                </div>
                <div class="detail">
                    <h4>support</h4>
                    <span>24*7 hours</span>
                </div>
            </div>
            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="image/services (7).png" class="img1">
                        <img src="image/services (8).png" class="img2">
                    </div>
                </div>
                <div class="detail">
                    <h4>gift service</h4>
                    <span>support gift service</span>
                </div>
            </div>
                
            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="image/service.png" class="img1">
                        <img src="image/service (1).png" class="img2">
                    </div>
                </div>
                <div class="detail">
                    <h4>return</h4>
                    <span>100% secure</span>
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