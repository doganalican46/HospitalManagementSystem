<?php
$page_title = "Admin-Add new user";
include("authentication.php");
include("includes/header.php");
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Register a new user page:</h1>

    <div class="row">
        <div class="col-md-12">
            <div class="card mt-5">
                <div class="card-header">
                    <h4>Add a new User:</h4>
                </div>
                <div class="card-body">

                    <form action="code.php" method="POST">
                        <input type="hidden" name="user_id" value="<?= $user['id']; ?>">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="">Full Name:</label>
                                <input name="fullname" type="text" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Birthday:</label>
                                <input required type="date" class="form-control" name="birthday">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="gender">Gender:</label>
                                <select name="gender" required class="form-control">
                                    <option value="">--Select Gender--</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">E-mail:</label>
                                <input name="email" type="email" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Password:</label>
                                <input name="password" type="password" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Role as:</label>
                                <select name="role_as" required class="form-control">
                                    <option value="">--Select Role--</option>
                                    <option value="1">Admin</option>
                                    <option value="0">User</option>
                                    <option value="2">Doctor</option>
                                    <option value="3">Secretary</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="speciality">Speciality: <b>Only fill when user role= Doctor</b></label>

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
                                <label for="secretary">Secretary: <b>(Only fill when Role = Doctor!</b>)</label>

                                <?php
                                $query = "SELECT fullname FROM users WHERE role_as='3'";
                                $result = mysqli_query($con, $query);

                                if ($result) {
                                    echo '<select name="secretary_name" class="form-control">';
                                    echo '<option value="">--Select Secretary--</option>';

                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $secretaryName = $row['fullname'];

                                        $checkQuery = "SELECT secretary_name FROM users WHERE secretary_name='$secretaryName' AND role_as='2'";
                                        $checkResult = mysqli_query($con, $checkQuery);

                                        if (mysqli_num_rows($checkResult) === 0) {
                                            echo '<option value="' . $secretaryName . '">' . $secretaryName . ' (Can be selected) </option>';
                                        }
                                    }

                                    echo '</select>';
                                }
                                ?>

                            </div>





                            <div class="col-md-6 mb-3">
                                <label for="secretary">Doctor: <b>(Only fill when Role= Secretary!</b> )</label>

                                <?php
                                $query = "SELECT fullname FROM users WHERE role_as='2' ";
                                $result = mysqli_query($con, $query);

                                if ($result) {
                                    echo '<select name="doctor_name" class="form-control">';
                                    echo '<option value="">--Select Doctor--</option>';

                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $doctorName = $row['fullname'];
                                        echo '<option value="' . $doctorName . '">' . $doctorName . '</option>';
                                    }

                                    echo '</select>';
                                }
                                ?>

                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="">Status:</label>
                                <input name="status" type="checkbox" width="70px" height="70px">
                            </div>
                        </div>





                </div>
                <div class="card-footer">
                    <div class="col-md-12 mb-3">
                        <a href="view-register.php" class="btn btn-danger">Cancel</a>
                        <button type="submit" class="btn btn-primary" name="add_userbtn">Add User</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>

    <?php
    include("includes/footer.php");
    include("includes/scripts.php");
    ?>