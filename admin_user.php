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
        $select_delete_id = $conn->prepare("DELETE FROM `users` WHERE id = :delete_id");
        $select_delete_id->bindParam(':delete_id', $delete_id);
        $select_delete_id->execute();   
        
        $errors[] = "user remove type";
        header('location:admin_user.php');
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
<div class="line2"></div>
<section class="message-container"> 
    <h1 class="title">Total User Account</h1>
    <div class="box-container">
        <?php
         $select_user = $conn->prepare("SELECT * FROM `users`");
         $select_user->execute();
         $results = $select_user->fetchAll(PDO::FETCH_ASSOC);
         if($select_user->rowCount() > 0){
         foreach($results as $result) {
        ?>

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

        <div class="box">
            <p>User Id: <span><?php echo $result['id'] ?></span></p>
            <p>Name: <span><?php echo $result['name'] ?></span></p>
            <p>Email: <span><?php echo  $result['email'] ?></span></p>
            <p>User Type: <span style="color: <?php if($result['user_type'] == 'admin' ) { echo 'orange';}; ?>"><?php echo $result['user_type'] ?></span></p>
            <a href="admin_user.php?delete=<?php echo $result['id'] ?>;" onclick="return confirm('Delete this message.');" class="delete" >delete</a>
         </div>

        <?php      
    }
 } else{
            echo ' <div class="epmty">  
            <p>No products added yet. </p>
            </div> ';

 }
    


        ?>




    </div>
</section>
<div class="line"></div> 


 
<script type="text/javascript" src="script.js"></script>
</body>
</html>