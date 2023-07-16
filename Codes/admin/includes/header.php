<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
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
    <link rel="shortcut icon" type="image/x-icon" href="logo.png">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="../js/table2excel.js"></script>
</head>

<style>
    
</style>

<body class="sb-nav-fixed">

    <?php include("includes/navbar-top.php"); ?>

    <div id="layoutSidenav">

        <?php include("includes/sidebar.php"); ?>

        <div id="layoutSidenav_content">
            <main>