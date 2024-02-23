<?php

@include 'config.php';

session_start();

if(isset($_POST['submit'])){

   $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
   $email = mysqli_real_escape_string($conn, $filter_email);
   $filter_pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
   $pass = mysqli_real_escape_string($conn, md5($filter_pass));

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');


   if(mysqli_num_rows($select_users) > 0){
      
      $row = mysqli_fetch_assoc($select_users);

      if($row['user_type'] == 'admin'){

         $_SESSION['admin_name'] = $row['name'];
         $_SESSION['admin_email'] = $row['email'];
         $_SESSION['admin_id'] = $row['id'];
         header('location:admin_page.php');

      }elseif($row['user_type'] == 'user'){

         $_SESSION['user_name'] = $row['name'];
         $_SESSION['user_email'] = $row['email'];
         $_SESSION['user_id'] = $row['id'];
         header('location:home.php');

      }else{
         $message[] = 'no user found!';
      }

   }else{
      $message[] = 'incorrect email or password!';
   }

}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anoymous"
    ></script>

    <link rel="stylesheet" type="text/css" href="templates/loginstyle.css">

    <title>Sign In</title>
  </head>
  <body>

<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>
 <div class="container">
      <div class="forms-container">
        <div class="signin-signup">

          <form method="post" action="" class="sign-in-form">
            <input type="hidden" name="csrf_token" value="your_csrf_token_here">
            <h2 class="title">Sign in</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="email" name="email" placeholder="Email">
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="pass" placeholder="Password">
            </div>

            <div class='f-password'>
                <h4 class="forgot-password"><a href="../templates/forgot.html" class="fp-link">Forgot Password?</a></h4>
            </div>

            <input type="submit" class="btn solid" value="Sign In" name="login_submit">
          </form>

          <!-- REGISTRATION FORM -->
          <?php

if(isset($_POST['submit'])){

   $filter_name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
   $name = mysqli_real_escape_string($conn, $filter_name);
   $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
   $email = mysqli_real_escape_string($conn, $filter_email);
   $filter_pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
   $pass = mysqli_real_escape_string($conn, md5($filter_pass));
   $filter_cpass = filter_var($_POST['cpass'], FILTER_SANITIZE_STRING);
   $cpass = mysqli_real_escape_string($conn, md5($filter_cpass));

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

   if(mysqli_num_rows($select_users) > 0){
      $message[] = 'user already exist!';
   }else{
      if($pass != $cpass){
         $message[] = 'confirm password not matched!';
      }else{
         mysqli_query($conn, "INSERT INTO `users`(name, email, password) VALUES('$name', '$email', '$pass')") or die('query failed');
         $message[] = 'registered successfully!';
         header('location:login.php');
      }
   }

}

?>
          <form method="POST" action="" class="sign-up-form">
            <input type="hidden" name="csrf_token" value="your_csrf_token_here">
            <h2 class="title">Sign up</h2>

            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" name="name" placeholder="Enter your name">
            </div>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" name="fullname" placeholder="Full Name">
            </div>
            <div class="input-field">
              <i class="fas fa-map-marker-alt"></i>
              <input type="text" name="address" placeholder="Address">
            </div>
            <div class="input-field">
              <i class="fas fa-mobile-alt"></i>
              <input type="text" name="phone_number" placeholder="Phone Number">
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="pass" placeholder="Password">
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="cpass" placeholder="Confirm Password">
            </div>

            <input type="submit" class="btn" value="Sign Up" name="register_submit">
          </form>
        </div>
      </div>

      <div class="panels-container">
        <!-- LOGIN PANEL -->
        <div class="panel left-panel">
          <div class="content">
            <h3>QuirkyCarta</h3>
            <p>
              Register to start using QuirkyCarta
            </p>
            <button class="btn transparent" id="sign-up-btn">
              Sign up
            </button>
          </div>
        </div>

        <!-- REGISTER PANEL -->
        <div class="panel right-panel">
          <div class="content">
            <h3>Already have an account? </h3>
            <p>
              Login to explore our items
            </p>
            <button class="btn transparent" id="sign-in-btn">
              Sign in
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="templates/login.js"></script>
  </body>
  </html>