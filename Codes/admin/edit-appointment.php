<?php
$page_title = "Edit-Appointment";
include("authentication.php");
include("includes/header.php");
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Page: </h1>
    <?php include('message.php'); ?>
    <?php


    if (isset($_GET['appointment_id'])) {
        $appointment_id = $_GET['appointment_id'];
        $appointment = "SELECT * FROM appointment WHERE appointment_id='$appointment_id' ";
        $appointment_run = mysqli_query($con, $appointment);
        if (mysqli_num_rows($appointment_run) > 0) {

            foreach ($appointment_run as $data) {
    ?>
                <form action="code.php" method="POST">
                    <input type="hidden" name="appointment_id" value="<?= $data['appointment_id']; ?>">

                    <div class="row">
                        <div class="col-md-12">

                            <div class="card mt-5">
                                <div class="card-header">
                                    <h4>Edit appointment: </h4>
                                </div>
                                <br>

                                <div class="row">
                                    <div class="col">
                                        <div class="card">
                                            <div class="card-header">Appointment Information</div>
                                            <div class="card-body">
                                                <p class="float-start"> <b>Patient Name:</b> <?= $data['patient_name']; ?> | Note: <?= $data['patient_note']; ?> <br> <b>Doctor Name:</b> <?= $data['doctor_name']; ?> | Note:<?= $data['doctor_note']; ?><br><b>Scheduled Date:</b> <?= $data['appointment_date']; ?><br> <b>Scheduled Time:</b> <?= $data['appointment_time']; ?> <br> <b>Speciality:</b> <?= $data['appointment_speciality']; ?> </p>
                                            </div>
                                            <div class="card-footer"></div>
                                        </div>
                                    </div>
                                </div>


                                <div class="card-body">

                                    <div class="form-group mt-2">
                                        <label for="appointmentDate">Select new Appointment Date:</label>
                                        <input class="form-control" type="date" name="appointment_date">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="availableTimes">Select New Time:</label>
                                        <?php
                                        $query = "SELECT slot FROM hms_slots ";
                                        $result = mysqli_query($con, $query);


                                        if ($result) {
                                            echo '<select name="slot" class="form-control">';
                                            echo '<option value="">--Select Slot--</option>';

                                            while ($data = mysqli_fetch_assoc($result)) {
                                                $slot = $data['slot'];
                                                echo '<option value="' . $slot . '">' . $slot . '</option>';
                                            }

                                            echo '</select>';
                                        }
                                        ?>
                                    </div>


                                </div>

                                <div class="card-footer">
                                    <div class="col-md-12 mb-3">

                                        <a href="admin-appointment.php" class="btn btn-danger">Cancel</a>
                                        <button type="submit" class="btn btn-primary" name="update_appointmentbtn2">Update</button>
                </form>
</div>
</div>

<?php
            }
        } else {
?>
<h4>No Record Found!</h4>
<?php
        }
    }
?>
</div>
</div>
</div>

<?php
include("includes/footer.php");
include("includes/scripts.php");
?>