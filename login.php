<?php
    include 'components/connect.php';

    if(isset($_POST['submit'])){
     
        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);

        $pass = sha1($_POST['pass']);
        $pass = filter_var($pass, FILTER_SANITIZE_STRING);
       
        $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
        $select_user -> execute([$email, $pass]);
        $row = $select_user->fetch(PDO::FETCH_ASSOC);

        if($select_user->rowCount() > 0){
            setcookie('user_id' , $row['id'], time() + 60*60*24*30, '/');
            header('location:home.php');
        }
        else{
            $warning_msg[] = 'incorrect email or password';
        }

    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coffee_nai</title>
    <link rel="stylesheet" type="text/css" href="css/register.css">
    

</head>
<body>
    <div class="form-container">
        <form action="" method="post" enctype="multipart/form-data" class="login">
        <span> <a href="home.php">←</a><i class="bx bx-right-arrow-alt"></i></span>
            <h3>Login now</h3>

            <div class="input-field">
                 <p>Your email <span>*</span></p>
                  <input type="text" name="email" placeholder="Enter your email" maxlength="50" required class="box">
            </div>

           <div class="input-field">
                 <p>Your password <span>*</span></p>
                 <input type="password" name="pass" placeholder="Enter your password" maxlength="50" required class="box">
             </div>        

        
            <p class="link">Do not have an account? <a href="register.php">Register now</a></p>
             <input type="submit" name="submit" value="Login now" class="btn" >
        </form>
    </div>

    <!--
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
     <script src="../js/script.js"></script>-->

     <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="js/admin_script.js"></script>

     <?php 
         include 'components/alert.php';
     ?>
    
</body>
</html>

 