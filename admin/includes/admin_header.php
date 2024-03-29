<!-- Database Connection -->
<?php include "../includes/db.php"; ?>
<!-- functions file -->
<?php include "functions.php"; ?>
<!-- Output buffering -->
<?php ob_start(); ?>
<!-- SESSION -->
<?php session_start(); ?>
<?php if (!$_SESSION["user_role"]) {
    header("Location: ../index.php");
} ?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="../images/favIcon.png" type="image/x-icon">
    <meta name="description" content="Alireza Mak | Front End Developer, CMS Project">
    <meta name="author" content="Alireza Mak | Front End Developer">

    <title>Alireza Mak | Front End Developer</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
    <!-- Custom Google Charts -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <!-- Summernote CSS -->
    <link rel="stylesheet" href="css/summernote.css">



    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>