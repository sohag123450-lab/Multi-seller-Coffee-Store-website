<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}
include 'components/add_wishlist.php';
include 'components/add_cart.php';

$products_per_page = 12;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$current_page = max($current_page, 1);
$start_offset = ($current_page - 1) * $products_per_page;
$total_products_query = $conn->prepare("SELECT COUNT(*) FROM `products` WHERE status = ?");
$total_products_query->execute(['active']);
$total_products = $total_products_query->fetchColumn();
$total_pages = ceil($total_products / $products_per_page);
$select_products = $conn->prepare("SELECT * FROM `products` WHERE status = 'active' LIMIT $products_per_page OFFSET $start_offset");
$select_products->execute();
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
<div class="products">
    <div class="heading">
        <h1>our products</h1>
    </div>
    <div class="box-container">
        <?php
        if ($select_products->rowCount() > 0) {
            while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <form action="" method="post" class="box <?php if ($fetch_products['stock'] == 0) {
                    echo "disabled";
                } ?>">
                    <img src="uploaded_files/<?= $fetch_products['image']; ?>">
                    <?php if ($fetch_products['stock'] > 9) { ?>
                        <span class="stock" style="color: green;">In stock</span>
                    <?php } elseif ($fetch_products['stock'] == 0) { ?>
                        <span class="stock" style="color: red;">out of stock</span>
                    <?php } else { ?>
                        <span class="stock" style="color: red;">hurry, only <?= $fetch_products['stock']; ?></span>
                    <?php } ?>
                    <div class="content">
                        <div class="button">
                            <div>
                                <h3 class="name"><?= $fetch_products['name']; ?></h3>
                            </div>
                            <div>
                                <button type="submit" name="add_to_cart"><i class="bx bx-cart"></i></button>
                                <button type="submit" name="add_to_wishlist"><i class="bx bx-heart"></i></button>
                                <a href="view_page.php?pid=<?= $fetch_products['id'] ?>" class="bx bxs-show"></a>
                            </div>
                        </div>
                        <p class="price">price  ৳<?= $fetch_products['price']; ?></p>
                        <input type="hidden" name="product_id" value="<?= $fetch_products['id'] ?>">
                        <div class="flex-btn">
                            <a href="checkout.php?get_id=<?= $fetch_products['id'] ?>" class="btn">buy now</a>
                            <input type="number" name="qty" required min="1" value="1" max="99" maxlength="2" class="qty">
                        </div>
                    </div>
                </form>
                <?php
            }
        } else {
            echo '<div class="empty">
                    <p>no products added yet!</p>
                 </div>';
        }
        ?>
    </div>
</div>


<div class="pagination">
    <?php if ($current_page > 1) { ?>
        <a href="?page=<?= $current_page - 1 ?>" class="prev">Previous</a>
    <?php } ?>
    <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
        <a href="?page=<?= $i ?>" class="<?= $i == $current_page ? 'active' : '' ?>"><?= $i ?></a>
    <?php } ?>
    <?php if ($current_page < $total_pages) { ?>
        <a href="?page=<?= $current_page + 1 ?>" class="next">Next</a>
    <?php } ?>
</div>

<?php include 'components/admin_footer.php'; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="js/admin_script.js"></script>
<?php include 'components/alert.php'; ?>
</body>
</html>
