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


                            <!-- Schedule update form start -->
                            <div id="scheduleCreation" class="col mt-5">
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h5 class="card-title">Schedule Settings</h5>
                                    </div>
                                    <div class="card-body">
                                        <?php

                                        if (isset($_GET['schedule_id'])) {
                                            $user_id = $_GET['schedule_id'];
                                            $schedule = "SELECT * FROM schedule WHERE schedule_id='$user_id' ";
                                            $schedule_run = mysqli_query($con, $schedule);
                                            if (mysqli_num_rows($schedule_run) > 0) {

                                                foreach ($schedule_run as $aaaa) {
                                        ?>
                                                    <b>Old Details:</b> <?= $aaaa['schedule_day']; ?> | <?= $aaaa['start_time']; ?>-<?= $aaaa['end_time']; ?> <br>

                                                    <form action="allcode.php" method="POST">
                                                        <input type="hidden" name="schedule_id" value="<?= $aaaa['schedule_id']; ?>">
                                                        <div class="mb-3">
                                                            <label for="days">Days:</label>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="data[]" id="monday" value="Monday">Monday

                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="data[]" id="tuesday" value="Tuesday">Tuesday

                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="data[]" id="wednesday" value="Wednesday">Wednesday

                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="data[]" id="thursday" value="Thursday">Thursday

                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="data[]" id="friday" value="Friday">Friday

                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="data[]" id="saturday" value="Saturday">Saturday

                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="data[]" id="sunday" value="Sunday">Sunday

                                                            </div>
                                                        </div>


                                                        <div class="mb-3">

                                                            <label for="start_time">Start Time:</label>
                                                            <?php
                                                            $query = "SELECT slot FROM hms_slots ";
                                                            $result = mysqli_query($con, $query);


                                                            if ($result) {
                                                                echo '<select name="start_time" class="form-control">';
                                                                echo '<option value="' . $aaaa['start_time'] . '">--Select Slot--</option>';

                                                                while ($data = mysqli_fetch_assoc($result)) {
                                                                    $start_slot = $data['slot'];
                                                                    echo '<option value="' . $start_slot . '">' . $start_slot . '</option>';
                                                                }

                                                                echo '</select>';
                                                            }
                                                            ?>

                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="end_time">End Time:</label>
                                                            <?php
                                                            $query = "SELECT slot FROM hms_slots ";
                                                            $result = mysqli_query($con, $query);


                                                            if ($result) {
                                                                echo '<select name="end_time" class="form-control">';
                                                                echo '<option value="' . $aaaa['end_time'] . '">--Select Slot--</option>';

                                                                while ($data = mysqli_fetch_assoc($result)) {
                                                                    $end_slot = $data['slot'];
                                                                    echo '<option value="' . $end_slot . '">' . $end_slot . '</option>';
                                                                }

                                                                echo '</select>';
                                                            }
                                                            ?>
                                                        </div>

                                    </div>
                                    <div class="card-footer">
                                        <a class="btn btn-danger" href="user-schedule.php">Cancel</a>
                                        <button type="submit" class="btn btn-primary" name="update_schedulebtn">Save</button>
                                    </div>
                                    </form>
                        <?php }
                                            }
                                        } ?>

                                </div>
                            </div>
                            <!-- Schedule update form end -->






                        </div>
                    </div>









                <?php elseif ($_SESSION['auth_role'] == 3) : //secretary
                ?>
                    <h3>Secretary Schedule Page:</h3>

                    <form action="allcode.php" method="POST">
                        <!-- Edit Scheduled Time start -->
                        <div class="col mt-5">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h5 class="card-title">Edit Scheduled Time</h5>
                                </div>
                                <div class="card-body">
                                    <?php

                                    if (isset($_GET['schedule_id'])) {
                                        $schedule_id = $_GET['schedule_id'];
                                        $schedule = "SELECT * FROM schedule WHERE schedule_id='$schedule_id' ";
                                        $schedule_run = mysqli_query($con, $schedule);
                                        if (mysqli_num_rows($schedule_run) > 0) {

                                            foreach ($schedule_run as $row) {

                                    ?>
                                                <b>Old Details:</b> <?= $row['schedule_day']; ?> | <?= $row['start_time']; ?>-<?= $row['end_time']; ?> <br>
                                                <div class="mb-3">
                                                    <label for="days">Days:</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="data[]" id="monday" value="Monday">Monday

                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="data[]" id="tuesday" value="Tuesday">Tuesday

                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="data[]" id="wednesday" value="Wednesday">Wednesday

                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="data[]" id="thursday" value="Thursday">Thursday

                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="data[]" id="friday" value="Friday">Friday

                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="data[]" id="saturday" value="Saturday">Saturday

                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="data[]" id="sunday" value="Sunday">Sunday

                                                    </div>
                                                </div>


                                                <div class="mb-3">

                                                    <label for="start_time">Start Time:</label>
                                                    <?php
                                                    $query = "SELECT slot FROM hms_slots ";
                                                    $result = mysqli_query($con, $query);


                                                    if ($result) {
                                                        echo '<select name="start_time" class="form-control">';
                                                        echo '<option value="">--Select Slot--</option>';

                                                        while ($data = mysqli_fetch_assoc($result)) {
                                                            $start_slot = $data['slot'];
                                                            echo '<option value="' . $start_slot . '">' . $start_slot . '</option>';
                                                        }

                                                        echo '</select>';
                                                    }
                                                    ?>

                                                </div>

                                                <div class="mb-3">
                                                    <label for="end_time">End Time:</label>
                                                    <?php
                                                    $query = "SELECT slot FROM hms_slots ";
                                                    $result = mysqli_query($con, $query);


                                                    if ($result) {
                                                        echo '<select name="end_time" class="form-control">';
                                                        echo '<option value="">--Select Slot--</option>';

                                                        while ($data = mysqli_fetch_assoc($result)) {
                                                            $end_slot = $data['slot'];
                                                            echo '<option value="' . $end_slot . '">' . $end_slot . '</option>';
                                                        }

                                                        echo '</select>';
                                                    }
                                                    ?>
                                                </div>
                                </div>
                                <div class="card-footer">
                                    <input type="hidden" name="schedule_id" value="<?= $row['schedule_id']; ?>">

                                    <a class="btn btn-danger float-start" href="user-schedule.php">Cancel</a>
                                    <button class="btn btn-primary float-end" type="submit" name="update_schedulebtn">Save</button>
                                </div>
                            </div>
                        </div>
                        <!-- Edit Scheduled Time end -->
            <?php }
                                        }
                                    } ?>
                    </form>






                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>