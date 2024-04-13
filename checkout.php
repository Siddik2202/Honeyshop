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


// Insert order details 
if(isset($_POST['order-btn'])){
    $name = $_POST['name'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $method = $_POST['method'];
    $address = $_POST['flat'] . ',' . $_POST['city'] . ',' . $_POST['state'] . ',' . $_POST['country'] . ',' . $_POST['pincode'];
    $placed_on = date('D-M-Y');


    $cart_total = 0;
    $cart_product[] ='';
    $cart_query = $conn->prepare("SELECT * FROM `cart` WHERE user_id = '$user_id'");
    $cart_query->execute();
    $results = $cart_query->fetchAll(PDO::FETCH_ASSOC);
    if ($cart_query->rowCount() > 0) {
        foreach ($results as $result) {
            
                $cart_product[] = $result['name']. '('. $result['quantity'].')';
                $sub_total =  $result['price'] *  $result['quantity'];
                $cart_total += $sub_total ;

            }
        }
        $total_product = implode(', ',$cart_product);
        $stmt = $conn->prepare("INSERT INTO `order` (user_id,name,number,email,method,address,total_products,total_price,placed_on) 
        VALUES (:user_id,:name,:number,:email,:method,:address,:total_products,:total_price,:placed_on)");
        $stmt->bindParam(':user_id',$user_id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':number', $number);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':method', $method);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':total_products', $total_product);
        $stmt->bindParam(':total_price', $cart_total);
        $stmt->bindParam(':placed_on', $placed_on);
        $stmt->execute();

        $stmts = $conn->prepare("DELETE FROM `cart` WHERE user_id = '$user_id' ");
        $stmts->execute();
        header('location:checkout.php');





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
        <h1>Order Now !</h1>
        <p>Hello Mr.Abu Bakkar Siddik, dolor sit amet consectetur adipisicing elit. Quas commodi odio beatae quo esse veniam placeat,
            deserunt porro est obcaecati culpa nulla, distinctio aliquam corporis. </p>
        
        <a href="index.php">home </a><span>/ checkout</span>
    </div>
</div>

<div class="checkout-form">
    <h1 class="title">payment process</h1>
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
    <div class="display-order">
        <div class="box-container">
            <?php 
                $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = '$user_id'");
                $select_cart->execute();
                $total = 0;
                $grand_total = 0;
            
            ?>
        
                <?php if ($select_cart->rowCount() > 0): ?>
                    <?php foreach ($select_cart as $result):
                        $total_price = ($result['price'] * $result['quantity']);
                        $grand_total = $total +=$total_price;
                         ?>
                        <div class="box">
                            <img src="img/<?php echo $result['image']; ?>">
                            <span><?= $result['name']; ?> (<?= $result['quantity']; ?>)</span>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            
        </div>
            <span class="grand-total">Total Amount Payable: $ <?=$grand_total; ?></span>
    </div>
    <form method="post">
        <div class="input-field">
            <label>your name</label>
            <input type="text" name="name" placeholder="enter your name" >
        </div>
        <div class="input-field">
            <label>your number</label>
            <input type="number" name="number" placeholder="enter your number" >
        </div>
        <div class="input-field">
            <label>your email</label>
            <input type="text" name="email" placeholder="enter your email" >
        </div>
        <div class="input-field">
            <label>select payment method</label>
            <select name="method">
                <option selected disabled>select payment method</option>
                <option value="cash on delivery">cash on delivery</option>
                <option value="cradit card">cradit card</option>
                <option value="paytm">paytm</option>
                <option value="paypal">paypal</option>
                <option value="Gpay">gpay</option>
            </select>
         </div>
        
        <div class="input-field">
            <label>Address</label>
            <input type="text" name="flat" placeholder="enter your address" >
        </div>
        <div class="input-field">
            <label>City</label>
            <input type="text" name="city" placeholder="enter your city" >
        </div>
        <div class="input-field">
            <label>State</label>
            <input type="text" name="state" placeholder="enter your state" >
        </div>
        <div class="input-field">
            <label>Country</label>
            <input type="text" name="country" placeholder="enter your country" >
        </div>
        <div class="input-field">
            <label>Pin Coe</label>
            <input type="text" name="pincode" placeholder="enter your pin" >
        </div>
         <input type="submit" name="order-btn" class="btn" value="Order Now">
    </form>

</div>
  
    <div class="line3"></div>
    <?php include 'footer.php'; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <script type="text/javascript" src="script.js"></script>
    

</body>
</html>

