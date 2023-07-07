<?php
session_start();
$page_title = "Appointment Creation Page";
include("includes/header.php");
include("includes/navbar.php");
include("admin/config/dbcon.php");
?>

<div class="py-5 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php include("message.php"); ?>

                <div class="card">

                    <div class="card-header">
                        <h6>Make an Appointment</h6>
                    </div>

                    <div class="card-body">
                        <h3>Finally add a comment to your doctor...</h3>
                        <div class="row no-gutters">
                            <div class="col-md-8">
                                <form action="appointment_code.php" method="post" id="appointmentForm">
                                    <?php
                                    if (isset($_GET['appointment_id'])) {
                                        $appointment_id = $_GET['appointment_id'];
                                    } else {
                                        echo "Appointment ID not found.";
                                        exit;
                                    } ?>
                                    <input type="hidden" name="appointment_id" value="<?php echo $appointment_id; ?>">
                                    <div class="form-group mt-2">
                                        <label for="patient_note">Write a brief note to the doctor:</label>
                                        <input class="form-control" name="patient_note" placeholder="Write your comment..." type="text">
                                    </div>
                            </div>
                            <div class="col-md-4">

                                <img src="images/comment.png" alt="login" class=" float-end img-fluid p-5">

                            </div>
                        </div>





                    </div>
                    <div class="card-footer">
                    <button type="submit" class="btn btn-danger mt-2 float-start" onclick="return confirm('Are you sure you want to delete this appointment?')" name="cancel_appointmentbtn">Cancel</button>
                        <button type="submit" class="btn btn-success mt-2 float-end" name="add_commentbtn">Create</button>
                    </div>



                    </form>
                </div>





            </div>

        </div>
    </div>
</div>


<?php include("includes/footer.php"); ?>