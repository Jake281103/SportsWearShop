<?php

use PHPUnit\Framework\TestCase;

require_once 'signup.php';

class SignupTest extends TestCase
{
    public function testRedirectsToEmailVerificationWithValidEmail()
    {
        $_GET['email'] = 'test@example.com';
        ob_start();
        header("Location: email-verification.php?email=" . $_GET['email']);
        $output = ob_get_clean();
        $this->assertStringContainsString('Location: email-verification.php?email=test@example.com', $output);
    }

    public function testRedirectsToEmailVerificationWithEmptyEmail()
    {
        $_GET['email'] = '';
        ob_start();
        header("Location: email-verification.php?email=" . $_GET['email']);
        $output = ob_get_clean();
        $this->assertStringContainsString('Location: email-verification.php?email=', $output);
    }

    public function testRedirectsToEmailVerificationWithInvalidEmail()
    {
        $_GET['email'] = 'invalid-email';
        ob_start();
        header("Location: email-verification.php?email=" . $_GET['email']);
        $output = ob_get_clean();
        $this->assertStringContainsString('Location: email-verification.php?email=invalid-email', $output);
    }
}
