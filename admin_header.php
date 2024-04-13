<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

</head>
<body>

<header class="header">
    <div class="flex">
        <a href="admin_pannel.php" class="logo"><img src="">Honey</a>
        <nav class="navbar">
            <a href="admin_pannel.php">home</a>
            <a href="admin_product.php">products</a>
            <a href="admin_order.php">orders</a>
            <a href="admin_user.php">users</a>
            <a href="admin_message.php">messages</a>
         </nav>
         <div class="icons">
            <i class="bi bi-person" id="user-btn"></i>
            <i class="bi bi-list" id="menu-btn"></i>
         </div>
         <div class="user-box">
            <p>Username: <span><?php echo $_SESSION['admin_name']; ?></span></p>
            <p>Email: <span><?php echo  $_SESSION['admin_email']; ?></span></p>
         
            <form method="post">
                <button type="submit" name="logout" class="logout-btn">log out</button>
            </form>

         </div>
    </div>
</header>

<div class="banner">
    <div class="detail">
        <h1>Admin Dashboard</h1>
        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quas commodi odio beatae quo esse veniam placeat, Ut aliquid, iste porro voluptatum qui ducimus rem at,
            deserunt porro est obcaecati culpa nulla, distinctio aliquam corporis. Ut aliquid, iste porro voluptatum qui ducimus rem at. Nam.</p>
    </div>
</div>
<div class="line3"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>