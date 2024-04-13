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

// Adding products to Database 
if(isset($_POST['add_product'])){
    $product_name = $_POST['name'];
    $product_price = $_POST['price'];
    $product_details = $_POST['details'];
    $image = $_FILES['image']['name'];  // For submiting Image.
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'img/'.$image;

    // Prepare a statement to check if the product name already exists
    $select_product_name = $conn->prepare("SELECT * FROM `products` WHERE name = :product_name");
    $select_product_name->bindParam(':product_name', $product_name);
    $select_product_name->execute();

    // Check if the product name already exists
    if($select_product_name->rowCount() > 0){
        $errors[] = "Product name already exists";
    } else {
        // Prepare the insert statement
        $stmt = $conn->prepare("INSERT INTO `products` (name, price, product_details, image) VALUES (:name, :price, :product_details, :image)");
        $stmt->bindParam(':name', $product_name);
        $stmt->bindParam(':price', $product_price);
        $stmt->bindParam(':product_details', $product_details);
        $stmt->bindParam(':image', $image);

        // Check if the statement is prepared successfully
        if($stmt){
            if($image_size > 2000000){
                $errors[] = "File is too Large";
            } else {
                // Move the uploaded file to the designated folder
                move_uploaded_file($image_tmp_name, $image_folder);

                // Execute the insert statement
                $stmt->execute();
                $errors[] = "Product Added Successfully";
            }
        }
    }
}

// Deleting products from Database 

if(isset($_GET['delete'])){
        $delete_id = $_GET['delete'];
    // Prepare the statement to select the image filename
        $select_delete_id = $conn->prepare("SELECT image FROM `products` WHERE id = :delete_id");
        $select_delete_id->bindParam(':delete_id', $delete_id);
        $select_delete_id->execute();
     // Fetch the result
    $fetch_image_img = $select_delete_id->fetch(PDO::FETCH_ASSOC);
    if($fetch_image_img) {
        // Delete the image file from the directory
        unlink('img/' . $fetch_image_img['image']);

        $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = :delete_id");
        $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE id = :delete_id");
        $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE id = :delete_id");

         // Bind and execute the delete statements
         $delete_product->bindParam(':delete_id', $delete_id);
         $delete_product->execute();
         
         $delete_wishlist->bindParam(':delete_id', $delete_id);
         $delete_wishlist->execute();
         
         $delete_cart->bindParam(':delete_id', $delete_id);
         $delete_cart->execute();

        header('location:admin_product.php');
    } else {
        // Handle if the product doesn't exist or there was an error fetching the image
        echo "Error: Product not found or unable to fetch image";
    }
} 

// updated product 
if(isset($_GET['update_product'])){
    $update_id = $_POST['update_id'];
    
    $update_name = $_POST['update_name'];
    $update_price = $_POST['update_price'];
    $update_detail = $_POST['update_detail'];
    $update_image = $_FILES['update_image']['name'];
    $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    $update_image_folder = 'img/' .$update_image;

    $update_query = $conn->prepare("UPDATE `products` SET name = :update_name, price = :update_price, product_details = :update_detail, image = :update_image WHERE id = :update_id");
    // Bind parameters
    $update_query->bindParam(':update_id', $update_id);
    $update_query->bindParam(':update_name', $update_name);
    $update_query->bindParam(':update_price', $update_price);
    $update_query->bindParam(':update_detail', $update_detail);
    $update_query->bindParam(':update_image', $update_image);
    $update_query_all = $update_query->execute();

    if($update_query_all){
        // Check if the file was uploaded successfully before moving it
        if(move_uploaded_file($update_image_tmp_name, $update_image_folder)){
            header('location:admin_product.php');
            exit(); // Exit to prevent further execution
        } else {
            $errors[] = "Error: Failed to move uploaded file";
        }
    } else {
        $errors[] = "Error: Failed to update product";
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

<div class="line2"></div>
<section class="add-products form-control" >
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
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="input-field">
            <label >Product Name</label>
            <input type="text" name="name" required>
        </div>
        <div class="input-field">
            <label >Product Price</label>
            <input type="text" name="price" required>
        </div>
        <div class="input-field">
            <label >Product Details</label>
            <textarea  name="details" required></textarea>
        </div>
        <div class="input-field">
            <label >Product Image</label>
            <input type="file" name="image" accept="image/jpg, image/jpeg, image/png image/webp" required>
        </div>
        <input type="submit" name="add_product" value="Add Product" class="btn">
    </form>
</section>
<div class="line3"></div>
        <div class="line4"></div>
        <section class="show-products">
            <div class="box-container">
            <?php 
                $select_products = $conn->prepare("SELECT * FROM `products`");
                $select_products->execute();
                $results = $select_products->fetchAll(PDO::FETCH_ASSOC);

                // Loop through each product in the result set
                foreach($results as $result) {
                ?>
                    <div class="box">
                        <img src="img/<?php echo $result['image'] ?>">
                        <p>Price: $<?php echo $result['price'] ?></p>
                        <h4><?php echo $result['name'] ?></h4>
                        <details><?php echo $result['product_details'] ?></details>
                        <a href="admin_product.php?edit=<?php echo $result['id']; ?>" class="edit">edit</a>
                        <a href="admin_product.php?delete=<?php echo $result['id']; ?>" class="delete"
                         onclick="return confirm('want to delete this product');">delete</a>
                    </div>
                <?php 
                }
                ?>             
            </div>

        </section>

<section class="update-container">
    <?php
    if(isset($_GET['edit'])){
        $edit_id = $_GET['edit'];

   $edit_query = $conn->prepare("SELECT * FROM `products` WHERE id = :edit_id");
   $edit_query->bindParam(':edit_id', $edit_id);   
   $edit_query->execute();
   if($edit_query->rowCount() > 0){
       $fetch_edit = $edit_query->fetch(PDO::FETCH_ASSOC);
    ?>

    <form method="POST" enctype="multipart/form-data">
        <img src="img/<?php echo $fetch_edit['image'];?>">
        <input type="hidden" name="update_id" value="<?php echo $fetch_edit['id'] ?>">
        <input type="text" name="update_name" value="<?php echo $fetch_edit['name'] ?>">
        <input type="number" name="update_price" min="0" value="<?php echo $fetch_edit['price'] ?>">
        <textarea name="update_detail"><?php echo $fetch_edit['product_details'] ?></textarea>
        <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png image/webp">
        <input type="submit" name="update_product" value="updated" class='edit'>
        <input type="reset" name="" value="cancel" class="option-btn btn" id="close-form">
    </form>

    <?php 
        }
        echo "<script>document.querySelector('.update-container').style.display = 'block'</script>";
    }
    
    ?>

 


        
</section>







    


 
<script type="text/javascript" src="script.js"></script>
</body>
</html>