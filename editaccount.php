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

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['accountupdate'])) {
        $name = htmlspecialchars($_POST['name']);
        $phonenumber = htmlspecialchars($_POST['phone']);
        $profile = $_FILES['profile'];
        updateaccount($name, $phonenumber, $email, $profile);
    } elseif ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['changepassword'])) {
        $currentpassword = htmlspecialchars($_POST['currentpassword']);
        $newpassword = htmlspecialchars($_POST['newpassword']);
        $confirmpassword = htmlspecialchars($_POST['confirmpassword']);
        if (password_verify($currentpassword, $user['password'])) {
            if ($newpassword == $confirmpassword) {
                if (ispasswordstrong($newpassword)) {
                    changepassword($newpassword, $email);
                } else {
                    $_SESSION['newpwd_not_strong'] = 'Password is not strong. Try again';
                }
            } else {
                $_SESSION['pwd_not_same'] = "New and Confirm Passwords are not the same";
            }
        } else {
            $_SESSION['currentpwd_fail'] = "Your current password is not correct";
        }
    }
}

function updateaccount($name, $phonenumber, $email, $profile)
{
    $prevprofileurl = checkprofileurl($email);
    if ($prevprofileurl != null) {
        unlink($prevprofileurl);
    }
    $date = new DateTimeImmutable();
    $datetime = $date->format('l-jS-F-Y-');
    $rdm = rand();
    $filename = $profile['name'];
    echo $filename; 
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    // $uploadpath = $location . $datetime . $rdm . "." . $ext;
    $uploadpath = "./assets/images/img/profile/" . $datetime . $rdm . "." . $ext;
    if (move_uploaded_file($profile['tmp_name'], $uploadpath)) {
        try {
            $conn = connect();
            $sql = "UPDATE user SET name=?, phonenumber=?, profile=? where email=?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$name, $phonenumber, $uploadpath, $email]);
            $_SESSION['updateaccount'] = "Update Account Info Successfully";
            $conn = null;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}

function checkprofileurl($email)
{
    try {
        $conn = connect();
        $sql = "SELECT profile FROM user WHERE email=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email]);
        $url = $stmt->fetch();
        $profileurl = $url['profile'];
        return $profileurl;
        $conn = null;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function changepassword($password, $email)
{
    try {
        $conn = connect();
        $hashcode = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE user SET password=? where email=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$hashcode, $email]);
        $_SESSION['changepassword'] = "Password has been change successfully";
        $conn = null;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function ispasswordstrong($password)
{
    if (strlen($password) < 8) {
        return false;
    } elseif (isstrong($password)) {
        return true;
    } else {
        return false;
    }
}

function isstrong($password)
{
    $digitcount = 0;
    $capitalcount = 0;
    $speccount = 0;
    $lowercount = 0;
    foreach (str_split($password) as $char) {
        if (is_numeric($char)) {
            $digitcount++;
        } elseif (ctype_upper($char)) {
            $capitalcount++;
        } elseif (ctype_lower($char)) {
            $lowercount++;
        } elseif (ctype_punct($char)) {
            $speccount++;
        }
    }

    if ($digitcount >= 1 && $capitalcount >= 1 && $speccount >= 1) {
        return true;
    } else {
        return false;
    }
}


// get message if messages sessions exist
if(isset($_SESSION['changepassword'])){
    $message = $_SESSION['changepassword'];
} elseif(isset($_SESSION['currentpwd_fail'])){
    $message = $_SESSION['currentpwd_fail'];
} elseif(isset($_SESSION['pwd_not_same'])){
    $message = $_SESSION['pwd_not_same'];
} elseif(isset($_SESSION['newpwd_not_strong'])){
    $message = $_SESSION['newpwd_not_strong'];
} elseif(isset($_SESSION['updateaccount'])){
    $message = $_SESSION['updateaccount'];
}



// var_dump($user);

?>


<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Sixty9 | Account Edit Page</title>
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
        <link href="./assets/css/user.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="./assets/css/toast.css">
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

                        <!-- start leftside bar -->
                        <div class="col-lg-3 col-md-4 border userleftsidebars">

                            <div class="row">
                                <div class="col-12 border-bottom py-3 ps-5">
                                    <a href="./account.php" class="nav-link">
                                        <i class="fas fa-user f-size-18 mr-3 text-center"></i>
                                        <span class="h5">Profile</span>
                                    </a>
                                </div>
                                <div class="col-12 border-bottom py-3 ps-5">
                                    <a href="./orderrecord.php" class="nav-link">
                                        <i class="fas fa-box-open f-size-18 mr-3 text-center"></i>
                                        <span class="h5 text-dark">My Order</span>
                                    </a>
                                </div>
                                <div class="col-12 border-bottom py-3 ps-5 bordersuccesses">
                                    <a href="./editaccount.php" class="nav-link text-primary">
                                        <i class="fas fa-user-edit mr-3 f-size-18 text-center"></i>
                                        <span class="h5 text-dark">Edit Account</span>
                                    </a>
                                </div>
                            </div>

                        </div>
                        <!-- end leftside bar -->

                        <!-- start contact area -->
                        <div class="col-lg-9 col-md-8 col-sm-11 mx-auto my-4">

                            <div class="row justify-content-center align-items-center">

                                <div class="col-lg-10 col-md-11 ">

                                    <div class="row">
                                        <div class="col-12 p-0 py-1">
                                            <p class="text-secondary">Home > <span class="fw-bold">Edit Account</span></p>
                                        </div>

                                        <div class="col-12 p-0 py-3">
                                            <h2>Edit Account</h2>
                                        </div>

                                        <div class="col-12 p-0 py-3">
                                            <div class="card shadow p-3">
                                                <div class="card-header bg-white">
                                                    <div class="d-flex justify-content-between align-items-center py-2">
                                                        <?php if ($user['profile'] != null) { ?>
                                                            <img src="<?php echo $user['profile'] ?>" class="rounded-circle" width="60" alt="user<?php echo $user['id'] ?>" />
                                                        <?php } else { ?>
                                                            <img src="./assets/images/img/avator.png" class="rounded-circle" width="60" alt="defaultprofile" />
                                                        <?php } ?>
                                                        <a href="./profile.php" class="small text-dark text-uppercase link-underline-dark">go to dashboard</a>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row justify-content-center ps-3">
                                                        <div class="col-lg-7">
                                                            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                                                                <table class="mt-4 mb-3">
                                                                    <th class="pb-3">Edit Account</th>
                                                                    <tr>
                                                                        <td class="h6 pe-4 py-3"><label for="name"><i class="fas fa-user"></i> Name:</label></td>
                                                                        <td class="small py-2"><input type="text" name="name" id="name" class="form-control" required /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="h6 pe-4 py-3"><label for="phone"><i class="fas fa-phone-alt"></i> Phone:</label></td>
                                                                        <td class="small py-2"><input type="text" name="phone" id="phone" class="form-control" minlength="9" maxlength="11" required /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="h6 pe-4 py-3"><label for="profile"><i class="fas fa-images"></i> Profile:</label></td>
                                                                        <td class="small py-2"><input type="file" name="profile" id="profile" class="form-control" accept="image/png, image/jpeg, image/jpg" placeholder="Only png, jpeg and jpg file" required /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="h6 pe-4 py-3"><button type="submit" class="btn btn-secondary px-4" name="accountupdate">Edit</button></td>
                                                                        <td class="small py-2"><button type="reset" class="btn btn-danger">Cancel</button></td>
                                                                    </tr>
                                                                </table>
                                                            </form>
                                                        </div>
                                                        <div class="col-lg-7">
                                                            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                                                                <table class="mt-4 mb-3">
                                                                    <th class="pb-3">Change Password</th>
                                                                    <tr>
                                                                        <td class="h6 pe-4 py-3"><label for="currentpassword"><i class="fas fa-key"></i> Current:</label></td>
                                                                        <td class="small py-2"><input type="password" name="currentpassword" id="currentpassword" class="form-control" required /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="h6 pe-4 py-3"><label for="newpassword"><i class="fas fa-unlock-alt"></i> New:</label></td>
                                                                        <td class="small py-2"><input type="password" name="newpassword" id="newpassword" class="form-control" required /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="h6 pe-4 py-3"><label for="confirmpassword"><i class="fas fa-unlock-alt"></i> Confirm:</label></td>
                                                                        <td class="small py-2"><input type="password" name="confirmpassword" id="confirmpassword" class="form-control" required /></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="h6 pe-4 py-3"><button type="submit" class="btn btn-success px-4" name="changepassword">Edit</button></td>
                                                                        <td class="small py-2"><button type="reset" class="btn btn-danger">Cancel</button></td>
                                                                    </tr>
                                                                </table>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer bg-white py-4">
                                                    <a href="./logout.php" class="small text-dark text-uppercase link-underline-dark">Log out</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>
                        <!-- end contact area -->


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

        <?php if($message != null) {?>
            <div class="toasts actives">
                <div class="toast-contents">
                    <?php if(isset($_SESSION['changepassword']) || isset($_SESSION['updateaccount'])) {?>
                        <i class="fas fa-check check"></i>
                    <?php }else{?>
                        <i class="fas fa-times check bg-danger"></i>
                    <?php } ?>

                    <div class="message">
                    <?php if(isset($_SESSION['changepassword']) || isset($_SESSION['updateaccount'])) {?>
                        <span class="text text-1">Success</span>
                    <?php }else{?>
                        <span class="text text-1">Fail</span>
                    <?php } ?>
                    <span class="text text-2"><?php echo $message ?></span>
                    </div>
                </div>
                <i class="fas fa-times closes"></i>

                <div class="progress actives"></div>
            </div>
        <?php 
            unset($_SESSION['changepassword']);
            unset($_SESSION['currentpwd_fail']);
            unset($_SESSION['pwd_not_same']);
            unset($_SESSION['newpwd_not_strong']);
            unset($_SESSION['updateaccount']);
            $message = '';
        } 
        ?>

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
        <script src="assets/js/toast.js"></script>
    </body>

</html>