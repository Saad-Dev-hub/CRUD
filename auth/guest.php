<?php
// if (isset($_SESSION['user'])) {
// header('location:home.php');
// }
// else if(isset($_SESSION['Admin'])){
//     header('location:products.php');
// }
if (empty($_SESSION['user']) and empty($_SESSION['Admin'])) {
    header('location:index.php');
    }
?>