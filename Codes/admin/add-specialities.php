<?php
$page_title = "Admin-Add Speciality";
include("authentication.php");
include("includes/header.php");
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Add a new specialities:</h1>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Add a new specialities:</h4>
                </div>
                <div class="card-body">

                    <form action="code.php" method="POST">
                        <div class="col-md-6 mb-3">
                            <label for="">Speciality Name:</label>
                            <input name="speciality_name" type="text" class="form-control">
                        </div>

                </div>
                <div class="card-footer">
                    <a href="specialities.php" class="btn btn-danger">Cancel</a>
                    <button type="submit" class="btn btn-primary" name="add_specialitybtn">Add Speciality</button>

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