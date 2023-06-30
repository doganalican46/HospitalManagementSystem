<?php
session_start();
$page_title = "Dashboard";
include("includes/header.php");
include("includes/navbar.php");
include("admin/config/dbcon.php");
?>

<div class="py-5 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php include("message.php"); ?>




                <?php if ($_SESSION['auth_role'] == 0) : //patient
                ?>
                    <h3>Hello patient <?= $_SESSION['auth_user']['fullname'];  ?>,</h3>
                    <p>Welcome to the system...</p>



                    <div class="row">
                        <div class="col">



                        </div>
                    </div>


                    <div class="row row-cols-1 row-cols-md-3 g-4">

                        <div class="card" style="width: 18rem;">
                            <img src="images/currentappointment.png" class="card-img-top" alt="Appointment images">

                            <?php
                            $query = "SELECT * FROM appointment WHERE patient_name='" . $_SESSION['auth_user']['fullname'] . "' ORDER BY appointment_date DESC LIMIT 1 ";
                            $query_run = mysqli_query($con, $query);
                            if (mysqli_num_rows($query_run) > 0) {
                                foreach ($query_run as $row) {
                            ?>
                                    <div class="card-body">
                                        <b>
                                            <h5 class="card-title">Current Appointment</h5>
                                        </b>
                                        <p class="card-text"> <b>Doctor Note:</b>
                                            <?php
                                            $doctorNote = $row['doctor_note'];
                                            if (!empty($doctorNote)) {
                                                echo $doctorNote;
                                            } else {
                                                echo "No doctor comment";
                                            }
                                            ?>
                                        </p>
                                    </div>

                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"> <b>Speciality:</b> <?= $row['appointment_speciality'] ?></li>
                                        <li class="list-group-item"> <b>Doctor:</b> <?= $row['doctor_name'] ?></li>
                                        <li class="list-group-item"> <b>Date&Time:</b><br> <?= $row['appointment_date'] ?> - <?= $row['appointment_time'] ?></li>
                                    </ul>
                                <?php
                                }
                            } else {
                                ?>
                                <div class="card-body">
                                    <b>
                                        <h5 class="card-title">Current Appointment</h5>
                                    </b>
                                    <p class="card-text"> <b>Doctor Note:</b> No Doctor Note</p>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">No Speciality</li>
                                    <li class="list-group-item">No Doctor</li>
                                    <li class="list-group-item">No Time</li>
                                </ul>
                            <?php
                            }
                            ?>
                            </ul>
                            <div class="card-body">
                                <a href="user-appointment.php#newappointments" class="btn btn-danger">Cancel</a>
                                <a href="user-appointment.php#newappointments" class="btn btn-success">Edit</a>
                            </div>
                        </div>



                        <div class="card">
                            <div class="card-body">
                                <br>
                                <h5 class="card-title"><?= $_SESSION['auth_user']['fullname'] ?> Appointment Statistics </h5>
                                <br><br>
                                <div class="statistics">
                                    <ul class="list-group">
                                        <?php
                                        $patientName = $_SESSION['auth_user']['fullname'];

                                        $totalAppointmentsQuery = "SELECT COUNT(*) AS total_appointments FROM appointment WHERE patient_name = '$patientName'";
                                        $totalAppointmentsResult = mysqli_query($con, $totalAppointmentsQuery);
                                        $totalAppointmentsCount = mysqli_fetch_assoc($totalAppointmentsResult)['total_appointments'];

                                        if ($totalAppointmentsCount == 0) {
                                            echo '<li class="list-group-item">No data</li>';
                                        } else {
                                            $mostFrequentAppointmentQuery = "SELECT appointment_date, COUNT(*) AS appointment_count FROM appointment
                                            WHERE patient_name = '$patientName'
                                            GROUP BY appointment_date
                                            ORDER BY appointment_count DESC
                                            LIMIT 1";
                                            $mostFrequentAppointmentResult = mysqli_query($con, $mostFrequentAppointmentQuery);
                                            $mostFrequentAppointment = mysqli_fetch_assoc($mostFrequentAppointmentResult);

                                            $mostVisitedDoctorQuery = "SELECT doctor_name, COUNT(*) AS visit_count FROM appointment
                                            WHERE patient_name = '$patientName'
                                            GROUP BY doctor_name
                                            ORDER BY visit_count DESC
                                            LIMIT 1";
                                            $mostVisitedDoctorResult = mysqli_query($con, $mostVisitedDoctorQuery);
                                            $mostVisitedDoctor = mysqli_fetch_assoc($mostVisitedDoctorResult);

                                            $mostFrequentSpecialtyQuery = "SELECT appointment_speciality, COUNT(*) AS specialty_count FROM appointment
                                                WHERE patient_name = '$patientName'
                                                GROUP BY appointment_speciality
                                                ORDER BY specialty_count DESC
                                                LIMIT 1";
                                            $mostFrequentSpecialtyResult = mysqli_query($con, $mostFrequentSpecialtyQuery);
                                            $mostFrequentSpecialty = mysqli_fetch_assoc($mostFrequentSpecialtyResult);

                                            echo '<li class="list-group-item"><b>Total Appointments:</b> ' . $totalAppointmentsCount . '</li>';
                                            echo '<li class="list-group-item"><b>Most Frequent Appointment Date:</b> <br>' . $mostFrequentAppointment['appointment_date'] . ' (' . $mostFrequentAppointment['appointment_count'] . ' times)</li>';
                                            echo '<li class="list-group-item"><b>Most Frequent Appointment Specialty:</b> ' . $mostFrequentSpecialty['appointment_speciality'] . ' (' . $mostFrequentSpecialty['specialty_count'] . ' times)</li>';
                                            echo '<li class="list-group-item"><b>Most Visited Doctor:</b> <br> ' . $mostVisitedDoctor['doctor_name'] . ' (' . $mostVisitedDoctor['visit_count'] . ' times)</li>';
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                            <img src="images/footer.png" class="card-img-bottom" alt="...">
                        </div>


                        <div class="container-fluid mt-3">
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Nearest Pharmacy</h5>
                                            <hr>
                                            <iframe src="https://www.google.com/maps/d/u/0/embed?mid=1YZCZzwk0KVCXHq25zBdjshGD-N2Ghps&ehbc=2E312F" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>





                    <?php elseif ($_SESSION['auth_role'] == 2) : //doctor
                    ?>
                        <h3>Hello doctor <?= $_SESSION['auth_user']['fullname'];  ?>,</h3>
                        <p>Welcome to the system...</p>

                        <div class="row row-cols-1 row-cols-md-3 g-4">

                            <div class="card" style="width: 18rem;">
                                <img src="images/currentappointment.png" class="card-img-top" alt="Appointment images">

                                <?php
                                $query = "SELECT * FROM appointment WHERE doctor_name='" . $_SESSION['auth_user']['fullname'] . "' ORDER BY appointment_date DESC LIMIT 1";
                                $query_run = mysqli_query($con, $query);
                                if (mysqli_num_rows($query_run) > 0) {
                                    foreach ($query_run as $row) {
                                ?>
                                        <div class="card-body">
                                            <b>
                                                <h5 class="card-title">Current Appointment</h5>
                                            </b>
                                            <p class="card-text"> <b>Patient Note:</b> <?= $row['patient_note'] ?></p>
                                        </div>

                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item"> <b>Speciality:</b> <?= $row['appointment_speciality'] ?></li>
                                            <li class="list-group-item"> <b>Patient:</b> <?= $row['patient_name'] ?></li>
                                            <li class="list-group-item"> <b>Date&Time:</b><br> <?= $row['appointment_date'] ?> - <?= $row['appointment_time'] ?></li>
                                        </ul>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <div class="card-body">
                                        <b>
                                            <h5 class="card-title">Current Appointment</h5>
                                        </b>
                                        <p class="card-text"> <b>Patient Note:</b> No Patient Note</p>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">No Speciality</li>
                                        <li class="list-group-item">No Patient</li>
                                        <li class="list-group-item">No Time</li>
                                    </ul>
                                <?php
                                }
                                ?>
                                </ul>
                                <div class="card-body">
                                    <a href="user-appointment.php#newappointments" class="btn btn-danger">Cancel</a>
                                    <a href="user-appointment.php#newappointments" class="btn btn-success">Edit</a>
                                </div>
                            </div>



                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Gender Distribution Statistics</h5>
                                    <?php
                                    $doctorName = $_SESSION['auth_user']['fullname'];

                                    $malePatientsQuery = "SELECT COUNT(DISTINCT appointment.patient_name) as male_count FROM appointment
                              INNER JOIN users ON appointment.patient_name = users.fullname
                              WHERE appointment.doctor_name = '$doctorName' AND users.gender = 'male'";
                                    $malePatientsResult = mysqli_query($con, $malePatientsQuery);
                                    $maleCount = mysqli_fetch_assoc($malePatientsResult)['male_count'];

                                    $femalePatientsQuery = "SELECT COUNT(DISTINCT appointment.patient_name) as female_count FROM appointment
                                INNER JOIN users ON appointment.patient_name = users.fullname
                                WHERE appointment.doctor_name = '$doctorName' AND users.gender = 'female'";
                                    $femalePatientsResult = mysqli_query($con, $femalePatientsQuery);
                                    $femaleCount = mysqli_fetch_assoc($femalePatientsResult)['female_count'];

                                    echo '<ul class="list-group">';
                                    echo '<li class="list-group-item">Male Patients: ' . $maleCount . '</li>';
                                    echo '<li class="list-group-item">Female Patients: ' . $femaleCount . '</li>';
                                    echo '</ul>';
                                    ?>
                                </div>
                                <img style="border-radius: 20%;" src="images/gender_dist.png" class="card-img-bottom" alt="...">
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Appointment Statistics</h5>
                                    <?php
                                    $doctorName = $_SESSION['auth_user']['fullname'];

                                    $currentAppointmentsQuery = "SELECT COUNT(*) as current_count FROM appointment
                                    WHERE doctor_name = '$doctorName' AND appointment_date >= CURDATE()";
                                    $currentAppointmentsResult = mysqli_query($con, $currentAppointmentsQuery);
                                    $currentCount = mysqli_fetch_assoc($currentAppointmentsResult)['current_count'];

                                    $oldAppointmentsQuery = "SELECT COUNT(*) as old_count FROM appointment
                                     WHERE doctor_name = '$doctorName' AND appointment_date < CURDATE()";
                                    $oldAppointmentsResult = mysqli_query($con, $oldAppointmentsQuery);
                                    $oldCount = mysqli_fetch_assoc($oldAppointmentsResult)['old_count'];

                                    $todayAppointmentsQuery = "SELECT COUNT(*) as today_count FROM appointment
                                    WHERE doctor_name = '$doctorName' AND appointment_date = CURDATE()";
                                    $todayAppointmentsResult = mysqli_query($con, $todayAppointmentsQuery);
                                    $todayCount = mysqli_fetch_assoc($todayAppointmentsResult)['today_count'];

                                    $tomorrowAppointmentsQuery = "SELECT COUNT(*) as tomorrow_count FROM appointment
                                    WHERE doctor_name = '$doctorName' AND appointment_date = DATE_ADD(CURDATE(), INTERVAL 1 DAY)";
                                    $tomorrowAppointmentsResult = mysqli_query($con, $tomorrowAppointmentsQuery);
                                    $tomorrowCount = mysqli_fetch_assoc($tomorrowAppointmentsResult)['tomorrow_count'];

                                    echo '<ul class="list-group">';
                                    echo '<li class="list-group-item">Today\'s Appointments: ' . $todayCount . '</li>';
                                    echo '<li class="list-group-item">Tomorrow\'s Appointments: ' . $tomorrowCount . '</li>';
                                    echo '<li class="list-group-item">Current Appointments: ' . $currentCount . '</li>';
                                    echo '<li class="list-group-item">Old Appointments: ' . $oldCount . '</li>';

                                    echo '</ul>';
                                    ?>
                                </div>
                                <img src="images/footer.png" class="card-img-bottom" alt="...">
                            </div>



                        </div>
















                    <?php elseif ($_SESSION['auth_role'] == 3) : //secretary
                    ?>
                        <h3>Hello secretary <?= $_SESSION['auth_user']['fullname'];  ?>,</h3>
                        <p>Welcome to the system...</p>

                        <div class="row row-cols-1 row-cols-md-3 g-4">

                            <div class="card" style="width: 18rem;">
                                <img src="images/currentappointment.png" class="card-img-top" alt="Appointment images">
                                <div class="card-body">
                                    <?php
                                    $query = "SELECT * FROM appointment WHERE doctor_name='" . $_SESSION['auth_user']['doctor_name'] . "' ORDER BY appointment_date DESC LIMIT 1";
                                    $query_run = mysqli_query($con, $query);
                                    if (mysqli_num_rows($query_run) > 0) {
                                        foreach ($query_run as $row) {
                                    ?>
                                            <h5 class="card-title">Appointments</h5>
                                            <p class="card-text"> <b>Doctor Note:</b> <?= $row['doctor_note'] ?></p>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><?= $row['patient_name'] ?>: <?= $row['patient_note'] ?></li>
                                    <li class="list-group-item"><?= $row['appointment_time'] ?></li>
                                    <li class="list-group-item"><?= $row['appointment_date'] ?></li>
                                </ul>
                            <?php
                                        }
                                    } else {
                            ?>
                            <div class="card-body">
                                <b>
                                    <h5 class="card-title">Current Appointment</h5>
                                </b>
                                <p class="card-text"> <b>Patient Note:</b> No Patient Note</p>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">No Speciality</li>
                                <li class="list-group-item">No Patient</li>
                                <li class="list-group-item">No Time</li>
                            </ul>
                        <?php
                                    }
                        ?>
                        </ul>
                        <div class="card-body">
                            <a href="user-appointment.php#appointmentdetails" class="btn btn-success">Display Details</a>
                        </div>
                            </div>



                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Your Doctor, <?= $_SESSION['auth_user']['doctor_name']; ?>;</h5>
                                    <div class="statistics">
                                        <?php
                                        $doctorName = $_SESSION['auth_user']['doctor_name'];

                                        $todaysAppointmentsQuery = "SELECT COUNT(*) AS today_appointments FROM appointment
                WHERE doctor_name = '$doctorName' AND appointment_date = CURDATE()";
                                        $todaysAppointmentsResult = mysqli_query($con, $todaysAppointmentsQuery);
                                        $todaysAppointmentsCount = mysqli_fetch_assoc($todaysAppointmentsResult)['today_appointments'];

                                        $tomorrowsAppointmentsQuery = "SELECT COUNT(*) AS tomorrow_appointments FROM appointment
                   WHERE doctor_name = '$doctorName' AND appointment_date = CURDATE() + INTERVAL 1 DAY";
                                        $tomorrowsAppointmentsResult = mysqli_query($con, $tomorrowsAppointmentsQuery);
                                        $tomorrowsAppointmentsCount = mysqli_fetch_assoc($tomorrowsAppointmentsResult)['tomorrow_appointments'];

                                        $totalAppointmentsQuery = "SELECT COUNT(*) AS total_appointments FROM appointment
               WHERE doctor_name = '$doctorName'";
                                        $totalAppointmentsResult = mysqli_query($con, $totalAppointmentsQuery);
                                        $totalAppointmentsCount = mysqli_fetch_assoc($totalAppointmentsResult)['total_appointments'];

                                        echo '<ul class="list-group">';
                                        echo '<li class="list-group-item">Today\'s Appointments: ' . $todaysAppointmentsCount . '</li>';
                                        echo '<li class="list-group-item">Tomorrow\'s Appointments: ' . $tomorrowsAppointmentsCount . '</li>';
                                        echo '<li class="list-group-item">Total Appointments: ' . $totalAppointmentsCount . '</li>';
                                        echo '</ul>';
                                        ?>
                                    </div>
                                </div>
                                <img src="images/footer.png" class="card-img-bottom" alt="...">
                            </div>




                        </div>




                    <?php endif; ?>





                    </div>
            </div>
        </div>
    </div>


    <?php include("includes/footer.php"); ?>