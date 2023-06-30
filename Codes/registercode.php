<?php
session_start();
include('admin/config/dbcon.php');

if (isset($_POST['registerbtn'])) {
    $fullname = mysqli_real_escape_string($con, $_POST['fullname']);
    $birthday = mysqli_real_escape_string($con, $_POST['birthday']);
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);

    if ($password == $cpassword) {

        //check email
        $checkemail = "SELECT email FROM users WHERE email='$email'";
        $checkemail_run = mysqli_query($con, $checkemail);
        if (mysqli_num_rows($checkemail_run) > 0) {
            //E-mail already exist!
            $_SESSION['message'] = "E-mail already exist!";
            header("Location: register.php");
            exit(0);
        } else {
            //insert data
            $user_query = "INSERT INTO users (fullname,birthday,gender,email,password) VALUES ('$fullname','$birthday','$gender','$email','$password')";
            $user_query_run = mysqli_query($con, $user_query);
            if ($user_query_run) {
                $_SESSION['message'] = "Registered Successfully!";
                header("Location: login.php");
                exit(0);
            } else {
                //echo "Error!";
                $_SESSION['message'] = "Error!";
                header("Location: register.php");
                exit(0);
            }
        }
    } else {
        $_SESSION['message'] = "Passwords do not match!";
        header("Location: register.php");
        exit(0);
    }
} else {
    header("Location: register.php");
    exit(0);
}
