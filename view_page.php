<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}
$pid = $_GET['pid'];

include 'components/add_wishlist.php';
include 'components/add_cart.php';



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
    <section class="view_page">
        <div class="heading">
            <h1>product details</h1>
        </div>
        <?php
        if (isset($_GET['pid'])) {
            $pid = $_GET['pid'];
            $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
            $select_products->execute([$pid]);
            if ($select_products->rowCount() > 0) {
                while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <form action="" method="post" class="box">
                        <div class="img-box">
                            <img src="uploaded_files/<?= $fetch_products['image']; ?>">
                        </div>
                        <div class="detail">
                            <?php if ($fetch_products['stock'] > 9) { ?>
                                <span class="stock" style="color:green;">In stock</span>
                            <?php } elseif ($fetch_products['stock'] == 0) { ?>
                                <span class="stock" style="color:red;">out of stock</span>
                            <?php } else { ?>
                                <span class="stock" style="color: red;">Hurry only <?= $fetch_products['stock']; ?> left</span>
                            <?php } ?>
                            <p class="price">৳<?= $fetch_products['price']; ?>/-</p>
                            <div class="name"><?= $fetch_products['name']; ?></div>
                            <p class="product-detail"><?= $fetch_products['product_detail']; ?></p>
                            <input type="hidden" name="product_id" value="<?= $fetch_products['id']; ?>">
                            <div class="button">
                                <button type="submit" name="add_to_wishlist" class="btn">add to wishlist <i class="bx bx-heart"></i>
                                </button>
                                <input type="hidden" name="qty" value="1" min="0" class="quantity">
                                <button type="submit" name="add_to_cart" class="btn">add to cart <i class="bx bx-cart"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <?php
                }
            }
        } ?>
        </section>


        

        <?php include 'components/admin_footer.php'; ?>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
        <script src="js/admin_script.js"></script>

        <?php
        include 'components/alert.php';
        ?>

</body>

</html>