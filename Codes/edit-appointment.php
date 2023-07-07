<?php
session_start();
$page_title = "Edit Appointment Page";
include("includes/header.php");
include("includes/navbar.php");
include("admin/config/dbcon.php");
?>

<div class="py-5 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php include("message.php"); ?>
                <h3>Edit Appointment Page:</h3>




                <?php if ($_SESSION['auth_role'] == 0) : //patient
                ?>


                    <div class="card mt-3">
                        <div class="card-header">
                            Change Appointment Settings:
                        </div>


                        <div class="card-body">


                            <?php

                            if (isset($_GET['appointment_id'])) {
                                $user_id = $_GET['appointment_id'];
                                $appoinment = "SELECT * FROM appointment WHERE appointment_id='$user_id' ";
                                $appoinment_run = mysqli_query($con, $appoinment);
                                if (mysqli_num_rows($appoinment_run) > 0) {

                                    foreach ($appoinment_run as $aaaa) {

                            ?>
                                        <div class="row">
                                            <div class="col">
                                                <div class="card">
                                                    <div class="card-header">Appointment İnformation</div>
                                                    <div class="card-body">
                                                        <p class="float-start"> <b>Appointment Owner:</b> <?= $_SESSION['auth_user']['fullname'];  ?> <br> <b>Scheduled Date:</b> <?= $aaaa['appointment_date']; ?><br> <b>Scheduled Time:</b> <?= $aaaa['appointment_time']; ?> <br> <b>Speciality:</b> <?= $aaaa['appointment_speciality']; ?> <br> <b>Doctor:</b> <?= $aaaa['doctor_name']; ?> </p>
                                                    </div>
                                                    <div class="card-footer"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col">
                                                <form action="allcode.php" method="POST">
                                                    <input type="hidden" name="appointment_id" value="<?= $aaaa['appointment_id']; ?>">






                                                    <div class="form-group mt-2">
                                                        <label for="appointmentDate">Select Appointment Date:</label>
                                                        <?php //displayCalendar(); 
                                                        ?>
                                                        <input class="form-control" type="date" name="appointment_date" value="<?= $aaaa['appointment_date']; ?>" id="appointment_date">

                                                    </div>

                                                    <div class="form-group mt-2">
                                                        <label for="availableTimes">Available Times:</label>
                                                        <?php
                                                        $query = "SELECT slot FROM hms_slots ";
                                                        $result = mysqli_query($con, $query);


                                                        if ($result) {
                                                            echo '<select name="slot" class="form-control">';
                                                            echo '<option value="' . $aaaa['appointment_time'] . '">--Select Slot--</option>';

                                                            while ($data = mysqli_fetch_assoc($result)) {
                                                                $slot = $data['slot'];
                                                                echo '<option value="' . $slot . '">' . $slot . '</option>';
                                                            }

                                                            echo '</select>';
                                                        }
                                                        ?>
                                                    </div>

                                                    <div class="form-group mt-2">
                                                        <label for="patient_note">Write a brief note to the doctor:</label>
                                                        <input class="form-control" name="patient_note" placeholder="Write your comment..." type="text" value="<?= $aaaa['patient_note']; ?>">
                                                    </div>
                                            </div>
                                        </div>
                        </div>


                        <div class="card-footer">
                            <a class="btn btn-danger" href="user-appointment.php">Cancel</a>
                            <button type="submit" class="btn btn-primary" name="update_appointmentbtn">Save</button>
                        </div>
                        </form>
            <?php }
                                }
                            } ?>
                    </div>



                <?php elseif ($_SESSION['auth_role'] == 2) : //doctor
                ?>

                    <div class="card mt-3">
                        <div class="card-header">
                            <b>Appointment Details:</b>
                        </div>


                        <div class="card-body">

                            <?php

                            if (isset($_GET['appointment_id'])) {
                                $user_id = $_GET['appointment_id'];
                                $appoinment = "SELECT * FROM appointment WHERE appointment_id='$user_id' ";
                                $appoinment_run = mysqli_query($con, $appoinment);
                                if (mysqli_num_rows($appoinment_run) > 0) {

                                    foreach ($appoinment_run as $bbbb) {
                            ?>

                                        <form action="allcode.php" method="POST">
                                            <input type="hidden" name="appointment_id" value="<?= $bbbb['appointment_id']; ?>">
                                            <p> <b>Appointment Owner:</b> <?= $bbbb['patient_name']; ?> | <b>Old Time:</b> <?= $bbbb['appointment_time']; ?></p>

                                            <div class="form-group mt-2">
                                                <label for="appointmentDate">Change Appointment Date:</label>
                                                <?php //displayCalendar(); 
                                                ?>
                                                <input class="form-control" type="date" name="appointment_date" value="<?= $bbbb['appointment_date']; ?>" id="appointment_date">

                                            </div>

                                            <div class="form-group mt-2">
                                                <label for="availableTimes">Change Appointment Time:</label>
                                                <?php
                                                $query = "SELECT slot FROM hms_slots ";
                                                $result = mysqli_query($con, $query);


                                                if ($result) {
                                                    echo '<select name="slot" class="form-control">';
                                                    echo '<option value="' . $bbbb['appointment_time'] . '">--Select Slot--</option>';

                                                    while ($data = mysqli_fetch_assoc($result)) {
                                                        $slot = $data['slot'];
                                                        echo '<option value="' . $slot . '">' . $slot . '</option>';
                                                    }

                                                    echo '</select>';
                                                }
                                                ?>
                                            </div>

                                            <div class="form-group mt-2">
                                                <label for="doctor_note">Write a brief note to the patient:</label>
                                                <input class="form-control" name="doctor_note" placeholder="Write your comment..." type="text" value="<?= $bbbb['doctor_note']; ?>">
                                            </div>
                        </div>


                        <div class="card-footer">
                            <a class="btn btn-danger " href="user-appointment.php">Cancel</a>
                            <button type="submit" class="btn btn-primary" name="update_doctorappointmentbtn">Save</button>
                        </div>
                        </form>
            <?php }
                                }
                            } ?>
                    </div>







                <?php elseif ($_SESSION['auth_role'] == 3) : //secretary
                ?>


                    <div class="card mt-3">
                        <div class="card-header">
                            <b>Appointment Details:</b>
                        </div>


                        <div class="card-body">

                            <?php

                            if (isset($_GET['appointment_id'])) {
                                $user_id = $_GET['appointment_id'];
                                $appoinment = "SELECT * FROM appointment WHERE appointment_id='$user_id' ";
                                $appoinment_run = mysqli_query($con, $appoinment);
                                if (mysqli_num_rows($appoinment_run) > 0) {

                                    foreach ($appoinment_run as $bbbb) {
                            ?>

                                        <form action="allcode.php" method="POST">
                                            <input type="hidden" name="appointment_id" value="<?= $bbbb['appointment_id']; ?>">
                                            <p> <b>Appointment Owner:</b> <?= $bbbb['patient_name']; ?> | <b>Old Time:</b> <?= $bbbb['appointment_time']; ?></p>

                                            <div class="form-group mt-2">
                                                <label for="appointmentDate">Change Appointment Date:</label>
                                                <?php //displayCalendar(); 
                                                ?>
                                                <input class="form-control" type="date" name="appointment_date" value="<?= $bbbb['appointment_date']; ?>" id="appointment_date">

                                            </div>

                                            <div class="form-group mt-2">
                                                <label for="availableTimes">Change Appointment Time:</label>
                                                <?php
                                                $query = "SELECT slot FROM hms_slots ";
                                                $result = mysqli_query($con, $query);


                                                if ($result) {
                                                    echo '<select name="slot" class="form-control">';
                                                    echo '<option value="' . $bbbb['appointment_time'] . '">--Select Slot--</option>';

                                                    while ($data = mysqli_fetch_assoc($result)) {
                                                        $slot = $data['slot'];
                                                        echo '<option value="' . $slot . '">' . $slot . '</option>';
                                                    }

                                                    echo '</select>';
                                                }
                                                ?>
                                            </div>

                                            <div class="form-group mt-2">
                                                <label for="doctor_note">Write a brief note to the doctor:</label>
                                                <input class="form-control" name="secretary_note" placeholder="Write your comment..." type="text" value="<?= $bbbb['secretary_note']; ?>">
                                            </div>
                        </div>


                        <div class="card-footer">
                            <a class="btn btn-danger " href="user-appointment.php">Cancel</a>
                            <button type="submit" class="btn btn-primary" name="update_doctorappointmentbtn2">Save</button>
                        </div>
                        </form>
            <?php }
                                }
                            } ?>
                    </div>




                <?php endif; ?>



            </div>
        </div>
    </div>
</div>
</div>


<?php include("includes/footer.php"); ?>