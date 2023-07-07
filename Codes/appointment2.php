<?php
session_start();
$page_title = "Appointment Creation Page";
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
                        <h6>Make an Appointment</h6>
                    </div>
                    <div class="card-body">
                        <h3>Now, select doctor...</h3>
                        <form action="appointment_code.php" method="post" id="appointmentForm">
                            <?php
                            if (isset($_GET['appointment_id'])) {
                                $appointment_id = $_GET['appointment_id'];
                            } else {
                                echo "Appointment ID not found.";
                                exit;
                            }
                            ?>
                            <input type="hidden" name="appointment_id" value="<?php echo $appointment_id; ?>">
                            <div class="row no-gutters">
                                <div class="col-md-8">
                                    <div class="form-group mt-2">
                                        <?php
                                        $get_appointment = "SELECT * FROM appointment WHERE appointment_id='$appointment_id'";
                                        $run_appointment = mysqli_query($con, $get_appointment);
                                        $row_appointment = mysqli_fetch_array($run_appointment);
                                        $speciality = $row_appointment['appointment_speciality'];

                                        $query = "SELECT fullname FROM users WHERE role_as='2' AND speciality='$speciality'";
                                        $result = mysqli_query($con, $query);
                                        echo '<label for="availableTimes">Doctor:</label>';

                                        if ($result) {
                                            echo '<select name="doctor" class="form-control">';
                                            echo '<option value="">--Select Doctor--</option>';

                                            while ($data = mysqli_fetch_assoc($result)) {
                                                $doctorName = $data['fullname'];

                                                $doctor_schedule_query = "SELECT visibility FROM schedule WHERE schedule_owner='$doctorName'";
                                                $doctor_schedule_result = mysqli_query($con, $doctor_schedule_query);
                                                $doctor_schedule_row = mysqli_fetch_assoc($doctor_schedule_result);
                                                $schedule_visibility = $doctor_schedule_row['visibility'];

                                                if ($schedule_visibility === 'Hidden') {
                                                    echo '<option value="' . $doctorName . '" style="color: red;" disabled>' . $doctorName . ' (Not available)</option>';
                                                } else {
                                                    echo '<option value="' . $doctorName . '" style="color: green;">' . $doctorName . '</option>';
                                                }
                                            }

                                            echo '</select>';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mt-2">
                                        <div>
                                            <img src="images/select_doctor.png" alt="login" class="img-fluid p-5">
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-danger mt-2 float-start" onclick="return confirm('Are you sure you want to delete this appointment?')" name="cancel_appointmentbtn">Cancel</button>
                        <button type="submit" class="btn btn-primary mt-2 float-end" name="select_doctorbtn" onclick="return validateDoctorSelection()">Continue</button>
                    </div>
                    </form>
                </div>

                <script>
                    function validateDoctorSelection() {
                        var doctorSelect = document.getElementsByName('doctor')[0];
                        if (doctorSelect.value === '') {
                            alert("You have not selected a doctor. Please select another doctor or cancel.");
                            return false;
                        }
                        return true;
                    }
                </script>


            </div>

        </div>
    </div>
</div>


<?php include("includes/footer.php"); ?>