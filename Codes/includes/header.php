<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?php if (isset($page_title)) {
                echo "$page_title";
            } else {
                echo "Hospital Management System";
            } ?> </title>
    <meta name="description" content="<?php if (isset($meta_description)) {
                                            echo "$meta_description";
                                        }  ?>" />
    <meta name="keywords" content="<?php if (isset($meta_keywords)) {
                                        echo "$meta_keywords";
                                    }  ?>" />
    <meta name="author" content="Ali Can Dogan" />
    <link rel="shortcut icon" type="image/x-icon" href="../../images/logo.png">


    <link rel="stylesheet" href="../datetimepicker/jquery.datetimepicker.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/bootstrap5.min.css">
    <link rel="stylesheet" href="../assets/css/custom.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.css" integrity="sha512-bYPO5jmStZ9WI2602V2zaivdAnbAhtfzmxnEGh9RwtlI00I9s8ulGe4oBa5XxiC6tCITJH/QG70jswBhbLkxPw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <?php include("admin/config/dbcon.php"); ?>

</head>


<body style="overflow-x: hidden;" class=".bg-light.bg-gradient">
    <div class="row justify-content-center">