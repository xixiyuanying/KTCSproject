<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Show cars last maintance</title>

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
                    <h2>All cars have travelled 5000km or more since their last maintenance</h2>
                    <hr class="star-primary">
                </div>
            </div>
			<?php
		
				try{
					$dbh = new PDO('mysql:host=localhost;dbname=ktcs', 'cisc332', 'cisc332password');
					$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$rows = $dbh->query("select CarVINcode , Make, Model, distance
                                        from cars natural join
                                        (select t1.CarVINcode, (current - lastmaintain) as distance from
                                        (SELECT CarVINcode, max(OdometerReading) as lastmaintain FROM car_maintenance_history group by CarVINcode) as t1
                                        join (SELECT CarVINcode, max(DropoffOdometerReading) as current FROM rental_history group by CarVINcode) as t2 on t1.CarVINcode
                                        where t1.CarVINcode = t2.CarVINcode) as t3
                                        where distance > 5000");
                                        
					foreach($rows as $row){
						
						echo "<div class = 'cars'>
						<p>CarVINcode: $row[CarVINcode]</p>
                        <p>Make: $row[Make]</p>
                        <p>Model: $row[Model]</p>
                        <p>Distance: $row[distance]</p>	                                              
						</div>
                        <br>

                        <style>
                            .cars {
      
                            padding: 20px;
                            border: 1px solid DarkCyan;
                            border-radius: 8px;
                            border-width: 15px;
                            }
                        </style>
						";
					}
				}catch(PDOException $e){
					echo "<h2>No Updating to the Database.<br>The Email Address Has Been Used For Signing Up This Conference.</h2>";
					die();
				}
			?></section>


	
</body>
</html>