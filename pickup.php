<!DOCTYPE html>
<html>
<head>
  <title>Pick up Car</title>
</head>

<body>
<?php


    echo "<h1> You have picked up a car. </h1>";
	session_start();
	$PickDate = $_POST["pickupdate"];
    $PickOdimeter = $_POST["odimeter"];
    $CarStatus = $_POST["carstatus"];
    echo "<p> Pick up date :$PickDate </p>";
    echo "<p> Car status : $CarStatus </p>";
    echo "<p> Pick up odimeter :$PickOdimeter </P>";
    
    $_SESSION["PickOdimeter"] = $PickOdimeter;
    
	
    

    

	
?>