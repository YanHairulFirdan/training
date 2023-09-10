<?php
require_once "../libs/validation.php";
require_once "../libs/database.php";

$errors = [];
$actionResult = '';

if (count($_POST) > 0) {
    $validationRules = [
        'image' => ['required', 'is_valid_url'],
        'name'  => ['required', 'min_length:5', 'max_length:100'],
        'price' => ['required', 'min_value:1000'],
        'description' => ['required', 'min_length:10', 'max_length:1000'],
    ];

    $errors = form_validation($_POST, $validationRules);

    if (count($errors) === 0) {
        $result = insert_data('products', $_POST);

        if ($result) {
            header('Location: index.php');
        } else {            
            $actionResult = 'Cannot store the data, Something went wrong';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="shortcut icon" href="/storage/img/logo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
    <title>Add Product</title>
</head>

<body>
    <!-- navbar start -->
    <nav class="navbar navbar-expand-lg" data-bs-theme="dark" style="background-color: #34a0a4;">
        <div class="container">
            <a class="navbar-brand" href="index.html">Shop Mate</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <a class="btn btn-outline-light ms-auto" href="login.html" role="button">Admin</a>
            </div>
        </div>
    </nav>
    <!-- navbar end -->



    <!-- main start -->
    <main class="full-page">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-5">
                    <div class="card shadow rounded-4">
                        <div class="card-body">
                            <h4 class="text-center mb-4">Add Product</h4>
                            <form action="create-product.php?" method="post">
                                <div role="alert" class="alert alert-danger">
                                    <?= $actionResult ?>
                                </div>
                                <div class="mb-3">
                                    <label for="inputImage" class="form-label">Image URL</label>
                                    <input type="text" class="form-control" id="inputImage" name="image" placeholder="insert your image url">
                                    
                                    <?php if (key_exists('image', $errors) && count($errors['image']) > 0) : ?>
                                    <?php foreach ($errors['image'] as $key => $error) : ?>
                                        <div class="alert alert-danger">
                                            <?= $error ?>
                                        </div>
                                    <?php endforeach ?>
                                <?php endif ?>
                                </div>
                                <div class="mb-3">
                                    <label for="inputName" class="form-label">Product Name </label>
                                    <input type="text" class="form-control" id="inputName" placeholder="insert your product name" name="name">

                                    <?php if (key_exists('name', $errors) && count($errors['name']) > 0) : ?>
                                        <?php foreach ($errors['name'] as $key => $error) : ?>
                                            <div class="alert alert-danger">
                                                <?= $error ?>
                                            </div>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </div>
                                <div class="mb-3">
                                    <label for="inputPrice" class="form-label">Product Price</label>
                                    <input type="number" class="form-control" id="inputPrice" placeholder="insert your product price" name="price">

                                    <?php if (key_exists('price', $errors) && count($errors['price']) > 0) : ?>
                                        <?php foreach ($errors['price'] as $key => $error) : ?>
                                            <div class="alert alert-danger">
                                                <?= $error ?>
                                            </div>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </div>
                                <div class="mb-3">
                                    <label for="inputDescription" class="form-label">Product Description</label>
                                    <textarea name="description" class="form-control" id="inputDescription" rows="3" placeholder="insert your description"></textarea>

                                    <?php if (key_exists('description', $errors) && count($errors['description']) > 0) : ?>
                                        <?php foreach ($errors['description'] as $key => $error) : ?>
                                            <div class="alert alert-danger">
                                                <?= $error ?>
                                            </div>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-secondary px-4">Batal</button>
                                    <button class="btn btn-secondary px-4">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- main end -->


    <!-- footer start -->
    <footer>
        <div class="container text-center">
            <div class="row py-5">
                <div class="col-12 col-lg-4">
                    <h4>Shop Mate</h4>
                    <ul class="footer-list">
                        <li>Jalan Ahmad Yani Utara</li>
                        <li>085738315221</li>
                        <li>shopmate@gmail.com</li>
                    </ul>
                </div>
                <div class="col-12 col-lg-4">
                    <h4>Menu</h4>
                    <ul class="footer-list">
                        <li>
                            <a href="">Home</a>
                        </li>
                        <li>
                            <a href="">Collection</a>
                        </li>
                        <li>
                            <a href="">Promo</a>
                        </li>
                        <li>
                            <a href="">How We Work</a>
                        </li>
                    </ul>
                </div>
                <div class="col-12 col-lg-4">
                    <h4>Follow Us</h4>
                    <div class="footer-socials">
                        <a href="">
                            <i class="fa-brands fa-twitter"></i>
                        </a>
                        <a href="">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                        <a href="">
                            <i class="fa-brands fa-square-facebook"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="text-center border-top">©2023 Shop Mate. All Rights Reserved.</div>
        </div>
    </footer>
    <!-- footer end -->


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>