<!DOCTYPE html>
<html>
<head>
  <title>Give feedback</title>
</head>

<body>
<?php
	session_start();
	$Rating = $_POST["rating"];
    $Comments = $_POST["comment"];
    $randomNum = rand(100000, 999999);
    $CarVINcode = $_POST["passCarVINcode"];
    $MemberNum = $_POST["passMemberNum"];
    
    echo "CarVINcode: $CarVINcode <br>";
    echo "MemberNum: $MemberNum<br>";
    echo "Rating: $Rating<br>";
    echo "Comments: $Comments<br>";
    
    switch ($Rating) {
    case "onestar":
        $rateNum = 1;
        break;
    case "twosrar":
        $rateNum = 2;
        break;
    case "threestar":
        $rateNum = 3;
        break;
     case "fourstar":
        $rateNum = 4;
        break;    
    default:
        $rateNum = Null;
    }
    
    echo "rateNum: $rateNum<br>";
    
    	
	try{
        $dbh = new PDO('mysql:host=localhost;dbname=ktcs', 'cisc332', 'cisc332password');
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $insert = $dbh->query ("INSERT INTO rental_comments (CommentID, MemberNum , CarVINcode, Rating, CommentText )
                                VALUES ( '$randomNum', '$MemberNum', '$CarVINcode', '$rateNum', '$Comments')");
        echo "<p> You have provided a comment for  your reatal and insert a new comment history.<p>";        
		echo "<script>
            alert('Go back to Your Account Page.');
            window.location.href='AccountPage.php';
        </script>";
		                                                                              				
	} catch(PDOException $e){		
            die();
	}
    $dbh = null;
    
	
?>