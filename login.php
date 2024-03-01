<?php

@include 'config.php';

session_start();

$message = []; 

if(isset($_POST['login_submit'])){
   // Check if both email and password are set and not empty
   if (!empty($_POST['email']) && !empty($_POST['pass'])) {
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
          } elseif($row['user_type'] == 'user'){
             $_SESSION['user_name'] = $row['name'];
             $_SESSION['user_email'] = $row['email'];
             $_SESSION['user_id'] = $row['id'];
             header('location:home.php');
          } else{
             $message[] = 'No such user found';
          }
       } else{
          $message[] = 'Incorrect Email or Password';
       }
   } else {
       $message[] = 'Please enter both email and password.';
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
        

        <!--Sign In Form-->
          <form method="Post" action="" class="sign-in-form">
              <!--logo image--->
        <div class="logo-container">
        <img src="images/quirkylogo.JPG" width="400px" style="margin-bottom:-30px;" alt="logo">
</div>
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
if (isset($_POST['register_submit'])) {

    $message = [];  // Initialize an array to store error messages

    // Validate that all fields are filled
    $required_fields = ['name', 'address', 'phone_number', 'email', 'pass', 'cpass'];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $message[] = ucfirst($field) . ' is required.';
        }
    }

    if (empty($message)) {  // If no empty fields
        // Sanitize and escape user input
        $name = mysqli_real_escape_string($conn, filter_var($_POST['name'], FILTER_SANITIZE_STRING));
        $address = mysqli_real_escape_string($conn, filter_var($_POST['address'], FILTER_SANITIZE_STRING));
        $phone_number = mysqli_real_escape_string($conn, filter_var($_POST['phone_number'], FILTER_SANITIZE_STRING));
        $email = mysqli_real_escape_string($conn, filter_var($_POST['email'], FILTER_SANITIZE_STRING));
        $pass = mysqli_real_escape_string($conn, md5(filter_var($_POST['pass'], FILTER_SANITIZE_STRING)));
        $cpass = mysqli_real_escape_string($conn, md5(filter_var($_POST['cpass'], FILTER_SANITIZE_STRING)));

        // Check if the user already exists
        $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

        if (mysqli_num_rows($select_users) > 0) {
            $message[] = 'User already exists!';
        } else {
            // Check if passwords match
            if ($pass != $cpass) {
                $message[] = 'Confirm password not matched!';
            } else {
                $stmt = mysqli_prepare($conn, "INSERT INTO `users` (name, address, phone_number, email, password) VALUES (?, ?, ?, ?, ?)");
                mysqli_stmt_bind_param($stmt, "sssss", $name, $address, $phone_number, $email, $pass);

                if (mysqli_stmt_execute($stmt)) {
                    $message[] = 'Registered successfully!';
                    header('location: login.php');
                } else {
                    $message[] = 'Registration failed. Please try again.';
                }

                mysqli_stmt_close($stmt);
            }
        }
    }
}

?>
          <form method="post" action="" class="sign-up-form">
            <input type="hidden" name="csrf_token" value="your_csrf_token_here">
            <h2 class="title">Sign up</h2>
            <?php
    if (!empty($message)) {
        echo '<div class="error-messages">';
        foreach ($message as $error) {
            echo '<div class="message"><span>' . $error . '</span><i class="fas fa-times" onclick="this.parentElement.remove();"></i></div>';
        }
        echo '</div>';
    }
    ?>

            <div class="input-field">
              <i class="fas fa-envelope"></i>
              <input type="text" name="email" placeholder="Email Address">
            </div>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" name="name" placeholder="Full Name">
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