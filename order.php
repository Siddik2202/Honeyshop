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
        
        <a href="index.php">home </a><span>/ order</span>
    </div>
</div>
 
<div class="order-section">
    <div class="box-container">
        <?php


            $select_query = $conn->prepare("SELECT * FROM `order` ");
            // $select_query = $conn->prepare("SELECT * FROM `order`  WHERE user_id = '$user_id' ");
            // $select_query->bindParam(':user_id', $user_id);
            $select_query->execute();
            $results = $select_query->fetchAll(PDO::FETCH_ASSOC);
                if ($select_query->rowCount() > 0) {
                     foreach ($results as $result) {
        ?>
        <div class="box">
            <p>User Id: <span><?php echo $result['user_id'] ?></span></p>
            <p>Placed on: <span><?php echo $result['placed_on'] ?></span></p>
            <p>User Name: <span><?php echo $result['name'] ?></span></p>
            <p>Number : <span><?php echo $result['number'] ?></span></p>
            <p>Email : <span><?php echo $result['email'] ?></span></p>
            <p>Address: <span><?php echo $result['address'] ?></span></p>
            <p>Payment Method: <span><?php echo $result['method'] ?></span></p>
            <p>Total price : <span><?php echo $result['total_price'] ?></span></p>
            <p>Total products: <span><?php echo $result['total_products'] ?></span></p>
        </div>
<?php
    }
} else{
    echo ' <div class="epmty">  
    <p>No Order Placed yet! </p>
    </div> ';
}
?>

     </div>
</div>

 
  
    <div class="line3"></div>
    <?php include 'footer.php'; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <script type="text/javascript" src="script.js"></script>
    

</body>
</html>

