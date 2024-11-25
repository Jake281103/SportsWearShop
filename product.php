<?php

// connection with database
require_once "dbconnect.php";

// call getuserdatafunction.php
require_once "commonfunctions.php";


// show error
ini_set("display_errors", 1);

$userid = '';
$showproducts = '';

if (!isset($_SESSION)) {
    session_start(); // to create succes if not exist
}

if(isset($_SESSION['email'])){
    $userid = getuser($_SESSION['email'])['id'];
}

if(!isset($_SESSION['showcount'])) {
    $_SESSION['showcount'] = '8';
}


function getlastproducts($count){
    try {
        $conn = connect();
        $sql = "SELECT * FROM products ORDER BY id DESC LIMIT $count";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $products = $stmt->fetchAll();
        return $products;
        $conn = null;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function getfirstproducts($count){
    try {
        $conn = connect();
        $sql = "SELECT * FROM products ORDER BY id ASC LIMIT $count";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $products = $stmt->fetchAll();
        return $products;
        $conn = null;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['addcount'])) {
    $_SESSION['showcount'] = $_SESSION['showcount'] + $_GET['addcount'];
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['filter'])) {
    $type = $_POST['sortby'];
    try {
        $conn = connect();
        $sql = "SELECT * FROM products WHERE type=? ORDER BY id ASC";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$type]);
        $showproducts = $stmt->fetchAll();
        $conn = null;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}elseif($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['filterbtn'])){
    $category = $_POST['filtercategory'];
    $minprice = $_POST['lowprice'];
    $maxprice = $_POST['highprice'];
    try {
        $conn = connect();
        $sql = "SELECT * FROM products WHERE category_id=? AND price BETWEEN ? AND ? ORDER BY id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$category, $minprice, $maxprice]);
        $showproducts = $stmt->fetchAll();
        $conn = null;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}elseif($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['searchname'])){
    $poductname = $_POST['searchname'];
    try {
        $conn = connect();
        $sql = "SELECT * FROM products WHERE name LIKE '%$poductname%' ORDER BY id";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $showproducts = $stmt->fetchAll();
        $conn = null;
    } catch (PDOException $e) {
        echo $e->getMessage();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}else{
    $showproducts = getfirstproducts($_SESSION['showcount']);
}


$categorys = getcategory();
$lastproducts = getlastproducts(10);

// echo $_SESSION['showcount'];

?>


<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <title>Sixty9 | Product Page</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="540x15" href="./assets/images/img/logo1.png">
    <!-- fontawesome Css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- Main CSS File -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/skins/skin-demo-10.css">
    <link rel="stylesheet" href="assets/css/demos/demo-10.css">
    <link rel="stylesheet" href="assets/css/plugins/owl-carousel/owl.carousel.css">
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
                                        <li><a href="about.php">About Us</a></li>
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
                                    <li>
                                        <a href="./homepage.php" class="">Home</a>
                                    </li>
                                    <li>
                                        <a href="./about.php" class="">About</a>
                                    </li>
                                    <li class="megamenu-container active">
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
        <main class="main">
        	<div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title">Sxity9 Sportswear<span>Shop</span></h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->

            <div class="page-content mt-3">
                <div class="container">
        			<div class="toolbox pb-1">
        				<div class="toolbox-left">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="./home">Home</a></li>
                                <li class="breadcrumb-item"><a href="./product.php">Products</a></li>
                            </ol>
        				</div><!-- End .toolbox-left -->

        				<div class="toolbox-right">
        					<div class="toolbox-sort">
        						<form action="./product.php" method="POST">
                                    <div class="d-flex align-items-center">
                                        <div class="select-custom d-flex align-items-center">
                                            <label for="sortby">Category by:</label>
                                            <select name="sortby" id="sortby" class="form-control">
                                                <option selected value="male">Man</option>
                                                <option value="female">Woman</option>
                                            </select>
                                        </div>
                                        <button type="submit" name="filter" class="mx-2">Submit</button>
                                    </div>
                                </form>
                                <button class="mx-2" data-toggle="modal" data-target="#exampleModalCenter"><i class="fas fa-filter mr-2"></i>Filter</button>  
        					</div><!-- End .toolbox-sort -->
        				</div><!-- End .toolbox-right -->
        			</div><!-- End .toolbox -->

                    <div class="products">
                        <div class="row">
                        <?php if($showproducts != null){ ?>
                            <?php foreach($showproducts as $showproduct){ ?>
                                <div class="col-6 col-md-4 col-lg-4 col-xl-3 p-3 border-0">
                                    <div class="product product-3 text-center border shadow">
                                        <figure class="product-media">
                                            <?php foreach($lastproducts as $lastproduct) {?>
                                                <?php if($lastproduct['id'] == $showproduct['id']){ ?>
                                                    <span class="product-label label-primary">New</span>
                                                <?php } ?>
                                            <?php } ?>
                                            <a href="product.html">
                                                <img src="<?php echo $showproduct['url'] ?>" alt="Product image" class="product-image">
                                            </a>
                                        </figure><!-- End .product-media -->
                                        <div class="product-body">
                                            <div class="product-cat">
                                                <a href="javascript:void(0);">
                                                    <?php 
                                                    foreach($categorys as $category){
                                                        if($showproduct['category_id'] == $category['id']){
                                                            echo ucwords($category['name']);
                                                        }
                                                    }
                                                    ?>
                                                </a>
                                            </div><!-- End .product-cat -->
                                            <h3 class="product-title"><a href="./productdetail.php?pid=<?php echo $showproduct['id'] ?>"><?php echo $showproduct['name'] ?></a></h3><!-- End .product-title -->
                                            <div class="product-price">
                                                <span class="new-price">$<?php echo $showproduct['price'] ?></span>
                                            </div><!-- End .product-price -->
                                        </div><!-- End .product-body -->
                                        <div class="product-footer">
                                            <div class="product-action">
                                                <a href="./productdetail.php?pid=<?php echo $showproduct['id'] ?>" class="btn-product"><span>View</span></a>
                                            </div><!-- End .product-action -->
                                        </div><!-- End .product-footer -->
                                    </div><!-- End .product -->
                                </div><!-- End .col-sm-6 col-lg-4 col-xl-3 -->
                        <?php } ?>
                        <?php }else{ ?>
                            <div class="text-center pt-5">
                                <h3>No Product Found</h3>
                            </div>
                        <?php } ?>
                        </div><!-- End .row -->

                        <?php if(!( isset($_POST['filter'] ) || isset($_POST['filterbtn']) || isset($_POST['searchname']) )){ ?>
                            <div class="load-more-container text-center">
                                <a href="./product.php?addcount=8" class="btn btn-outline-darker btn-load-more">More Products <i class="icon-refresh"></i></a>
                            </div><!-- End .load-more-container -->
                        <?php } ?>
                    </div><!-- End .products -->

                </div><!-- End .container -->
            </div><!-- End .page-content -->
        </main><!-- End .main -->

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
                        <li>
                            <a href="./homepage.php">Home</a>
                        </li>
                        <li>
                            <a href="./about.php">About</a>
                        </li>
                        <li class="active">
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

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Product Filter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-5">
                <!-- <form action="./product.php" method="post">
                    <input type="text" name="" placeholder="product name..">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </form> -->
                <form action="./product.php" method="post">
                    <div class="form-group">
                        <label for="inputState">Category</label>
                        <select id="inputState" class="form-control" name="filtercategory" required>
                            <option disabled selected>Choose...</option>
                            <?php foreach($categorys as $category): ?>
                                <option value="<?php echo $category['id'] ?>"><?php echo $category['name'] ?></option>
                            <?php endforeach; ?>  
                        </select>
                    </div>
                    <div class="row pb-2">
                        <div class="col-6">
                            <label for="lowprice">Min Price</label>
                            <input type="number" step="0.01" class="form-control" min="<?php echo getminprice()['lowest_price'] ?>" max="<?php echo getmaxprice()['highest_price'] ?>"  id="lowprice" name="lowprice" required>
                        </div>
                        <div class="col-6">
                            <label for="highprice">Max Price</label>
                            <input type="number" step="0.01" class="form-control" min="<?php echo getminprice()['lowest_price'] ?>" max="<?php echo getmaxprice()['highest_price'] ?>" id="highprice" name="highprice" required>
                        </div>
                    </div>
                    <button type="submit" name="filterbtn" class="btn btn-secondary">Filter</button>
                    <button type="reset" class="btn btn-danger">Reset</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>

    <!-- Plugins JS File -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery.hoverIntent.min.js"></script>
    <script src="assets/js/jquery.waypoints.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/jquery.plugin.min.js"></script>
    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>
    <script src="assets/js/demos/demo-10.js"></script>
    
</body>


<!-- molla/category-boxed.html  22 Nov 2019 10:03:02 GMT -->
</html>