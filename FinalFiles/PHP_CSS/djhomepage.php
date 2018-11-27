<?php
	session_start();

	if ( isset( $_SESSION['login_dj'] ) ) {
	} 
	else {
		// Redirect them to the login page
		header("Location: http://localhost:1234/login.php");
	}
?>

<html>
<head>
<link rel="stylesheet" href="login.css"/>
<title>DJ Home</title>
</head>
<body>

<div class="container">

<h3 class="text-center">Welcome, DJ!</h3>

<div class="btn-posit">
<form>
<input type="button" onclick="location.href='http://localhost:1234/addshow.php';" value="Request Show" />
</form>
</div>

<div class="btn-posit">
<form>
<input type="button" onclick="location.href='http://localhost:1234/addsongreq.php';" value="Request Song" />
</form>	
</div>

<div class="btn-posit">
<form>
<input type="button" onclick="location.href='http://localhost:1234/getmanager.php';" value="View Managers" />
</form>
</div>

<div class="btn-posit">
<form>
<input type="button" onclick="location.href='http://localhost:1234/getdj.php';" value="View DJs" />
</form>
</div>

<div class="btn-posit">
<form>
<input type="button" onclick="location.href='http://localhost:1234/getadvertiser.php';" value="View Advertisers" />
</form>		
</div>

<div class="btn-posit">
<form>
<input type="button" onclick="location.href='http://localhost:1234/getad.php';" value="View Ads" />
</form>		
</div>

<div class="btn-posit">
<form>
<input type="button" onclick="location.href='http://localhost:1234/getshow.php';" value="View Schedule" />
</form>
</div>

<div class="btn-posit">
<form>
<input type="button" onclick="location.href='http://localhost:1234/getsongreq.php';" value="View Song Requests" />
</form>
</div>

<div class="btn-posit">
<form>
<input type="button" onclick="location.href='http://localhost:1234/logout.php';" value="Logout" />
</form>
</div>
	
</div>
<div class="new-container">
</div>
	
</body>
</html>
