<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Shop Homepage - Start Bootstrap Template</title>
  <!-- Bootstrap icons-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Core theme CSS (includes Bootstrap)-->
  <link href="css/style.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/Home.css">

</head>

<body>
  <?php
  session_start();
  include_once 'includes/nav.php';
  ?>
  <!-- Header-->
  <header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
      <div class="text-center text-white">
        <h1 class="display-4 fw-bolder">Shop in style</h1>
        <p class="lead fw-normal text-white-50 mb-0">With this shop hompeage template</p>
      </div>
    </div>
  </header>
  <div class="container d-flex justify-content-center mt-50 mb-50">
    <div class="row">
      <div class="col-md-10 mx-auto">
        <?php
        $con = mysqli_connect('localhost', 'root', '', 'ecommerce');
        if ($con) {
          $query = "SELECT `products`.`id`,`products`.`name`,`products`.`description`,`products`.`price`,`products`.`image`,`categories`.`name` AS `Category`
              FROM `products` JOIN `categories`
              ON (`products`.`category_id`=`categories`.`id`) ORDER BY `products`.`id`";
          $result = mysqli_query($con, $query);
          while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="card card-body">
              <div class="media align-items-center align-items-lg-start text-center text-lg-left flex-column flex-lg-row">
                <div class="mr-2 mb-3 mb-lg-0"> <img src="<?= $row['image'] ?>" width="150" height="150" alt=""> </div>
                <div class="media-body">
                  <h4 class="media-title font-weight-semibold"> <a href="#" data-abc="true"><?= $row['name']?></a> </h4>
                  <ul class="list-inline list-inline-dotted mb-3 mb-lg-2">
                    <li class="list-inline-item"><a href="#" class="text-muted" data-abc="true"><?= $row['Category']?></a></li>
                  </ul>
                  <p class="mb-3"><?= $row['description']?></p>
                </div>
                <div class="mt-3 mt-lg-0 ml-lg-3 text-center">
                  <h3 class="mb-0"><?=$row['price']?>$</h3>
                  <div> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> </div>
                  <button type="button" class="btn btn-warning mt-4 text-white"><i class="icon-cart-add mr-2"></i> Add to cart</button>
                </div>
              </div>
            </div>
        <?php
          }
        }

        ?>

      </div>
    </div>
  </div>

  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; Your Website 2021</p>
    </div>
  </footer>
  <!-- Bootstrap core JS-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>