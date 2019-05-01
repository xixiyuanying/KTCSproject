<!DOCTYPE html>
<html>
<head>
  <title>Reserve It</title>
</head>

<body>
<?php
	session_start();
	$VIN = $_GET["carVINcode"];
	$_SESSION["CarVINcode"] = $VIN;
	$user = $_SESSION["emaillogined"];
	$pickup = $_SESSION["pickup"];
	$dropoff = $_SESSION["dropoff"];
	$length = (strtotime($dropoff) - strtotime($pickup))/86400;
	$accessCode = rand(1000, 9999);
	//$day = date('m').date('d'); 
	$resNum	= rand(1000, 99999999);
	$today = date("Y-m-d"); 
	
	try{
        $dbh = new PDO('mysql:host=localhost;dbname=ktcs', 'cisc332', 'cisc332password');
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$memberNum = $dbh->query("SELECT MemberNum FROM ktcs_members WHERE Email = '$user'");
		$memberNum = $memberNum->fetch();
		$memNum = $memberNum["MemberNum"];
		$_SESSION["MemberNum"] = $memNum;
		$insert = $dbh->query("insert into reservation values('$resNum', '$memNum', '$VIN', '$pickup', '$length', '$accessCode', '$today')");
		echo "<script>
            alert('You have successfully reserved the car from $pickup to $dropoff.');
            window.location.href='UserMain.html';
            </script>";                                                                                     				
	} catch(PDOException $e){		
            die();
	}
    $dbh = null;
	
?>