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
                        <h3>Select time for appointment...</h3>


                        <form action="appointment_code.php" method="post" id="appointmentForm">
                            <?php
                            if (isset($_GET['appointment_id'])) {
                                $appointment_id = $_GET['appointment_id'];
                            } else {
                                echo "Appointment ID not found.";
                                exit;
                            }

                            $get_doctorname = "SELECT doctor_name, appointment_date FROM appointment WHERE appointment_id='$appointment_id' ";
                            $run_doctorname = mysqli_query($con, $get_doctorname);
                            $row_doctor = mysqli_fetch_array($run_doctorname);
                            $doctor_name = $row_doctor['doctor_name'];
                            $appointment_date = $row_doctor['appointment_date'];

                            $existingAppointments = []; // Array to store existing appointments

                            
                            $query = "SELECT appointment_date, appointment_time FROM appointment WHERE doctor_name='$doctor_name' ";
                            $result = mysqli_query($con, $query);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $existingAppointments[] = $row;
                                }
                            }
                            ?>
                            <input type="hidden" name="appointment_id" value="<?php echo $appointment_id; ?>">
                            <div class="row no-gutters">
                                <div class="col-md-8">
                                    <label for="appointment_time">Appointment Time:</label>
                                    <select class="form-control" id="appointment_time" name="appointment_time" required>
                                        <option value="">--Select Time--</option>
                                        <?php
                                        $times = array("9:00 AM", "10:00 AM", "11:00 AM", "12:00 AM", "1:00 PM", "2:00 PM", "3:00 PM", "4:00 PM");

                                        foreach ($times as $time) {
                                            $disabled = '';
                                            $style = '';

                                            // Check if the time and date are in the existing appointments array
                                            foreach ($existingAppointments as $appointment) {
                                                if ($appointment['appointment_time'] == $time && $appointment['appointment_date'] == $appointment_date) {
                                                    $disabled = 'disabled'; 
                                                    $style = 'color: red;'; 
                                                    break;
                                                }
                                            }

                                           
                                            echo "<option value=\"$time\" $disabled style=\"$style\">$time</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-4">

                                    <img src="images/select_time.png" alt="login" class="img-fluid p-5">

                                </div>
                            </div>



                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-danger mt-2 float-start" onclick="return confirm('Are you sure you want to delete this appointment?')" name="cancel_appointmentbtn">Cancel</button>
                        <button type="submit" class="btn btn-primary mt-2 float-end" name="select_timebtn">Continue</button>
                    </div>



                    </form>
                </div>





            </div>
        </div>
    </div>
</div>


<?php include("includes/footer.php"); ?>