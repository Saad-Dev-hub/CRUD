<?php
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

    if (empty($imageErrors)) {
        // code to upload image
        // time();
        $photoPath = 'uploads/';
        $photoName = time() . '.' .  $extension;
        $fullPath = $photoPath . $photoName;
        // upload photo
        move_uploaded_file($_FILES['image']['tmp_name'], $fullPath);
        // save photo to session
        $_SESSION['path'] = $fullPath;
    }
}
?>