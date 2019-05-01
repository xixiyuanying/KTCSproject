<!DOCTYPE html>
<html>
<head>
  <title>Drop off Car</title>
</head>

<body>
<?php
	session_start();
	$DropDate = $_POST["dropoffdate"];
    $DropOdimeter = $_POST["odimeter"];
    $ReservationNum = $_POST["passReservationNum"];
    $PickOdimeter = $_SESSION["PickOdimeter"];
    $CarStatus = $_POST["carstatus"];
    $randomNum = rand(10000000, 99999999);

    
    echo "DropDate: $DropDate <br>";
    echo "CarStatus: $CarStatus <br>";
    echo "DropOdimeter: $DropOdimeter <br>"; 
    echo "PickOdimeter: $PickOdimeter <br>";
    echo "ReservationNum:  $ReservationNum <br> ";

    
    
	
	try{
        $dbh = new PDO('mysql:host=localhost;dbname=ktcs', 'cisc332', 'cisc332password');
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $memberNum = $dbh->query("SELECT MemberNum FROM reservation WHERE ReservationNum = '$ReservationNum' ");
		$memberNum = $memberNum->fetch();
		$memNum = $memberNum["MemberNum"];
        echo "MemberNum for reservation $ReservationNum is $memNum";
        
        $CarVINcode = $dbh->query("SELECT CarVINcode FROM reservation WHERE ReservationNum = '$ReservationNum' ");
		$CarVINcode = $CarVINcode ->fetch();
		$carCode = $CarVINcode["CarVINcode"];
        echo "CarVINcode for reservation $ReservationNum is $carCode";
               
        
        $insert = $dbh->query ("INSERT INTO rental_history (HistoryID, CarVINcode , MemberNum, PickupOdometerReading, DropoffOdometerReading, Status )
                VALUES ( '$randomNum', '$carCode', '$memNum', '$PickOdimeter', '$DropOdimeter','$CarStatus')");
        echo "<p> You have drop off your car and insert a new rental history.<p>";

        $update = $dbh -> query (" UPDATE cars SET cars.Status = '$CarStatus' WHERE CarVINcode = '$carCode' ");
        echo "<p>You have update the status in cars table</P> ";
       
		                                                                              				
	} catch(PDOException $e){		
            die();
	}
    $dbh = null;
   
    
	
?>