<?php
require_once "../libs/database.php";
require_once "../libs/pagination.php";

try {
    $currentPage = intval($_GET["page"] ?? 1);
    $perPage = 10;
    $products = get_paginated_data('products', '*', $perPage, $currentPage);
} catch (\Throwable $th) {
    die($th->getMessage());
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
    <title>Manage Product</title>
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
        <div class="container">
            <h1 class="mt-4 mb-4 h3 text-center">Manage Product</h1>
            <div class="card mb-4">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (! $products || $products->num_rows === 0) : ?>
                                <tr>
                                    <td colspan="4" class="text-center">No data</td>
                                </tr>
                            <?php else : ?>
                                <?php $index = 0;?>

                                <?php while ($product = mysqli_fetch_assoc($products)) : ?>
                                    <tr>
                                        <td>
                                            <?= make_pagination_numbering($perPage, $currentPage, $index) ?>
                                            <?php $index++ ?>
                                        </td>
                                        <td>
                                            <?= $product['name'] ?>
                                        </td>
                                        <td>
                                            Rp. <?= $product['price'] ?>
                                        </td>
                                        <td class="text-nowrap" style="width: 1%;">
                                            <button type="button" data-bs-toggle="modal" data-bs-target="#product-<?= $product['id'] ?>" class="btn btn-outline-primary btn-sm">Detail</button>
                                            <a href="product-form.html" class="btn btn-outline-warning btn-sm">Edit</a>
                                            <button class="btn btn-outline-danger btn-sm">Delete</button>

                                            <div class="modal fade" id="product-<?= $product['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel-<?= $product['id'] ?>" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-scrollable">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h2 class="modal-title fs-5" id="exampleModalLabel-<?= $product['id'] ?>">
                                                                <?= $product['name'] ?>
                                                            </h2>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="text-center">
                                                                <img class="img-fluid" style="width: 300px;" src="<?= $product['image'] ?>" alt="">
                                                            </div>
                                                            <hr>
                                                            <h4 class="fw-bold text-center">Rp
                                                                <?= $product['price'] ?>
                                                            </h4>
                                                            <p class="text-wrap">
                                                                <?= $product['description'] ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?= build_pagination(100, $perPage, $currentPage) ?>
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