<?php
session_start();
include('admin/config/dbcon.php');

if (isset($_POST['loginbtn'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    $login_query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $login_query_run = mysqli_query($con, $login_query);
    if ($login_query_run) {
        foreach ($login_query_run as $data) {
            $user_id = $data['id'];
            $fullname = $data['fullname'];
            $birthday = $data['birthday'];
            $gender=$data['gender'];
            $speciality=$data['speciality'];
            $secretary_name=$data['secretary_name'];
            $doctor_name=$data['doctor_name'];
            $email = $data['email'];
            $role_as = $data['role_as'];
            $created_at=$data['created_at'];
        }

        $_SESSION['auth'] = true; //means login succesfully
        $_SESSION['auth_role'] = "$role_as"; //1=admin  0=user  2=Doctor  3=secretary
        $_SESSION['auth_user'] = [
            'user_id' => $user_id,
            'fullname' => $fullname,
            'birthday'=> $birthday,
            'gender' => $gender,
            'speciality'=>$speciality,
            'secretary_name'=>$secretary_name,
            'doctor_name'=>$doctor_name,
            'email' => $email,
            'created_at' => $created_at,
        ];

        if ($_SESSION['auth_role'] == 1) {
            $_SESSION['message'] = "You are logged in! Welcome to Admin Dashboard!";
            header("Location: admin/index.php");
            exit(0);
        } elseif ($_SESSION['auth_role'] == 0) {
            $_SESSION['message'] = "You are logged in! Welcome to User Dashboard!";
            header("Location: index.php");
            exit(0);
        } elseif ($_SESSION['auth_role'] == 2) {
            $_SESSION['message'] = "You are logged in! Welcome to Doctor Dashboard!";
            header("Location: index.php");
            exit(0);
        } elseif ($_SESSION['auth_role'] == 3) {
            $_SESSION['message'] = "You are logged in! Welcome to Secretary Dashboard!";
            header("Location: index.php");
            exit(0);
        } else {

            if (isset($_POST['loginbtn'])) {
                unset($_SESSION['auth']);
                unset($_SESSION['auth_role']);
                unset($_SESSION['auth_user']);

                $_SESSION['message'] = "Invalid e-mail or password";
                header("Location: login.php");
                exit(0);
            }
            header("Location: login.php");
            exit(0);
        }
    } else {
        $_SESSION['message'] = "Invalid e-mail or password!";
        header("Location: login.php");
        exit(0);
    }
} else {
    $_SESSION['message'] = "You are not allowed to acces!";
    header("Location: login.php");
    exit(0);
}
