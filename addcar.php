<!DOCTYPE html>
<html>
<head>
  <title>Add To The Fleet</title>
</head>

<body>
<?php
	$VIN = $_POST["VIN"];
	$make = $_POST["make"];
	$model = $_POST["model"];
	$year = $_POST["year"];
	$address = $_POST["address"];
	$fee = $_POST["fee"];
	
	try{
        $dbh = new PDO('mysql:host=localhost;dbname=ktcs', 'cisc332', 'cisc332password');
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$check = $dbh->prepare("SELECT CarVINcode FROM cars WHERE CarVINcode = ?");
		$check -> bindParam(1,$VIN);
		$check->execute();
		$count = $check -> rowCount();
		
		if($count == 0){
			// $insert = $dbh->query("cars('$VIN', '$make', '$model', '$year', '$address', '$fee', 'normal')");
			// header("Location: AdminMain.html");


			$sql = ("INSERT INTO cars(CarVINcode, Make, Model, Year, Address, DailyRentalFee, Status)
                    VALUES ('$VIN', '$make', '$model', '$year', '$address','$fee','normal')"); //Default Admin setting is NO, DBA can change privileges in future
            $dbh -> exec($sql);
            // should do something now like create a new session
            echo "<script>
            alert('Car successfully registered.');
            window.location.href = 'AdminMain.html';
            </script>";
		}else{
			echo "<script>
            alert('The Car VIN Code You Entered Already Exiting. Add Another Car.');
			window.location.href='AdminMain.html';
            </script>";
		}                                                                                    				
	} catch(PDOException $e){		
        die();
	}
    $dbh = null;
	
?>