<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer autoload files

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$secret = '6LcvergqAAAAADZu06rc0pYIbmUa08MACO865h21';  // Secret key for reCAPTCHA
$smtp_host = 'smtp.gmail.com';  // SMTP host
$smtp_user = 'kscool2015@gmail.com';  // SMTP username
$smtp_password = 'bipz dssa vnoi gxjt';  // SMTP password
$receiving_email = 'mubashersultanmehmmood@gmail.com';  // Recipient email

if (isset($_POST['name'], $_POST['designation'], $_POST['company'], $_POST['cell'], $_POST['email'], $_POST['address'], $_POST['message'], $_POST['g-recaptcha-response'])) {
    $response = $_POST['g-recaptcha-response'];
    $remoteip = $_SERVER['REMOTE_ADDR'];

    $verifyUrl = "https://www.google.com/recaptcha/api/siteverify";
    $responseKeys = json_decode(file_get_contents("$verifyUrl?secret=$secret&response=$response&remoteip=$remoteip"));

    if ($responseKeys->success) {
        // Sanitize and validate inputs
        $name = htmlspecialchars(trim($_POST['name']), ENT_QUOTES, 'UTF-8');
        $designation = htmlspecialchars(trim($_POST['designation']), ENT_QUOTES, 'UTF-8');
        $company = htmlspecialchars(trim($_POST['company']), ENT_QUOTES, 'UTF-8');
        $cell = htmlspecialchars(trim($_POST['cell']), ENT_QUOTES, 'UTF-8');
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        $address = htmlspecialchars(trim($_POST['address']), ENT_QUOTES, 'UTF-8');
        $message = htmlspecialchars(trim($_POST['message']), ENT_QUOTES, 'UTF-8');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die("Invalid email format.");
        }

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = $smtp_host;
            $mail->SMTPAuth = true;
            $mail->Username = $smtp_user;
            $mail->Password = $smtp_password;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom($email, 'Contact Form');
            $mail->addAddress($receiving_email);  
            $mail->addReplyTo($email, $name);  // Set the Reply-To header
            $mail->addCustomHeader('X-Mailer', 'PHP/' . phpversion());  // Set X-Mailer header

            $mail->isHTML(true);
            $mail->Subject = 'Contact Form Submission from ' . $name;
            $mail->Body = "Name: $name<br>Designation: $designation<br>Company: $company<br>Cell Phone: $cell<br>Email: $email<br>Address: $address<br><br><strong>Message:</strong><br>$message";

            $mail->send();
            echo 'Your message has been sent successfully!';
        } catch (Exception $e) {
            error_log('Mailer Error: ' . $mail->ErrorInfo);
            echo 'Message could not be sent. Please try again later.';
        }
    } else {
        echo 'reCAPTCHA verification failed. Please try again.';
    }
} else {
    echo 'Invalid form submission. Please try again.';
}
?>
