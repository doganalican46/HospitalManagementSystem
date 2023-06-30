<?php
session_start();

if (isset($_SESSION['auth'])) {

    if (!isset($_SESSION['message'])) {
        $_SESSION['message'] = "You are already logged in!";
    }
    header("Location: index.php");
    exit(0);
}
$page_title = "Login Page";
include("includes/header.php");
include("includes/navbar.php");
?>


<section class="d-flex flex-column min-vh-100 justify-content-center align-items-center">
    <div class="container">
        <div class="row">
            <?php include("message.php"); ?>
            <div class="col-md-10 mx-auto rounded shadow bg-white">
                <div class="row">
                    <div class="col-md-6">
                        <div class="m-5 text-center">
                            <h2>Welcome!</h2>
                            <div class="text-center">
                                <h5>Hospital Management System</h5>
                                <hr>
                            </div>
                        </div>


                        <form class="m-5" action="logincode.php" method="post">
                            <div class="m-2 text-center">
                                <h6>Login Form</h6>
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
                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-primary" name="loginbtn">Login</button>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">You don't have an account?<a href="register.php" style="font-size: 16px; transition: font-size 0.3s ease;" onmouseover="this.style.fontSize='20px';" onmouseout="this.style.fontSize='16px';">Register now...</a>
                                </label>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <div>
                            <img src="images/login_image.svg" alt="login" class="img-fluid p-5">
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
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>


</section>



<?php include("includes/footer.php"); ?>