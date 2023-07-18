<?php
$page_title = "Edit-Specialty";
include("authentication.php");
include("includes/header.php");
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Page:</h1>

    <div class="row">
        <div class="col-md-12">
            <div class="card mt-5">
                <div class="card-header">
                    <h4>Edit Specialities:</h4>
                </div>
                <?php include('message.php'); ?>
                <div class="card-body">

                    <?php

                    if (isset($_GET['speciality_id'])) {
                        $user_id = $_GET['speciality_id'];
                        $users = "SELECT * FROM specialities WHERE speciality_id='$user_id' ";
                        $users_run = mysqli_query($con, $users);
                        if (mysqli_num_rows($users_run) > 0) {

                            foreach ($users_run as $user) {
                    ?>
                                <form action="code.php" method="POST">
                                    <input type="hidden" name="speciality_id" value="<?= $user['speciality_id']; ?>">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="">Speciality Name:</label>
                                            <input name="speciality_name" type="text" class="form-control" value="<?= $user['speciality_name']; ?>">
                                        </div>




                                    </div>


                </div>
                <div class="card-footer">
                    <div class="col-md-12 mb-3">
                        <a href="specialities.php" class="btn btn-danger">Cancel</a>
                        <button type="submit" class="btn btn-primary" name="edit_specialitybtn">Update</button>
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