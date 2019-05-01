<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>K-Town Car Share</title>

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
                    <li class="page-scroll">
                        <a href="AccountPage.php">Your Account</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

	<header>
        <div class="container" id="maincontent" tabindex="-1">
            <div class="row">
                <div class="col-lg-12">
                    <div class="intro-text">
					<?php
						session_start();
						$email = $_SESSION["emaillogined"];
						try{
							$dbh = new PDO('mysql:host=localhost;dbname=ktcs', 'cisc332', 'cisc332password');
							$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
							$personal = $dbh->query("SELECT * FROM ktcs_members WHERE Email = '$email'");
							foreach($personal as $p){
								echo "<h1 class='name'>Hello, $p[Name]</h1>
									<hr class='star-light'>
									<p><a href='#allreservation' style = 'color:white;'>Manage Your Reservation</a></p>
									<p><a href='#rentalhistory' style = 'color:white;'>Rental History</a></p>";	
							}
						}catch(PDOException $e){
							echo "<h2>No Updating to the Database.<br>The Email Address Has Been Used For Signing Up This Conference.</h2>";
							die();
						}
	
					?>
					</div>
                </div>
            </div>
        </div>
    </header>
	
	<section id="allreservation">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>All Reservations</h2>
                    <hr class="star-primary">
                </div>
            </div>
			<?php
				
				$email = $_SESSION["emaillogined"];
				try{
					$dbh = new PDO('mysql:host=localhost;dbname=ktcs', 'cisc332', 'cisc332password');
					$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$reservations = $dbh->query("SELECT * FROM reservation NATURAL JOIN ktcs_members WHERE email = '$email'");
					foreach($reservations as $r){
						$reservationNum = $r['ReservationNum'];
                        $carPINcode = $r['AccessCode'];
						echo "<div>
						<p>Reservation No.: $reservationNum</p>
                        <p>Access Code: $carPINcode </p>
						<a class='button' href='PickUpPage.php?Reservation=$reservationNum' style='font-size:2em;'>Pick Up</a>
						<a class='button' href='DropOffPage.php?Reservation=$reservationNum' style='font-size:2em;'>Drop Off</a>
						</div>
						";
					}
				}catch(PDOException $e){
					echo "<h2>No Updating to the Database.<br>The Email Address Has Been Used For Signing Up This Conference.</h2>";
					die();
				}
	//<a class='button' href='reserve.php?carVINcode=$VIN' style='font-size:2em;'>RESERVE</a>
			?></section>
            
    <section id="allreservation">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>Rental History</h2>
                    <hr class="star-primary">
                </div>
            </div>
	
	<?php
         
    try{
        $dbh = new PDO('mysql:host=localhost;dbname=ktcs', 'cisc332', 'cisc332password');
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				              
        if (isset($_SESSION["emaillogined"])) {
        $checkemail = $_SESSION["emaillogined"];

        $rentalhistorys = $dbh -> query("SELECT * FROM `rental_history` WHERE rental_history.MemberNum = 
                                   ( SELECT ktcs_members.MemberNum FROM `ktcs_members` WHERE Email = '$checkemail' )" );
        
        foreach ($rentalhistorys as $history){    
			echo "<div>
				<p> HistoryID: $history[0] </p>
				<p> CarVINcode: $history[1] </p>
				<p> MemberNum: $history[2] </P>
				<p> PickupOdometerReading: $history[3] </P>
				<p> DropoffOdometerReading: $history[4] </P>
				<p> Status: $history[5] </P>
                <a class='button' href='FeedbackPage.php?CarVINcode=$history[1]&MemberNum=$history[2]' style='font-size:2em;'>Give Feedback</a>
				</div>
				";		
  
        }
    }
                                                                                          
					
	} catch(PDOException $e){		
            die();
		}
        $dbh = null;
        
            
?></section>
	
	
	
</body>
</html>