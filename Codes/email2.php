<?php
session_start();
$page_title = "Appointment Page";
include("includes/header.php");
include("includes/navbar.php");
include("admin/config/dbcon.php");
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
                        <?php
                        if (isset($_GET['appointment_id'])) {
                            $appointment_id = $_GET['appointment_id'];
                            $email = "SELECT users.email,users.fullname, appointment_date, appointment_time, appointment.doctor_name
                            FROM appointment
                            JOIN users ON appointment.patient_name = users.fullname
                            WHERE appointment.appointment_id = '$appointment_id';
                            ";
                            $email_run = mysqli_query($con, $email);
                            if (mysqli_num_rows($email_run) > 0) {
                                foreach ($email_run as $row) {
                                    $name = $row['fullname'];
                                    $email = $row['email'];
                                    $appointment_date = $row['appointment_date'];
                                    $appointment_time = $row['appointment_time'];
                                    $doctor_name = $row['doctor_name'];
                        ?>

                                    <form class="center_absolute display_grid" action="emailcode.php" method="post">
                                        <input class="form-control mb-3" type="hidden" name="name" placeholder="Patient Name" value="<?= $name ?>">
                                        <input class="form-control mb-3" type="hidden" name="email" placeholder="E-mail" value="<?= $email ?>">
                                        <input class="form-control mb-3" type="hidden" name="subject" placeholder="Subject" value="HMS-Appointment Information">

                                        <input class="form-control mb-3" type="text" name="message" placeholder="Enter Your Message" value="Don't forget your appointment <?= $name ?>! You have appointment with doctor <?= $doctor_name ?>. Your appointment date: <?= $appointment_date ?> | Time: <?= $appointment_time ?>">


                    </div>

                    <div class="card-footer">
                        <a href="user-appointment.php" class="btn btn-danger float-start">Cancel</a>
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