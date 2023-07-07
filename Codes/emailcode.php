<?php
include("admin/config/dbcon.php");
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
if (isset($_POST['send'])) {
    $name = htmlentities($_POST['name']);
    $email = htmlentities($_POST['email']);
    $subject = htmlentities($_POST['subject']);
    $message = htmlentities($_POST['message']);
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'alicanalican4141@gmail.com';
    $mail->Password = 'ddbrgvaeutlqwcxo';
    $mail->Port = 465;
    $mail->SMTPSecure = 'ssl';
    $mail->isHTML(true);
    $mail->setFrom($email, $name);
    $mail->addAddress($email);
    $mail->Subject = ("$email ($subject)");
    $mail->Body = $message;
    $mail->send();
    try {
        $mail->send();
        $_SESSION['message'] = "Email sent successfully!";
        header("Location: user-appointment.php");
        
    } catch (Exception $e) {
        $_SESSION['message'] = "Failed to send email!";
        header("Location: email2.php");
    }
}
