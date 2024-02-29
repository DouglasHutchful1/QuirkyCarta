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

<header class="header">

    <div class="flex">

    <a href="home.php" class="logo"><img src="./img/quirkylogo.JPG" width="130px"  alt="quirky"></a>

        <nav class="navbar" style="margin-left:auto;">
        <ul>
                <li><a href="home.php">home</a></li>
                <li><a href="store.php">Categories</a>
                    <ul>
                        <li><a href="fabrics.php">Ghana Kaftan</a></li>
                        <li><a href="shoes.php">Shoes</a></li>
                        <li><a href="clothes.php">Clothes</a></li>
                        <li><a href="fabrics.php">Fabrics</a></li>


                    </ul>
                </li>
                <li><a href="orders.php">orders</a></li>
                <li><a href="about.php">about us</a></li>
                <li><a href="contact.php">contact</a></li>
               
            </ul>
        </nav>

        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="search_page.php" class="fas fa-search"></a>
            <div id="user-btn" class="fas fa-user"></div>
            <?php
                $select_wishlist_count = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE user_id = '$user_id'") or die('query failed');
                $wishlist_num_rows = mysqli_num_rows($select_wishlist_count);
            ?>
            <a href="wishl.php"><i class="fas fa-heart"></i><span>(<?php echo $wishlist_num_rows; ?>)</span></a>
            <?php
                $select_cart_count = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
                $cart_num_rows = mysqli_num_rows($select_cart_count);
            ?>
            <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?php echo $cart_num_rows; ?>)</span></a>
        </div>

        <div class="account-box">
            <p>Fullname: <span><?php echo $_SESSION['user_name']; ?></span></p>
            <p>Email Address: <span><?php echo $_SESSION['user_email']; ?></span></p>
            <a href="logout.php" class="delete-btn">logout</a>
        </div>

    </div>

</header>