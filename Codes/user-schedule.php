<?php
session_start();
$page_title = "Schedule Page";
include("admin/config/dbcon.php");
include("includes/header.php");
include("includes/navbar.php");
?>

<div class="py-5 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php include("message.php"); ?>



                <?php if ($_SESSION['auth_role'] == 0) : //patient
                ?>
                    <h3>Patient Schedule Page:</h3>

                    <p>This page is not avaliable !!!</p>






                <?php elseif ($_SESSION['auth_role'] == 2) : //doctor
                ?>
                    <h3>Doctor Schedule Page:</h3>

                    <div class="container">
                        <div class="row">
                            <!-- Schedule settings form start -->
                            <div id="scheduleCreation" class="col mt-2">
                                <div class="card mb-3 mt-5">
                                    <div class="card-header">
                                        <h5 class="card-title">Select times for <?= $_SESSION['auth_user']['fullname']; ?></h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="allcode.php" method="post">
                                            <?php
                                            $schedule_owner = $_SESSION['auth_user']['fullname'];
                                            $query = "SELECT schedule_id,visibility FROM schedule WHERE schedule_owner = '$schedule_owner'";
                                            $query_run = mysqli_query($con, $query);
                                            if (mysqli_num_rows($query_run) > 0) {
                                                $row = mysqli_fetch_assoc($query_run);
                                            ?>
                                                <div class="mb-3">
                                                    <label for="visibility">Select Visibility of Schedule:</label>
                                                    <select name="visibility" class="form-control">
                                                        <?php
                                                        $visibility_values = array("Visible", "Hidden"); // Define the visibility options

                                                        foreach ($visibility_values as $value) {
                                                            $selected = ($value == $row['visibility']) ? 'selected' : ''; // Check if the option should be selected
                                                            echo "<option value='$value' $selected>$value</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>


                                                <input type="hidden" name="schedule_id" value="<?= $row['schedule_id'] ?>">
                                            <?php
                                            }
                                            ?>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary" name="update_schedulevisibility">Update</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                            <!-- Schedule settings form end -->
                        </div>









                    <?php elseif ($_SESSION['auth_role'] == 3) : //secretary
                    ?>
                        <h3>Secretary Schedule Page:</h3>


                        <!-- Schedule creation form start -->
                        <div id="scheduleCreation" class="col mt-2">

                            <div class="card mb-3 mt-5">
                                <div class="card-header">
                                    <h5 class="card-title">Schedule Visibility for <?= $_SESSION['auth_user']['doctor_name']; ?></h5>
                                </div>
                                <div class="card-body">
                                    <form action="allcode.php" method="post">
                                        <?php
                                        $schedule_owner = $_SESSION['auth_user']['doctor_name'];
                                        $query = "SELECT schedule_id, visibility FROM schedule WHERE schedule_owner = '$schedule_owner'";
                                        $query_run = mysqli_query($con, $query);
                                        if (mysqli_num_rows($query_run) > 0) {
                                            $row = mysqli_fetch_assoc($query_run);
                                        ?>
                                            <div class="mb-3">
                                                <label for="visibility">Select Visibility of Schedule:</label>
                                                <select name="visibility" class="form-control">
                                                    <?php
                                                    $visibility_values = array("Visible", "Hidden");

                                                    foreach ($visibility_values as $value) {
                                                        $selected = ($value == $row['visibility']) ? 'selected' : '';
                                                        echo "<option value='$value' $selected>$value</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <input type="hidden" name="schedule_id" value="<?= $row['schedule_id'] ?>">
                                        <?php
                                        }
                                        ?>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary" name="update_schedulevisibility">Update</button>
                                </div>
                                </form>
                            </div>



                        </div>
                        <!-- Schedule creation form end -->







                    <?php endif; ?>

                    </div>
            </div>
        </div>
    </div>

    <?php include("includes/footer.php"); ?>