<?php
$page_title = "Edit-Specialty";
include("authentication.php");
include("includes/header.php");
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Page: </h1>
    <?php include('message.php'); ?>
    <?php


    if (isset($_GET['schedule_id'])) {
        $schedule_id = $_GET['schedule_id'];
        $schedule = "SELECT * FROM schedule WHERE schedule_id='$schedule_id' ";
        $schedule_run = mysqli_query($con, $schedule);
        if (mysqli_num_rows($schedule_run) > 0) {

            foreach ($schedule_run as $data) {
    ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card mt-5">
                            <div class="card-header">
                                <h4>Edit Schedule: <?= $data['schedule_owner'];
                                                    ?></h4>
                            </div>
                            <div class="card-body">



                                <form action="code.php" method="POST">
                                    <input type="hidden" name="schedule_id" value="<?= $data['schedule_id'] ?>">



                                    <div class="mb-3">
                                        <label for="visibility">Select Visibility of Schedule:</label>
                                        <select name="visibility" class="form-control">
                                            <?php
                                            $visibility_values = array("Visible", "Hidden");

                                            foreach ($visibility_values as $value) {
                                                $selected = ($value == $data['visibility']) ? 'selected' : '';
                                                echo "<option value='$value' $selected>$value</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>


                            </div>
                            <div class="card-footer">
                                <div class="col-md-12 mb-3">
                                    <a href="admin-schedule.php" class="btn btn-danger">Cancel</a>
                                    <button type="submit" class="btn btn-primary" name="editschedulebtn">Update</button>
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

                <?php
                include("includes/footer.php");
                include("includes/scripts.php");
                ?>