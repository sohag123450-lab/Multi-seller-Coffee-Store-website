<?php 
    include 'connect.php'; 

    // Clear the seller_id cookie
    setcookie('seller_id', '', time() - 1, '/');
    
    // Redirect to logout page
    header('location: ../admin panel/login.php ');
?>
