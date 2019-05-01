<!DOCTYPE html>
<html>
<head>
  <title>Show history</title>
</head>
<body>

<?php
    session_start();
         
    try{
        $dbh = new PDO('mysql:host=localhost;dbname=ktcs', 'cisc332', 'cisc332password');
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				              
        if (isset($_SESSION["emaillogined"])) {
        $checkemail = $_SESSION["emaillogined"];

        $rentalhistorys = $dbh -> query("SELECT * FROM `rental_history` WHERE rental_history.MemberNum = 
                                   ( SELECT ktcs_members.MemberNum FROM `ktcs_members` WHERE Email = '$checkemail' )" );
        
        foreach ($rentalhistorys as $history){

            //$_SESSION['CarVINcode'] = $history[1];
            //$_SESSION['MemberNum'] = $history[2];   
            //echo "<a href="givefeedback.php?Username=John&Passsword=thePassword">Submit</a>";            
            
            echo "<p> HistoryID: $history[0] </p>";
            echo "<p> CarVINcode: $history[1] </p>";
            echo "<p> MemberNum: $history[2] </P>";
            echo "<p> PickupOdometerReading: $history[3] </P>";
            echo "<p> DropoffOdometerReading: $history[4] </P>";
            echo "<p> Status: $history[5] </P>";
            /*
            echo "<form name = 'Write Comment' action = 'givefeedback.php' method='POST' enctype='multipart/form-data'>
                  <input type='hidden' name='CarVINcode' value='$history[1]'>
                  <input type='hidden' name='MemberNum' value='$history[2]'>
                  <input type='submit' value='Give a feedback' />
                  </form>           
            ";
            */
            echo "<p>________________________________________________________________</p>";
        }
        

    }
                                                                                          
					
	} catch(PDOException $e){		
            die();
		}
        $dbh = null;
        
            
?>
            
</body>
</html> 