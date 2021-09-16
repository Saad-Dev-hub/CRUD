<?php
session_start();
include_once 'auth/guest.php';

?>

<body>
    <?php
    include_once 'includes/header.php';
    include_once 'includes/nav.php';
    ?>
    <div class="container-xl">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-6">
                            <h2>Manage <b>Products</b></h2>
                        </div>
                        <div class="col-sm-6">
                            <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add New Product</span></a>

                            <a href="#deleteEmployeeModal" class="btn btn-danger" data-toggle="modal"><i class="material-icons">&#xE15C;</i> <span>Delete</span></a>
                        </div>
                    </div>
                </div>
                <!-- In case of Insert Data -->
                <?php
                if (isset($alertSuccess)) {
                    echo $alertSuccess;
                }
                ?>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <td>id</td>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Image</th>
                            <th>Category</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $con = mysqli_connect('localhost', 'root', '', 'ecommerce');
                        if ($con) {
                            #START OF PAGINATION
                            $results_per_page = 5;
                            // find out the number of results stored in database
                            $sql = 'SELECT * FROM Pagination';
                            $result = mysqli_query($con, $sql);
                            $number_of_results = mysqli_num_rows($result);
                            // determine number of total pages available
                            $number_of_pages = ceil($number_of_results / $results_per_page);

                            // determine which page number visitor is currently on
                            if (!isset($_GET['page'])) {
                                $page = 1;
                            } else {
                                $page = $_GET['page'];
                            }

                            // determine the sql LIMIT starting number for the results on the displaying page
                            $this_page_first_result = ($page - 1) * $results_per_page;

                            // retrieve selected results from database and display them on page
                            $sql = 'SELECT * FROM Pagination LIMIT ' . $this_page_first_result . ',' .  $results_per_page;
                            $result = mysqli_query($con, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                $id = $row['id'];
                        ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['name'] ?></td>
                                    <td><?php echo $row['description'] ?></td>
                                    <td><?php echo $row['price'] . '$' ?></td>
                                    <td><img src="<?php echo ($row['image']) ?>" alt="<?php echo $row['name'] ?>" width="80px" height="80px"></td>
                                    <td><?php echo $row['Category'] ?></td>

                                    <td class="d-flex">
                                        <a href="Edit_Product.php?id=<?php echo base64_encode($row['id']); ?>" class="edit mt-4"><i class="material-icons" data-toggle="tooltip" >&#xE254;</i></a>
                                        <a href="delete_product.php?id=<?= $row['id']; ?>" class="delete mt-4"><i class="material-icons" data-toggle="tooltip" >&#xE872;</i></a>
                                    </td>
                                </tr>
                        <?php
                            }
                            if ($page > 1) {
                                $back = $page - 1;
                            } else {
                                $back = 1;
                            }
                            if ($page < $number_of_pages) {
                                $ahead = $page + 1;
                            } else {
                                $ahead = $number_of_pages;
                            }

                            echo "<ul class='pagination'>";
                            for ($page = 1; $page <= $number_of_pages; $page++) {

                                echo '<a class="page-item text-decoration-none" href="products.php?page=' . $back . '">Previous</a> ';
                                for ($page=1;$page<= $number_of_pages; $page++) 
                                {
                                    echo '<a class="page-item text-decoration-none" href="products.php?page=' . $page . '">&nbsp;' . $page . '&nbsp;</a> ';
                                }
                                echo '<a class="page-item text-decoration-none" href="products.php?page=' . $ahead . '">Next</a> ';
                              }
                              echo"</ul>";
                        } else echo 'Failed';
                        mysqli_close($con);
                        ?>
                    </tbody>
                </table>


                <?php

                ?>
               
            </div>
        </div>
    </div>
    <!-- ADD Modal HTML -->
    <div id="addEmployeeModal" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" enctype="multipart/form-data">
                    <?php
                    if ($_POST) {
                        //print_r($_GET['page_no']);die;
                        //print_r($_SESSION);die;
                        $errors = [];
                        //Validate Inputs
                        // Validate Name of Product
                        if ($_POST['name'] == '') {
                            $errors['Empty-Name'] = "<div class='alert alert-danger'> This Field is Required</div>";
                        }
                        if ($_POST['name'] != strip_tags($_POST['name'])) {
                            $errors['invalid-string'] = "<div class='alert alert-danger'>Please Enter valid Name</div>";
                        }
                        if ((strlen($_POST['name']) < 3 ||  strlen($_POST['name']) > 80 and ($_POST['name']) != '')) {
                            $errors['wrong-lenght'] = "<div class='alert alert-danger'>Your Name must be greater than 3 letters and less than 80 letters </div>";
                        }
                        if (is_numeric($_POST['name'])) {
                            $errors['string'] = "<div class='alert alert-danger'> Your name must be string</div>";
                        }
                        $pattern = '/[\'\/~`\!@#\$%\^&\*\(\)\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/';
                        if (preg_match($pattern, $_POST['name'])) {
                            $errors['special-charcters'] = "<div class='alert alert-danger'>Please Enter Name as only String Format.</div>";
                        }
                        //Validate Description
                        if ($_POST['description'] == '') {
                            $errors['Empty-description'] = "<div class='alert alert-danger'> This Field is Required</div>";
                        } else if ($_POST['description'] != strip_tags($_POST['description'])) {
                            $errors['invalid-description'] = "<div class='alert alert-danger'>Please Enter valid Charecters</div>";
                        } else if ((strlen($_POST['description']) < 3 ||  strlen($_POST['description']) > 500 && ($_POST['description']) != '')) {
                            $errors['wrong-lenght-description'] = "<div class='alert alert-danger'>Your description must be greater than 3 letters and less than 500 letters </div>";
                        } else if (is_numeric($_POST['description'])) {
                            $errors['string-description'] = "<div class='alert alert-danger'> Please Enter only string</div>";
                        }

                        //Validate Price

                        if (!preg_match("/^[0-9]+(\.[0-9]{2})?$/", $_POST['price'])) {
                            $errors['price'] = "<div class='alert alert-danger'>Please make sure this Field is not Empty  and Enter Valid Price</div>";
                        }
                        //Validate Image
                        if ($_FILES['image']['error'] == 0) {
                            //
                            $imageErrors = [];
                            // validate on size
                            if ($_FILES['image']['size'] > (10 ** 6)) {
                                $imageErrors['size'] = "<div class='alert alert-danger'> Image Must Be Less Than 1 Mega Byte </div>";
                            }
                            // get file extension
                            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                            // create array of allowed extensions
                            $allowedExtensions = ['png', 'jpg', 'jpeg'];
                            // check on extension if it allowed
                            if (!in_array($extension, $allowedExtensions)) {
                                $imageErrors['extension'] = "<div class='alert alert-danger'> Image Must Be png,jpeg or jpg </div>";
                            }

                            if (empty($imageErrors) and empty($errors)) {
                                // code to upload image
                                // time();

                                $photoPath = 'uploads/';
                                $photoName = time() . '.' .  $extension;
                                $fullPath = $photoPath . $photoName;
                                // upload photo
                                move_uploaded_file($_FILES['image']['tmp_name'], $fullPath);
                                $con = mysqli_connect('localhost', 'root', '', 'ecommerce');

                                if ($con) {
                                    $name = mysqli_real_escape_string($con, $_POST['name']);
                                    $desc = mysqli_real_escape_string($con, $_POST['description']);
                                    $price = $_POST['price'];
                                    $cat = $_POST['Category'];
                                    //$path=$_SESSION['path'];

                                    $selectCat = " SELECT * FROM categories where name='$cat'";
                                    $resultCat = mysqli_query($con, $selectCat);
                                    if (mysqli_num_rows($resultCat) > 0) {
                                        $var =  mysqli_fetch_assoc($resultCat);
                                        $id = $var['id'];
                                    }
                                    $insertQuery = "INSERT INTO `products`(
                                    `name`,
                                    `image`,
                                    `description`,
                                    `price`,
                                    `category_id`
                                )
                                VALUES(
                                    '$name',
                                     '$fullPath',
                                    '$desc',
                                     $price,
                                    $id
                                )";
                                    $result = mysqli_query($con, $insertQuery);
                                    if ($result) {
                                        echo 'Inserted Successfully';
                                        // echo $var['id'];

                                    } else {
                                        echo $result . mysqli_error($con);
                                        echo 'Failed';
                                    }
                                } else {
                                    echo 'Connection Failed';
                                }

                                // save photo to session
                                //$_SESSION['path'] = $fullPath;
                            }
                        }


                        //To stop Bootstrap Modal if there is error
                        if ($errors) {
                            echo '<script>$("#addEmployeeModal").modal("show");</script>';
                        } else {
                            echo '<script>$("#addEmployeeModal").modal("hide");</script>';
                        }


                        //Insert New Product To Database
                    }


                    ?>
                    <div class="modal-header">
                        <h4 class="modal-title">Add Product</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control">
                            <?php
                            if (isset($errors['Empty-Name'])) {
                                echo $errors['Empty-Name'];
                            } else if (isset($errors['invalid-string'])) {
                                echo $errors['invalid-string'];
                            } else if (isset($errors['wrong-lenght'])) {
                                echo $errors['wrong-lenght'];
                            } else if (isset($errors['string'])) {
                                echo $errors['string'];
                            } else if (isset($errors['special-charcters'])) {
                                echo $errors['special-charcters'];
                            }
                            ?>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" cols="39" rows="5"></textarea>
                            <?php
                            if (isset($errors['Empty-description'])) {
                                echo $errors['Empty-description'];
                            } else if (isset($errors['invalid-description'])) {
                                echo $errors['invalid-description'];
                            } elseif (isset($errors['wrong-lenght-description'])) {
                                echo $errors['wrong-lenght-description'];
                            } elseif (isset($errors['string-description'])) {
                                echo  $errors['string-description'];
                            } elseif (isset($errors['special-charcters-description'])) {
                                echo $errors['special-charcters-description'];
                            }
                            ?>
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input type="text" name="price" class="form-control"></input>
                            <?php
                            if (isset($errors['price'])) {
                                echo $errors['price'];
                            }
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Categories</label>
                            <select class="form-control" name="Category" id="exampleFormControlSelect1">
                                <?php
                                $validSelectOptions = [];
                                $con = mysqli_connect('localhost', 'root', '', 'ecommerce');
                                if ($con) {
                                    $queryOptions = "SELECT `categories`.`id`, `categories`.`name` FROM `categories`";

                                    $result = mysqli_query($con, $queryOptions);
                                    while ($row = mysqli_fetch_assoc($result)) { ?>
                                        <option><?php
                                                array_push($validSelectOptions, $row['name']);
                                                if (!in_array($row['name'], $validSelectOptions)) {
                                                    $errors['select'] = "<div class='alert alert-danger'> You Can't Change Values Here</div>";
                                                }
                                                echo $row['name'];
                                                // echo $_SESSION['cat_id']= $row['id'];

                                                ?></option>

                                <?php
                                    }
                                } else {
                                    echo 'Connection Failed';
                                }
                                mysqli_close($con);


                                ?>
                            </select>

                            <?php
                            // if (isset($errors['select'])) {
                            //     echo $errors['select'];
                            // }
                            // $con = mysqli_connect('localhost', 'root', '', 'ecommerce');
                            // if ($con) {
                            //     $query="";
                            // }
                            // else{
                            //     echo 'Connection Failed';
                            // }
                            // print_r($validSelectOptions);die;
                            ?>
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <label>Image</label>
                                <input type="file" class="form-control" name="image">
                            </div>
                            <?php
                            if (isset($imageErrors)) {
                                foreach ($imageErrors as $key => $error) {
                                    echo $error;
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <input type="submit" class="btn btn-success" value="Add">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Modal HTML -->
    <!-- Delete Modal HTML -->
    <script src="js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>

    </script>

</body>

</html>
<?php
// ob_end_flush();
?>