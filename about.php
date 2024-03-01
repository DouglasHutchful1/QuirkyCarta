<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>About</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php @include 'header.php'; ?>

<section class="heading">
    <h3>about us</h3>
</section>

<section class="about">

   

    <div class="flex">

       

        <div class="image">
            <img src="images/about.jpg" alt="">
        </div>

        <div class="content">
            <h3>What QuirkyCarta Offers</h3>
            <p>QuirkyCarta presents a broad array of products, encompassing clothing, footwear, and various other items. Our collection spans across diverse categories, ensuring there's something for everyone. From stylish apparel and trendy shoes to a variety of miscellaneous items, QuirkyCarta is committed to simplifying the buying and selling experience for individuals worldwide.</p>
            <a href="contact.php" class="btn">contact us</a>
        </div>

    </div>

   

</section>












<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>