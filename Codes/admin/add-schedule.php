<?php
$page_title = "Admin-Add new user";
include("authentication.php");
include("includes/header.php");
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Add a new schedule Page:</h1>

    <div class="row">
        <div class="col-md-12">
            <div class="card mt-5">
                <div class="card-header">
                    <h4>Add a new schedule:</h4>
                </div>
                <div class="card-body">

                    <form action="code.php" method="POST">

                        <div class="col-md-6 mb-3">
                            <label for="doctorname">Doctor Name:</label>
                            <?php
                            $query = "SELECT fullname from users where role_as='2' ";
                            $result = mysqli_query($con, $query);
                            if ($result) {
                                echo '<select name="doctorname" class="form-control">';
                                echo '<option value="">--Select Doctor--</option>';
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $doctorname = $row['fullname'];
                                    echo '<option value="' . $doctorname . '">' . $doctorname . '</option>';
                                }
                                echo '</select>';
                            }
                            ?>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="visibility">Select Visibility of Schedule:</label>
                            <select name="visibility" class="form-control">
                                <option value="Visible">Visible</option>
                                <option value="Hidden">Hidden</option>
                            </select>
                        </div>



                </div>
                <div class="card-footer">
                    <a href="admin-schedule.php" class="btn btn-danger">Cancel</a>
                    <button type="submit" class="btn btn-primary" name="addschedulebtn">Add Schedule</button>

                </div>
                </form>

            </div>
        </div>
    </div>
</div>

<?php
include("includes/footer.php");
include("includes/scripts.php");
?>