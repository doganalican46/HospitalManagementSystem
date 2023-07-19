<?php
$page_title = "Admin-Appointment Page";
include("authentication.php");
include("includes/header.php");
?>
<script type="text/javascript" src="js/table2excel.js"></script>
<div class="container-fluid px-4">
    <h1 class="mt-4">Admin-Appointment Page</h1>

    <div class="card-body">
        <div class="col mt-5">
            <?php include('message.php'); ?>
            <!-- Current Appointments card start-->
            <div class="card mb-3">

                <div class="card-header">
                    <h4>Appointments:
                        <button class="btn btn-primary float-end" type="button" data-bs-toggle="modal" data-bs-target="#addAppointmentModal">Create Appointment</button>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="myTable">
                            <thead>
                                <tr>
                                    <th>Doctor Name:</th>
                                    <th>Patient Name:</th>
                                    <th>Speciality:</th>
                                    <th>Date&Time:</th>
                                    <th>Process:</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $currentDate = date('Y-m-d');
                                $query = "SELECT * FROM appointment WHERE appointment_date > '$currentDate' ORDER BY doctor_name";
                                $query_run = mysqli_query($con, $query);
                                if (mysqli_num_rows($query_run) > 0) {
                                    foreach ($query_run as $row) {

                                ?>

                                        <tr>
                                            <td><?= $row['doctor_name'] ?></td>
                                            <td><?= $row['patient_name'] ?></td>
                                            <td><?= $row['appointment_speciality'] ?></td>
                                            <td> <?= $row['appointment_date'] ?> | <?= $row['appointment_time'] ?></td>
                                            <td>
                                                <form action="code.php" method="post">
                                                    <input type="hidden" name="appointment_id" value="<?= $row['appointment_id'] ?>">
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this appointment?')" name="delete_appointmentbtn">Cancel</button>
                                                    <a class="btn btn-success" href="edit-appointment.php?appointment_id=<?= $row['appointment_id'] ?>">Edit</a>
                                                    <a class="btn btn-primary" href="email-appointment.php?appointment_id=<?= $row['appointment_id'] ?>">Inform</a>

                                                </form>

                                            </td>
                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="3"> No Record Found!</td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" id="exporttable" onclick="tableToExcel()">Export</button>
                </div>
            </div>
            <!-- Current Appointments card end-->

        </div>

        <div class="col-md-12">
            <!-- Old Appointments -->
            <div id="oldappointments" class="card mt-4">
                <div class="card-header">
                    <h4>Old Appointments:</h4>
                </div>
                <div class="card-body" id="oldAppointments">

                    <div class="table-responsive">
                        <table class="table table-hover" id="myTable2">
                            <thead>
                                <tr>

                                    <th>Patient Name:</th>
                                    <th>Doctor Name:</th>
                                    <th>Date&Time:</th>
                                    <th>Speciality:</th>


                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $currentDate = date('Y-m-d');

                                $query = "SELECT * FROM appointment WHERE appointment_date < '$currentDate' ";
                                $query_run = mysqli_query($con, $query);
                                if (mysqli_num_rows($query_run) > 0) {
                                    foreach ($query_run as $row) {

                                ?>
                                        <tr>
                                            <td> <?= $row['patient_name'] ?> </td>
                                            <td> <?= $row['doctor_name'] ?> </td>
                                            <td> <?= $row['appointment_date'] ?> - <?= $row['appointment_time'] ?></td>
                                            <td> <?= $row['appointment_speciality'] ?>  </td>
                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="3"> No Record Found!</td>
                                    </tr>

                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" id="exporttable" onclick="tableToExcel()">Export</button>
                </div>
            </div>
        </div>







        <!-- MODALSSSS -->

        <!-- Add appointment modals start -->
        <div class="modal fade" id="addAppointmentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">



                    <!-- add appointment PROCESS start-->
                    <div class="modal-body">

                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="card-title">Create a Appointment:</h5>

                            </div>
                            <div class="card-body">
                                <form method="post" action="code.php" id="appointmentForm">

                                    <div class="form-group mt-2">
                                        <label for="availableTimes">Patient:</label>
                                        <?php
                                        $query = "SELECT fullname FROM users WHERE role_as='0'  ";
                                        $result = mysqli_query($con, $query);
                                        if ($result) {
                                            echo '<select name="patient" class="form-control">';
                                            echo '<option value="">--Select Patient--</option>';

                                            while ($data = mysqli_fetch_assoc($result)) {
                                                $patientName = $data['fullname'];
                                                echo '<option value="' . $patientName . '">' . $patientName . '</option>';
                                            }

                                            echo '</select>';
                                        }
                                        ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="speciality">Speciality:</label>
                                        <?php
                                        $query = "SELECT speciality_name FROM specialities";
                                        $result = mysqli_query($con, $query);

                                        if ($result) {
                                            echo '<select name="speciality" class="form-control">';
                                            echo '<option value="">--Select Speciality--</option>';

                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $specialityName = $row['speciality_name'];
                                                echo '<option value="' . $specialityName . '">' . $specialityName . '</option>';
                                            }

                                            echo '</select>';

                                        ?>

                                    </div>



                                    <div class="form-group mt-2">
                                        <label for="availableTimes">Doctor:</label>
                                    <?php

                                        }

                                        $query = "SELECT fullname FROM users WHERE role_as='2'  ";
                                        $result = mysqli_query($con, $query);


                                        if ($result) {
                                            echo '<select name="doctor" class="form-control">';
                                            echo '<option value="">--Select Doctor--</option>';

                                            while ($data = mysqli_fetch_assoc($result)) {
                                                $doctorName = $data['fullname'];
                                                echo '<option value="' . $doctorName . '">' . $doctorName . '</option>';
                                            }

                                            echo '</select>';
                                        }
                                    ?>
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="appointmentDate">Select Appointment Date:</label>
                                        <input class="form-control" type="date" name="appointment_date">
                                    </div>

                                    <div class="form-group mt-2">
                                        <label for="availableTimes">Available Times:</label>
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
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary" name="create_appointmentbtna">Save</button>

                            </div>
                            </form>
                        </div>
                    </div>


                </div>
            </div>
        </div>
        <!-- Add appointment modals end -->


    </div>

    <?php
    include("includes/footer.php");
    include("includes/scripts.php");
    ?>



    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });

        $(document).ready(function() {
            $('#myTable2').DataTable();
        });

        function tableToExcel() {
            var table2excel = new Table2Excel();
            table2excel.export(document.querySelectorAll("#myTable"));
        }

        function tableToExcel() {
            var table2excel = new Table2Excel();
            table2excel.export(document.querySelectorAll("#myTable2"));
        }
    </script>