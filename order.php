<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
    header('location:login.php');
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

    <div class="orders">
        <div class="heading">
            <h1>my orders</h1>
        </div>
        <div class="box-container">
            <?php
            $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ? ORDER BY dates DESC");
            $select_orders->execute([$user_id]);
            if ($select_orders->rowCount() > 0) {
                while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                    $product_id = $fetch_orders['product_id'];
                    $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                    $select_products->execute([$product_id]);
                    if ($select_products->rowCount() > 0) {
                        while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                    
                            $total_price = $fetch_products['price'] * $fetch_orders['qty'];  
                            ?>
                            <div class="box" <?php if ($fetch_orders['status'] == 'canceled') {
                                echo 'style ="border:2px solid red"';
                            } ?>>
                                <a href="view_order.php?get_id=<?= $fetch_orders['id']; ?>"></a>
                                <img src="uploaded_files/<?= $fetch_products['image'] ?>" class="image">
                                <div class="content">
                                    <p class="date"> <i class="bx bxs-calendar-alt"></i> <?= $fetch_orders['dates']; ?></p>
                                    <div class="row">
                                        <h3 class="name"><?= $fetch_products['name'] ?></h3>
                                        <p class="price">Price: ৳<?= $fetch_products['price'] ?>/-</p>
                                        <p class="quantity">Quantity: <?= $fetch_orders['qty']; ?></p>
                                        <p class="total-price">Total: ৳<?= $total_price; ?>/-</p> 
                                        <p class="status"
                                            style="color: <?php if ($fetch_orders['status'] == 'delivered') {
                                                echo "green";
                                            } elseif ($fetch_orders['status'] == 'canceled') {
                                                echo "red";
                                            } else {
                                                echo "orange";
                                            } ?>">
                                            <?= $fetch_orders['status']; ?></p>
                                        <p class="payment-status"
                                            style="color: <?php if ($fetch_orders['payment_status'] == 'paid') {
                                                echo "green";
                                            } else {
                                                echo "red";
                                            } ?>">
                                            Payment: <?= ucfirst($fetch_orders['payment_status']); ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                }
            } else {
                echo '<p class="empty">No orders placed yet</p>';
            }
            ?>
        </div>
    </div>

    <?php include 'components/admin_footer.php'; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="js/admin_script.js"></script>

    <?php
    include 'components/alert.php';
    ?>
</body>

</html>
