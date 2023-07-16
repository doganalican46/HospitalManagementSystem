<?php
$page_title = "Dashboard-Admin";
include("authentication.php");
include("includes/header.php");
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Admin-Dashboard</h1>

    <div class="row mt-5">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">Total Doctors

                    <?php
                    $query = "SELECT * FROM users WHERE role_as='2'";
                    $query_run = mysqli_query($con, $query);
                    if ($total_doctor = mysqli_num_rows($query_run)) {
                        echo '<h4 class="mb-0">' . $total_doctor . '</h4>';
                    } else {
                        echo '<h4 class="mb-0">No Data</h4>';
                    }
                    ?>

                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="admin-doctor.php">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>



        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">Total Patients
                    <?php
                    $query = "SELECT * FROM users WHERE role_as='0'";
                    $query_run = mysqli_query($con, $query);
                    if ($total_patient = mysqli_num_rows($query_run)) {
                        echo '<h4 class="mb-0">' . $total_patient . '</h4>';
                    } else {
                        echo '<h4 class="mb-0">No Data</h4>';
                    }
                    ?>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="admin-patient.php">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">Total Secretary
                    <?php
                    $query = "SELECT * FROM users WHERE role_as='3'";
                    $query_run = mysqli_query($con, $query);
                    if ($total_secretary = mysqli_num_rows($query_run)) {
                        echo '<h4 class="mb-0">' . $total_secretary . '</h4>';
                    } else {
                        echo '<h4 class="mb-0">No Data</h4>';
                    }
                    ?>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="admin-secretary.php">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">Total Specialities
                    <?php
                    $query = "SELECT * FROM specialities";
                    $query_run = mysqli_query($con, $query);
                    if ($total_speciality = mysqli_num_rows($query_run)) {
                        echo '<h4 class="mb-0">' . $total_speciality . '</h4>';
                    } else {
                        echo '<h4 class="mb-0">No Data</h4>';
                    }
                    ?>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="specialities.php">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">Current Appointments
                    <?php
                    $currentDate = date("Y-m-d");
                    $query = "SELECT COUNT(*) AS appointment_count FROM appointment WHERE appointment_date>'$currentDate'";
                    $query_run = mysqli_query($con, $query);
                    $row = mysqli_fetch_assoc($query_run);
                    $total_appointments = $row['appointment_count'];

                    if ($total_appointments > 0) {
                        echo '<h4 class="mb-0">' . $total_appointments . '</h4>';
                    } else {
                        echo '<h4 class="mb-0">No Data</h4>';
                    }
                    ?>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="admin-appointment.php">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">Old Appointments
                    <?php
                    $currentDate = date("Y-m-d");
                    $query = "SELECT COUNT(*) AS appointment_count FROM appointment WHERE appointment_date<'$currentDate'";
                    $query_run = mysqli_query($con, $query);
                    $row = mysqli_fetch_assoc($query_run);
                    $total_appointments = $row['appointment_count'];

                    if ($total_appointments > 0) {
                        echo '<h4 class="mb-0">' . $total_appointments . '</h4>';
                    } else {
                        echo '<h4 class="mb-0">No Data</h4>';
                    }
                    ?>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="admin-appointment.php">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>


        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">Total Scheduled Times
                    <?php
                    $query = "SELECT Count(schedule_id) AS total_scheduled_times FROM schedule";
                    $query_run = mysqli_query($con, $query);
                    $row = mysqli_fetch_assoc($query_run);
                    $total_scheduled_times = $row['total_scheduled_times'];

                    if ($total_scheduled_times > 0) {
                        echo '<h4 class="mb-0">' . $total_scheduled_times . '</h4>';
                    } else {
                        echo '<h4 class="mb-0">No Data</h4>';
                    }
                    ?>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="admin-schedule.php">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>


        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">Total Users

                    <?php
                    $query = "SELECT * FROM users";
                    $query_run = mysqli_query($con, $query);
                    if ($totalusers = mysqli_num_rows($query_run)) {
                        echo '<h4 class="mb-0">' . $totalusers . '</h4>';
                    } else {
                        echo '<h4 class="mb-0">No Data</h4>';
                    }
                    ?>

                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="admin-doctor.php">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title">Gender Distribution of Patients</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="male">
                                    <img src="../images/male.png" style="width:200px; height:200px;" class="card-img-top" alt="Male">

                                    <?php
                                    $patientGender = "SELECT COUNT(*) FROM users WHERE role_as='0' AND gender='male'";
                                    $query_run = mysqli_query($con, $patientGender);
                                    if ($totalMale = mysqli_fetch_array($query_run)[0]) {
                                        echo '<p class="card-text">There are <b>' . $totalMale . '</b> males as patients in the system. They use';

                                        $mostUsedSpecialityMale = "SELECT appointment_speciality, COUNT(*) as count FROM appointment 
                                           INNER JOIN users ON appointment.patient_name = users.fullname 
                                           WHERE users.role_as='0' AND users.gender='male' 
                                           GROUP BY appointment_speciality 
                                           ORDER BY count DESC LIMIT 1";
                                        $query_run = mysqli_query($con, $mostUsedSpecialityMale);
                                        if ($row = mysqli_fetch_assoc($query_run)) {
                                            $mostUsedSpecialityMale = $row['appointment_speciality'];
                                            echo ' <b>' . $mostUsedSpecialityMale . '</b> specialty mostly.</p>';
                                        } else {
                                            echo ' no specific specialty information available.</p>';
                                        }
                                    } else {
                                        echo '<h4 class="mb-0">No Data</h4>';
                                        echo '<p class="card-text">There are no males in the system.</p>';
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col">
                                <div class="female">
                                    <img src="../images/female.png" style="width:200px; height:200px;" class="card-img-top" alt="Female">

                                    <?php
                                    $patientGender = "SELECT COUNT(*) FROM users WHERE role_as='0' AND gender='female'";
                                    $query_run = mysqli_query($con, $patientGender);
                                    if ($totalFemale = mysqli_fetch_array($query_run)[0]) {
                                        echo '<p class="card-text">There are <b>' . $totalFemale . '</b> females as patients in the system. They use';

                                        $mostUsedSpecialityFemale = "SELECT appointment_speciality, COUNT(*) as count FROM appointment 
                                             INNER JOIN users ON appointment.patient_name = users.fullname 
                                             WHERE users.role_as='0' AND users.gender='female' 
                                             GROUP BY appointment_speciality 
                                             ORDER BY count DESC LIMIT 1";
                                        $query_run = mysqli_query($con, $mostUsedSpecialityFemale);
                                        if ($row = mysqli_fetch_assoc($query_run)) {
                                            $mostUsedSpecialityFemale = $row['appointment_speciality'];
                                            echo ' <b>' . $mostUsedSpecialityFemale . '</b> specialty mostly.</p>';
                                        } else {
                                            echo ' no specific specialty information available.</p>';
                                        }
                                    } else {
                                        echo '<h4 class="mb-0">No Data</h4>';
                                        echo '<p class="card-text">There are no females in the system.</p>';
                                    }
                                    ?>
                                </div>
                            </div>
                            
                        </div>


                    </div>
                    <div class="card-footer">
                        <small class="text-muted"></small>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title">Most used Specialities</h5>
                    </div>
                    <div class="card-body">

                        <div class="col">

                            <div class="male">
                                <img src="../images/speciality.png" style="width:200px; height:200px;" class="card-img-top" alt="speciality">

                                <?php
                                $countOfSpeciality = "SELECT appointment_speciality, COUNT(*) as count FROM appointment GROUP BY appointment_speciality";

                                $query_run = mysqli_query($con, $countOfSpeciality);

                                if (mysqli_num_rows($query_run) > 0) {
                                    $specialities = array();

                                    while ($row = mysqli_fetch_assoc($query_run)) {
                                        $speciality = $row['appointment_speciality'];
                                        $count = $row['count'];

                                        $specialities[$speciality] = $count;
                                    }

                                    $mostUsedSpeciality = '';
                                    $maxCount = 0;

                                    $leastUsedSpeciality = '';
                                    $minCount = PHP_INT_MAX;

                                    foreach ($specialities as $speciality => $count) {
                                        if ($count > $maxCount) {
                                            $maxCount = $count;
                                            $mostUsedSpeciality = $speciality;
                                        }

                                        if ($count < $minCount) {
                                            $minCount = $count;
                                            $leastUsedSpeciality = $speciality;
                                        }
                                    }



                                    echo '<p class="card-text">The most used speciality is <b> ' . $mostUsedSpeciality . ' </b> with a count of <b> ' . $maxCount . ' </b></p>';

                                    echo '<p class="card-text">The least used speciality is <b> ' . $leastUsedSpeciality . '</b>with a count of <b> ' . $minCount . ' </b> </p>';
                                } else {
                                    echo '<p class="card-text">No data available for specialities</p>';
                                }
                                ?>


                            </div>

                        </div>



                    </div>

                    <div class="card-footer">
                        <small class="text-muted"></small>
                    </div>

                </div>


            </div>
        </div>
    </div>

</div>


<?php
include("includes/footer.php");
include("includes/scripts.php");
?>