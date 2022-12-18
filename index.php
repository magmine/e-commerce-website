<?php

include 'config.php';

session_start();


if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name'") or die('query failed');

   if(mysqli_num_rows($check_cart_numbers) > 0){
      $message[] = 'already added to cart!';
   }else{
      mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('1', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
      $message[] = 'product added to cart!';
   }

}

function consoleLog($msg) {
   echo '<script type="text/javascript">' .
       'console.log(' . $msg . ');</script>';
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="panier-box">
   <div class="panier">
      <?php
         $select_cart_number = mysqli_query($conn, "SELECT * FROM `cart`") or die('query failed');
         $cart_rows_number = mysqli_num_rows($select_cart_number); 
      ?>
      <a href="cart.php"> <i class="fas fa-shopping-cart"></i> <span>(<?php echo $cart_rows_number; ?>)</span> </a>
   </div>
</div>

<section class="about">

   <div class="flex">
      <div class="content">
         <h3>Bookly</h3>
         <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Impedit quos enim minima ipsa dicta officia corporis ratione saepe sed adipisci?</p>
      </div>

   </div>

</section>


<!-- 

   In this section we will create a php filter script to filter the products by category, and availability (stock). The filtered products will be displayed in the same page in  the products section.
 -->
<section>
   <form action="" method="post" enctype="multipart/form-data">
      <h3>Filter</h3>
      <div class="select">
         <select name="category" id="category">
            <option value="all">All Categories</option>
            <option value="ENFANT">ENFANT</option>
            <option value="ADULTE">ADULTE</option>
         </select>
      </div>
      <div class="select">
         <select name="availability" id="availability">
            <option value="all">All Availability</option>
            <option value="in">In Stock</option>
            <option value="out">Out of Stock</option>
         </select>
      </div>
      <input type="submit" value="filter" name="filter" class="btn">
   </form>
   <button class="btn" onclick="window.location.href='add_product.php'">Nouveau produit</button>
</section>

<section class="products">

   <h1 class="title">latest products</h1>

   <div class="box-container">
      <?php
         $select_products_query = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
         if(isset($_POST['filter'])){

            $category = $_POST['category'];
            $available = $_POST['availability'];
            // $select_products_query = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
            if($category == 'all' && $available == 'all'){
               $select_products_query = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
               consoleLog("Lol $category 1");
            }else if($category == 'all' && $available == 'in'){
               $select_products_query = mysqli_query($conn, "SELECT * FROM `products` WHERE `stock` > 0") or die('query failed');
               consoleLog("Lol $category 2");
            }else if($category == 'all' && $available == 'out'){
               $select_products_query = mysqli_query($conn, "SELECT * FROM `products` WHERE `stock` = 0") or die('query failed');
               consoleLog("Lol $category 3");
            }else if($category != 'all' && $available == 'all'){
               $select_products_query = mysqli_query($conn, "SELECT * FROM `products` WHERE `category`='$category'") or die('query failed');
               consoleLog("Lol $category 4");
            }else if($category != 'all' && $available == 'in'){
               $select_products_query = mysqli_query($conn, "SELECT * FROM `products` WHERE `category` = '$category' AND `stock` > 0") or die('query failed');
               consoleLog("Lol $category 5");
            }else if($category != 'all' && $available == 'out'){
               $select_products_query = mysqli_query($conn, "SELECT * FROM `products` WHERE `category` = '$category' AND `stock` = 0") or die('query failed');
               consoleLog("Lol $category 6");
            }
         }
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

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>