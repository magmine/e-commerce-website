<?php

include 'config.php';

session_start();
$user_id = $_SESSION['user_id'];

if(isset($_POST['update_cart'])){
   $cart_id = $_POST['cart_id'];
   $cart_quantity = $_POST['cart_quantity'];
   mysqli_query($conn, "UPDATE `cart` SET quantity = '$cart_quantity' WHERE id = '$cart_id' and user_id = '$user_id'") or die('query failed');
   $message[] = 'cart quantity updated!';
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$delete_id'") or die('query failed');
   header('location:cart.php');
}

if(isset($_GET['delete_all'])){
   mysqli_query($conn, "DELETE FROM `cart`") or die('query failed');
   header('location:cart.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>cart</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="contenue">
<section class="cart">

   <h1 class="title">Panier</h1>

   <div class="cart-items">
      <table class="table">
         <thead>
            <tr>
               <th class="name">Description produit</th>
               <th>Qtte</th>
               <th>Photo</th>
               <th>Prix</th>
            </tr>
         </thead>
         <tbody>
      <?php
         $grand_total = 0;
         $select_cart = mysqli_query($conn, "SELECT * FROM `cart`") or die('query failed');
         if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){   
      ?>
         <tr class="row">
            <td class="name"><?php echo $fetch_cart['name']; ?></td>
            <td class="number"><?php echo $fetch_cart['quantity']; ?></td>
            <td class="image"><img height="50" widht="50" src="images/<?php echo $fetch_cart['image']; ?>" alt=<?php echo $fetch_cart['image']; ?>></td>
            <td class="number"><?php echo $fetch_cart['price']; ?></td>
         </tr>
      <!-- <div class="box">
         <a href="cart.php?delete=<?php echo $fetch_cart['id']; ?>" class="fas fa-times" onclick="return confirm('delete this from cart?');"></a>
         <img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" alt="">
         <div class="name"><?php echo $fetch_cart['name']; ?></div>
         <div class="price">$<?php echo $fetch_cart['price']; ?>/-</div>
         <form action="" method="post">
            <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
            <input type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>">
            <input type="submit" name="update_cart" value="update" class="option-btn">
         </form>
         <div class="sub-total"> sub total : <span>$<?php echo $sub_total = ($fetch_cart['quantity'] * $fetch_cart['price']); ?>/-</span> </div>
      </div> -->
      <?php
      $grand_total += $sub_total;
         }
      }else{
         echo '<p class="empty">your cart is empty</p>';
      }
      ?>
         </tbody>
      </table>
      <div class="cart-total">
         <p>Total : <span>$<?php echo $grand_total; ?>/-</span></p>
      </div>
   </div>

   <!-- <div style="margin-top: 2rem; text-align:center;">
      <a href="cart.php?delete_all" class="delete-btn <?php echo ($grand_total > 1)?'':'disabled'; ?>" onclick="return confirm('delete all from cart?');">delete all</a>
   </div> -->

</section>
   </div>








<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>