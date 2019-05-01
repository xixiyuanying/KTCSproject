<!DOCTYPE html>
<html>

<head>
    <title>Compute Invoice Page</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Find all reservations</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Theme CSS -->
    <link href="css/freelancer.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body id="page-top" class="index">
<div id="skipnav"><a href="#maincontent">Skip to main content</a></div>

    <!-- Navigation -->
    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="UserMain.html">K-Town Car Share</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li class="page-scroll">
                        <a href="Logout.php">Sign Out</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
 
    <section id="alldamagecars">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>Monthly Invoice</h2>
                    <hr class="star-primary">
                </div>
            </div>
            <?php
            error_reporting(E_ALL);
                // $Username = $_POST['username'];
                $Month = $_POST['month'];
                $Email = $_POST['loginemail'];

                try {
                    $dbh = new PDO('mysql:host=localhost;dbname=ktcs', 'cisc332', 'cisc332password');
                    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $result= $dbh -> prepare("SELECT Email FROM ktcs_members WHERE Email = ?");
                    $result -> bindParam(1,$Email);
                    $result -> execute();
              		$count = $result -> rowCount();

              		if ($count == 0){
              		echo "<script>
                        alert('The Email you entered is NOT registered. Please try another Email.');
                        window.history.back();
                        </script>";
                    }
                    //Email is registered, now compute the monthly invoice
                    else{
                    	//First, translate $Month string to integer value, from 1 to 12. This will be used to filter the Rental Start Date
                    	$IntMonth;
                    	if ($Month == 'January') {$IntMonth = 1;}
                    	elseif ($Month == 'February') {$IntMonth = 2;}
                    	elseif ($Month == 'March') {$IntMonth = 3;}
                    	elseif ($Month == 'April') {$IntMonth = 4;}
                    	elseif ($Month == 'May') {$IntMonth = 5;}
                    	elseif ($Month == 'June') {$IntMonth = 6;}
                    	elseif ($Month == 'July') {$IntMonth = 7;}
                    	elseif ($Month == 'August') {$IntMonth = 8;}
                    	elseif ($Month == 'September') {$IntMonth = 9;}
                    	elseif ($Month == 'October') {$IntMonth = 10;}
                    	elseif ($Month == 'November') {$IntMonth = 11;}
                    	else {$IntMonth = 12;}

                    	//Second, find the memberNum corresponding with Email
                    	$result= $dbh -> prepare("SELECT memberNum FROM ktcs_members WHERE Email = ?");
                    	$result -> bindParam(1,$Email);
                    	$result -> execute();
                    	$MemberNumber = $result -> fetch();
                    	$MemberNumber = $MemberNumber[0];

                    	$result= $dbh -> prepare("SELECT CarVINcode, MemberNum, LengthOfReservation, RentalStartingDate, DailyRentalFee, (LengthOfReservation * DailyRentalFee) as Total
            				FROM reservation NATURAL JOIN cars 
            				Where MemberNum = ? AND Month(RentalStartingDate) = ?");
                    	$result -> bindParam(1,$MemberNumber);
                    	$result -> bindParam(2,$IntMonth);
                    	$result -> execute();

                    	echo "<legend>Member: $MemberNumber - Email: $Email - Month of: $Month</legend>";
                    	echo "<br>";
                    	echo " <table border = '1'>
                            <tr>
                              <th>Car VIN code</th>
                              <th>Rental Start Date</th>
                              <th>Reservation Length (Days)</th>
                              <th>Daily Rental Fee ($)</th>                 
                              <th>Total Amount Paid ($)</th>
                            </tr>";

                        foreach ($result as $row) {
                            echo "<tr>
                                    <td>$row[0]</td>
                                    <td>$row[3]</td>
                                    <td>$row[2]</td>
                                    <td>$row[4]</td>
                                    <td>$row[5]</td>                     
                                  </tr>";
                            }                   
                   		echo "</table>";
                   		echo "<br>";

                    	//Calculate total monthly invoice
                    	$result= $dbh -> prepare("SELECT (LengthOfReservation * DailyRentalFee) as Total
            				FROM reservation NATURAL JOIN cars 
            				Where MemberNum = ? AND Month(RentalStartingDate) = ?");
                    	$result -> bindParam(1,$MemberNumber);
                    	$result -> bindParam(2,$IntMonth);
                    	$result -> execute();
                    	$totalCount = 0;
                    	foreach ($result as $row) {
                    		$totalCount = $totalCount + $row[0];
                    	}

                   		echo "Total Monthly Invoice is: $$totalCount";
                    }

                }
                catch(PDOException $e) {
                      die($e);
                }
                $conn = null; 
            ?>
            </div>
    </section>
</body>

</html>