<?php

    include 'config.php';

    session_start();
    if(isset($_POST['add_product'])){

        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $price = $_POST['price'];
        $image = $_FILES['image']['name'];
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = 'uploaded_img/'.$image;

        $select_product_name = mysqli_query($conn, "SELECT name FROM `products` WHERE name = '$name'") or die('query failed');

        if(mysqli_num_rows($select_product_name) > 0){
        $message[] = 'product name already added';
        }else{
        $add_product_query = mysqli_query($conn, "INSERT INTO `products`(name, price, image) VALUES('$name', '$price', '$image')") or die('query failed');

        if($add_product_query){
            if($image_size > 2000000){
                $message[] = 'image size is too large';
            }else{
                move_uploaded_file($image_tmp_name, $image_folder);
                $message[] = 'product added successfully!';
            }
        }else{
            $message[] = 'product could not be added!';
        }
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
<div class="contenue">
<section class="add-products">

   <h1 class="title">Nouveau produit</h1>

   <form action="" method="post" enctype="multipart/form-data">
        <div class="box">
            <label for="new-product-name">Nom du produit:</label>
            <input type="text" name="name" id="new-product-name" placeholder="Nom du produit" required>
        </div>
        <div class="box">
            <label for="new-product-price">Prix du produit:</label>
            <input type="number" min="0" id="new-product-price" name="price" class="box" placeholder="Prix du produit" required>
        </div>
        <div class="box">
            <label for="new-product-image">Image du produit:</label>
            <input type="file" name="image" id="new-product-image" accept="image/jpg, image/jpeg, image/png" class="box" required>
        </div>
        <input type="submit" value="ajouter" name="add_product" class="btn submit">
   </form>

</section>
</div>

<?php include 'footer.php'; ?>

</body>
</html>