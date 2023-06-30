<?php
session_start();

if (isset($_SESSION['auth'])) {
    $_SESSION['message'] = "You are already registered!";
    header("Location: index.php");
    exit(0);
}
$page_title = "Register Page";
include("includes/header.php");
include("includes/navbar.php");
?>

<div class="py-5 mt-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">

                <?php include("message.php"); ?>

                <div class="card">
                    <div class="card-header">
                        <h4>Register Form:</h4>
                    </div>
                    <div class="card-body">
                        <form action="registercode.php" method="post">
                            <div class="form-group mb-3">
                                <label class="form-label">Fullname:</label>
                                <input required type="text" placeholder="Enter your fullname..." class="form-control" name="fullname">
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">Birthday:</label>
                                <input required type="date" class="form-control" name="birthday">
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="gender">Gender:</label>
                                <select class="form-control" id="gender" name="gender">
                                    <option value="">--Select gender--</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">E-mail:</label>
                                <input required type="email" placeholder="Enter your e-mail..." class="form-control" name="email">
                            </div>
                            <label class="form-label">Password:</label>
                            <div class="form-group input-group mb-3">
                                <input required type="password" placeholder="Enter your password..." class="form-control" id="pass" name="password">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <a href="#" class="text-dark" id="icon-click">
                                            <i class="fas fa-eye" id="icon"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <label class="form-label">Confirm Password:</label>
                            <div class="form-group input-group mb-3">
                                <input required type="password" placeholder="Confirm your password..." class="form-control" id="cpass" name="cpassword">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <a href="#" class="text-dark" id="cicon-click">
                                            <i class="fas fa-eye" id="cicon"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-primary" name="registerbtn">Register</button>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">Already have an account? <a href="login.php"style="font-size: 16px; transition: font-size 0.3s ease;" onmouseover="this.style.fontSize='20px';" onmouseout="this.style.fontSize='16px';">Login now...</a></label>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#icon-click").click(function() {
            $("#icon").toggleClass('fa-eye fa-eye-slash');
            var input = $("#pass");
            if (input.attr("type") === "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
        $("#cicon-click").click(function() {
            $("#cicon").toggleClass('fa-eye fa-eye-slash');
            var input = $("#cpass");
            if (input.attr("type") === "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    });
</script>


<?php include("includes/footer.php"); ?>