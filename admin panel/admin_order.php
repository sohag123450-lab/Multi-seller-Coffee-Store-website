<?php
include '../components/connect.php';

if (isset($_COOKIE['seller_id'])) {
    $seller_id = $_COOKIE['seller_id'];
} else {
    $seller_id = '';
    header('location:login.php');
    exit;
}

// Update order payment 
if (isset($_POST['update_order'])) {
    $order_id = htmlspecialchars($_POST['order_id'], ENT_QUOTES, 'UTF-8');

    if (!empty($_POST['update_payment'])) {
        $update_payment = htmlspecialchars($_POST['update_payment'], ENT_QUOTES, 'UTF-8');

        $update_pay = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
        $update_pay->execute([$update_payment, $order_id]);

        $success_msg[] = 'Order payment status updated';
    } else {
        $warning_msg[] = 'Please select a payment status.';
    }
}


if (isset($_POST['delete_order'])) {
    $delete_id = htmlspecialchars($_POST['order_id'], ENT_QUOTES, 'UTF-8');

    $verify_delete = $conn->prepare("SELECT * FROM `orders` WHERE id = ?");
    $verify_delete->execute([$delete_id]);

    if ($verify_delete->rowCount() > 0) {
        $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
        $delete_order->execute([$delete_id]);
        $success_msg[] = 'Order deleted';
    } else {
        $warning_msg[] = 'Order already deleted.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coffee_nai</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
</head>

<body>
    <div class="main-container">
        <?php include '../components/admin_header.php'; ?>

        <section class="order-container">
            <div class="heading">
                <h1>Total Orders Placed</h1>
            </div>

            <div class="box-container">
                <?php
                $select_order = $conn->prepare("SELECT * FROM `orders` WHERE seller_id = ?");
                $select_order->execute([$seller_id]);
                if ($select_order->rowCount() > 0) {
                    while ($fetch_order = $select_order->fetch(PDO::FETCH_ASSOC)) {
                        $product_id = $fetch_order['product_id'];
                        $select_product = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
                        $select_product->execute([$product_id]);

                        if ($select_product->rowCount() > 0) {
                            $fetch_product = $select_product->fetch(PDO::FETCH_ASSOC);

                            $total_price = $fetch_product['price'] * $fetch_order['qty'];
                        } else {
                            $total_price = 'Unknown (Product not found)';
                        }
                        ?>
                        <div class="box">
                            <div class="status" style="color: <?php if ($fetch_order['status'] == 'in progress') {
                                echo "limegreen";
                            } else {
                                echo "red";
                            } ?>">
                                <?= htmlspecialchars($fetch_order['status'], ENT_QUOTES, 'UTF-8'); ?>
                            </div>

                            <div class="details">
                                <p>User Name: <span><?= htmlspecialchars($fetch_order['name'], ENT_QUOTES, 'UTF-8'); ?></span></p>
                                <p>User ID: <span><?= htmlspecialchars($fetch_order['user_id'], ENT_QUOTES, 'UTF-8'); ?></span></p>
                                <p>Placed On: <span><?= htmlspecialchars($fetch_order['dates'], ENT_QUOTES, 'UTF-8'); ?></span></p>
                                <p>User Number: <span><?= htmlspecialchars($fetch_order['number'], ENT_QUOTES, 'UTF-8'); ?></span></p>
                                <p>User Email: <span><?= htmlspecialchars($fetch_order['email'], ENT_QUOTES, 'UTF-8'); ?></span></p>
                                <p>Total Price: <span>৳<?= htmlspecialchars($total_price, ENT_QUOTES, 'UTF-8'); ?></span></p>
                                <p>Quantity: <span><?= htmlspecialchars($fetch_order['qty'], ENT_QUOTES, 'UTF-8'); ?></span></p>
                                <p>Payment Method: <span><?= htmlspecialchars($fetch_order['method'], ENT_QUOTES, 'UTF-8'); ?></span></p>
                                <p>User Address: <span><?= htmlspecialchars($fetch_order['address'], ENT_QUOTES, 'UTF-8'); ?></span></p>
                            </div>

                            <form action="" method="post">
                                <input type="hidden" name="order_id" value="<?= htmlspecialchars($fetch_order['id'], ENT_QUOTES, 'UTF-8'); ?>">
                                <select name="update_payment" class="box" style="width: 90%;" required>
                                    <option disabled selected><?= htmlspecialchars($fetch_order['payment_status'], ENT_QUOTES, 'UTF-8'); ?></option>
                                    <option value="pending">Pending</option>
                                    <option value="payment cleared">Payment Cleared</option>
                                    <option value="way to delivery">Way to Delivery</option>
                                    <option value="order delivered">Order Delivered</option>
                                </select>
                                <div class="flex-btn">
                                    <input type="submit" name="update_order" value="Update Payment" class="btn">
                                    <input type="submit" name="delete_order" value="Delete Order" class="btn" onclick="return confirm('Delete this order?');">
                                </div>
                            </form>
                        </div>
                        <?php
                    }
                } else {
                    echo '
                        <div class="empty">
                            <p>No orders placed yet!</p>
                        </div>';
                }
                ?>
            </div>
        </section>
    </div>

    <?php include '../components/alert.php'; ?>
</body>

</html>
