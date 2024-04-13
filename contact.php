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

if(isset($_POST['submit-btn'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $message = $_POST['message'];

    $check = $conn->prepare("SELECT * FROM `message` WHERE email = '$email' AND number = '$number' ");
    $check->execute();
    $check_exist = $check->rowCount(); 


    if($check_exist > 0){  
        $errors[] = 'Message alrady sent';
    } else {
        $stmt = $conn->prepare("INSERT INTO `message` (user_id,name,email,number,message) VALUES (:user_id, :name, :email, :number, :message) ");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':number', $number);
        $stmt->bindParam(':message', $message);
        $stmt->execute();
        
        $errors[] = 'Message sent Successfully. ';
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
        <h1>Contact with Us!</h1>
        <p>Hello Mr.Abu Bakkar Siddik, dolor sit amet consectetur adipisicing elit. Quas commodi odio beatae quo esse veniam placeat,
            deserunt porro est obcaecati culpa nulla, distinctio aliquam corporis. </p>
        
        <a href="index.php">home </a><span>/ contact</span>
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

 <div class="form-container">
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
    <h1 class="title">Leave a message</h1>
    <form method="post">
        <div class="input-field">
            <label>your Name</label><br>
            <input type="text" name="name" >
        </div>
        <div class="input-field">
            <label>your Email</label><br>
            <input type="text" name="email" >
        </div>
        <div class="input-field">
            <label>Number</label><br>
            <input type="number" name="number" >
        </div>
        <div class="input-field">
            <label>Your Message</label><br>
            <textarea type="text" name="message" ></textarea>
        </div>
        <button type="submit" name="submit-btn">Send Message</button>
    </form>
</div>


<div class="address">
    <h1 class="title">our contact</h1>
    <div class="row">
        <div class="box">
            <i class="bi bi-map-fill"></i>
            <div>
                <h4>address</h4>
                <p>14323 Kolkata Lane, <br> Solt Lake, West Bengal  </p>
            </div>
        </div>
        <div class="box">
            <i class="bi bi-telephone-fill"></i>
            <div>
                <h4>phone number</h4>
                <p>+91 8944945897</p>
            </div>
        </div>
        <div class="box">
            <i class="bi bi-envelope-fill"></i>
            <div>
                <h4>email</h4>
                <p>absabs2202@gmail.com</p>
            </div>
        </div>
    </div>
</div>
 

 




    <div class="line3"></div>
    <?php include 'footer.php'; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <script type="text/javascript" src="script.js"></script>
    

</body>
</html>

