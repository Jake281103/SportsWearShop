<?php

// show error
ini_set("display_errors", 1);

// connection with database
require_once "dbconnect.php";

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
 
//Load Composer's autoloader
require 'vendor/autoload.php';

if (!isset($_SESSION)) {
    session_start(); // to create session if not exist
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

function textfilter($data)
{
    $data = trim($data);
    $data = htmlspecialchars($data);
    $data = stripslashes($data);
    return $data;
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

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['signup'])) {

    $name = textfilter($_POST['name']);
    $phonenumber = textfilter($_POST['phonenumber']);
    $email = textfilter($_POST['email']);
    $address = textfilter($_POST['address']);
    $password = textfilter($_POST['password']);
    $hascode = null;

    //Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        $conn = connect();
        $sql = "SELECT * FROM user WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $status = $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            // echo "has be registered";
            $_SESSION['email_exit'] = "Your email has already been registered";
            header("Location:login.php");
        } else {
            // echo "new Customer";
            if (ispasswordstrong($password)) {

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
                
                $mail->Subject = 'Email verification';
                $mail->Body    = '<p>Your verification code is: <b style="font-size: 30px;">' . $verification_code . '</b></p>';
                
                $mail->send();
                // echo 'Message has been sent';

                $hascode = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("INSERT INTO user (name,phonenumber,email,address,password,verificationcode) VALUES(:name, :phonenumber, :email, :address, :password, :code)");
                $stmt->bindValue(':name', $name);
                $stmt->bindValue(':phonenumber', $phonenumber);
                $stmt->bindValue(':email', $email);
                $stmt->bindValue(':address', $address);
                $stmt->bindValue(':password', $hascode);
                $stmt->bindValue(':code', $verification_code);
                $stmt->execute();
                header("Location: email-verification.php?email=" . $email);
                exit();
            }else{
                $_SESSION['password_not_strong'] = "Your password is not strong enough";
                header("Location:login.php");
            }
        }
        $conn = null;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

?>
