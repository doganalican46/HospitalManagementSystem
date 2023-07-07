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
                        <h3>Select date...</h3>


                        <form action="appointment_code.php" method="post" id="appointmentForm">
                            <?php
                            if (isset($_GET['appointment_id'])) {
                                $appointment_id = $_GET['appointment_id'];
                                $doctor_name = $_GET['doctor_name'];
                            } else {
                                echo "Appointment ID not found.";
                                exit;
                            } ?>
                            <input type="hidden" name="appointment_id" value="<?php echo $appointment_id; ?>">
                            <input type="hidden" name="doctor_name" value="<?php echo $doctor_name; ?>">


                            <div class="row no-gutters">
                                <div class="col-md-8">

                                    <?php
                                    $get_doctoravaliableday = "SELECT * FROM schedule WHERE schedule_owner='$doctor_name' ";
                                    $run_doctoravaliableday = mysqli_query($con, $get_doctoravaliableday);
                                    $row_doctoravaliableday = mysqli_fetch_array($run_doctoravaliableday);

                                    ?>
                                    <div id="warning_message" style="display: none; color: red;"></div>


                                    <label for="appointmentDate">Select Appointment Date:</label>
                                    <input class="form-control" type="date" name="appointment_date" id="appointment_date" required>
                                    <span id="schedule_day_info"> </span>

                                </div>
                                <div class="col-md-4">

                                    <img src="images/select_date.png" alt="login" class="img-fluid p-5">

                                </div>
                            </div>


                            <style>
                                .past-date {
                                    background-color: red;
                                }

                                .avaliable-date {
                                    background-color: green;
                                }
                            </style>

                            <script>
                                var today = new Date().toISOString().split("T")[0];

                                var dateInput = document.getElementById("appointment_date");
                                dateInput.min = today;

                                dateInput.addEventListener("change", function() {
                                    var selectedDate = new Date(this.value);
                                    if (selectedDate < new Date() || isWeekend(selectedDate)) {
                                        this.classList.add("past-date");
                                        this.classList.remove("avaliable-date"); 
                                        showMessage("This day cannot be chosen. Please select another day.");
                                        this.value = ""; 
                                    } else {
                                        this.classList.remove("past-date");
                                        this.classList.add("avaliable-date"); 
                                        hideMessage();
                                    }
                                });

                                
                                function isWeekend(date) {
                                    var day = date.getDay();
                                    return day === 0 || day === 6; // 0 represents Sunday, 6 represents Saturday
                                }

                                function showMessage(message) {
                                    var messageElement = document.getElementById("warning_message");
                                    messageElement.textContent = message;
                                    messageElement.style.display = "block";
                                }

                                function hideMessage() {
                                    var messageElement = document.getElementById("warning_message");
                                    messageElement.style.display = "none";
                                }
                            </script>







                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-danger mt-2 float-start" onclick="return confirm('Are you sure you want to delete this appointment?')" name="cancel_appointmentbtn">Cancel</button>
                        <button type="submit" class="btn btn-primary mt-2 float-end" name="select_datebtn">Continue</button>
                    </div>



                    </form>
                </div>





            </div>
        </div>
    </div>
</div>


<?php include("includes/footer.php"); ?>