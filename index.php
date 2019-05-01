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

</head>

<body id="page-top" class="index">
<!--<div id="skipnav"><a href="#maincontent">Skip to main content</a></div>-->

    <!-- Navigation -->
    <!--<nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom">-->
        <!--<div class="container">-->
            <!-- Brand and toggle get grouped for better mobile display -->
            <!--<div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="#page-top">K-Town Car Share</a>
            </div>-->

            <!-- Collect the nav links, forms, and other content for toggling -->
            <!--<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li class="page-scroll">
                        <a href="join.html">Join Now</a>
                    </li>
                    <li class="page-scroll">
                        <a href="login.html">Sign in</a>
                    </li>
                    <li class="page-scroll">
                        <a href="#contact">Your Account</a>
                    </li>
                </ul>
            </div>-->
            <!-- /.navbar-collapse -->
        <!--</div>
        <!-- /.container-fluid -->
    <!--</nav>-->
	
<?php
if(isset($_POST['search'])){
	include_once 'connection.php'; 

    // include database connection
    //include_once 'connection.php'; 
	echo "<h1>CONNETED TO THE DATABASE</h1>";
	// SELECT query
    //$query = "SELECT * FROM cars";
	// SELECT query
        $query = "SELECT * FROM cars";
		$result = $con->query($query);
		
 
        // prepare query for execution
        //if($stmt = $con->prepare($query)){
		
        // bind the parameters. This is the best way to prevent SQL injection hacks.
        //$stmt->bind_Param("ss", $_POST['username'], $_POST['password']);


         
        // Execute the query
		//$stmt->execute();
 
		/* resultset */
		//$result = $stmt->get_result();
		
		foreach($result as $r){
			echo $r['Make'];
		}
		//}
 }
?>
	<form>
					<p>Pick up: <input type = "date" name = "pickupdate" min = "2017-03-22" max = "9999-12-31" required = "required" style = "color: black">
					Drop off: <input type = "date" name = "dropoffdate" min = "2017-03-23" max = "999-12-31" required = "required" style = "color: black">
					</p>
					<p>
					<input class = "button" type = "submit" name = "search" value = "Search">
					</p>
				</form>
	
</body>
</html>
