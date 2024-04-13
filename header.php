<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

</head>
<body>

<header class="header">
    <div class="flex">
        <a href="admin_pannel.php" class="logo"><img src="">Honey</a>
        <nav class="navbar">
            <a href="index.php">home</a>
            <a href="about.php">about us</a>
            <a href="shop.php">shop</a>
            <a href="order.php">order</a>
            <a href="contact.php">contact</a>
         </nav>
         <div class="icons">
            <i class="bi bi-person" id="user-btn"></i>
            <!-- For wishlist -->
            <?php 
            $select_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = :user_id");
            $select_wishlist->bindParam(':user_id', $user_id);
            $select_wishlist->execute();
            $wishlist_rows = $select_wishlist->rowCount();
            ?>
            <a href="wishlist.php"><i class="bi bi-heart"><sup><?php echo $wishlist_rows ?></sup></i></a>
            <!-- For cart -->
            <?php 
            $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = :user_id");
            $select_cart->bindParam(':user_id', $user_id);
            $select_cart->execute();
            $cart_rows = $select_cart->rowCount();
            ?>
            <a href="cart.php"><i class="bi bi-cart"><sup><?php echo $cart_rows ?></sup></i></a>
            <i class="bi bi-list" id="menu-btn"></i>
         </div>
         <div class="user-box">
            <p>Username: <span><?php echo $_SESSION['user_name']; ?></span></p>
            <p>Email: <span><?php echo  $_SESSION['user_email']; ?></span></p>
         
            <form method="post">
                <button type="submit" name="logout" class="logout-btn">log out</button>
            </form>

         </div>
    </div>
</header>

 
<!-- <div class="line"></div> -->



    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>