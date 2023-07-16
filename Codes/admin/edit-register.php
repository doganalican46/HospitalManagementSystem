<?php
$page_title = "Edit-Users Settings";
include("authentication.php");
include("includes/header.php");
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Users List:</h1>

    <div class="row">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <h4>Edit User:</h4>
                </div>
                <div class="card-body">

                    <?php

                    if (isset($_GET['id'])) {
                        $user_id = $_GET['id'];
                        $users = "SELECT * FROM users WHERE id='$user_id' ";
                        $users_run = mysqli_query($con, $users);
                        if (mysqli_num_rows($users_run) > 0) {

                            foreach ($users_run as $user) {
                    ?>
                                <form action="code.php" method="POST">
                                    <input type="hidden" name="user_id" value="<?= $user['id']; ?>">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="">Full Name:</label>
                                            <input name="fullname" type="text" class="form-control" value="<?= $user['fullname']; ?>">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label>Birthday:</label>
                                            <input required type="date" class="form-control" name="birthday" value="<?= $user['birthday']; ?>">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="gender">Gender:</label>
                                            <select name="gender" required class="form-control">
                                                <option value="">--Select Gender--</option>
                                                <option value="male" <?= $user['gender'] == 'male' ? 'selected' : '' ?>>Male</option>
                                                <option value="female" <?= $user['gender'] == 'female' ? 'selected' : '' ?>>Female</option>
                                                <option value="other" <?= $user['gender'] == 'other' ? 'selected' : '' ?>>Other</option>
                                            </select>
                                        </div>


                                        <div class="col-md-6 mb-3">
                                            <label for="">E-mail:</label>
                                            <input name="email" type="email" class="form-control" value="<?= $user['email']; ?>">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="">Password:</label>
                                            <input name="password" type="password" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="">Role as:</label>
                                            <select name="role_as" required class="form-control">
                                                <option value="">--Select Role--</option>
                                                <option value="1" <?= $user['role_as'] == '1' ? 'selected' : '' ?>>Admin</option>
                                                <option value="0" <?= $user['role_as'] == '0' ? 'selected' : '' ?>>User</option>
                                                <option value="2" <?= $user['role_as'] == '2' ? 'selected' : '' ?>>Doctor</option>
                                                <option value="3" <?= $user['role_as'] == '3' ? 'selected' : '' ?>>Secretary</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="speciality">Speciality:<b> Only fill when user role= Doctor</b></label>

                                            <?php
                                            $query = "SELECT speciality_name FROM specialities";
                                            $result = mysqli_query($con, $query);

                                            if ($result) {
                                                echo '<select name="speciality" class="form-control">';
                                                echo '<option value="">--Select Speciality--</option>';

                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $specialityName = $row['speciality_name'];
                                                    echo '<option value="' . $specialityName . '"  >' . $specialityName . '</option>';
                                                }

                                                echo '</select>';
                                            }
                                            ?>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="secretary">Secretary:  <b>Only fill when user role= Doctor!</b></label>

                                            <?php
                                            $query = "SELECT fullname FROM users WHERE role_as='3'";
                                            $result = mysqli_query($con, $query);

                                            if ($result) {
                                                echo '<select name="secretary_name" class="form-control">';
                                                echo '<option value="">--Select Secretary--</option>';

                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $secretaryName = $row['fullname'];
                                                    echo '<option value="' . $secretaryName . '"  >' . $secretaryName . '</option>';
                                                }

                                                echo '</select>';
                                            }
                                            ?>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="doctor">Doctor: <b> Only fill when user role= Secretary!</b></label>

                                            <?php
                                            $query = "SELECT fullname FROM users WHERE role_as='2'";
                                            $result = mysqli_query($con, $query);

                                            if ($result) {
                                                echo '<select name="doctor_name" class="form-control">';
                                                echo '<option value="">--Select Doctor--</option>';

                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $doctorName = $row['fullname'];
                                                    echo '<option value="' . $doctorName . '"  >' . $doctorName . '</option>';
                                                }

                                                echo '</select>';
                                            }
                                            ?>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="">Status:</label>
                                            <input name="status" type="checkbox" width="70px" height="70px" <?= $user['status'] == '1' ? 'checked' : '' ?>>
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <a href="view-register.php" class="btn btn-danger">Cancel</a>
                                            <button type="submit" class="btn btn-primary" name="update_userbtn">Update</button>
                                        </div>

                                    </div>
                                </form>
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
    </div>


    <?php
    include("includes/footer.php");
    include("includes/scripts.php");
    ?>