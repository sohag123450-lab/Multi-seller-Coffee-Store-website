<?php
    include 'components/connect.php';

    if(isset($_POST['submit'])){
        $id =unique_id();
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);

        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);

        $pass = sha1($_POST['pass']);
        $pass = filter_var($pass, FILTER_SANITIZE_STRING);

        $cpass = sha1($_POST['cpass']);
        $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);
        

        $image = $_FILES['image']['name'];
        $image = filter_var($image, FILTER_SANITIZE_STRING);
        $ext = pathinfo($image, PATHINFO_EXTENSION);
        $rename = unique_id(). '.' .$ext;
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = 'uploaded_files/' .$rename;

        $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? ");
        $select_user -> execute([$email]);

        if($select_user->rowCount() > 0){
            $warning_msg[] = 'email already exist! ';     
        }
        else{
            if($pass != $cpass){
                $warning_msg[] = 'Confirm password not matched';
            }
            else{
                $insert_user = $conn->prepare("INSERT INTO `users` (id, name, email , password, image) VALUES(?, ?, ?, ?, ?)");
                $insert_user->execute([$id, $name, $email, $cpass, $rename]);
                move_uploaded_file($image_tmp_name, $image_folder);
                $success_msg[] = 'New user registered! Please login now!';
            }
        }

    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee_nai</title>
    <link rel="stylesheet" type="text/css" href="css/register.css">
    

</head>
<body>
    <div class="form-container">
        <form action="" method="post" enctype="multipart/form-data" class="register">
        <span> <a href="home.php">←</a><i class="bx bx-right-arrow-alt"></i></span>
            <h3>Register now</h3>
            <div class="flex">
                <div class="col">
                    <div class="input-field">
                        <p>Your name <span>*</span></p>
                        <input type="text" name="name" placeholder="Enter your name" maxlength="50" required class="box">
                    </div>
                    <div class="input-field">
                        <p>Your email <span>*</span></p>
                        <input type="text" name="email" placeholder="Enter your email" maxlength="50" required class="box">
                    </div>
                </div>
                <div class="col">
                    <div class="input-field">
                        <p>Your password <span>*</span></p>
                        <input type="password" name="pass" placeholder="Enter your password" maxlength="50" required class="box">
                    </div>
                    <div class="input-field">
                        <p>Confirm password <span>*</span></p>
                        <input type="password" name="cpass" placeholder="Confirm your password" maxlength="50" required class="box">
                    </div>
                </div>
            </div>
            <div class="input-field">
                 <p>Your profile <span>*</span></p>
                   <input type="file" name="image" accept="image/*" maxlength="50" required class="box">
           </div>
            <p class="link">Already have an account? <a href="login.php">Login now</a></p>
             <input type="submit" name="submit" value="Register now" class="btn" >
             
        </form>
    </div>

     <?php 
         include 'components/alert.php';
     ?>
    
</body>
</html>

 