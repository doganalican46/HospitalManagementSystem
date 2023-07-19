<?php
session_start();
$page_title = "Mail Page";
include("includes/header.php");
include("includes/navbar.php");
include("config/dbcon.php");
error_reporting(0); 
ini_set('display_errors', 0); 
?>

<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

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
        echo '<script>alert("Email sent successfully!");</script>';
        header("Location: admin-secretary.php");
    } catch (Exception $e) {
        echo '<script>alert("Failed to send email. Error: ' . $mail->ErrorInfo . '");</script>';
        header("Location: email-profile.php");
    }
}
?>

<div class="py-5 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php include("message.php"); ?>
                <div class="card">
                    <div class="card-header">
                        <b>Send E-Mail:</b>
                    </div>
                    <div class="card-body">
                        <form class="center_absolute display_grid" action="" method="post">

                            <?php
                            if (isset($_GET['id'])) {
                                $user_id = $_GET['id'];
                                $user = "SELECT * FROM users WHERE id='$user_id' ";
                                $user_run = mysqli_query($con, $user);
                                if (mysqli_num_rows($user_run) > 0) {
                                    foreach ($user_run as $row) {
                                        $name = $row['fullname'];
                                        $email = $row['email'];
                                        $password = $row['password'];
                                        $doctor_name = $row['doctor_name'];


                            ?>
                                        <?= $name ?>
                                        <input class="form-control mb-3" type="text" name="name" placeholder="Secretary Name" value="<?= $name ?>">
                                        <input class="form-control mb-3" type="email" name="email" placeholder="E-mail" value="<?= $email ?>">
                                        <input class="form-control mb-3" type="text" name="subject" placeholder="Subject" value="HMS-Login Information">
                                        <input class="form-control mb-3" type="text" name="message" placeholder="Enter Your Message" value=" Hello Secretary <?= $name ?>, your HMS-System login informations are; E-Mail:<?= $email ?> | Password:<?= $password ?> | Your doctor name: <?= $doctor_name ?>. Have a good day... [HMS-Admin]">

                                        
                    </div>
                    <div class="card-footer">
                                            <a href="admin-secretary.php" class="btn btn-danger float-start">Cancel</a>
                                            <button class="btn btn-primary float-end" type="submit" name="send">Send</button>
                                        </div>


                    </form>
        <?php }
                                }
                            } ?>
                </div>
            </div>
        </div>
    </div>






    <?php include("includes/footer.php"); ?>