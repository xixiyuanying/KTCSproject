<!DOCTYPE html>
<html>
<head>
  <title>Proces Response</title>
</head>

<body>
<?php
	session_start();
	$CommentID = $_POST["passCommentID"];
    $Response = $_POST["response"];
    
    echo "CommentID: $CommentID <br>";
	
	try{
        $dbh = new PDO('mysql:host=localhost;dbname=ktcs', 'cisc332', 'cisc332password');
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
        $insert = $dbh->query ("UPDATE rental_comments SET AdminReply = '$Response' where CommentID = '$CommentID'");
        echo "You have successfully give a reponse!";
		
		echo "<script>
            alert('Give another comment.');
            window.location.href='respondcomment.php';
            </script>";
		                                                                              				
	} catch(PDOException $e){		
            die();
	}
    $dbh = null;
   
    
	
?>