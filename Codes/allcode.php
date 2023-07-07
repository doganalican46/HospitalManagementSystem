<?php
include("admin/config/dbcon.php");
session_start();


// log out process
if (isset($_POST['logoutbtn'])) {
    unset($_SESSION['auth']);
    unset($_SESSION['auth_role']);
    unset($_SESSION['auth_user']);
    $_SESSION['message'] = "Log Out Successfully";
    header("Location: login.php");
    exit(0);
}


// delete account process
if (isset($_POST['deleteaccountbtn'])) {
    $user_id = $_SESSION['auth_user']['id'];
    $query = "DELETE FROM users WHERE id='$user_id' ";
    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        unset($_SESSION['auth']);
        unset($_SESSION['auth_role']);
        unset($_SESSION['auth_user']);
        $_SESSION['message'] = "User deleted Successfully";
        $_SESSION['message'] = "Log Out Successfully";
        header("Location: login.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Something went wrong!";
        header('Location: user-profile.php');
        exit(0);
    }
}


//delete_schedulebtn
if (isset($_POST['delete_schedulebtn'])) {
    $user_id = $_POST['schedule_id'];
    $query = "DELETE FROM schedule WHERE schedule_id='$user_id' ";
    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        $_SESSION['message'] = "Schedule deleted Successfully";
        header('Location: user-schedule.php');
        exit(0);
    } else {
        $_SESSION['message'] = "Something went wrong!";
        header('Location: user-schedule.php');
        exit(0);
    }
}



//delete_appointmentbtnpatient
if (isset($_POST['delete_appointmentbtnpatient'])) {
    $appointment_id = $_POST['appointment_id'];
    $query = "SELECT appointment.patient_name, appointment.appointment_date,appointment.appointment_secretary,appointment.doctor_name,appointment.appointment_speciality,appointment.appointment_time,users.email, users.fullname FROM appointment INNER JOIN users ON appointment.patient_name = users.fullname WHERE appointment.appointment_id='$appointment_id'";
    $query_run = mysqli_query($con, $query);
    if (mysqli_num_rows($query_run) > 0) {
        $row = mysqli_fetch_assoc($query_run);
        $patient_name = $row['patient_name'];
        $recipient_email = $row['email'];
        $recipient_name = $row['fullname'];
        $appointment_date = $row['appointment_date'];
        $appointment_time = $row['appointment_time'];
        $appointment_doctor = $row['doctor_name'];
        $appointment_secretary = $row['appointment_secretary'];
        $appointment_speciality = $row['appointment_speciality'];
        if ($patient_name == $_SESSION['auth_user']['secretary_name'] || $_SESSION['auth_user']['doctor_name'] || $_SESSION['auth_user']['fullname']) {
            $delete_query = "DELETE FROM appointment WHERE appointment_id='$appointment_id' ";
            $delete_query_run = mysqli_query($con, $delete_query);
            if ($delete_query_run) {
                $_SESSION['message'] = "Appointment deleted successfully...";
                require 'PHPMailer/src/Exception.php';
                require 'PHPMailer/src/PHPMailer.php';
                require 'PHPMailer/src/SMTP.php';

                $mail = new PHPMailer\PHPMailer\PHPMailer();

                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'alicanalican4141@gmail.com';
                $mail->Password = 'ddbrgvaeutlqwcxo';
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;

                $mail->setFrom('alicanalican4141@gmail.com', 'Ali Can Dogan');
                $mail->addAddress($recipient_email, $recipient_name);
                $mail->Subject = 'Appointment Deleted';
                $mail->Body = 'Hello ' . $appointment_secretary . ', appointment with patient ' . $patient_name . ' in details: ' . $appointment_speciality . '| ' . $appointment_date . '- ' . $appointment_time . '  
                canceled! Sorry for that, Do not forget inform your doctor...';

                if ($mail->send()) {
                    $_SESSION['message'] = "Appointment deleted successfully. An email has been sent to patient.";
                } else {
                    $_SESSION['message'] = "Appointment deleted successfully, but there was an error sending the email.";
                }

                header("Location: user-appointment.php");
                exit(0);
            } else {
                $_SESSION['message'] = "Something went wrong!";
                header('Location: user-appointment.php');
                exit(0);
            }
        } else {
            $_SESSION['message'] = "You are not authorized to delete this appointment.";
            header('Location: user-appointment.php');
            exit(0);
        }
    } else {
        $_SESSION['message'] = "Appointment not found.";
        header('Location: user-appointment.php');
        exit(0);
    }
}



//delete_appointmentbtn
if (isset($_POST['delete_appointmentbtn'])) {
    $appointment_id = $_POST['appointment_id'];
    $query = "SELECT appointment.patient_name, appointment.appointment_date,appointment.doctor_name,appointment.appointment_speciality,appointment.appointment_time,users.email, users.fullname FROM appointment INNER JOIN users ON appointment.patient_name = users.fullname WHERE appointment.appointment_id='$appointment_id'";
    $query_run = mysqli_query($con, $query);
    if (mysqli_num_rows($query_run) > 0) {
        $row = mysqli_fetch_assoc($query_run);
        $patient_name = $row['patient_name'];
        $recipient_email = $row['email'];
        $recipient_name = $row['fullname'];
        $appointment_date = $row['appointment_date'];
        $appointment_time = $row['appointment_time'];
        $appointment_doctor = $row['doctor_name'];
        $appointment_speciality = $row['appointment_speciality'];
        if ($patient_name == $_SESSION['auth_user']['secretary_name'] || $_SESSION['auth_user']['doctor_name'] || $_SESSION['auth_user']['fullname']) {
            $delete_query = "DELETE FROM appointment WHERE appointment_id='$appointment_id' ";
            $delete_query_run = mysqli_query($con, $delete_query);
            if ($delete_query_run) {
                $_SESSION['message'] = "Appointment deleted successfully...";
                require 'PHPMailer/src/Exception.php';
                require 'PHPMailer/src/PHPMailer.php';
                require 'PHPMailer/src/SMTP.php';

                $mail = new PHPMailer\PHPMailer\PHPMailer();

                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'alicanalican4141@gmail.com';
                $mail->Password = 'ddbrgvaeutlqwcxo';
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;

                $mail->setFrom('alicanalican4141@gmail.com', 'Ali Can Dogan');
                $mail->addAddress($recipient_email, $recipient_name);
                $mail->Subject = 'Appointment Deleted';
                $mail->Body = 'Hello ' . $patient_name . ', your appointment with doctor ' . $appointment_doctor . ' in details: ' . $appointment_speciality . '| ' . $appointment_date . '- ' . $appointment_time . '  canceled! Sorry for that, Do not forget create a new appointment...';

                if ($mail->send()) {
                    $_SESSION['message'] = "Appointment deleted successfully. An email has been sent to patient.";
                } else {
                    $_SESSION['message'] = "Appointment deleted successfully, but there was an error sending the email.";
                }

                header("Location: user-appointment.php");
                exit(0);
            } else {
                $_SESSION['message'] = "Something went wrong!";
                header('Location: user-appointment.php');
                exit(0);
            }
        } else {
            $_SESSION['message'] = "You are not authorized to delete this appointment.";
            header('Location: user-appointment.php');
            exit(0);
        }
    } else {
        $_SESSION['message'] = "Appointment not found.";
        header('Location: user-appointment.php');
        exit(0);
    }
}



// add new schedule from doctor side
if (isset($_POST['schedulesavebtn'])) {
    // Retrieve the form data
    $schedule_owner = $_SESSION['auth_user']['fullname'];
    $schedule_secretary = $_SESSION['auth_user']['secretary_name'];
    $visibility = $_POST['visibility'];


    $user_query = "INSERT INTO schedule (schedule_owner, schedule_secretary, visibility) VALUES ('$schedule_owner','$schedule_secretary','$visibility')";
    $user_query_run = mysqli_query($con, $user_query);
    if ($user_query_run) {
        $_SESSION['message'] = "Schedule Updated Successfully!";
        header("Location: user-schedule.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Error!";
        header("Location: user-schedule.php");
        exit(0);
    }
}


// add new schedule from secretary side
if (isset($_POST['schedulesavebtn'])) {
    // Retrieve the form data
    $schedule_owner = $_SESSION['auth_user']['doctor_name'];
    $schedule_secretary = $_SESSION['auth_user']['fullname'];
    $visibility = $_POST['visibility'];


    $user_query = "INSERT INTO schedule (schedule_owner, schedule_secretary, visibility) VALUES ('$schedule_owner','$schedule_secretary','$visibility')";
    $user_query_run = mysqli_query($con, $user_query);
    if ($user_query_run) {
        $_SESSION['message'] = "Schedule Updated Successfully!";
        header("Location: user-schedule.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Error!";
        header("Location: user-schedule.php");
        exit(0);
    }
}




//Add a new appointment process from patient side
if (isset($_POST['makeappointmentbtn'])) {
    $patient_name = $_SESSION['auth_user']['fullname'];
    $speciality = $_POST['speciality'];
    $doctor = $_POST['doctor'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $patient_note = $_POST['patient_note'];

    $appointment_control = "SELECT COUNT(*) FROM appointment WHERE appointment_date = '$appointment_date' AND appointment_time = '$appointment_time' AND doctor_name = '$doctor' ";
    $appointment_control_run = mysqli_query($con, $appointment_control);
    $result = mysqli_fetch_row($appointment_control_run);
    $slotAvailable = ($result[0] == 0);

    if ($slotAvailable) {
        $query = "INSERT INTO appointment (patient_name, appointment_speciality, doctor_name, appointment_date, appointment_time, patient_note) VALUES ('$patient_name','$speciality','$doctor','$appointment_date','$appointment_time','$patient_note') ";
        $query_run = mysqli_query($con, $query);

        if ($query_run) {
            $_SESSION['message'] = "Appointment booked Successfully!";
            header("Location: user-appointment.php");
            exit(0);
        } else {
            $_SESSION['message'] = "Error!";
            header("Location: user-appointment.php");
            exit(0);
        }
    } else {
        $_SESSION['message'] = "Appointment slot not available!";
        header("Location: user-appointment.php");
        exit(0);
    }
}

//create_appointment 
if (isset($_GET['create_appointment'])) {
    $patient_name = $_SESSION['auth_user']['fullname'];
    $selectedSpeciality = $_POST['speciality'];
    $selectedDoctor = $_POST['doctor'];
    $selectedDate = $_POST['date'];
    $selectedTime = $_POST['time'];
    $selectedNote = $_POST['patient_note'];

    $query = "INSERT INTO appointment (patient_name,appointment_speciality,doctor_name,appointment_date, appointment_time,patient_note) VALUES ('$patient_name','$selectedSpeciality','$selectedDoctor','$selectedDate','$selectedTime','$selectedNote') ";
    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        $_SESSION['message'] = "Appointment booked Successfully!";
        header("Location: user-appointment.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Error!";
        header("Location: user-appointment.php");
        exit(0);
    }
}



//create_appointmentbtn from doctor side
if (isset($_POST['create_appointmentbtn'])) {
    $doctor_name = $_SESSION['auth_user']['fullname'];
    $speciality = $_SESSION['auth_user']['speciality'];
    $secretary_name = $_SESSION['auth_user']['secretary_name'];
    $patient = $_POST['patient'];
    $appointment_date = $_POST['appointment_date'];
    $slot = $_POST['slot'];
    $doctor_note = $_POST['doctor_note'];

    $query = "INSERT INTO appointment (doctor_name,appointment_speciality,appointment_secretary,patient_name,appointment_date, appointment_time,doctor_note) VALUES ('$doctor_name','$speciality','$secretary_name','$patient','$appointment_date','$slot','$doctor_note') ";
    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        $_SESSION['message'] = "Appointment booked Successfully!";
        header("Location: user-appointment.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Error!";
        header("Location: user-appointment.php");
        exit(0);
    }
}

//create_appointmentbtn from secretary side
if (isset($_POST['create_appointmentbtn2'])) {
    $doctor_name = $_SESSION['auth_user']['doctor_name'];
    $specialityquery = "SELECT speciality FROM users WHERE fullname='$doctor_name'";
    $specialityquery_run = mysqli_query($con, $specialityquery);
    if (mysqli_num_rows($specialityquery_run) > 0) {
        $row = mysqli_fetch_assoc($specialityquery_run);
        $speciality = $row['speciality'];
    }

    $secretary_name = $_SESSION['auth_user']['fullname'];
    $patient = $_POST['patient'];
    $appointment_date = $_POST['appointment_date'];
    $slot = $_POST['slot'];
    $secretary_note = $_POST['secretary_note'];

    $query = "INSERT INTO appointment (doctor_name, appointment_speciality, appointment_secretary, patient_name, appointment_date, appointment_time, secretary_note) VALUES ('$doctor_name', '$speciality', '$secretary_name', '$patient', '$appointment_date', '$slot', '$secretary_note')";
    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        $_SESSION['message'] = "Appointment booked Successfully!";
        header("Location: user-appointment.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Error!";
        header("Location: user-appointment.php");
        exit(0);
    }
}




// update schedule process
if (isset($_POST['scheduleupdatebtn'])) {

    $schedule_id = $_POST['schedule_id'];
    $days = $_POST['days'];
    $alldays = implode(",", $days);
    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];

    //update data
    $query = "UPDATE schedule SET schedule_day='$alldays', start_time='$startTime', end_time='$endTime' WHERE schedule_id='$schedule_id'";
    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        $_SESSION['message'] = "Updated Succesfully!!";
        header("Location: user-schedule.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Error!";
        header("Location: user-schedule.php");
        exit(0);
    }
}


//update_schedulebtn
if (isset($_POST['update_schedulevisibility'])) {

    $schedule_id = $_POST['schedule_id'];
    $visibility = $_POST['visibility'];

    //update data
    $query = "UPDATE schedule SET visibility='$visibility' WHERE schedule_id='$schedule_id'";
    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        $_SESSION['message'] = "Updated Succesfully!!";
        header("Location: user-schedule.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Error!";
        header("Location: user-schedule.php");
        exit(0);
    }
}


// update user process
if (isset($_POST['update_userbtn'])) {

    $user_id = $_POST['user_id'];
    $fullname = $_POST['fullname'];
    $birthday = $_POST['birthday'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    //insert data
    $user_query = "UPDATE users SET fullname='$fullname', birthday='$birthday', gender='$gender' ,email='$email', password='$password' WHERE email='$email'";
    $user_query_run = mysqli_query($con, $user_query);
    if ($user_query_run) {
        $_SESSION['auth_user']['fullname'] = $fullname;
        $_SESSION['auth_user']['birthday'] = $birthday;
        $_SESSION['auth_user']['gender'] = $gender;
        $_SESSION['auth_user']['email'] = $email;
        $_SESSION['auth_user']['password'] = $password;
        //echo "Updated Successfully!";
        $_SESSION['message'] = "Updated Succesfully!!";
        header("Location: user-profile.php");
        exit(0);
    } else {
        //echo "Error!";
        $_SESSION['message'] = "Error!";
        header("Location: user-profile.php");
        exit(0);
    }
}


//update appointment process
if (isset($_POST['update_appointmentbtn'])) {
    $appointment_id = $_POST['appointment_id'];
    $patient_name = $_SESSION['auth_user']['fullname'];
    $appointment_date = $_POST['appointment_date'];
    $slot = $_POST['slot'];
    $patient_note = $_POST['patient_note'];

    $query = "UPDATE appointment SET patient_name='$patient_name', appointment_date='$appointment_date' , appointment_time='$slot', patient_note='$patient_note' WHERE appointment_id='$appointment_id' ";
    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        $_SESSION['message'] = "Appointment updated Successfully!";
        header("Location: user-appointment.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Error!";
        header("Location: user-appointment.php");
        exit(0);
    }
}


//update_doctorappointmentbtn from doctor side
if (isset($_POST['update_doctorappointmentbtn'])) {
    $appointment_id = $_POST['appointment_id'];
    $appointment_speciality = $_SESSION['auth_user']['speciality'];
    $doctor_name = $_SESSION['auth_user']['fullname'];
    $appointment_date = $_POST['appointment_date'];
    $slot = $_POST['slot'];
    $doctor_note = $_POST['doctor_note'];

    $query = "UPDATE appointment SET appointment_speciality='$appointment_speciality',  appointment_date='$appointment_date' , appointment_time='$slot', doctor_note='$doctor_note' WHERE appointment_id='$appointment_id' ";
    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        $_SESSION['message'] = "Appointment updated Successfully!";
        header("Location: user-appointment.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Error!";
        header("Location: user-appointment.php");
        exit(0);
    }
}


//update_doctorappointmentbtn2 from secretary side
if (isset($_POST['update_doctorappointmentbtn2'])) {
    $appointment_id = $_POST['appointment_id'];
    $doctor_name = $_SESSION['auth_user']['doctor_name'];
    $secretary_name = $_SESSION['auth_user']['fullname'];
    $appointment_date = $_POST['appointment_date'];
    $slot = $_POST['slot'];
    $secretary_note = $_POST['secretary_note'];

    $query = "UPDATE appointment SET appointment_secretary='$secretary_name' , doctor_name='$doctor_name',  appointment_date='$appointment_date' , appointment_time='$slot', secretary_note='$secretary_note' WHERE appointment_id='$appointment_id' ";
    $query_run = mysqli_query($con, $query);
    if ($query_run) {
        $_SESSION['message'] = "Appointment updated Successfully!";
        header("Location: user-appointment.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Error!";
        header("Location: user-appointment.php");
        exit(0);
    }
}
