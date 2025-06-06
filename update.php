<?php
include 'components/connect.php';

session_start();

if (!isset($_COOKIE['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_COOKIE['user_id'];

if (isset($_POST['submit'])) {
    
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $old_pass = sha1($_POST['old_pass']);
    $new_pass = sha1($_POST['new_pass']);
    $cpass = sha1($_POST['cpass']);

    
    $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
    $select_user->execute([$user_id]);
    $fetch_profile = $select_user->fetch(PDO::FETCH_ASSOC);

    if ($select_user->rowCount() > 0) {
    
        if (!empty($_FILES['image']['name'])) {
            $image = $_FILES['image']['name'];
            $image_tmp_name = $_FILES['image']['tmp_name'];
            $image_folder = 'uploaded_files/' . $image;

            move_uploaded_file($image_tmp_name, $image_folder);
        } else {
            $image = $fetch_profile['image'];
        }

        
        if (!empty($old_pass) && !empty($new_pass) && !empty($cpass)) {
            if ($old_pass === $fetch_profile['password']) {
                if ($new_pass === $cpass) {
                    $update_user = $conn->prepare("UPDATE `users` SET name = ?, email = ?, image = ?, password = ? WHERE id = ?");
                    $update_user->execute([$name, $email, $image, $new_pass, $user_id]);
                    $success_msg = 'Profile updated successfully!';
                } else {
                    $warning_msg[] = 'New password and confirm password do not match!';
                }
            } else {
                $warning_msg[] = 'Old password is incorrect!';
            }
        } else {
            
            $update_user = $conn->prepare("UPDATE `users` SET name = ?, email = ?, image = ? WHERE id = ?");
            $update_user->execute([$name, $email, $image, $user_id]);
            $success_msg = 'Profile updated successfully!';
        }
    } else {
        $warning_msg[] = 'User not found!';
    }
}


$select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
$select_user->execute([$user_id]);
$fetch_profile = $select_user->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link rel="stylesheet" href="css/p_update.css">
</head>
<body>
<span> <a href="profile.php">←</a><i class="bx bx-right-arrow-alt"></i></span>
<section class="form-container">
    <div class="heading">
        <h1>Update Profile Details</h1>
    </div>
    <form action="" method="post" enctype="multipart/form-data" class="register">
        <div class="img-box">
            <img src="uploaded_files/<?= htmlspecialchars($fetch_profile['image']); ?>" alt="Profile Image">
        </div>
        <div class="flex">
            <div class="col">
                <div class="input-field">
                    <p>Your Name <span>*</span></p>
                    <input type="text" name="name" value="<?= htmlspecialchars($fetch_profile['name']); ?>" class="box" required>
                </div>
                <div class="input-field">
                    <p>Your Email <span>*</span></p>
                    <input type="email" name="email" value="<?= htmlspecialchars($fetch_profile['email']); ?>" class="box" required>
                </div>
                <div class="input-field">
                    <p>Select Picture <span>*</span></p>
                    <input type="file" name="image" accept="image/*" class="box">
                </div>
            </div>
            <div class="col">
                <div class="input-field">
                    <p>Old Password <span>*</span></p>
                    <input type="password" name="old_pass" placeholder="Enter your old password" class="box">
                </div>
                <div class="input-field">
                    <p>New Password <span>*</span></p>
                    <input type="password" name="new_pass" placeholder="Enter your new password" class="box">
                </div>
                <div class="input-field">
                    <p>Confirm Password <span>*</span></p>
                    <input type="password" name="cpass" placeholder="Confirm your new password" class="box">
                </div>
            </div>
        </div>
        <input type="submit" name="submit" value="Update Profile" class="btn">
    </form>
</section>

<?php
if (isset($success_msg)) {
    echo "<script>alert('$success_msg');</script>";
}
if (isset($warning_msg)) {
    foreach ($warning_msg as $msg) {
        echo "<script>alert('$msg');</script>";
    }
}
?>

</body>
</html>
