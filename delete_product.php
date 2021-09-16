<?php 
$con = mysqli_connect('localhost', 'root', '', 'ecommerce');
if ($con) {
    if (isset($_GET['id'])) {
        $id=$_GET['id'];
        $deletedImage=mysqli_query($con,"SELECT `products`.`image` FROM `products` WHERE id=$id");
        while ($data=mysqli_fetch_assoc($deletedImage)) {
            unlink($data['image']);
        }
        $query="DELETE FROM `products` where id=$id";
        $result=mysqli_query($con,$query);
        if ($result) {
            header("location:".$_SERVER['HTTP_REFERER']);// Send Me again to the same Page instead of Products.php 
                //header('location:products.php');
            }

           
        }


}


?>
