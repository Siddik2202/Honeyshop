<?php 
include 'connection.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home-page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="main.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <!-- For slick css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css" integrity="sha512-6lLUdeQ5uheMFbWm3CP271l14RsX1xtx+J5x2yeIDkkiBpeVTNhTqijME7GgRKKi6hCqovwCoBTlRBEC20M8Mg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js" integrity="sha512-HGOnQO9+SP1V92SrtZfjqxxtLmVzqZpjFFekvzZVWoiASSQgSr4cw9Kqd2+l8Llp4Gm0G8GIFJ4ddwZilcdb8A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

</head>
<body> 

<section class="popular-brands">
    <h2>POPULAR BRANDS</h2>
    <div class="control">
        <i class="bi bi-chevron-left left"></i>
        <i class="bi bi-chevron-right right"></i>
    </div>
    <div class="popular-brands-content">
        <?php
        $select_products = $conn->prepare("SELECT * FROM `products`");
        $select_products->execute();
        $results = $select_products->fetchAll(PDO::FETCH_ASSOC);
        if($select_products->rowCount() > 0){
            foreach($results as $result) {
        
        ?>
        <form method="post" class="card">
            <img src="img/<?php echo $result['image']; ?>">
            <div class="price">$<?php echo $result['price']; ?></div>
            <div class="name"><?php echo $result['name']; ?></div>
            <input type="hidden" name="product_id" value="<?php  echo $result['id']; ?>">
            <input type="hidden" name="product_name" value="<?php  echo $result['name']; ?>">
            <input type="hidden" name="product_price" value="<?php  echo $result['price']; ?>">
            <input type="hidden" name="product_quantity" value="1" min="1">
            <input type="hidden" name="product_image" value="<?php  echo $result['image']; ?>">
            <div class="icon">
                <a href="view_page.php?pid=<?php echo $result['id']; ?>" class="bi bi-eye-fill"></a>
                <button type="submit" name="add_to_wishlist" class="bi bi-heart"></button>
                <button type="submit" name="add_to_cart" class="bi bi-cart"></button>
            </div>
        </form>


        <?php 
            }
        }else {
            echo '<p class="epmty">no products yet!</p> ';
        }



        ?>
    </div>
</section>





<script type="text/javascript" src="script2.js">
    
$('.popular-brands-content').slick({
    lazyLoad: 'ondemand',
    slidesToShow: 4,
    slidesToScroll: 1,
    nextArrow:$('.left'),
    prevArrow:$('.right'),
    responsive: [
        {
        breakpoint: 1024,
        settings: {
            slidesToShow: 3,
            slidesToScroll:3,
            infinite: true,
            dots: true
        }
        },
        {
        breakpoint: 600,
        settings: {
            slidesToShow: 2,
            slidesToScroll: 2
        }
        },
        {
        breakpoint: 480,
        settings: {
            slidesToShow: 1,
            slidesToScroll: 1
        }
        }
    
  ]
});
</script>

</body>
</html>


