<?php

// connection with database
require_once "dbconnect.php";

// call getuserdatafunction.php
require_once "commonfunctions.php";

// show error
ini_set("display_errors", 1);

$userid = '';
$email = '';
$name = '';

// change timezone as myanmar time
date_default_timezone_set("Asia/Yangon");

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
 
//Load Composer's autoloader
require 'vendor/autoload.php';

if (!isset($_SESSION)) {
    session_start(); // to create succes if not exist
}

if (!isset($_SESSION['email'])) {
    header("Location:homepage.php");
}else{
    $userid = getuser($_SESSION['email'])['id'];
    $email = $_SESSION['email'];
    $name = getuser($_SESSION['email'])['name'];
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['checkout'])) {
    $total = $_POST['total'];
    $cid = $userid;
    $cardnumber = $_POST['cardnum'];
    $cardname = $_POST['cardname'];
    $cardexp = $_POST['carddate'];
    $cardcvv = $_POST['cvv'];

    //Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        $conn = connect();
        $sql = "SELECT * FROM payment WHERE crnumber=? AND crname=? AND  expdate=? AND ccv=?";
        $stmt = $conn->prepare($sql);
        $status = $stmt->execute([$cardnumber, $cardname, $cardexp, $cardcvv]);
        $customer = $stmt->fetch();
        if ($stmt->rowCount() > 0) {

            // Insert data into order table
            $sql = "INSERT INTO orders (user_id,totalprice) VALUES (?,?)";
            $stmt = $conn->prepare($sql);
            $status = $stmt->execute([$cid, $total]);

            // get last order id
            $sql = "SELECT id FROM orders ORDER BY id DESC LIMIT 1";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $orders = $stmt->fetch();
            $orderid = $orders['id'];

            // get all cart products by user id
            $sql = "SELECT * FROM cart WHERE user_id=?";
            $stmt = $conn->prepare($sql);
            $status = $stmt->execute([$cid]);
            $products = $stmt->fetchAll();

            foreach ($products as $product) {
                $pid = $product['products_id'];
                echo $pid;
                $size = $product['size_id'];
                $quantity = $product['count'];
                $totalprice = $product['totalprice'];

                // Insert data into orderdetail table
                $sql = "INSERT INTO orderdetail (orders_id,products_id,quantity,totalprice) VALUES (?,?,?,?)";
                $stmt = $conn->prepare($sql);
                $status = $stmt->execute([$orderid, $pid, $quantity, $totalprice]);

                // Update quantity in stock table
                $sql = "UPDATE stock SET quantity=quantity-? WHERE products_id=? AND size_id=?";
                $stmt = $conn->prepare($sql);
                $status = $stmt->execute([$quantity, $pid, $size]);

            }

            // Delete cart products 
            $sql = "DELETE FROM cart WHERE user_id=?";
            $stmt = $conn->prepare($sql);
            $status = $stmt->execute([$cid]);
            $conn = null;

            //Enable verbose debug output
            $mail->SMTPDebug = 0;//SMTP::DEBUG_SERVER;
                
            //Send using SMTP
            $mail->isSMTP();
            
            //Set the SMTP server to send through
            $mail->Host = 'smtp.gmail.com';
            
            //Enable SMTP authentication
            $mail->SMTPAuth = true;
            
            //SMTP username
            $mail->Username = 'thawmaungoo@gmail.com';
            
            //SMTP password
            $mail->Password = 'wcfuoqgpqcuuhbdr';
            
            //Enable TLS encryption;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            
            //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            $mail->Port = 587;
            
            //Recipients
            $mail->setFrom('thawmaungoo123@gmail.com', 'sixty9sportswear.com');
            
            //Add a recipient
            $mail->addAddress($email, $name);
            
            //Set email format to HTML
            $mail->isHTML(true);
            
            $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
            
            $mail->Subject = 'Your Order is Successful!';
            $mail->Body    = '<p>Your Order Number is: <b style="font-size: 18px;">OID' . $orderid . '</b></p><p>Total Amount is : <b style="font-size: 18  px;">$' . $total . '</b></p>';
            
            $mail->send();
            // echo 'Message has been sent';

            $_SESSION['payment_success'] = "Your Order is Successful!!";
            header("Location: homepage.php");
        } else {
            $_SESSION['payment_fail'] = "Something Wrong, Check your information again!!";
            header("Location: cart.php");
        }

        $conn = null;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

?>