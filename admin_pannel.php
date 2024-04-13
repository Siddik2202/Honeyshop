<?php
include 'connection.php';
session_start();

$admin_id = $_SESSION['admin_name'];
if(!isset($admin_id)){
    header('location: login.php');
    exit;
}
if(isset($_POST['logout'])){
    session_destroy();
    header('location: login.php');
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin pannel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
     <link rel="stylesheet" href="style.css">

</head>
<body>

<?php include 'admin_header.php' ?>
<div class="line4"></div>
    <section class="dashboard">
        <div class="box-container">
            <div class="box">

                <?php 
                $total_pendings = 0;
                $select_pending = $conn->prepare("SELECT * FROM `order` WHERE payment_status = 'pending'");
                $select_pending->execute();
                $pending_orders = $select_pending->fetchAll(PDO::FETCH_ASSOC);
                foreach($pending_orders as $fetch_pending){
                    $total_pendings +=  $fetch_pending['total_price'];
                }        
                ?>
                <h3> $<?php echo $total_pendings; ?>/-</h3>
                <p>Total pendings</p>
            </div>

            <div class="box">
                <?php 
                $total_completes = 0;
                $select_completes = $conn->prepare("SELECT * FROM `order` WHERE payment_status = 'complete'");
                $select_completes->execute();
                $completes_orders = $select_completes->fetchAll(PDO::FETCH_ASSOC);
                foreach($completes_orders as $fetch_completes){
                    $total_completes +=  $fetch_completes['total_price'];
                }        
                ?>
                <h3> $<?php echo $total_completes; ?>/-</h3>
                <p>Total complete</p>
            </div>

            <div class="box">
                <?php 
                 $select_orders = $conn->prepare("SELECT COUNT(*) AS num_of_orders FROM `order`");
                 $select_orders->execute();
                 $result = $select_orders->fetch(PDO::FETCH_ASSOC);
                 $num_of_orders = $result['num_of_orders'];
                 ?>
                 <h3><?php echo $num_of_orders; ?></h3>
                <p>Order Placed</p>
             </div>

             <div class="box">
                <?php 
                $select_products = $conn->prepare("SELECT COUNT(*) AS num_of_products FROM `products`");
                $select_products->execute();
                $result = $select_products->fetchAll(PDO::FETCH_ASSOC);
                $num_of_products = $result[0]['num_of_products'];
                ?>
                <h3> <?php echo $num_of_products;  ?> </h3>
                <p>Product Added</p>
             </div>
            
             <!-- For user and admin from users table -->
             <div class="box">
                <?php 
                $select_user = $conn->prepare("SELECT COUNT(*) AS num_of_user FROM `users` WHERE user_type='user' ");
                $select_user->execute();
                $result = $select_user->fetchAll(PDO::FETCH_ASSOC);
                $num_of_user =   $result[0]['num_of_user']; // Access the count value using index [0]
                ?>
                <h3>
                    <?php  echo $num_of_user ?> 
                </h3>
                <p>Total Normal User </p>
             </div>

             <div class="box">
                <?php 
                $select_admin = $conn->prepare("SELECT COUNT(*) AS num_of_admin FROM `users` WHERE user_type='admin' ");
                $select_admin->execute();
                $result = $select_admin->fetchAll(PDO::FETCH_ASSOC);
                $num_of_admin =   $result[0]['num_of_admin'];
                ?>
                <h3>
                    <?php echo $num_of_admin ?> 
                </h3>
                <p>Total Admin </p>
             </div>

             <div class="box">
             <?php 
                $select_register = $conn->prepare("SELECT COUNT(*) AS total_user FROM `users`");
                $select_register->execute();  
                $result = $select_register->fetchAll(PDO::FETCH_ASSOC);
                $total_user = $result[0]['total_user'];
                ?>
            <h3><?php echo $total_user ?></h3>
                <p>Total Registered User </p>
             </div>


             <div class="box">
                <?php 
                $select_message = $conn->prepare("SELECT COUNT(*) AS total_new_message FROM `message` ");
                $select_message->execute();
                $result = $select_message->fetchAll(PDO::FETCH_ASSOC);
                $total_new_message = $result[0]['total_new_message'];
                ?>
                <h3>  <?php echo $total_new_message ?>  </h3>
                <p>New Messages </p>
             </div>
            

        </div>
    </section>


 
<script type="text/javascript" src="script.js"></script>
</body>
</html>

 