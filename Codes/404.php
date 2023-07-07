<?php
session_start();
$page_title = "404! Error";
include("includes/header.php");
include("includes/navbar.php");
?>

<div class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php include("message.php"); ?>

                <h2>------ 404! Error ------</h2>
                <h4>Page do not found!</h4>

            </div>
        </div>
    </div>
</div>



<?php include("includes/footer.php"); ?>