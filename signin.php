<?php

// connection with database
require_once "dbconnect.php";

// show error
ini_set("display_errors", 1);

if(!isset($_SESSION)){
    session_start();
}

function textfilter($data)
{
    $data = trim($data);
    $data = htmlspecialchars($data);
    $data = stripslashes($data);
    return $data;
}

if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['login'])){
    $email = textfilter($_POST['email']);
    $password = textfilter($_POST['password']);

    try{
        $conn = connect();
        $sql = "SELECT * FROM user WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $status = $stmt->execute([$email]);
        $customer = $stmt->fetch();
        if($stmt->rowCount() > 0){
            if(password_verify($password, $customer['password'])){
                if($customer['emailverified'] == 1){
                    $_SESSION['customerlogin_success'] = "You have successfully logged in";
                    $_SESSION['email'] = $email;
                    header("Location: homepage.php");
                }else{
                    $_SESSION['loginerror'] = "Please verify your email to login";
                    $_SESSION['email_verification_error'] = "Please verify your email to login";
                    header("Location: email-verification.php?email=" . $email);
                }
            }else{
                $_SESSION['loginerror'] = "Your Password might be incorrect";
                header("Location:login.php");
            }
        }else{
            $_SESSION['loginerror'] = "Your email might be incorrect";
            header("Location:login.php");
        }

        $conn = null;

    }catch(PDOException $e){
        echo $e->getMessage();
    }


}



?>