<?php
include("admin/config/dbcon.php");
session_start();

if (isset($_POST['select_specialitybtn'])) {
    $speciality_name = $_POST['speciality'];
    $patient_name = $_SESSION['auth_user']['fullname'];

    $query = "INSERT INTO appointment (appointment_speciality,patient_name) VALUES ('$speciality_name','$patient_name')";

    $result = mysqli_query($con, $query);
    if ($result) {
        $appointment_id = mysqli_insert_id($con);
        header("Location: appointment2.php?appointment_id=$appointment_id");
    } else {
        die('Error: ' . mysqli_error($con));
    }
}


if (isset($_POST['select_doctorbtn'])) {
    $appointment_id = $_POST['appointment_id'];
    $doctor_name = $_POST['doctor'];

    $query = "SELECT secretary_name FROM users WHERE fullname = '$doctor_name'";
    $result = mysqli_query($con, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $secretary_name = $row['secretary_name'];

        $query = "UPDATE appointment SET doctor_name = '$doctor_name', appointment_secretary = '$secretary_name' WHERE appointment_id = '$appointment_id'";
        $update_result = mysqli_query($con, $query);

        if ($update_result) {
            header("Location: appointment3.php?appointment_id=$appointment_id&doctor_name=$doctor_name");
            exit;
        } else {
            die('Error: ' . mysqli_error($con));
        }
    } else {
        die('Error: ' . mysqli_error($con));
    }
}


//select_datebtn
if (isset($_POST['select_datebtn'])) {
    $appointment_id = $_POST['appointment_id'];
    $appointment_date = $_POST['appointment_date'];

    $query = "UPDATE appointment SET appointment_date = '$appointment_date' WHERE appointment_id = '$appointment_id'";

    $result = mysqli_query($con, $query);
    if ($result) {
        header("Location: appointment4.php?appointment_id=$appointment_id");
        exit;
    } else {
        die('Error: ' . mysqli_error($con));
    }
}



//select_timebtn
if (isset($_POST['select_timebtn'])) {
    $appointment_id = $_POST['appointment_id'];
    $appointment_time = $_POST['appointment_time'];

    $query = "UPDATE appointment SET appointment_time = '$appointment_time' WHERE appointment_id = '$appointment_id'";

    $result = mysqli_query($con, $query);
    if ($result) {
        header("Location: appointment5.php?appointment_id=$appointment_id");
        exit;
    } else {
        die('Error: ' . mysqli_error($con));
    }
}



//add_commentbtn
if (isset($_POST['add_commentbtn'])) {
    $appointment_id = $_POST['appointment_id'];
    $patient_note = $_POST['patient_note'];

    $query = "UPDATE appointment SET patient_note = '$patient_note' WHERE appointment_id = '$appointment_id'";

    $result = mysqli_query($con, $query);
    if ($result) {
        $_SESSION['message'] = "Appointment booked Successfully!";
        header("Location: user-appointment.php");
        exit(0);
    } else {
        die('Error: ' . mysqli_error($con));
    }
}



//cancel_appointmentbtn
if (isset($_POST['cancel_appointmentbtn'])) {
    $appointment_id = $_POST['appointment_id'];
    $query = "DELETE FROM appointment WHERE appointment_id = '$appointment_id'";
    $result = mysqli_query($con, $query);
    if ($result) {
        $_SESSION['message'] = "Appointment cancelled Successfully!";
        header("Location: user-appointment.php");
        exit(0);
    } else {
        die('Error: ' . mysqli_error($con));
    }
}
