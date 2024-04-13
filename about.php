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

 </head>
<body>

    <!-- This is for header -->
    <?php include 'header.php'; ?>

<div class="banner">
    <div class="detail">
        <h1>About Us! </h1>
        <p>Hello Mr.Abu Bakkar Siddik, dolor sit amet consectetur adipisicing elit. Quas commodi odio beatae quo esse veniam placeat,
            deserunt porro est obcaecati culpa nulla, distinctio aliquam corporis. Ut aliquid, iste porro voluptatum qui ducimus rem at. Nam.</p>
        
        <a href="index.php">home</a><span>/ about us</span>
    </div>
</div>
<!-- <div class="line2"></div> -->

<div class="about-us"></div>
    <div class="row rows">
        <div class="box">
            <div class="title">
                <span>ABOUT OUR ONLINE STORE</span>
                <h1>Hello, with 20 years of experience. </h1>
            </div>
            <p>Over 20 years Ecommerce helping companies reach their financial and branding goals.
                 Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ut fugit maiores doloribus veniam,
                  est amet placeat ducimus voluptates beatae, corporis eveniet et. 
                Voluptas harum, ipsam asperiores dolorem aliquam ex qui.</p>
        </div>
        <div class="img-box">
            <img src="img/about.jpg" alt="">
        </div>
    </div>
</div>

    <div class="line3"></div>
    <!-- features  -->

    <div class="features">
        <div class="title">
            <h1>Complete Customer Ideas</h1>
            <span>Best Features</span>
        </div>
        <div class="row">
            <div class="box">
                <img src="img/cart1.jpg" alt="">
                <h4>24 * 7</h4>
                <p>Online Support 24/7</p>
            </div>
            <div class="box">
                <img src="img/cart2.webp" alt="">
                <h4>Money Back Gurantee</h4>
                <p>100% Secure Payment</p>
            </div>
            <div class="box">
                <img src="img/cart4.jpg" alt="">
                <h4>Special Gift Card</h4>
                <p>Give the Perfect Gift</p>
            </div>
            <div class="box">
                <img src="img/image5.jpeg" alt="">
                <h4>Worldwide Shipping</h4>
                <p>On Order Over $99</p>
            </div>
        </div>
    </div>

    <!-- team section -->
    <div class="team">
        <div class="title">
            <h1>Our Workable Team</h1>
            <span>Best collection make best team</span>
        </div>
        <div class="row">
            <div class="box">
                <div class="img-box">
                    <img src="img/man1.avif" alt="">
                </div>
                <div class="detail">
                        <spna>Finance Manager</spna>
                        <h4>Manas Bagla </h4>
                        <div class="icons">
                            <i class="bi bi-instagram"></i>
                            <i class="bi bi-youtube"></i>
                            <i class="bi bi-twitter"></i>
                            <i class="bi bi-behance"></i>
                            <i class="bi bi-whatsapp"></i>
                        </div>
                 </div>
            </div>
            <div class="box">
                <div class="img-box">
                    <img src="img/women1.webp" alt="">
                </div>
                <div class="detail">
                        <spna>Developing Manager</spna>
                        <h4>Prabhpreet Kaur </h4>
                        <div class="icons">
                            <i class="bi bi-instagram"></i>
                            <i class="bi bi-youtube"></i>
                            <i class="bi bi-twitter"></i>
                            <i class="bi bi-behance"></i>
                            <i class="bi bi-whatsapp"></i>
                        </div>
                 </div>
            </div>
            <div class="box">
                <div class="img-box">
                    <img src="img/man2.webp" alt="">
                </div>
                <div class="detail">
                        <spna>Cyber Security</spna>
                        <h4>Abu Bakkar Siddik </h4>
                        <div class="icons">
                            <i class="bi bi-instagram"></i>
                            <i class="bi bi-youtube"></i>
                            <i class="bi bi-twitter"></i>
                            <i class="bi bi-behance"></i>
                            <i class="bi bi-whatsapp"></i>
                        </div>
                 </div>
            </div>
            <div class="box">
                <div class="img-box">
                    <img src="img/women2.jpg" alt="">
                </div>
                <div class="detail">
                        <spna>IT Application</spna>
                        <h4>Simran Singh </h4>
                        <div class="icons">
                            <i class="bi bi-instagram"></i>
                            <i class="bi bi-youtube"></i>
                            <i class="bi bi-twitter"></i>
                            <i class="bi bi-behance"></i>
                            <i class="bi bi-whatsapp"></i>
                        </div>
                 </div>
            </div>
            <div class="box">
                <div class="img-box">
                    <img src="img/women3.webp" alt="">
                </div>
                <div class="detail">
                        <spna>Digital Marketer</spna>
                        <h4>Saumaya Verma </h4>
                        <div class="icons">
                            <i class="bi bi-instagram"></i>
                            <i class="bi bi-youtube"></i>
                            <i class="bi bi-twitter"></i>
                            <i class="bi bi-behance"></i>
                            <i class="bi bi-whatsapp"></i>
                        </div>
                 </div>
            </div>

        </div>
    </div>
    <div class="line3"></div>
    <div class="project">
        <div class = "title"> 
            <h1>Our Best Project</h1>
            <span>How it Works</span>
        </div>
        <div class="row">
            <div class="box">
                <img src="img/team3.jpeg" alt="">
            </div>
            <div class="box">
                <img src="img/team2.jpg" alt="">
            </div>
        </div>
    </div>
 <div class="line3"></div>

 <div class="ideas">
    <div class="title">
        <h1>We And Our Clients Are Happy to Cooperate with Our Company</h1>
        <span>our fratures</span>
    </div>
    <div class="row">
        <div class="box">
            <i class="bi bi-stack"></i>
            <div class="detail">
                <h2>What we Really Do</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                     Earum magni ut optio error odit quae consequatur quod consectetur nihil quidem?</p>
            </div>
        </div>
        <div class="box">
            <i class="bi bi-grid-1x2-fill"></i>
            <div class="detail">
                <h2>History of Beginning</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                     Earum magni ut optio error odit quae consequatur quod consectetur nihil quidem?</p>
            </div>
        </div>
        <div class="box">
            <i class="bi bi-tropical-storm"></i>
            <div class="detail">
                <h2>Our Vision</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                     Earum magni ut optio error odit quae consequatur quod consectetur nihil quidem?</p>
            </div>
        </div>
    </div>
 </div>




 <div class="line3"></div>

    <?php include 'footer.php'; ?>
    <script type="text/javascript" src="script.js"></script>

</body>
</html>

