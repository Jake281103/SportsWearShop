<?php

// connection with database
require_once "dbconnect.php";

// call getuserdatafunction.php
require_once "commonfunctions.php";


// show error
ini_set("display_errors", 1);

$userid = '';
$message = '';
$user = [];

// to create succes if not exist
if (!isset($_SESSION)) {
    session_start(); 
}

// get user id if email session exist
if (!isset($_SESSION['email'])) {
    header("Location:homepage.php");
}else{
    $userid = getuser($_SESSION['email'])['id'];
    $user = getuser($_SESSION['email']);
}


// var_dump($user);

?>


<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Sixty9 | Profile Page</title>
        <!-- Favicon -->
        <link rel="icon" type="image/png" sizes="540x15" href="./assets/images/img/logo1.png">
        <!-- fontawesome Css -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- Plugins CSS File -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/plugins/owl-carousel/owl.carousel.css">
        <!-- Main CSS File -->
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/skins/skin-demo-10.css">
        <link rel="stylesheet" href="assets/css/demos/demo-10.css">
    </head>

    <body>
        <div class="page-wrapper">
            <header class="header header-8">
                <div class="header-top">
                    <div class="container">
                        <div class="header-left">
                            <div class="header-dropdown">
                                <a href="javascprit:void(0);">USD</a>
                                <div class="header-menu">
                                    <ul>
                                        <li><a href="javascript:void(0);">Eur</a></li>
                                        <li><a href="javascript:void(0);">Usd</a></li>
                                    </ul>
                                </div><!-- End .header-menu -->
                            </div><!-- End .header-dropdown -->

                            <div class="header-dropdown">
                                <a href="javascript:void(0);">Eng</a>
                                <div class="header-menu">
                                    <ul>
                                        <li><a href="javascript:void(0);">English</a></li>
                                        <li><a href="javascript:void(0);">Myanmar</a></li>
                                    </ul>
                                </div><!-- End .header-menu -->
                            </div><!-- End .header-dropdown -->
                        </div><!-- End .header-left -->

                        <div class="header-right">
                            <ul class="top-menu">
                                <li>
                                    <a href="#">Links</a>
                                    <ul>
                                        <li><a href="tel:+959763544740"><i class="icon-phone"></i>Call: +959763544740</a></li>
                                        <li><a href="./about.php">About Us</a></li>
                                        <li><a href="contact.php">Contact Us</a></li>
                                        <?php if(isset($_SESSION['email'])){ ?>
                                            <li>
                                                <!-- <a href="./logout.php"><i class="icon-user"></i>Logout</a> -->
                                                <div class="dropdown">
                                                    <a href="javascript:void(0);" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-user"></i>Profile</a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item" href="./profile.php"><i class="fa fa-user-circle"></i> Profile</a>
                                                        <a class="dropdown-item" href="./logout.php"><i class="fa fa-power-off"></i> Logout</a>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php }else{ ?>
                                            <li><a href="./login.php"><i class="icon-user"></i>Login</a></li>
                                        <?php } ?>
                                    </ul>
                                </li>
                            </ul><!-- End .top-menu -->
                        </div><!-- End .header-right -->
                    </div><!-- End .container -->
                </div><!-- End .header-top -->

                <div class="header-middle sticky-header">
                    <div class="container">
                        <div class="header-left">
                            <button class="mobile-menu-toggler">
                                <span class="sr-only">Toggle mobile menu</span>
                                <i class="icon-bars"></i>
                            </button>

                            <a href="./homepage.php" class="logo">
                                <img src="assets/images/img/logo1.png" alt="Molla Logo" width="100" >
                            </a>
                        </div><!-- End .header-left -->

                        <div class="header-right">
                            <nav class="main-nav">
                                <ul class="menu sf-arrows">
                                    <li class="megamenu-container active">
                                        <a href="./homepage.php" class="">Home</a>
                                    </li>
                                    <li>
                                        <a href="./about.php" class="">About</a>
                                    </li>
                                    <li>
                                        <a href="./product.php" class="">Products</a>
                                    </li>
                                    <li>
                                        <a href="./contact.php" class="">Contact Us</a>
                                    </li>
                                </ul><!-- End .menu -->
                            </nav><!-- End .main-nav -->

                            <div class="header-search">
                                <a href="#" class="search-toggle" role="button"><i class="icon-search"></i></a>
                                <form action="./product.php" method="post">
                                    <div class="header-search-wrapper">
                                        <label for="q" class="sr-only">Search</label>
                                        <input type="search" class="form-control" name="searchname" id="q" placeholder="Search by product name..." required>
                                    </div><!-- End .header-search-wrapper -->
                                </form>
                            </div><!-- End .header-search -->

                            <div class="dropdown cart-dropdown">
                                <?php if(isset($_SESSION['email'])){ ?>
                                    <a href="cart.php" class="dropdown-toggle" role="button">
                                        <i class="icon-shopping-cart"></i>
                                        <span class="cart-count"><?php echo getcartcount($userid)['count'] ?></span>
                                    </a>
                                <?php } else{ ?>
                                    <a href="#" class="dropdown-toggle" role="button">
                                        <i class="icon-shopping-cart"></i>
                                        <span class="cart-count">0</span>
                                    </a>
                                <?php } ?>
                            </div><!-- End .cart-dropdown -->
                        </div><!-- End .header-right -->
                    </div><!-- End .container -->
                </div><!-- End .header-middle -->
            </header><!-- End .header -->

            <main class="main mt-5">
                <div class="container">
                    <div class="row">

                        <div class="col-12">
                            <p class="text-secondary">Home / <span class="fw-bold">Account</span></p>
                        </div>

                        <div class="col-12 account-hearder">
                            <div class="d-flex align-items-center p-5">
                                <?php if ($user['profile'] != null) { ?>

                                    <img src="<?php echo $user['profile'] ?>" class="rounded-circle" width="170" alt="user<?php echo $user['id'] ?>" />
                                <?php } else { ?>
                                    <img src="./assets/images/img/avator.png" class="rounded-circle" width="170" alt="defaultprofile" />
                                <?php } ?>

                                <div class="ml-5">
                                    <?php if ($user['name'] != null) { ?>
                                        <h3 class="pb-1">Hi <?php echo $user['name'] ?></h3>
                                    <?php } else { ?>
                                        <h3 class="pb-1">Hi Customer</h3>
                                    <?php } ?>
                                    <h6 class="pb-1"><?php echo $user['email'] ?></h6>
                                    <a href="./logout.php" class="btn btn-secondary btn-sm">Logout</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 my-4">
                            <div class="row">
                                <div class="col-lg-3 mb-2">
                                    <a href="./account.php" class="nav-link">
                                        <div class="d-flex border border-secondary rounded px-5 py-4">
                                            <i class="fas fa-user mr-4" style="font-size: 24px;"></i>
                                            <h5>Profile</h5>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-3 mb-2">
                                    <a href="./orderrecord.php" class="nav-link">
                                        <div class="d-flex border border-secondary rounded px-5 py-4">
                                            <i class="fas fa-box-open mr-4" style="font-size: 24px; "></i>
                                            <h5>Order</h5>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-3 mb-2">
                                    <a href="./editaccount.php" class="nav-link">
                                        <div class="d-flex border border-secondary rounded px-5 py-4">
                                            <i class="fas fa-user-edit mr-4" style="font-size: 24px;"></i>
                                            <h5>Edit Info</h5>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <!-- End .main -->

            <footer class="footer footer-dark">
                <div class="cta bg-image bg-dark pt-4 pb-5 mb-0" style="background-image: url(assets/images/img/banner10.jpg);">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-sm-10 col-md-8 col-lg-6">
                                <div class="cta-heading text-center">
                                    <h3 class="cta-title text-white">Subscribe for Our Newsletter</h3><!-- End .cta-title -->
                                    <p class="cta-desc text-white">and receive <span class="font-weight-normal">$20 coupon</span> for first shopping</p><!-- End .cta-desc -->
                                </div><!-- End .text-center -->
                            
                                <form action="#" method="">
                                    <div class="input-group input-group-round">
                                        <input type="email" class="form-control form-control-white" placeholder="Enter your Email Address" aria-label="Email Adress" required>
                                        <div class="input-group-append">
                                            <button class="btn btn-white" type="submit"><span>Subscribe</span><i class="icon-long-arrow-right"></i></button>
                                        </div><!-- .End .input-group-append -->
                                    </div><!-- .End .input-group -->
                                </form>
                            </div><!-- End .col-sm-10 col-md-8 col-lg-6 -->
                        </div><!-- End .row -->
                    </div><!-- End .container -->
                </div><!-- End .cta -->
                <div class="footer-middle">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-6 col-lg-3">
                                <div class="widget widget-about">
                                    <img src="assets/images/img/logo1.png" class="footer-logo" alt="Footer Logo" width="105" height="25">
                                    <p>With nearly 40 years’ experience, Sixty9 proudly supplies with comfortable sportswear, specially designed accessories and quality footwear for better arch support during sports and exercise.</p>

                                    <div class="social-icons">
                                        <a href="javascript:void(0);" class="social-icon" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>
                                        <a href="javascript:void(0);" class="social-icon" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>
                                        <a href="javascript:void(0);" class="social-icon" title="Instagram" target="_blank"><i class="icon-instagram"></i></a>
                                        <a href="javascript:void(0);" class="social-icon" title="Youtube" target="_blank"><i class="icon-youtube"></i></a>
                                        <a href="javascript:void(0);" class="social-icon" title="Pinterest" target="_blank"><i class="icon-pinterest"></i></a>
                                    </div><!-- End .soial-icons -->
                                </div><!-- End .widget about-widget -->
                            </div><!-- End .col-sm-6 col-lg-3 -->

                            <div class="col-sm-6 col-lg-3">
                                <div class="widget">
                                    <h4 class="widget-title">Useful Links</h4><!-- End .widget-title -->

                                    <ul class="widget-list">
                                        <li><a href="about.php">About Sixty9</a></li>
                                        <li><a href="product.php">How to shop on Sixty9</a></li>
                                        <li><a href="javascript:void(0)">FAQ</a></li>
                                        <li><a href="contact.php">Contact us</a></li>
                                        <li><a href="login.php">Log in</a></li>
                                    </ul><!-- End .widget-list -->
                                </div><!-- End .widget -->
                            </div><!-- End .col-sm-6 col-lg-3 -->

                            <div class="col-sm-6 col-lg-3">
                                <div class="widget">
                                    <h4 class="widget-title">Customer Service</h4><!-- End .widget-title -->

                                    <ul class="widget-list">
                                        <li><a href="javascript:void(0);">Payment Methods</a></li>
                                        <li><a href="javascript:void(0);">Money-back guarantee!</a></li>
                                        <li><a href="javascript:void(0);">Returns</a></li>
                                        <li><a href="javascript:void(0);">Shipping</a></li>
                                        <li><a href="javascript:void(0);">Terms and conditions</a></li>
                                        <li><a href="javascript:void(0);">Privacy Policy</a></li>
                                    </ul><!-- End .widget-list -->
                                </div><!-- End .widget -->
                            </div><!-- End .col-sm-6 col-lg-3 -->

                            <div class="col-sm-6 col-lg-3">
                                <div class="widget">
                                    <h4 class="widget-title">My Account</h4><!-- End .widget-title -->

                                    <ul class="widget-list">
                                        <li><a href="login.php">Sign In</a></li>
                                        <li><a href="javascript:void(0);">Track My Order</a></li>
                                        <li><a href="javascript:void(0);">Help</a></li>
                                    </ul><!-- End .widget-list -->
                                </div><!-- End .widget -->
                            </div><!-- End .col-sm-6 col-lg-3 -->
                        </div><!-- End .row -->
                    </div><!-- End .container -->
                </div><!-- End .footer-middle -->

                <div class="footer-bottom">
                    <div class="container">
                        <p class="footer-copyright">Copyright © 2024 Sixty9 Sportswear. All Rights Reserved.</p><!-- End .footer-copyright -->
                        <figure class="footer-payments">
                            <img src="assets/images/payments.png" alt="Payment methods" width="272" height="20">
                        </figure><!-- End .footer-payments -->
                    </div><!-- End .container -->
                </div><!-- End .footer-bottom -->
            </footer><!-- End .footer -->
        </div><!-- End .page-wrapper -->
        <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>

        <!-- Mobile Menu -->
        <div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->

        <div class="mobile-menu-container">
            <div class="mobile-menu-wrapper">
                <span class="mobile-menu-close"><i class="icon-close"></i></span>

                <form action="./product.php"" method="post" class="mobile-search">
                    <label for="mobile-search" class="sr-only">Search</label>
                    <input type="search" class="form-control" name="searchname" id="mobile-search" placeholder="Search by product name..." required>
                    <button class="btn btn-primary" name="search" type="submit"><i class="icon-search"></i></button>
                </form>
                
                <nav class="mobile-nav">
                    <ul class="mobile-menu">
                        <li class="active">
                            <a href="./homepage.php">Home</a>
                        </li>
                        <li>
                            <a href="./about.php">About</a>
                        </li>
                        <li>
                            <a href="./product.php">Products</a>
                        </li>
                        <li>
                            <a href="./contact.php">Contact Us</a>
                        </li>
                    </ul>
                </nav><!-- End .mobile-nav -->

                <div class="social-icons">
                    <a href="#" class="social-icon" target="_blank" title="Facebook"><i class="icon-facebook-f"></i></a>
                    <a href="#" class="social-icon" target="_blank" title="Twitter"><i class="icon-twitter"></i></a>
                    <a href="#" class="social-icon" target="_blank" title="Instagram"><i class="icon-instagram"></i></a>
                    <a href="#" class="social-icon" target="_blank" title="Youtube"><i class="icon-youtube"></i></a>
                </div><!-- End .social-icons -->
            </div><!-- End .mobile-menu-wrapper -->
        </div><!-- End .mobile-menu-container -->

        <!-- Plugins JS File -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/jquery.hoverIntent.min.js"></script>
        <script src="assets/js/jquery.waypoints.min.js"></script>
        <script src="assets/js/owl.carousel.min.js"></script>
        <script src="assets/js/bootstrap-input-spinner.js"></script>
        <script src="assets/js/jquery.plugin.min.js"></script>
        <!-- Main JS File -->
        <script src="assets/js/main.js"></script>
        <script src="assets/js/demos/demo-10.js"></script>
    </body>

</html>