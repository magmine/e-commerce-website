<?php

    include 'config.php';

    session_start();
    echo 'Hello '.$_REQUEST['id'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Ajout produit</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'header.php'; ?>

<section class="products">

   <h1 class="title">Détail du produit</h1>

   <div class="box-container">
      <?php
        $product_id = $_REQUEST['id'];
         $select_products_query = mysqli_query($conn, "SELECT * FROM `products` where id = '$product_id'") or die('query failed');
         if(mysqli_num_rows($select_products_query) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products_query)){
      ?>
            <form action="" method="post" class="box">
               <a href="details_produit.php?id=<?php echo $fetch_products['id']; ?>"><img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt=""></a>
               <div class="name"><?php echo $fetch_products['name']; ?></div>
               <div class="price">$<?php echo $fetch_products['price']; ?>/-</div>
               <input type="number" min="1" name="product_quantity" value="1" class="qty">
               <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
               <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
               <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
               <input type="submit" value="add to cart" name="add_to_cart" class="btn">
            </form>
      <?php
            }
         }else{
            echo '<p class="empty">Aucun produit disponible!</p>';
         }
      ?>
   </div>

   <div class="load-more" style="margin-top: 2rem; text-align:center">
      <a href="shop.php" class="option-btn">load more</a>
   </div>

</section>


<?php include 'footer.php'; ?>

</body>
</html>