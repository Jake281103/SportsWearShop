<?php

// show error
ini_set("display_errors", 1);

// connection with database
require_once "dbconnect.php";

$count = 1;

if (!isset($_SESSION)) {
    session_start(); // to create session if not exist
}

if (isset($_SESSION['verifycount'])) {
    $count = $count + $_SESSION['verifycount'];
    // unset($_SESSION['verifycount']);
}

if (isset($_POST["verify_email"])) {
    $email = $_POST["email"];
    $verification_code = $_POST["verification_code"];

    try {
        $conn = connect();
        $sql = "SELECT * FROM user WHERE email=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($count <= 6) {
            if ($user['verificationcode'] == $verification_code) {
                $sql = "UPDATE user SET emailverified=1 WHERE email=?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$email]);
                $_SESSION['email'] = $email;
                $_SESSION['customersignup_success'] = "You have successfully registered";
                unset($_SESSION['verifycount']);
                header("Location:homepage.php");
            } else {
                $_SESSION['verifycount'] = $count++;
                $_SESSION['email_verification_error'] = "Your verification code is incorrect";
                header("Location: email-verification.php?email=" . $email);
            }
        } else {
            $sql = "DELETE FROM user WHERE email=?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$email]);
            unset($_SESSION['verifycount']);
            $_SESSION['loginerror'] = "Please register with correct email.";
            header("Location: login.php");
        }

        $conn = null;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// echo $count;

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Sixty9 | Email Verify Page</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="540x15" href="assets/images/img/logo1.png">
    <style type="text/css">
        @media screen {
            @font-face {
                font-family: 'Lato';
                font-style: normal;
                font-weight: 400;
                src: local('Lato Regular'), local('Lato-Regular'), url(https://fonts.gstatic.com/s/lato/v11/qIIYRU-oROkIk8vfvxw6QvesZW2xOQ-xsNqO47m55DA.woff) format('woff');
            }

            @font-face {
                font-family: 'Lato';
                font-style: normal;
                font-weight: 700;
                src: local('Lato Bold'), local('Lato-Bold'), url(https://fonts.gstatic.com/s/lato/v11/qdgUG4U09HnJwhYI-uK18wLUuEpTyoUstqEm5AMlJo4.woff) format('woff');
            }

            @font-face {
                font-family: 'Lato';
                font-style: italic;
                font-weight: 400;
                src: local('Lato Italic'), local('Lato-Italic'), url(https://fonts.gstatic.com/s/lato/v11/RYyZNoeFgb0l7W3Vu1aSWOvvDin1pK8aKteLpeZ5c0A.woff) format('woff');
            }

            @font-face {
                font-family: 'Lato';
                font-style: italic;
                font-weight: 700;
                src: local('Lato Bold Italic'), local('Lato-BoldItalic'), url(https://fonts.gstatic.com/s/lato/v11/HkF_qI1x_noxlxhrhMQYELO3LdcAZYWl9Si6vvxL-qU.woff) format('woff');
            }
        }

        /* CLIENT-SPECIFIC STYLES */
        body,
        table,
        td,
        a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        table,
        td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        img {
            -ms-interpolation-mode: bicubic;
        }

        /* RESET STYLES */
        img {
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }

        table {
            border-collapse: collapse !important;
        }

        body {
            height: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }

        /* iOS BLUE LINKS */
        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        /* MOBILE STYLES */
        @media screen and (max-width:600px) {
            h1 {
                font-size: 32px !important;
                line-height: 32px !important;
            }
        }

        /* ANDROID CENTER FIX */
        div[style*="margin: 16px 0;"] {
            margin: 0 !important;
        }
    </style>
</head>

<body style="background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <!-- LOGO -->
        <tr>
            <td bgcolor="#0e6ba8" align="center">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td align="center" valign="top" style="padding: 40px 10px 40px 10px;"> </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#0e6ba8" align="center" style="padding: 0px 10px 0px 10px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td bgcolor="#ffffff" align="center" valign="top" style="padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;">
                            <h1 style="font-size: 48px; font-weight: 400; margin: 2;">Welcome!</h1> <img src=" https://img.icons8.com/clouds/100/000000/handshake.png" width="125" height="120" style="display: block; border: 0px;" />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td bgcolor="#ffffff" align="center" style="padding: 20px 30px 40px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                            <p style="margin: 0;">We're excited to have you get started. First, you need to confirm your account. Just press the button below.</p>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" align="left">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td bgcolor="#ffffff" align="center" style="padding: 20px 30px 60px 30px;">
                                        <table border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td align="center" style="border-radius: 3px;" bgcolor="#FFA73B">
                                                    <form action="./email-verification.php" method="post">
                                                        <?php if (isset($_GET['email'])) {  ?>
                                                            <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>" required>
                                                        <?php } ?>
                                                        <input type="text" name="verification_code" placeholder="Enter your verification code" required style="font-size: 18px; border: 1px solid #dddddd; height: 45px; padding: 0 20px; width: 270px; ">
                                                        <input type="submit" name="verify_email" value="Verify" style="background-color: #FFA73B; border: 0px solid #FFA73B; border-radius: 4px; border-top-left-radius: 0; border-bottom-left-radius: 0; font-weight: bold; font-size: 13px; font-family: Helvetica, Arial, sans-serif; text-decoration: none; padding: 12px 25px; border-color: #FFA73B; color: #ffffff; display: inline-block; margin-left: -5px; cursor:pointer;">
                                                    </form>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr> <!-- COPY -->
                </table>
            </td>
        </tr>
        <?php if (isset($_SESSION['email_verification_error'])) { ?>
            <tr>
                <td bgcolor="#f4f4f4" align="center" style="padding: 30px 10px 0px 10px;">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                        <tr>
                            <td bgcolor="#e56b6f" align="center" style="padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                                <h2 style="font-size: 20px; font-weight: 400; color: #111111; margin: 0;"><?php echo $_SESSION['email_verification_error'] ?></h2>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        <?php
            unset($_SESSION['email_verification_error']);
        }
        ?>
    </table>
</body>

</html>