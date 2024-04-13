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

 

// update qut to cart
if(isset($_POST['update_qty_btn'])){
    $update_qut_id = $_POST['update_qty_id'];
    $update_value = $_POST['update_qty'];

    $update_querry = $conn->prepare("UPDATE `cart` SET quantity = :update_value WHERE id = :update_qut_id ");
    $update_querry->bindParam(':update_value', $update_value);
    $update_querry->bindParam(':update_qut_id', $update_qut_id);
    $update_querry->execute();

    if($update_querry){
        header('location:cart.php');
    }
    

}


// Delete product from wishlist 
if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];

    $delete_wishlist = $conn->prepare("DELETE FROM `cart` WHERE id = :delete_id");
    $delete_wishlist->bindParam(':delete_id', $delete_id);
    $delete_wishlist->execute();

    header('location:cart.php');

}


 // Delete all product from wishlist 
if(isset($_GET['delete_all'])){
    $delete_wishlist = $conn->prepare("DELETE FROM `cart` WHERE user_id = :user_id ");
    $delete_wishlist->bindParam(':user_id', $user_id);
    $delete_wishlist->execute();

    header('location:cart.php');

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
        <h1>my cart</h1>
        <p>Hello Mr.Abu Bakkar Siddik, dolor sit amet consectetur adipisicing elit. Quas commodi odio beatae quo esse veniam placeat,
            deserunt porro est obcaecati culpa nulla, distinctio aliquam corporis. Ut aliquid, iste porro voluptatum qui ducimus rem at. Nam.</p>
        
        <a href="index.php">home </a><span>/ cart</span>
    </div>
</div>
<!-- <div class="line2"></div> -->

<section class="shop">
    <h1 class="title">products added in cart </h1>
 
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

<div class="box-container">
        <?php
        $grand_total = 0;
        $select_cart = $conn->prepare("SELECT * FROM `cart`");
        $select_cart->execute();
        $results = $select_cart->fetchAll(PDO::FETCH_ASSOC);
        if($select_cart->rowCount() > 0){
            foreach($results as $result) {
        
        ?>
        <div class="box">
        <div class="icon">
                <a href="view_page.php?pid=<?php echo $result['id']; ?>" class="bi bi-eye-fill"></a>
                <a href="cart.php?delete=<?php echo $result['id']  ?>"  class="bi bi-x" onclick="return confirm('do you want to delete items in your wishlist')" ></a>
                 <button type="submit" name="add_to_cart" class="bi bi-cart"></button>
            </div>
            <img src="img/<?php echo $result['image']; ?>">
            <div class="price">$<?php echo $result['price']; ?></div>
            <div class="name"><?php echo $result['name']; ?></div>
            <form method="post">
                <input type="hidden" name="update_qty_id" value="<?php echo $result['id']; ?>">
                <div class="qty">
                    <input type="number" min="1" name="update_qty" value="<?php echo $result['quantity'];?>" >
                    <input type="submit" name="update_qty_btn" value="update">

                </div>
            </form>
            <div class="total-amt">
                Total Amount : <span><?php echo $total_amt =($result['price'] * $result['quantity']) ?></span>
            </div>
        </div>



        <?php 
            
            $grand_total += $total_amt;

            }
        }else {
            echo '<p class="epmty">no products yet!</p> ';
        }
        ?>
</div>

<div class="dlt">
<a href="cart.php?delete_all" class="btn2" onclick="return confirm('Do you want to delete all items in your wishlist')">Delete All</a>

</div>

<div class="wishlist-total">
        <p>total amount payable : <span>$<?php echo $grand_total ?></span></p>
        <a href="shop.php" class="btn">continue shoping</a>
        <a href="checkout.php" class="btn <?php echo ($grand_total>1)?'':'disabled'?>"
         onclick="return confirm('Proceed to Buy')">Proceed to Checkout</a>
</div>
 
</section>
 

    <div class="line3"></div>
    <?php include 'footer.php'; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <script type="text/javascript" src="script.js"></script>
    

</body>
</html>

