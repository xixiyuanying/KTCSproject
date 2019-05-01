<!DOCTYPE html>
<html>
<head>
  <title>Login check</title>
</head>
<body>

<?php
    try{
        $dbh = new PDO('mysql:host=localhost;dbname=ktcs', 'cisc332', 'cisc332password');
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
                
        if(isset($_POST["loginemail"], $_POST["password"])) {     

        $loginemail = $_POST["loginemail"];
        $password = $_POST["password"];

        $result = $dbh->query("SELECT Email, Admin FROM ktcs_members 
                                WHERE Email = '".$loginemail."' AND  Password = '".$password."'");
        $result -> execute();
        $count = $result -> rowCount();
        $adminStatus = $result -> fetch(PDO::FETCH_ASSOC);

        //echo $adminStatus['Admin'];
        if($count == 1 ){       
            session_start();
            $_SESSION["emaillogined"] = $loginemail;
        
            if(isset($_SESSION["emaillogined"])){
                if ($adminStatus['Admin'] == 'NO'){
                    header("Location: UserMain.html");
                    die();
                }
                else{
                    header("Location: AdminMain.html");
                    die();
                }
            }    
        } 
        else{
            echo "<script>
            alert('Your email address or password is incorrect; please enter again.');
            window.history.back();
            </script>";
        }
        }
    }
    catch(PDOException $e){		
            die();
	}
    $dbh = null;      
?>     
</body>
</html>            