<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title><?php echo $data['title']; ?></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="description">
    <link rel="icon" type="image/png" href="img/logo.png">

    <meta name="Author" lang="es" content="leenhcraft.com">

    <link rel="stylesheet" href="/css/plugins/bootstrap.css">
    <link rel="stylesheet" href="/css/plugins/font.min.css">
    <link rel="stylesheet" href="/css/plugins/sweetalert2.min.css">

    <link rel="stylesheet" href="/css/web/animate.css">
    <link rel="stylesheet" href="/css/web/owl.carousel.min.css">
    <link rel="stylesheet" href="/css/web/all.css">
    <link rel="stylesheet" href="/css/web/flaticon.css">
    <link rel="stylesheet" href="/css/web/themify-icons.css">
    <link rel="stylesheet" href="/css/web/magnific-popup.css">
    <link rel="stylesheet" href="/css/web/slick.css">
    <link rel="stylesheet" href="/css/web/style.css">
    <link rel="stylesheet" href="/css/custom.css">

    <?php
    if (isset($data['css']) && !empty($data['css'])) {
        for ($i = 0; $i < count($data['css']); $i++) {
            echo '<link rel="stylesheet" type="text/css" href="' . $data['css'][$i] . '">';
        }
    }
    ?>

</head>

<body>
    <div id="divLoading" style="display: none;">
        <div>
            <img src="/img/loading.svg" alt="Loading">
        </div>
    </div>
    <header class="main_menu home_menu">
        <div class="header_top d-none d-md-inline" style="background-color: #ECFDFF;">
            <div class="container">
                <div class="row py-1">
                    <div class="col-lg-6">
                        <label class="form-label m-0">Hola, <b><?= $nombre ?></b></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <a class="navbar-brand logo-web" href="/"> <?= NOMBRE_EMPRESA; ?> </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="menu_icon"><i class="fas fa-bars"></i></span>
                        </button>

                        <div class="collapse navbar-collapse main-menu-item" id="navbarSupportedContent">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="/login">intranet</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="blog.html" id="navbarDropdown_1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Shop
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown_1">
                                        <a class="dropdown-item" href="category.html"> shop category</a>
                                        <a class="dropdown-item" href="single-product.html">product details</a>

                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="blog.html" id="navbarDropdown_3" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        pages
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown_2">
                                        <a class="dropdown-item" href="login.html"> login</a>
                                        <a class="dropdown-item" href="tracking.html">tracking</a>
                                        <a class="dropdown-item" href="checkout.html">product checkout</a>
                                        <a class="dropdown-item" href="cart.html">shopping cart</a>
                                        <a class="dropdown-item" href="confirmation.html">confirmation</a>
                                        <a class="dropdown-item" href="elements.html">elements</a>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="blog.html" id="navbarDropdown_2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        blog
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown_2">
                                        <a class="dropdown-item" href="blog.html"> blog</a>
                                        <a class="dropdown-item" href="single-blog.html">Single blog</a>
                                    </div>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="contact.html">Contact</a>
                                </li>
                            </ul>
                        </div>
                        <div class="hearer_icon d-flex">
                            <a id="search_1" href="javascript:void(0)"><i class="ti-search m-0"></i></a>
                            <?php
                            if (isset($_SESSION['pe'])) :
                            ?>
                                <a href="/logout" class="mx-3"><i class='ti-arrow-circle-left m-0'></i></a>
                            <?php else : ?>
                                <a href="/login" class="mx-3"><i class="ti-user m-0"></i></a>
                            <?php endif; ?>

                            <div class="">
                                <a class="" href="/carrito">
                                    <i id="cantcar" class="fas fa-cart-plus m-0"><span class="cant_car" <?= $dnone ?>><?= $cant ?></span></i>
                                </a>
                                <!-- <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <div class="single_product px-2">
                                        <?php dep($_SESSION); ?>
                                    </div>
                                </div> -->

                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        <div class="search_input" id="search_input_box">
            <div class="container ">
                <form class="d-flex justify-content-between search-inner">
                    <input type="text" class="form-control" id="search_input" placeholder="Search Here">
                    <button type="submit" class="btn"></button>
                    <span class="ti-close" id="close_search" title="Close Search"></span>
                </form>
            </div>
        </div>
    </header>