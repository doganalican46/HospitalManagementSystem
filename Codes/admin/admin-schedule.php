<?php
$page_title = "Admin-Schedule Page";
include("authentication.php");
include("includes/header.php");
?>
<script type="text/javascript" src="js/table2excel.js"></script>
<div class="container-fluid px-4">
    <h1 class="mt-4">Admin-Schedule Page</h1>

    <div class="card-body">
        <div class="col mt-5">
            <?php include('message.php'); ?>

            <div class="card mb-3 ">
                <div class="card-header">
                    <h4>Scheduled Time:
                        <a href="add-schedule.php" class="btn btn-primary float-end"> Add New</a>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover " id="myTable">
                            <thead>
                                <tr>
                                    <th>Doctor Name</th>
                                    <th>Status:</th>
                                    <th>Process:</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT * FROM schedule ORDER BY schedule_owner ASC";
                                $query_run = mysqli_query($con, $query);
                                if (mysqli_num_rows($query_run) > 0) {
                                    foreach ($query_run as $row) {
                                ?>
                                        <tr>
                                            <td><?= $row['schedule_owner'] ?></td>
                                            <td><?= $row['visibility'] ?></td>
                                            <td>
                                                <form action="code.php" method="post">
                                                    <input type="hidden" name="user_id" value="<?= $row['schedule_id'] ?>">
                                                    <button type="submit" type="button" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?')" name="deleteschedulebtn">Delete</button>
                                                    <a href="edit-schedule.php?schedule_id=<?= $row['schedule_id'] ?>" class="btn btn-success">Edit</a>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="3"> No Record Found!</td>
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