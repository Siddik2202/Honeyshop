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
    <!-- This is for home slider -->
    <div class="container-fluid">
        <div class="hero-slider">

            <div class="slider-item">
                <img src="img/banner5.jpg">
                <div class="slider-caption">
                    <span>Test the quality.</span>
                    <h1>Organic Premium <br>Honey </h1>
                    <p>Organic sweet, aromatic honey made by hardworking people of <br> 
                    ecologically clean raw materials in the most pure environment!</p>
                    <a href="shop.php" class="btn">shop now</a>
                </div>
            </div>

            <div class="slider-item">
            <img src="img/banner5.jpg">
                <div class="slider-caption">
                    <span>Test the quality & quantity.</span>
                    <h1>Organic Testy <br> Honey </h1>
                    <p>Organic sweet, aromatic honey made by hardworking people of <br> 
                    ecologically clean raw materials in the most pure environment!</p>
                    <a href="shop.php" class="btn">shop now</a>
                </div>
            </div>

        </div>
        <div class="controls">
            <i class="bi bi-chevron-left prev"></i>
            <i class="bi bi-chevron-right next"></i>
        </div>
    </div>

     <div class="services">
        <div class="row">
            <div class="box">
                <img src="img/box4.png" alt="">
                <div>
                    <h1>Free Shipping Fast</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus enim sequi quia quod dolorem veniam.</p>
                </div>
            </div>
            <div class="box">
                <img src="img/box2.png" alt="">
                <div>
                    <h1>Money Back & Guarantee</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus enim sequi quia quod dolorem veniam.</p>
                </div>
            </div>
            <div class="box">
                <img src="img/box3.avif" alt="">
                <div>
                    <h1>Online Support 24/7</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus enim sequi quia quod dolorem veniam.</p>
                </div>
            </div>
            <div class="box">
                <img src="img/box5.jpeg" alt="">
                <div>
                    <h1> 90% Satisfaction Guarantees</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus enim sequi quia quod dolorem veniam.</p>
                </div>
            </div>
        </div>
    </div>

     <div class="story">
        <div class="row">
            <div class="box">
                <span>Our Story</span>
                <h1>Prodcution of natural honey since 1990</h1>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Tenetur magnam corporis ea odio accusamus 
                    dignissimos quisquam perspiciatis, itaque, sunt voluptas iste placeat quaerat aliquam, eaque ullam. 
                    Debitis placeat, doloribus odio recusandae, sit animi pariatur voluptate ea tempora dolore aliquam 
                    eius dolorum mollitia labore dicta voluptatem consequuntur quo harum facere quasi!</p>
                    <a href="shop.php" class="btn">shop now</a>
            </div>
            <div class="box">
                <img src="img/photo4.jpg">
            </div>
        </div>
    </div>
     <!-- testimonial -->

     <div class="testimonial-fluid">
        <h1 class="title">What our customer Say's</h1>
        <div class="testimonial-slider">

            <div class="testimonial-item">
                <img src="img/photo5.jpg" alt="">
                <div class="testimonial-caption">
                    <span>Test The Quality</span>
                    <h1>Organic Premium Honey</h1>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam, eum magnam cupiditate sunt aliquid in? 
                        Enim doloremque veniam nulla impedit eligendi. Culpa minima nesciunt est voluptatem voluptatibus facilis
                        quisquam inventore, voluptatum natus, laboriosam ipsum voluptas? Sapiente vitae tempore, dolores excepturi
                        recusandae fugiat aperiam, doloribus assumenda est odio porro minima quo a laudantium reiciendis illum at 
                        aliquam consequuntur necessitatibus.</p>
                </div>
            </div>

            <div class="testimonial-item">
                <img src="img/photo5.jpg " alt="">
                <div class="testimonial-caption">
                    <span>Test The Quality</span>
                    <h1>Organic Premium Honey</h1>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam, eum magnam cupiditate sunt aliquid in? 
                        Enim doloremque veniam nulla impedit eligendi. Culpa minima nesciunt est voluptatem voluptatibus facilis
                        quisquam inventore, voluptatum natus, laboriosam ipsum voluptas? Sapiente vitae tempore, dolores excepturi
                        recusandae fugiat aperiam, doloribus assumenda est odio porro minima quo a laudantium reiciendis illum at 
                        aliquam consequuntur necessitatibus.</p>
                </div>
            </div>

            <div class="testimonial-item">
                <img src="img/photo5.jpg" alt="">
                <div class="testimonial-caption">
                    <span>Test The Quality</span>
                    <h1>Organic Premium Honey</h1>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam, eum magnam cupiditate sunt aliquid in? 
                        Enim doloremque veniam nulla impedit eligendi. Culpa minima nesciunt est voluptatem voluptatibus facilis
                        quisquam inventore, voluptatum natus, laboriosam ipsum voluptas? Sapiente vitae tempore, dolores excepturi
                        recusandae fugiat aperiam, doloribus assumenda est odio porro minima quo a laudantium reiciendis illum at 
                        aliquam consequuntur necessitatibus.</p>
                </div>
            </div>

        </div>

        <div class="controls">
            <i class="bi bi-chevron-left prev1"></i>
            <i class="bi bi-chevron-right next1"></i>
        </div>
    </div>



    <div class="discover">
        <div class="detail">
            <h1 class="title">Organic Honey Be Healthy</h1>
            <span>Buy Now And Save 30% off!</span>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum voluptate cumque magnam 
                vitae deleniti illum ipsam natus corporis mollitia molestiae animi architecto, repellat,
                 eaque aspernatur a autem! Quasi id, modi quis esse impedit numquam consectetur corporis 
                 fugiat nihil perferendis delectus perspiciatis nobis quibusdam, 
                dolorum voluptatum facere neque dolorem quos voluptas.</p>

                <a href="shop.php" class="btn">Discover Now</a>
        </div>
        <div class="img-box">
            <img src="img/honey10.jpg">
        </div>
    </div>
 
      
    <!-- This is for footer -->
    <?php include 'homeshop.php'; ?>
    <?php include 'footer.php'; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
     <script type="text/javascript" src="script2.js"></script>

</body>
</html>

