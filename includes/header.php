<!-- Data base Connection -->
<?php include "./includes/db.php"; ?>
<!-- Function -->
<?php include "admin/functions.php"; ?>
<!-- Output buffering -->
<?php ob_start(); ?>
<!-- Session -->
<?php session_start(); ?>
<!DOCTYPE html>
<?php
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
    if (isset($_SESSION['lang']) && $_SESSION['lang'] != $_GET['lang']) {
        echo "<script type='text/javascript'>location.reload();</script>";
    }
}
if (isset($_SESSION['lang'])) {
    include "./languages/" . $_SESSION['lang'] . ".php";
} else {
    include "./languages/en.php";
}

?>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Alireza Mak | Front End Developer, CMS Project">
    <meta name="author" content="Alireza Mak | Front End Developer">
    <link rel="shortcut icon" href="/portfolio/images/favIcon.png" type="image/x-icon">

    <title>Alireza Mak | Front End Developer</title>

    <!-- Bootstrap Core CSS -->
    <link href="/portfolio/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/portfolio/css/blog-home.css" rel="stylesheet">


</head>

<body>