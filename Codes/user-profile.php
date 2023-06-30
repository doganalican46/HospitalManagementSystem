<?php
session_start();
$page_title = "Profile Page";
include("includes/header.php");
include("includes/navbar.php");
?>

<div class="py-5 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php include("message.php"); ?>
                <h3>Profile Page:</h3>

                <div class="row mt-5">
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-header"> <b>Profile Information</b> </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <img src="images/user.png" class="img-fluid rounded-start" alt="photo of <?= $_SESSION['auth_user']['fullname']; ?>">
                                    </div>
                                    <div class="col-md-8">
                                        <h4><?= $_SESSION['auth_user']['fullname']; ?></h4>
                                        <p><strong>Name-Surname:</strong> <?= $_SESSION['auth_user']['fullname']; ?></p>
                                        <p><strong>E-Mail:</strong> <?= $_SESSION['auth_user']['email']; ?></p>
                                        <p><strong>Birthday:</strong> <?= $_SESSION['auth_user']['birthday']; ?></p>
                                        <p><strong>Gender:</strong> <?= $_SESSION['auth_user']['gender']; ?></p>
                                        <p><strong>Account Created:</strong> <?= $_SESSION['auth_user']['created_at']; ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deletemodal">
                                    Delete Account
                                </button>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updatemodal">
                                    Update
                                </button>
                            </div>
                        </div>
                    </div>



                    <!-- UPDATE PROFILE MODAL start -->
                    <div class="modal fade" id="updatemodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">


                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Update Profile Setting</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>


                                <!-- UPDATE PROFILE PROCESS start-->
                                <div class="modal-body">

                                    <form action="allcode.php" method="POST">
                                        <input type="hidden" name="user_id" <?= $_SESSION['auth_user']['fullname'];  ?>>
                                        <div class="row">

                                            <div class="col-md-6 mb-3">
                                                <label for="">Full Name:</label>
                                                <input name="fullname" type="text" class="form-control" value="<?= $_SESSION['auth_user']['fullname']; ?>">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label>Birthday:</label>
                                                <input required type="date" class="form-control" name="birthday" value="<?= $_SESSION['auth_user']['birthday']; ?>">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="gender">Gender:</label>
                                                <select name="gender" required class="form-control">
                                                    <option value="">--Select Gender--</option>
                                                    <option value="male" <?= $_SESSION['auth_user']['gender'] == 'male' ? 'selected' : '' ?>>Male</option>
                                                    <option value="female" <?= $_SESSION['auth_user']['gender']  == 'female' ? 'selected' : '' ?>>Female</option>
                                                    <option value="other" <?= $_SESSION['auth_user']['gender']  == 'other' ? 'selected' : '' ?>>Other</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="">E-mail:</label>
                                                <input name="email" type="email" class="form-control" value="<?= $_SESSION['auth_user']['email']; ?>">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="">Password:</label>
                                                <input name="password" type="password" class="form-control">
                                            </div>


                                        </div>
                                        <a href="#" data-bs-dismiss="modal" class="btn btn-danger">Cancel</a>
                                        <button type="submit" class="btn btn-primary" name="update_userbtn">Save</button>
                                    </form>
                                </div>
                                <!-- UPDATE PROFILE PROCESS end-->
                            </div>
                        </div>
                    </div>
                    <!-- UPDATE PROFILE MODAL end -->


                    <!-- DELETE PROFILE MODAL start -->
                    <div class="modal" id="deletemodal" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Are you sure for deleting account?</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>If you delete your account you will lose all your information!</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <form action="allcode.php" method="post">
                                        <button type="submit" name="deleteaccountbtn" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- DELETE PROFILE MODAL END -->



                    <?php if ($_SESSION['auth_role'] == 0) : //patient
                    ?>


                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Appointment Statistics:</h4>
                                </div>
                                <div class="card-body">
                                    <?php
                                    $patientName = $_SESSION['auth_user']['fullname'];

                                    $oldAppointmentsQuery = "SELECT COUNT(*) AS old_appointments_count FROM appointment
                                     WHERE patient_name = '$patientName' AND appointment_date < CURDATE()";
                                    $oldAppointmentsResult = mysqli_query($con, $oldAppointmentsQuery);
                                    $oldAppointmentsCount = mysqli_fetch_assoc($oldAppointmentsResult)['old_appointments_count'];

                                    $currentAppointmentsQuery = "SELECT COUNT(*) AS current_appointments_count FROM appointment
                                         WHERE patient_name = '$patientName' AND appointment_date >= CURDATE()";
                                    $currentAppointmentsResult = mysqli_query($con, $currentAppointmentsQuery);
                                    $currentAppointmentsCount = mysqli_fetch_assoc($currentAppointmentsResult)['current_appointments_count'];

                                    echo '<p> <b> Current Appointments: </b>' . $currentAppointmentsCount . ' <a href="user-appointment.php#currentappointments" class="btn btn-primary btn-sm float-end ">Details</a></p>';
                                    echo '<p> <b> Old Appointments: </b>' . $oldAppointmentsCount . '         <a href="user-appointment.php#oldappointments" class="btn btn-primary btn-sm float-end">Details</a></p>';

                                    ?>
                                </div>
                                <div class="card-footer">
                                    <a href="user-appointment.php" class="btn btn-primary float-end">Create a new Appointment</a>

                                </div>
                            </div>
                        </div>













                    <?php elseif ($_SESSION['auth_role'] == 2) : //doctor
                    ?>










                    <?php elseif ($_SESSION['auth_role'] == 3) : //secretary
                    ?>





                    <?php endif; ?>




                </div>
            </div>
        </div>
    </div>
</div>


<?php include("includes/footer.php"); ?>