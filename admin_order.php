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

  

// Deleting products from Database 

if(isset($_GET['delete'])){
        $delete_id = $_GET['delete'];
    // Prepare the statement to select the image filename
        $select_delete_id = $conn->prepare("DELETE FROM `order` WHERE id = :delete_id");
        $select_delete_id->bindParam(':delete_id', $delete_id);
        $select_delete_id->execute();   
        
        $errors[] = "user remove type";
        header('location:admin_order.php');
    } 
    
    
    // updating payment status 
    if(isset($_POST['update_payment'])){
        $order_id = $_POST['order_id'];
        $update_payment = $_POST['update_payment'];

        $update_query = $conn->prepare("UPDATE `order` SET payment_status = :update_payment WHERE id = :order_id");
        $update_query->bindParam(':order_id', $order_id);
        $update_query->bindParam(':update_payment', $update_payment);
        $update_query->execute();

        if($update_query) {
            // Query executed successfully
            $errors[] = "Payment status updated successfully.";
        } else {
            // Error occurred
            $errors[] = "Error updating payment status: " . $conn->errorInfo();
        }
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
<section class="order-container"> 
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




    <h1 class="title">Total Order Placed</h1>
    <div class="box-container">
        <?php
         $select_order = $conn->prepare("SELECT * FROM `order`");
         $select_order->execute();
         $results = $select_order->fetchAll(PDO::FETCH_ASSOC);
         if($select_order->rowCount() > 0){
         foreach($results as $result) {
        ?>

        <div class="box">
        <p>User Id: <span><?php echo $result['user_id'] ?></span></p>
        <p>User Name: <span><?php echo $result['name'] ?></span></p>
        <p>Number : <span><?php echo $result['number'] ?></span></p>
        <p>Email : <span><?php echo $result['email'] ?></span></p>
        <p>Total price : <span><?php echo $result['total_price'] ?></span></p>
        <p>Placed on: <span><?php echo  $result['placed_on'] ?></span></p>
        <p>Method: <span><?php echo  $result['method'] ?></span></p>
        <p>Address: <span><?php echo  $result['address'] ?></span></p>
        <p>Total products: <span><?php echo  $result['total_products'] ?></span></p>
        <form method="POST">
            <input type="hidden" name="order_id" value="<?php echo $result['id']; ?>">
            <select name="update_payment">
            <option disabled selected><?php echo $result['payment_status']; ?></option>
            <option value="pending">Pending</option>
            <option value="complete">Complete</option>
            </select>
            <input type="submit" name="update_order" value="Update Payment" class="btn">
            <a href="admin_order.php?delete=<?php echo $result['id'] ?>;" onclick="return confirm('Delete this message.');" class="delete" >delete</a>
        </form>
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
</section>
<div class="line"></div> 


 
<script type="text/javascript" src="script.js"></script>
</body>
</html>