<?php
//we dont need to restart session again and again because it is already started from authentication.php
include("authentication.php");

//logout process
if (isset($_POST['logoutbtn'])) {
    session_destroy();
    unset($_SESSION['auth']);
    unset($_SESSION['auth_role']);
    unset($_SESSION['auth_user']);

    $_SESSION['message'] = "Log Out Successfully";
    header("Location: ../index.php");
    exit(0);
}

//delete user process
if (isset($_POST['deleteuserbtn'])) {
    $user_id = $_POST['user_id'];
    $query = "DELETE FROM users WHERE id='$user_id' ";
    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        $_SESSION['message'] = "User deleted Successfully";
        header('Location: view-register.php');
        exit(0);
    } else {
        $_SESSION['message'] = "Something went wrong!";
        header('Location: view-register.php');
        exit(0);
    }
}


//delete user process
if (isset($_POST['deletepatientbtn'])) {
    $user_id = $_POST['user_id'];
    $query = "DELETE FROM users WHERE id='$user_id' ";
    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        $_SESSION['message'] = "User deleted Successfully";
        header('Location: admin-patient.php');
        exit(0);
    } else {
        $_SESSION['message'] = "Something went wrong!";
        header('Location: admin-patient.php');
        exit(0);
    }
}


//delete secretary process
if (isset($_POST['deletesecretarybtn'])) {
    $user_id = $_POST['user_id'];
    $query = "DELETE FROM users WHERE id='$user_id' ";
    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        $_SESSION['message'] = "User deleted Successfully";
        header('Location: admin-secretary.php');
        exit(0);
    } else {
        $_SESSION['message'] = "Something went wrong!";
        header('Location: admin-secretary.php');
        exit(0);
    }
}


// delete delete_appointmentbtn
if (isset($_POST['delete_appointmentbtn'])) {
    $appointment_id = $_POST['appointment_id'];
    $query = "DELETE FROM appointment WHERE appointment_id='$appointment_id' ";
    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        $_SESSION['message'] = "Appointment deleted Successfully";
        header('Location: admin-appointment.php');
        exit(0);
    } else {
        $_SESSION['message'] = "Something went wrong!";
        header('Location: admin-appointment.php');
        exit(0);
    }
}


//delete doctor process
if (isset($_POST['deletedoctorbtn'])) {
    $user_id = $_POST['user_id'];
    $query = "DELETE FROM users WHERE id='$user_id' ";
    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        $_SESSION['message'] = "User deleted Successfully";
        header('Location: admin-doctor.php');
        exit(0);
    } else {
        $_SESSION['message'] = "Something went wrong!";
        header('Location: admin-doctor.php');
        exit(0);
    }
}


//delete speciality process
if (isset($_POST['deletespecialitybtn'])) {
    $user_id = $_POST['user_id'];
    $query = "DELETE FROM specialities WHERE speciality_id='$user_id' ";
    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        $_SESSION['message'] = "Speciality deleted Successfully";
        header('Location: specialities.php');
        exit(0);
    } else {
        $_SESSION['message'] = "Something went wrong!";
        header('Location: specialities.php');
        exit(0);
    }
}


//delete schedule process
if (isset($_POST['deleteschedulebtn'])) {
    $user_id = $_POST['user_id'];
    $query = "DELETE FROM schedule WHERE schedule_id='$user_id' ";
    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        $_SESSION['message'] = "Schedule deleted Successfully";
        header('Location: admin-schedule.php');
        exit(0);
    } else {
        $_SESSION['message'] = "Something went wrong!";
        header('Location: admin-schedule.php');
        exit(0);
    }
}





//add user process
if (isset($_POST['add_userbtn'])) {

    $fullname = $_POST['fullname'];
    $birthday = $_POST['birthday'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $speciality = $_POST['speciality'];
    $secretary_name = $_POST['secretary_name'];
    $doctor_name = $_POST['doctor_name'];
    $password = $_POST['password'];
    $role_as = $_POST['role_as'];
    $status = $_POST['status'] == true ? '1' : '0';


    $query = "INSERT INTO users (fullname,birthday,gender, email, speciality,secretary_name,doctor_name,password, role_as, status) VALUES ('$fullname','$birthday','$gender','$email','$speciality','$secretary_name','$doctor_name','$password','$role_as','$status')";
    $query_run = mysqli_query($con, $query);



    if ($query_run) {
        $_SESSION['message'] = "User Added Successfully";
        if ($role_as == "2") {
            header("Location: admin-doctor.php");
            exit();
        } elseif ($role_as == "3") {
            header("Location: admin-secretary.php");
            exit();
        } elseif ($role_as == "0") {
            header("Location: admin-patient.php");
            exit();
        } else {
            // Handle the case when the role is not recognized or not selected
            header("Location: view-register.php");
            exit(0);
        }
    } else {
        $_SESSION['message'] = "Something went wrong!";
        header('Location: view-register.php');
        exit(0);
    }
}


//add speciality process
if (isset($_POST['add_specialitybtn'])) {

    $speciality_id = $_POST['speciality_id'];
    $speciality_name = $_POST['speciality_name'];

    $query = "INSERT INTO specialities (speciality_id,speciality_name) VALUES ('$speciality_id','$speciality_name')";
    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        $_SESSION['message'] = "Speciality Added Successfully";
        header('Location: specialities.php');
        exit(0);
    } else {
        $_SESSION['message'] = "Something went wrong!";
        header('Location: specialities.php');
        exit(0);
    }
}


//add schedule process
if (isset($_POST['addschedulebtn'])) {
    $schedule_owner = $_POST['doctorname'];
    $visibility = $_POST['visibility'];

    $user_query = "SELECT secretary_name FROM users WHERE fullname = '$schedule_owner'";
    $user_query_run = mysqli_query($con, $user_query);
    $row = mysqli_fetch_assoc($user_query_run);
    $secretary_name = $row['secretary_name'];

    $schedule_query = "INSERT INTO schedule (schedule_owner, schedule_secretary, visibility) VALUES ('$schedule_owner', '$secretary_name', '$visibility')";
    $schedule_query_run = mysqli_query($con, $schedule_query);
    if ($schedule_query_run) {
        $_SESSION['message'] = "Schedule added Successfully!";
        header("Location: admin-schedule.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Error!";
        header("Location: admin-schedule.php");
        exit(0);
    }
}



//create_appointmentbtna
//Add a new appointment process from admin side
if (isset($_POST['create_appointmentbtna'])) {
    $patient_name = $_POST['patient'];
    $speciality = $_POST['speciality'];
    $doctor = $_POST['doctor'];
    $appointment_date = $_POST['appointment_date'];
    $slot = $_POST['slot'];

    $query = "INSERT INTO appointment (patient_name,appointment_speciality,doctor_name,appointment_date, appointment_time) VALUES ('$patient_name','$speciality','$doctor','$appointment_date','$slot') ";
    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        $_SESSION['message'] = "Appointment booked Successfully!";
        header("Location: admin-appointment.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Error!";
        header("Location: admin-appointment.php");
        exit(0);
    }
}



//update user process
if (isset($_POST['update_userbtn'])) {
    $user_id = $_POST['user_id'];
    $fullname = $_POST['fullname'];
    $birthday = $_POST['birthday'];
    $gender = $_POST['gender'];

    $email = $_POST['email'];
    $speciality = $_POST['speciality'];
    $secretary_name = $_POST['secretary_name'];
    $doctor_name = $_POST['doctor_name'];
    $password = $_POST['password'];
    $role_as = $_POST['role_as'];
    $status = $_POST['status'] == true ? '1' : '0';

    $query = "UPDATE users SET fullname='$fullname', birthday='$birthday', gender='$gender' ,email='$email', speciality='$speciality', secretary_name='$secretary_name',doctor_name='$doctor_name',password='$password', role_as='$role_as', status='$status'
            WHERE id='$user_id' ";
    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        $_SESSION['message'] = "Updated Succesfully!";
        if ($role_as == "2") {
            header("Location: admin-doctor.php");
            exit();
        } elseif ($role_as == "3") {
            header("Location: admin-secretary.php");
            exit();
        } elseif ($role_as == "0") {
            header("Location: admin-patient.php");
            exit();
        } else {
            header("Location: view-register.php");
            exit(0);
        }
    } else {
        $_SESSION['message'] = "Update process failed!";
        header('Location: edit-register.php');
        exit(0);
    }
}



//update_appointmentbtn2
if (isset($_POST['update_appointmentbtn2'])) {
    $appointment_id = $_POST['appointment_id'];
    $appointment_date = $_POST['appointment_date'];
    $slot = $_POST['slot'];

    $query = "UPDATE appointment SET appointment_date='$appointment_date' , appointment_time='$slot' WHERE appointment_id='$appointment_id' ";
    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        $_SESSION['message'] = "Appointment updated Successfully!";
        header("Location: admin-appointment.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Error!";
        header("Location: admin-appointment.php");
        exit(0);
    }
}



//update speciality process
if (isset($_POST['edit_specialitybtn'])) {
    $user_id = $_POST['speciality_id'];
    $speciality_name = $_POST['speciality_name'];

    $query = "UPDATE specialities SET speciality_name='$speciality_name' WHERE speciality_id='$user_id' ";
    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        $_SESSION['message'] = "Updated Succesfully!";
        header('Location: specialities.php');
        exit(0);
    } else {
        $_SESSION['message'] = "Update process failed!";
        header('Location: specialities.php');
        exit(0);
    }
}



//update schedule
if (isset($_POST['editschedulebtn'])) {

    $schedule_id = $_POST['schedule_id'];
    $visibility = $_POST['visibility'];


    //update data
    $query = "UPDATE schedule SET visibility='$visibility' WHERE schedule_id='$schedule_id'";
    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        $_SESSION['message'] = "Updated Succesfully!!";
        header("Location: admin-schedule.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Error!";
        header("Location: admin-schedule.php");
        exit(0);
    }
}


//informbtn
if (isset($_POST['informbtn'])) {
    $doctorEmail = $_POST['doctor_email'];
    $secretary_name = $_POST['secretary_name'];
    $password = $_POST['password'];

    $to = $doctorEmail;
    $subject = "Informative Email";
    $message = "<p><b>Your E-mail:</b>$doctorEmail</p>
                        <p><b>Your Secretary:</b>$secretary_name</p>
                        <p><b>Your Password:</b>$password</p>";
    $headers = "hospitalmanagementsystem999@gmail.com";

    if (mail($to, $subject, $message, $headers)) {
        $_SESSION['message'] = "User Informed Succesfully!!";
        header("Location: admin-doctor.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Failed to send email!";
        header("Location: admin-doctor.php");
        exit(0);
    }
}
