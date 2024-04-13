<?php
include 'connection.php';
session_start();

$user_id = $_SESSION['user_name'];
if(!isset($user_id)){
    header('location: login.php');
    exit;
}
if(isset($_POST['logout'])){
    session_destroy();
    header('location: login.php');
    exit;
}

// Adding product to wishlist
if(isset($_POST['add_to_wishlist'])){
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];

    $wishlist_number = $conn->prepare("SELECT * FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id' ");
    $wishlist_number->execute();
    $wishlist_numbers = $wishlist_number->rowCount(); // Fetching row count directly

    if($wishlist_numbers > 0){
        $errors[] = 'Product already exists in wishlist';
    } else {
        $stmt = $conn->prepare("INSERT INTO `wishlist` (user_id,pid,name,price,image) VALUES (:user_id, :pid, :name, :price, :image) ");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':pid', $product_id);
        $stmt->bindParam(':name', $product_name); // Corrected variable name
        $stmt->bindParam(':price', $product_price);
        $stmt->bindParam(':image', $product_image);
        $stmt->execute();
        
        $errors[] = 'Product added to your wishlist';
    }
}

// Adding product to cart

if(isset($_POST['add_to_cart'])){
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_quantity = $_POST['product_quantity'];
    $product_image = $_POST['product_image'];


    $cart_number = $conn->prepare("SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id' ");
    $cart_number->execute();
    $cart_numbers = $cart_number->rowCount(); // Corrected variable name
 
    if($cart_numbers > 0){ // Corrected elseif and variable name
        $errors[] = 'Product already exists in cart';
    } else {
        $stmt = $conn->prepare("INSERT INTO `cart` (user_id,pid,name,price,quantity,image) VALUES (:user_id, :pid, :name, :price, :quantity, :image) ");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':pid', $product_id);
        $stmt->bindParam(':name', $product_name); // Corrected variable name
        $stmt->bindParam(':price', $product_price);
        $stmt->bindParam(':quantity', $product_quantity);
        $stmt->bindParam(':image', $product_image);
        $stmt->execute();
        
        $errors[] = 'Product added to your cart';
    }
}


 





?>
<style type="text/css">
    <?php
        include 'main.css';
    ?>

</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Honeyshop</title>
    <link rel="stylesheet" href="main.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <!-- For slick css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css" integrity="sha512-6lLUdeQ5uheMFbWm3CP271l14RsX1xtx+J5x2yeIDkkiBpeVTNhTqijME7GgRKKi6hCqovwCoBTlRBEC20M8Mg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js" integrity="sha512-HGOnQO9+SP1V92SrtZfjqxxtLmVzqZpjFFekvzZVWoiASSQgSr4cw9Kqd2+l8Llp4Gm0G8GIFJ4ddwZilcdb8A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>


 </head>
<body>

    <!-- This is for header -->
    <?php include 'header.php'; ?>

<div class="banner">
    <div class="detail">
        <h1>Product details</h1>
        <p>Hello Mr.Abu Bakkar Siddik, dolor sit amet consectetur adipisicing elit. Quas commodi odio beatae quo esse veniam placeat,
            deserunt porro est obcaecati culpa nulla, distinctio aliquam corporis. Ut aliquid, iste porro voluptatum qui ducimus rem at. Nam.</p>
        
        <a href="index.php">home </a><span>/ shop / view</span>
    </div>
</div>
<!-- <div class="line2"></div> -->

<section class="view_page">
    <h1 class="title">shop best sellers</h1>
    <?php
    if (!empty($errors)) {
        // Display validation errors
        foreach ($errors as $error) {
            echo ' 
        <div class="message">
        <span>' . $error . '</span>
        <i class="bi bi-x-circle" onclick="this.parentElement.remove()"> </i>
        </div>
        ';
        }
    }
    ?>
         <?php
        if(isset($_GET['pid'])){
            $pid = $_GET['pid'];
            $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = :id");
            $select_products->bindParam(':id', $pid);
            $select_products->execute(); 

            $results = $select_products->fetchAll(PDO::FETCH_ASSOC);
            if($select_products->rowCount() > 0){
                foreach($results as $result) {
     
        }
       
        
        ?>
        <form method="post">
            <img src="img/<?php echo $result['image']; ?>">
            <div class="detail">
                <div class="price">$<?php echo $result['price']; ?></div>
                <div class="name"><?php echo $result['name']; ?></div>
                <div class="detail"><?php echo $result['product_details']; ?></div>
                <input type="hidden" name="product_id" value="<?php  echo $result['id']; ?>">
                <input type="hidden" name="product_name" value="<?php  echo $result['name']; ?>">
                <input type="hidden" name="product_price" value="<?php  echo $result['price']; ?>">
                <input type="hidden" name="product_image" value="<?php  echo $result['image']; ?>">
                    <div class="icon">
                        <button type="submit" name="add_to_wishlist" class="bi bi-heart"></button>
                        <input type="number" name="product_quantity" value="1" min="1" class = "quantity">
                        <button type="submit" name="add_to_cart" class="bi bi-cart"></button>
                    </div>
                    <button type="submit" name="buy_now" class="buy">Buy Now</button>

            </div>
        </form>


        <?php 
            }
        }
            
        
        ?>

</section>






    <div class="line3"></div>
    <?php include 'footer.php'; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <script type="text/javascript" src="script.js"></script>
    

</body>
</html>

