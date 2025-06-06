<header class="header">
    <section class="flex">
        <a href="home.php" class="logo">
            <img src="image/nai.jpg" width="130px">
        </a>
        <nav class="navbar">
            <a href="home.php">home</a>
            <a href="about_us.php">about us</a>
            <a href="menu.php">shop</a>
            <a href="order.php">order</a>
            <a href="contact.php">contact now</a>
            <!--<a href="#footer" class="btn">contact now</a>-->
        </nav>
        <form action="search_product.php" method="post">
            <input type="text" name="search_product" placeholder="search product..." required maxlength="100">
            <button type="submit" class="bx bx-search-alt-2" id="search_product_btn"></button>
        </form>
        <div class="icons">
            <?php
            $count_wistlist_item=$conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
            $count_wistlist_item->execute([$user_id]);
            $total_wishlist_items=$count_wistlist_item->rowCount();
            ?>
            <a href="wishlist.php"><i class="bx bx-heart"></i><sup><?= $total_wishlist_items; ?></sup></a>
            <?php
            $count_cart_item=$conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $count_cart_item->execute([$user_id]);
            $total_cart_items=$count_cart_item->rowCount();
            ?>
            <a href="cart.php"><i class="bx bx-cart"></i><sup><?= $total_cart_items; ?></sup></a>
            <div class="bx bxs-user" id="user-btn"></div>

            <div class="profile">
    <?php
    session_start();
    if (!isset($user_id) || empty($user_id)) {
        ?>
        <h3 style="margin-bottom: 1rem;">Please login or register</h3>
        <div class="flex-btn">
            <a href="login.php" class="btn">Login</a>
            <a href="register.php" class="btn">Register</a>
        </div>
        <?php
    } else {
        $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
        $select_profile->execute([$user_id]);
        if ($select_profile->rowCount() > 0) {
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
            ?>
            <img src="<?= file_exists('uploaded_files/' . $fetch_profile['image']) ? 'uploaded_files/' . $fetch_profile['image'] : 'default-profile.png'; ?>" alt="Profile Image" style="width: 80px; height: 80px; border-radius: 50%; margin-bottom: 1rem;">
            <h3 style="margin-bottom: 1rem;"><?= htmlspecialchars($fetch_profile['name']); ?></h3>
            <div class="flex-btn">
                <a href="profile.php" class="btn">View Profile</a>
                <a href="components/user_logout.php" onclick="return confirm('Are you sure you want to logout?');" class="btn">Logout</a>
            </div>
            <?php
        } else {
            ?>
            <h3 style="margin-bottom: 1rem;">No profile found. Please login or register.</h3>
            <div class="flex-btn">
                <a href="login.php" class="btn">Login</a>
                <a href="register.php" class="btn">Register</a>
            </div>
            <?php
        }
    }
    ?>
</div>


        </div>
    </section>
</header>
