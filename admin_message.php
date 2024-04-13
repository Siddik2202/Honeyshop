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
        $select_delete_id = $conn->prepare("DELETE FROM `message` WHERE id = :delete_id");
        $select_delete_id->bindParam(':delete_id', $delete_id);
        $select_delete_id->execute();  
        header('location:admin_message.php');
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
<section class="message-container"> 
    <h1 class="title">Unread Message</h1>
    <div class="box-container">
        <?php
         $select_message = $conn->prepare("SELECT * FROM `message`");
         $select_message->execute();
         $results = $select_message->fetchAll(PDO::FETCH_ASSOC);
         if($select_message->rowCount() > 0){
         foreach($results as $result) {
        ?>

        <div class="box">
            <p>User Id: <span><?php echo $result['id'] ?></span></p>
            <p>Name: <span><?php echo $result['name'] ?></span></p>
            <p>Email: <span><?php echo  $result['email'] ?></span></p>
            <p><?php echo $result['message'] ?></p>
            <a href="admin_message.php?delete=<?php echo $result['id'] ?>;" onclick="return confirm('Delete this message.');" class="delete" >delete</a>
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