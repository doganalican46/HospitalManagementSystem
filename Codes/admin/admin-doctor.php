<?php
$page_title = "Admin-Doctor Page";
include("authentication.php");
include("includes/header.php");
?>

<script type="text/javascript" src="js/table2excel.js"></script>



<div class="container-fluid px-4">
    <h1 class="mt-4">Admin-Doctor Page</h1>

    <div class="card mt-5">
        <div class="card-header">
            <h4>Doctor List <a href="add-register.php" class="btn btn-primary float-end"> Add New</a></h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="myTable">
                    <thead>
                        <tr>
                            <th>ID:</th>
                            <th>Fullname:</th>
                            <th>Secretary Name:</th>
                            <th>Birthday & Gender</th>

                            <th>Speciality:</th>
                            <th>E-mail:</th>
                            <th>User Role:</th>
                            <th>Process</th>

                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $query = "SELECT * FROM users WHERE role_as = '2'";
                        $query_run = mysqli_query($con, $query);

                        if (mysqli_num_rows($query_run) > 0) {

                            foreach ($query_run as $row) {
                        ?>
                                <tr>
                                    <td> <?= $row['id'] ?> </td>
                                    <td> <?= $row['fullname'] ?> </td>
                                    <td> <?= $row['secretary_name'] ?> </td>
                                    <td> <?= $row['birthday'] ?> | <?= $row['gender'] ?> </td>
                                    <td> <?= $row['speciality'] ?> </td>
                                    <td> <?= $row['email'] ?> </td>
                                    <td>
                                        <?php
                                        if ($row['role_as'] == "1") {
                                            echo "Admin";
                                        } elseif ($row['role_as'] == "0") {
                                            echo "User";
                                        } elseif ($row['role_as'] == "2") {
                                            echo "Doctor";
                                        } elseif ($row['role_as'] == "3") {
                                            echo "Secretary";
                                        }

                                        ?>
                                    </td>

                                    <form action="code.php" method="post">
                                        <td>
                                            <input type="hidden" id="user_id" name="user_id" value="<?= $row['id'] ?>">
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?')" name="deletedoctorbtn">Delete</button>
                                            <a href="edit-register.php?id=<?= $row['id'] ?>" class="btn btn-success">Edit</a>
                                            <a href="email-profile.php?id=<?= $row['id'] ?>" class="btn btn-primary">Inform</a>

                                        </td>
                                </tr>
                                </form>
                            <?php

                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="7"> No Record Found!</td>
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