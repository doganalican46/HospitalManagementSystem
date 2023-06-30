<?php
session_start();
$page_title = "Appointment Page";
include("includes/header.php");
include("includes/navbar.php");
include("admin/config/dbcon.php");
?>


<style>
    /* Adjust column width for smaller screens */
    @media (max-width: 576px) {

        .booking-calendar th,
        .booking-calendar td {
            padding: 0.25rem;
            font-size: 0.75rem;
        }

        .booking-calendar th:first-child,
        .booking-calendar td:first-child {
            padding-left: 0.5rem;
        }

        .booking-calendar th:last-child,
        .booking-calendar td:last-child {
            padding-right: 0.5rem;
        }
    }

    .unavailable {
        color: red;
    }
</style>

<div class="py-5 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php include("message.php"); ?>


                <?php if ($_SESSION['auth_role'] == 0) : //patient
                ?>
                    <!-- patient interface start -->
                    <h3 class="mb-5">Patient Appointment Page:</h3>

                    <div class="container">
                        <div class="row">


                            <div class="col-md-12 mb-5">

                                <!-- make an appointment start -->
                                <div class="card">

                                    <div class="card-header">
                                        <h6>Make an Appointment</h6>
                                    </div>

                                    <div class="card-body">
                                        <h3>To create an new appointment, select speciality...</h3>


                                        <form action="appointment_code.php" method="post" id="appointmentForm">

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
                                                }
                                                ?>

                                            </div>

                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary mt-2 float-end" name="select_specialitybtn">Continue</button>
                                    </div>
                                    </form>
                                </div>


                            </div>


                            <div class="col-md-12 mb-5">
                                <!-- Current Appointments -->
                                <div id="newappointments" class="card mt-4">
                                    <div class="card-header">
                                        <h6>Current Appointments</h6>
                                    </div>
                                    <div class="card-body" id="currentAppointments">
                                        <div class="table-responsive">
                                            <table class="table table-hover" id="">
                                                <thead>
                                                    <tr>

                                                        <th>Doctor Name:</th>
                                                        <th>Speciality:</th>
                                                        <th>Date&Time:</th>
                                                        <th>Your Comment:</th>
                                                        <th>Doctor Comment:</th>
                                                        <th>Process:</th>

                                                    </tr>
                                                </thead>
                                                <tbody>


                                                    <?php
                                                    $currentDate = date('Y-m-d');
                                                    $currentTime = date('H:i:s');
                                                    $query = "SELECT * FROM appointment where patient_name='" . $_SESSION['auth_user']['fullname'] . "'  AND appointment_date > '$currentDate'";
                                                    $query_run = mysqli_query($con, $query);
                                                    if (mysqli_num_rows($query_run) > 0) {
                                                        foreach ($query_run as $row) {

                                                    ?>
                                                            <tr>

                                                                <td> <?= $row['doctor_name'] ?> </td>
                                                                <td> <?= $row['appointment_speciality'] ?> </td>
                                                                <td><?= $row['appointment_date'] ?> - <?= $row['appointment_time'] ?></td>
                                                                <td> <?= $row['patient_note'] ?> </td>
                                                                <td>
                                                                    <?php
                                                                    $doctorNote = $row['doctor_note'];
                                                                    if (!empty($doctorNote)) {
                                                                        echo $doctorNote;
                                                                    } else {
                                                                        echo "No doctor comment";
                                                                    }
                                                                    ?>
                                                                </td>

                                                                <td>
                                                                    <form action="allcode.php" method="post">
                                                                        <input name="appointment_id" type="hidden" value="<?= $row['appointment_id'] ?>">
                                                                        <button class="btn btn-danger" name="delete_appointmentbtnpatient" onclick="return confirm('Are you sure you want to delete this appointment?')">Cancel</button>
                                                                        <a class="btn btn-success" href="edit-appointment.php?appointment_id=<?= $row['appointment_id'] ?>">Edit</a>
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

                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <!-- Old Appointments start-->
                                <div id="oldappointments" class="card mt-4">
                                    <div class="card-header">
                                        <h6>Old Appointments</h6>
                                    </div>
                                    <div class="card-body" id="oldAppointments">


                                        <div class="table-responsive">
                                            <table class="table table-hover" id="patient_oldappointmentstable">
                                                <thead>
                                                    <tr>
                                                        <th>Doctor Name:</th>
                                                        <th>Speciality:</th>
                                                        <th>Date&Time:</th>
                                                        <th>Doctor Comment:</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $currentDate = date('Y-m-d');
                                                    $currentTime = date('H:i:s');

                                                    $query = "SELECT * FROM appointment WHERE appointment_date < '$currentDate'  AND patient_name = '" . $_SESSION['auth_user']['fullname'] . "' ";
                                                    $query_run = mysqli_query($con, $query);
                                                    if (mysqli_num_rows($query_run) > 0) {
                                                        foreach ($query_run as $data) {
                                                    ?>
                                                            <tr>
                                                                <td> <?= $data['doctor_name'] ?> </td>
                                                                <td> <?= $data['appointment_speciality'] ?> </td>
                                                                <td><?= $data['appointment_date'] ?> - <?= $data['appointment_time'] ?></td>
                                                                <td> <?= $data['doctor_note'] ?></td>
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
                                <!-- Old Appointments end-->

                                <script>
                                    function tableToExcel() {
                                        var table2excel8 = new Table2Excel();
                                        table2excel8.export(document.querySelectorAll("#patient_oldappointmentstable"));
                                    }
                                </script>


                            </div>
                        </div>


                    </div>
                    <!-- patient interface end -->




                    <!-- doctor interface start -->
                <?php elseif ($_SESSION['auth_role'] == 2) : //doctor
                ?>
                    <h3>Doctor Appointment Page:</h3>

                    <div class="container">
                        <div class="row">



                            <div class="col-md-12">
                                <!-- Current Appointments -->
                                <div id="newappointments" class="card mt-4">
                                    <div class="card-header">
                                        <b>Current Appointments</b> <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#createAppointmentModal">Create</button>
                                    </div>
                                    <div class="card-body" id="currentAppointments">
                                        <div class="table-responsive">
                                            <table class="table table-hover" id="doctor_currentAppointmentTable">
                                                <thead>
                                                    <tr>
                                                        <th>Patient Name:</th>
                                                        <th>Date&Time:</th>
                                                        <th>Patient Comment:</th>
                                                        <th>Secretary Comment:</th>
                                                        <th>Doctor Comment:</th>
                                                        <th>Process</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $currentDate = date('Y-m-d');
                                                    $currentTime = date('H:i:s');
                                                    $query = "SELECT * FROM appointment WHERE appointment_date > '$currentDate' AND doctor_name = '" . $_SESSION['auth_user']['fullname'] . "'  ORDER BY appointment_date";
                                                    $query_run = mysqli_query($con, $query);
                                                    if (mysqli_num_rows($query_run) > 0) {
                                                        foreach ($query_run as $row) {
                                                    ?>
                                                            <tr>
                                                                <td> <?= $row['patient_name'] ?> </td>
                                                                <td><?= $row['appointment_date'] ?> - <?= $row['appointment_time'] ?></td>
                                                                <td><?= $row['patient_note'] ?></td>
                                                                <td><?= $row['secretary_note'] ?></td>
                                                                <td><?= $row['doctor_note'] ?></td>
                                                                <td>
                                                                    <form action="allcode.php" method="post">
                                                                        <input name="appointment_id" type="hidden" value="<?= $row['appointment_id'] ?>">
                                                                        <button class="btn btn-danger" name="delete_appointmentbtn" onclick="return confirm('Are you sure you want to delete this appointment?')">Cancel</button>
                                                                        <a class="btn btn-success" href="edit-appointment.php?appointment_id=<?= $row['appointment_id'] ?>">Edit</a>
                                                                        <a class="btn btn-primary" href="email2.php?appointment_id=<?= $row['appointment_id'] ?>">Inform</a>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <tr>
                                                            <td colspan="5"> No Record Found!</td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button class="btn btn-primary" onclick="exportCurrentTableToExcel()">Export</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script>
                            function exportCurrentTableToExcel() {
                                var table2excel = new Table2Excel();
                                table2excel.export(document.querySelectorAll("#doctor_currentAppointmentTable"));
                            }
                        </script>



                        <div class="row">
                            <div class="col-md-12">
                                <!-- Old Appointments -->
                                <div id="oldappointments" class="card mt-4">
                                    <div class="card-header">
                                        <b>Old Appointments</b>
                                    </div>
                                    <div class="card-body" id="oldAppointments">

                                        <div class="table-responsive">
                                            <table class="table table-hover" id="doctor_oldAppointmentTable">
                                                <thead>
                                                    <tr>

                                                        <th>Patient Name:</th>
                                                        <th>Date & Time:</th>
                                                        <th>Patient Note:</th>
                                                        <th>Secretary Note:</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $currentDate = date('Y-m-d');
                                                    $currentTime = date('H:i:s');

                                                    $query = "SELECT * FROM appointment WHERE appointment_date < '$currentDate'  AND doctor_name = '" . $_SESSION['auth_user']['fullname'] . "' ";
                                                    $query_run = mysqli_query($con, $query);
                                                    if (mysqli_num_rows($query_run) > 0) {
                                                        foreach ($query_run as $data) {
                                                    ?>
                                                            <tr>
                                                                <td> <?= $data['patient_name'] ?> </td>
                                                                <td><?= $data['appointment_date'] ?> - <?= $data['appointment_time'] ?></td>
                                                                <td> <?= $data['patient_note'] ?></td>
                                                                <td> <?= $data['secretary_note'] ?></td>
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
                                        <button class="btn btn-primary" onclick="exportOldTableToExcel()">Export</button>
                                    </div>
                                </div>

                                <script>
                                    function exportOldTableToExcel() {
                                        var table2excel = new Table2Excel();
                                        table2excel.export(document.querySelectorAll("#doctor_oldAppointmentTable"));
                                    }
                                </script>










                                <!-- appointment creation Modal -->
                                <div class="modal fade" id="createAppointmentModal" tabindex="-1" aria-labelledby="createAppointmentModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="createAppointmentModalLabel">Appointment Information</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="allcode.php" method="post">

                                                    <div class="form-group mt-2">
                                                        <label for="patient">Patient:</label>
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

                                                    <div class="form-group mt-2">
                                                        <label for="appointmentDate">Select Appointment Date:</label>
                                                        <?php //displayCalendar(); 
                                                        ?>
                                                        <input class="form-control" type="date" name="appointment_date" id="appointment_date">

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

                                                    <div class="form-group mt-2">
                                                        <label for="doctor_note">Write a brief note to the patient:</label>
                                                        <input class="form-control" name="doctor_note" placeholder="Write your comment..." type="text">
                                                    </div>




                                            </div>

                                            <div class="modal-footer">

                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary" name="create_appointmentbtn">Create</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- doctor interface end -->





                                <!-- secretary interface start -->
                            <?php elseif ($_SESSION['auth_role'] == 3) : //secretary
                            ?>
                                <h3>Secretary Appointment Page:</h3>

                                <div class="container">
                                    <div class="row">

                                        <div class="col-md-12">
                                            <!-- Current Appointments -->
                                            <div id="newappointments" class="card mt-4">
                                                <div class="card-header">
                                                    Current Appointments of your doctor <b> <?= $_SESSION['auth_user']['doctor_name'];  ?> </b> <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#createAppointmentModal2">Create</button>
                                                </div>
                                                <div class="card-body" id="currentAppointments">
                                                    <div class="table-responsive">
                                                        <table class="table table-hover newTable" id="secretary_currentAppointmentTable">
                                                            <thead>
                                                                <tr>
                                                                    <th>Patient Name:</th>
                                                                    <th>Date&Time:</th>
                                                                    <th>Patient Comment:</th>
                                                                    <th>Doctor Comment:</th>
                                                                    <th>Process</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $currentDate = date('Y-m-d');
                                                                $currentTime = date('H:i:s');
                                                                $query = "SELECT * FROM appointment WHERE appointment_date > '$currentDate' AND doctor_name = '" . $_SESSION['auth_user']['doctor_name'] . "'  ORDER BY appointment_date";
                                                                $query_run = mysqli_query($con, $query);
                                                                if (mysqli_num_rows($query_run) > 0) {
                                                                    foreach ($query_run as $row) {
                                                                ?>
                                                                        <tr>
                                                                            <td> <?= $row['patient_name'] ?> </td>
                                                                            <td><?= $row['appointment_date'] ?> - <?= $row['appointment_time'] ?></td>
                                                                            <td><?= $row['patient_note'] ?></td>
                                                                            <td><?= $row['doctor_note'] ?></td>
                                                                            <td>
                                                                                <form action="allcode.php" method="post">
                                                                                    <input name="appointment_id" type="hidden" value="<?= $row['appointment_id'] ?>">
                                                                                    <button class="btn btn-danger" name="delete_appointmentbtn" onclick="return confirm('Are you sure you want to delete this appointment?')">Cancel</button>
                                                                                    <a class="btn btn-success" href="edit-appointment.php?appointment_id=<?= $row['appointment_id'] ?>">Edit</a>
                                                                                    <a class="btn btn-primary" href="email2.php?appointment_id=<?= $row['appointment_id'] ?>">Inform</a>
                                                                                </form>
                                                                            </td>
                                                                        </tr>
                                                                    <?php
                                                                    }
                                                                } else {
                                                                    ?>
                                                                    <tr>
                                                                        <td colspan="5"> No Record Found!</td>
                                                                    </tr>
                                                                <?php
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="card-footer">
                                                    <button class="btn btn-primary" id="exporttable" onclick="exportCurrentSecretaryTableToExcel()">Export</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        function exportCurrentSecretaryTableToExcel() {
                                            var table2excel = new Table2Excel();
                                            table2excel.export(document.querySelectorAll("#secretary_currentAppointmentTable"));
                                        }
                                    </script>

                                    <!-- appointment creation Modal -->
                                    <div class="modal fade" id="createAppointmentModal2" tabindex="-1" aria-labelledby="createAppointmentModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="createAppointmentModalLabel">Appointment Information</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="allcode.php" method="post">

                                                        <div class="form-group mt-2">
                                                            <label for="patient">Patient:</label>
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

                                                        <div class="form-group mt-2">
                                                            <label for="appointmentDate">Select Appointment Date:</label>
                                                            <?php //displayCalendar(); 
                                                            ?>
                                                            <input class="form-control" type="date" name="appointment_date" id="appointment_date">

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

                                                        <div class="form-group mt-2">
                                                            <label for="secretary_note">Write a brief note to the doctor:</label>
                                                            <input class="form-control" name="secretary_note" placeholder="Write your comment..." type="text">
                                                        </div>




                                                </div>

                                                <div class="modal-footer">

                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary" name="create_appointmentbtn2">Create</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- Old Appointments -->
                                            <div id="oldappointments" class="card mt-4">
                                                <div class="card-header">
                                                    Old Appointments of your doctor <b> <?= $_SESSION['auth_user']['doctor_name'];  ?> </b>
                                                </div>
                                                <div class="card-body" id="oldAppointments">

                                                    <div class="table-responsive">
                                                        <table class="table table-hover" id="secretary_oldAppointmentTable">
                                                            <thead>
                                                                <tr>

                                                                    <th>Patient Name:</th>
                                                                    <th>Date & Time:</th>
                                                                    <th>Patient Note:</th>
                                                                    <th>Doctor Note:</th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $currentDate = date('Y-m-d');
                                                                $currentTime = date('H:i:s');

                                                                $query = "SELECT * FROM appointment WHERE appointment_date < '$currentDate'  AND doctor_name = '" . $_SESSION['auth_user']['doctor_name'] . "' ";
                                                                $query_run = mysqli_query($con, $query);
                                                                if (mysqli_num_rows($query_run) > 0) {
                                                                    foreach ($query_run as $data) {
                                                                ?>
                                                                        <tr>
                                                                            <td> <?= $data['patient_name'] ?> </td>
                                                                            <td><?= $data['appointment_date'] ?> - <?= $data['appointment_time'] ?></td>
                                                                            <td> <?= $data['patient_note'] ?> </td>
                                                                            <td> <?= $data['doctor_note'] ?> </td>
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
                                                    <button class="btn btn-primary" id="exporttable" onclick="exportOldSecretaryTableToExcel()">Export</button>
                                                </div>
                                            </div>

                                            <script>
                                                function exportOldSecretaryTableToExcel() {
                                                    var table2excel = new Table2Excel();
                                                    table2excel.export(document.querySelectorAll("#secretary_oldAppointmentTable"));
                                                }
                                            </script>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- secretary interface end -->

                    <?php endif; ?>





                    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
                    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
                    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
                    <script src="assets/js/table2excel.js"></script>

                    <script type="text/javascript">
                        $(document).ready(function() {
                            new simpleDatatables.DataTable('#doctor_currentAppointmentTable');
                        });
                    </script>
                    <?php include("includes/footer.php"); ?>