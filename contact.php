<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}

if (isset($_POST['send_message'])) {

    if ($user_id != '') {
        $id = uniqid();

        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);

        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);

        $subject = $_POST['subject'];
        $subject = filter_var($subject, FILTER_SANITIZE_STRING);

        $message = $_POST['message'];
        $message = filter_var($message, FILTER_SANITIZE_STRING);

        // Verify if the message already exists
        $verify_message = $conn->prepare("SELECT * FROM `message` WHERE user_id = ? AND name = ? AND email = ? AND subject = ? AND message = ?");
        $verify_message->execute([$user_id, $name, $email, $subject, $message]);

        if ($verify_message->rowCount() > 0) {
            $warning_msg[] = 'Message already exists';
        } else {
            // Insert the new message
            $insert_message = $conn->prepare("INSERT INTO `message` (id, user_id, name, email, subject, message) VALUES (?, ?, ?, ?, ?, ?)");
            $insert_message->execute([$id, $user_id, $name, $email, $subject, $message]);
            $success_msg[] = 'Comment inserted successfully!';
        }
    } else {
        $warning_msg[] = 'Please login first';
    }
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
    <div class="contact">
    <div class="heading">
            <h1>contact us</h1>
        </div>
    <div class="form-container">
        <form action="" method="post" class="register">
            <div class="input-field">
                <label>name <sup>*</sup></label>
                <input type="text" name="name" required placeholder="enter your name" class="box">
            </div>
            <div class="input-field">
                <label>email <sup>*</sup></label>
                <input type="email" name="email" required placeholder="enter your email" class="box">
            </div>
            <div class="input-field">
                <label>subject <sup>*</sup></label>
                <input type="text" name="subject" required placeholder="reason.." class="box">
            </div>
            <div class="input-field">
                <label>comment<sup>*</sup></label>
                <textarea name="message" cols="30" rows="10" required placeholder="" class="box"></textarea>
            </div>
            <button type="submit" name="send_message" class="btn">send message</button>
        </form>
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