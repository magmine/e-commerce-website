<?php

   include 'config.php';

   session_start();

   $user_id = $_SESSION['user_id'];

   function consoleLog($msg) {
      echo '<script type="text/javascript">' .
          'console.log(' . $msg . ');</script>';
   }

   if(isset($_POST['add_to_cart'])){

      $product_name = $_POST['product_name'];
      $product_price = $_POST['product_price'];
      $product_image = $_POST['product_image'];
      $product_quantity = $_POST['product_quantity'];
   
      $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' and user_id='$user_id'") or die('query failed');
   
      if(mysqli_num_rows($check_cart_numbers) > 0){
         $message[] = 'already added to cart!';
      }else{
         mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES($user_id, '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
         $message[] = 'product added to cart!';
      }
   
   }
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
   <link rel="stylesheet" href="style.css">

</head>
<body>

<?php include 'header.php'; ?>

<div class="contenue-detail">
<section class="product-details">

   <h1 class="title">Détail du produit</h1>
   <form action="" method="post">
   <div class="box-container">
      <?php
         $product_id = $_GET['id'];
         $select_products_query = mysqli_query($conn, "SELECT * FROM `products` where id = '$product_id'") or die('query failed');
         if(mysqli_num_rows($select_products_query) > 0){
            $fetch_products = mysqli_fetch_assoc($select_products_query);
      ?>
         <div class="image-container">
            <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
         </div>
         <div class="description">
            <p>Description: <?php echo $fetch_products['name']; ?></p>
            <p>Prix: <?php echo $fetch_products['price']; ?></p>
            <p>Categorie: <?php echo $fetch_products['category']; ?></p>
            <p>Disponibles: <?php echo $fetch_products['stock']; ?></p>
         </div>
         <div class="quantite">
            <label for="quantite-produit">Quantité: <input id="quantite-produit" type="number" min="1" name="product_quantity" value="1" class="quantite-in"></label>
         </div>
         <input type="hidden" name="id" value="<?php echo $fetch_products['id']; ?>">
         <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
         <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
         <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
         <input type="hidden" name="product_category" value="<?php echo $fetch_products['category']; ?>">
         <input type="hidden" name="product_stock" value="<?php echo $fetch_products['stock']; ?>">
         <div class="panier">
            <input type="submit" value="+ panier" name="add_to_cart" class="add-panier">
         </div>
      <?php
         }else{
            echo '<p class="empty">Aucun produit disponible!</p>';
         }
      ?>
   </form>
   </div>

</section>
      </div>


<?php include 'footer.php'; ?>

</body>
</html>