<!DOCTYPE html>
<html>
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
                <a class="navbar-brand" href="AdminMain.html">K-Town Car Share</a>
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

	<section id="portfolio">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>All Available Cars</h2>
                    <hr class="star-primary">
                </div>
            </div>
            <div class="row">
			<?php
			$location = $_POST["location"];
			$today = date("Y-m-d"); 
	
			try{
				$dbh = new PDO('mysql:host=localhost;dbname=ktcs', 'cisc332', 'cisc332password');
				$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$available = $dbh->query("SELECT CarVINcode, Make, Model
										FROM cars
										WHERE cars.CarVINcode NOT IN
											(SELECT CarVINcode
												FROM CARS NATURAL JOIN
													(SELECT *, DATE_ADD(RentalStartingDate,INTERVAL LengthOfReservation DAY) AS DropOffDate FROM reservation) as t1
												WHERE '$today' >= RentalStartingDate AND '$today' <= DropOffDate)
										AND Address = '$location'");
				
				foreach($available as $a){
					$name = $a['Make'].$a['Model'];
					$make = $a['Make'];
					$model = $a['Model'];
			
					echo "<div class='col-sm-4 portfolio-item'>
							<form method='post' action='allreservation.php'>
								<div class='caption'>
									<div class='caption-content'>
									</div>
								</div>
								<img src='img/portfolio/$name.png' class = 'img-responsive' alt = $name>
								<input class='button' type='submit' name = 'name' value='$make $model'>
							</div>
							</form>";
				}
				
				$dbh = null;
			} catch(PDOException $e){
				echo "<h2>No Updating to the Database.<br>The Email Address Has Been Used For Signing Up This Conference.</h2>";
				die();
			}
			?>
		</div>
	</section>
	
	
		
	
</body>
</html