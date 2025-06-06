<?php
    include '../components/connect.php';

    if(isset($_COOKIE['seller_id'])) {
        $seller_id = $_COOKIE['seller_id'];
    }
    else{
        $seller_id = '';
        header('location:login.php');
    }
if(isset($_POST['delete_msg'])){

    $delete_id = $_POST['delete_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

    $verify_delete = $conn->prepare("SELECT * FROM `message` WHERE id = ?");
    $verify_delete->execute([$delete_id]);

    if($verify_delete->rowCount() > 0){
        $delete_msg = $conn->prepare("DELETE FROM `message` WHERE id = ?");
        $delete_msg->execute([$delete_id]);

        $success_msg[] = 'Message deleted successfully';
    }
    else{
        $warning_msg[] = 'Message already deleted';
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
    <link rel="stylesheet"href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" >


</head>
<body>

    <div class="main-container">
        <?php include '../components/admin_header.php';?>
        <section class="message-container">
          <div class="heading">
             <h1>Unread messages</h1>
            
          </div>
          <div class="box-container">
            <?php 
                $select_message = $conn->prepare("SELECT * FROM `message`");
                $select_message->execute();
                if($select_message->rowCount() > 0){
                    while($fetch_message = $select_message->fetch(PDO::FETCH_ASSOC)){
                       
                       ?>
                       <div class="box">
                            <h3 class="name"><?= $fetch_message['name']; ?></h3>
                            <h4><?= $fetch_message['subject']; ?></h4>
                            <p><?= $fetch_message['message']; ?></p> 
                            <form action="" method="post">
                                <input type="hidden" name="delete_id" value="<?= $fetch_message['id']; ?>">
                                <input type="submit" name="delete_msg" value="delete message" class="btn" onclick="return confirm('Delete this message');">
                            </form>                   
                       </div>
                       <?php
                    }
                }
                    else {
                        echo '
                        <div class="empty">
                          <p>No unread message yet!<br>
                          </div>';
                    }
                
            ?>
          </div>

        </section>
    </div>



     <?php include '../components/alert.php'; ?>
    
</body>
</html>

 