<!DOCTYPE html>
<html>
<head>
  <title>Registration Page</title>
</head>

<body>

<?php
error_reporting(E_ALL);
    // $Username = $_POST['username'];
    $Name = $_POST['name'];
    $Email = $_POST['loginemail'];
    $Password1 = $_POST['password1'];
    $Password2 = $_POST['password2'];
    $Address = $_POST['address'];
    $Driver_License_Number = $_POST['license'];
    $Phone_Number = $_POST['phone'];

    //check and format driver's licence.
    $Driver_License_Number = str_replace(' ', '', $Driver_License_Number);
    $Driver_License_Number = preg_replace('/\s+/', '', $Driver_License_Number);
    $Driver_License_Number = str_replace('-', '', $Driver_License_Number);

    //check and format phone number.
    $Phone_Number = str_replace(' ', '', $Phone_Number);
    $Phone_Number = preg_replace('/\s+/', '', $Phone_Number);
    $Phone_Number = str_replace('-', '', $Phone_Number);

    if (empty($Email) || empty($Password1) || empty($Password2) || empty($Address) || empty($Driver_License_Number) || empty($Phone_Number)) {
        echo "<script>
          alert('Please fill in all text boxes.');
          window.history.back();
          </script>";
    }
    elseif (strlen($Phone_Number) != 10 || is_numeric($Phone_Number) == false)
    {
        echo "<script>
          alert('Incorrect Phone Number.');
          window.history.back();
          </script>";
    }
    elseif (strlen($Driver_License_Number) != 15 || is_numeric($Driver_License_Number[0]) == true)
    {
        echo "<script>
          alert('Incorrect Driver License Number.');
          window.history.back();
          </script>";
    }
    elseif($Password1 != $Password2)
    {
        echo "<script>
          alert('Passwords do not match.');
          window.history.back();
          </script>";
    }
    else {
      try {
          $dbh = new PDO('mysql:host=localhost;dbname=ktcs', 'cisc332', 'cisc332password');
          $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         	$result= $dbh -> prepare("SELECT Email FROM ktcs_members WHERE Email = ?");
          $result -> bindParam(1,$Email);
          $result -> execute();
          //print_r($result);
  		    $count = $result -> rowCount();
          //print_r($count);

          if ($count == 0) { // OK, email is not registered yet
          //Generate random memberNum
            // $MemberNumber = 0;
            $OK = false;
            while ($OK == false)
            {
                $MemberNumber = rand(10000000, 99999999); //To lazy to implement memberNum like 00033452
                $result = $dbh -> prepare("SELECT MemberNum FROM ktcs_members WHERE MemberNum= ?");
                $result -> bindParam(1,$MemberNumber);
                $result -> execute();
                $count2 = $result -> rowCount();
                if ($count2 == 0){
                  $OK = true;
                }
            }

            $sql = ("INSERT INTO ktcs_members (MemberNum, Name, Address, PhoneNum, Email, DriverLicenseNum, AnnualMembershipFee, Password, Admin)
                    VALUES ('$MemberNumber', '$Name', '$Address', '$Phone_Number', '$Email', '$Driver_License_Number', '120', '$Password2', 'NO')"); //Default Admin setting is NO, DBA can change privileges in future
            $dbh -> exec($sql);
            // should do something now like create a new session
            echo "<script>
            alert('Account successfully registered. Please Login.');
            window.location.href = 'login.html';
            </script>";
          } 

          else 
          {
            echo "<script>
            alert('The Email or Name that you entered is already registered. Please try another Email or Name.');
            window.history.back();
            </script>";
          }
      }
      catch(PDOException $e) {
          die($e);
      }
      $conn = null; 
    }
  ?>
</body>
</html>  
