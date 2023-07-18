<?php
$page_title = "Admin-Specialty Page";
include("authentication.php");
include("includes/header.php");
?>

<script type="text/javascript" src="js/table2excel.js"></script>

<div class="container-fluid px-4">
    <h1 class="mt-4">Admin-Specialities Page</h1>

    <div class="row">

        <div class="col-md-12">

            <?php include('message.php'); ?>

            <div class="card mt-5">
                <div class="card-header">
                    <h4>Specialities:
                        <a href="add-specialities.php" class="btn btn-primary float-end"> Add Specialities</a>
                    </h4>

                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-hover" id="myTable">
                            <thead>
                                <tr>
                                    <th>ID:</th>
                                    <th>Speciality Name:</th>
                                    <th>Proccess</th>

                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $query = "SELECT * FROM specialities ORDER BY speciality_name";
                                $query_run = mysqli_query($con, $query);

                                if (mysqli_num_rows($query_run) > 0) {

                                    foreach ($query_run as $row) {
                                ?>
                                        <tr>
                                            <td> <?= $row['speciality_id'] ?> </td>
                                            <td> <?= $row['speciality_name'] ?> </td>

                                            <td>
                                                <form action="code.php" method="post">
                                                    <input type="hidden" name="user_id" value="<?= $row['speciality_id'] ?>">
                                                    <button type="submit" type="button" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?')" name="deletespecialitybtn">Delete</button>
                                                    <a href="edit-specialities.php?speciality_id=<?= $row['speciality_id'] ?>" class="btn btn-success">Edit</a>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php

                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="4"> No Record Found!</td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>



                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" id="exporttable" onclick="tableToExcel()">Export</button>
                </div>
            </div>

        </div>
    </div>






</div>

<?php
include("includes/footer.php");
include("includes/scripts.php");
?>


<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });

    function tableToExcel() {
        var table2excel = new Table2Excel();
        table2excel.export(document.querySelectorAll("#myTable"));
    }
</script>