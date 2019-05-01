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

<body>
	<!-- Navigation -->
    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="Main.html">K-Town Car Share</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li class="page-scroll">
                        <a href="join.html">Join Now</a> <!--should link to other pages-->
                    </li>
                    <li class="page-scroll">
                        <a href="login.html">Sign in</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
	
	<?php
	$email = $_POST['loginemail'];
	echo "<h2>$email</h2>";
	try{
		$dbh = new PDO('mysql:host=localhost;dbname=ktcs', 'cisc332', 'cisc332password');
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$carinfo = $dbh->query("SELECT * FROM ktcs_members WHERE Email = '$email'");
		foreach($carinfo as $c){
			
			echo "<section id='portfolio'>
			<div class='container'>
				<div class='row'>
					<div class='col-lg-12 text-center'>
						<h2>Already Existing</h2>
						<hr class='star-primary'>
					</div>
				</div>
				<img src='img/portfolio/$picname.png' alt = $name style='width:50%; height:auto; float:right;'>	
				<p>Name: $name</p>
				<p>Car VIN Code: $VIN</p>
				<p>Year: $year</p>
				<p>Pick Up/Drop Off Location: $address</p>
				<p>Daily Rental Fee: $fee</p>
				
				<form><input class='button' type='submit' name = 'reserve' value='Reserve' style='font-size:2em;'></form>
			</div>
		</section>";
		}
	
		
	}catch(PDOException $e) {
		echo "<h2>Failed to connect with the database.</h2>";
		die();
	}
	?>
	
</body>