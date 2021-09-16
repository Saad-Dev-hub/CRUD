<?php
include_once 'auth/Verified.php';
ob_start();
session_start();
include_once 'includes/header.php';
if ($_POST) {
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
    if ($_POST['desc'] == '') {
        $errors['Empty-description'] = "<div class='alert alert-danger'> This Field is Required</div>";
    }
    if ($_POST['desc'] != strip_tags($_POST['desc'])) {
        $errors['invalid-description'] = "<div class='alert alert-danger'>Please Enter valid Charecters</div>";
    }
    if ((strlen($_POST['desc']) < 3 ||  strlen($_POST['desc']) > 500 and ($_POST['desc']) != '')) {
        $errors['wrong-lenght-description'] = "<div class='alert alert-danger'>Your description must be greater than 3 letters and less than 500 letters </div>";
    }
    if (is_numeric($_POST['desc'])) {
        $errors['string-description'] = "<div class='alert alert-danger'> Please Enter only string</div>";
    }

    //Validate Price

    if (!preg_match("/^[0-9]+(\.[0-9]{2})?$/", $_POST['price'])) {
        $errors['price'] = "<div class='alert alert-danger'>Please Enter Valid Price</div>";
    }
    ////Validate Image
    $imageErrors = [];
    if ($_FILES['image']['size'] == 0) {
        $imageErrors['empty'] = "<div class='alert alert-danger'>You must Upload An Image</div>";
    } else if ($_FILES['image']['error'] == 0) {

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

        if (empty($imageErrors)) {
            // code to upload image
            //To give Image Unique Encrypted Name
            //$encryptName = base64_encode($_FILES['image']['name']);
            $photoPath = 'uploads/';
            $photoName = time() . '.' . $extension;
            $fullPath = $photoPath . $photoName;
            // upload photo
            move_uploaded_file($_FILES['image']['tmp_name'], $fullPath);
        }
    }

    if (empty($errors) and empty($imageErrors)) {
        //Update Record In Database
        $con = mysqli_connect('localhost', 'root', '', 'ecommerce');
        if ($con) {
            # code...
            $name = $_POST['name'];
            $desc = $_POST['desc'];
            $price = $_POST['price'];
            $cat = $_POST['Category'];
            $selectCat = " SELECT * FROM categories where name='$cat'";
            $resultCat = mysqli_query($con, $selectCat);
            if (mysqli_num_rows($resultCat) > 0) {
                $var =  mysqli_fetch_assoc($resultCat);
                $id = base64_decode($_GET['id']);
                $Category_id = $var['id']; //Foreign Key
                //DELETE Photos First From my uploads Folder then from database
                $deletedImage = mysqli_query($con, "SELECT `products`.`image` FROM `products` WHERE id=$id");
                while ($data = mysqli_fetch_assoc($deletedImage)) {
                    unlink($data['image']);
                }
                $updateQuery = "UPDATE `products` JOIN `categories`
                ON (`products`.`category_id`=`categories`.`id`)
                SET `products`.`name`='$name',`products`.`description`='$desc',`products`.`price`=$price,`products`.`category_id`=$Category_id,`products`.`image`='$fullPath'
                WHERE `products`.`id`=$id";
                $updateResult = mysqli_query($con, $updateQuery);
                if ($updateQuery) {

                    header('location:Products.php');
                } else {
                    echo 'Something Error';
                }
            }
        } else echo 'Connection Failed';
        mysqli_close($con);
    }
}
?>

<body>
    <?php
    include_once 'includes/nav.php';
    $con = mysqli_connect('localhost', 'root', '', 'ecommerce');
    if ($con) {
        //$id = $_GET['id'];
        // $id=$_SESSION['Edit'];//For Security Reasons
        $id = base64_decode($_GET['id']);
        $query = "SELECT `products`.`id`,`products`.`image`,`products`.`name`,`products`.`description`,`products`.`price`,`products`.`category_id`,`categories`.`name` AS `Category`
         FROM `products` JOIN `categories`
         ON (`products`.`category_id`=`categories`.`id`)
            WHERE `products`.`id`=$id
         ";
        $result = mysqli_query($con, $query);
        while ($row = mysqli_fetch_assoc($result)) { ?>
            <!-- Edit Modal HTML -->
            <div id="editEmployeeModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="modal-header">
                                <h4 class="modal-title">Edit Product</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" value="<?= $row['name'] ?>">
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

                                    <label>Description</label><br>
                                    <textarea class="form-control" rows="4" cols="6" name="desc"><?= $row['description'] ?></textarea>
                                    <?php
                                    if (isset($errors['Empty-description'])) {
                                        echo $errors['Empty-description'];
                                    } else if (isset($errors['invalid-description'])) {
                                        echo $errors['invalid-description'];
                                    } else if (isset($errors['wrong-lenght-description'])) {
                                        echo $errors['wrong-lenght-description'];
                                    } else if (isset($errors['string-description'])) {
                                        echo  $errors['string-description'];
                                    } else if (isset($errors['special-charcters-description'])) {
                                        echo $errors['special-charcters-description'];
                                    }
                                    ?>
                                </div>
                                <div class="form-group">
                                    <label>Price</label>
                                    <input type="text" class="form-control" name="price" value="<?= $row['price'] ?>">
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
                                        if ($con) {
                                            $queryOptions = "SELECT `categories`.`id`,`categories`.`name` From `categories`";
                                            $result = mysqli_query($con, $queryOptions);
                                            while ($categories = mysqli_fetch_assoc($result)) { ?>
                                                <option <?php if ($categories['id'] == $row['category_id']) echo 'selected'; ?>><?php
                                                                                                                                array_push($validSelectOptions, $row['name']);
                                                                                                                                if (!in_array($categories['name'], $validSelectOptions)) {
                                                                                                                                    $errors['select'] = "<div class='alert alert-danger'> You Can't Change Values Here</div>";
                                                                                                                                }
                                                                                                                                echo $categories['name'];

                                                                                                                                ?></option>

                                        <?php
                                            }
                                        } else {
                                            echo 'Connection Failed';
                                        }
                                        mysqli_close($con);


                                        ?>
                                    </select>

                                </div>
                                <div>
                                    <label>Image</label><br>
                                    <img class="img-fluid w-50 rounded" src="<?php echo $row['image']; ?>" alt="">
                                    <input type="file" name="image" class="form-control" />
                                    <?php
                                    if (isset($imageErrors)) {
                                        foreach ($imageErrors as $key => $error) {
                                            # code...
                                            echo $error;
                                        }
                                    }
                                    ?>
                                </div>
                                <div class="modal-footer">
                                    <a href="products.php" class="btn btn-default">Cancel</a>
                                    <input type="submit" class="btn btn-info" value="Save">
                                </div>

                        <?php
                    }
                }

                        ?>




                        <script src="js/script.js"></script>
                        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
                        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
ob_end_flush();
?>