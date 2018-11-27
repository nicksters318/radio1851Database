<?php
	session_start();

	if ( isset( $_SESSION['login_manager'] ) ) {
	} 
	else {
		// Redirect them to the login page
		header("Location: http://localhost:1234/login.php");
	}
?>

<html>
<head>
<link rel="stylesheet" href="login.css"/>
<title>Manager Home</title>
</head>
<body>

<div class="container">

<h3 class="text-center">Welcome, Manager!</h3>

<div class="btn-posit">
<form>
<input type="button" onclick="location.href='http://localhost:1234/addmanager.php';" value="Add a Manager" />
</form>
</div>

<div class="btn-posit">
<form>
<input type="button" onclick="location.href='http://localhost:1234/adddj.php';" value="Add a DJ" />
</form>
</div>

<div class="btn-posit">
<form>
<input type="button" onclick="location.href='http://localhost:1234/addshow.php';" value="Add Show" />
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
<input type="button" onclick="location.href='http://localhost:1234/getdj.php';" value="View / Delete DJs" />
</form>
</div>

<div class="btn-posit">
<form>
<input type="button" onclick="location.href='http://localhost:1234/getadvertiser.php';" value="View Advertisers" />
</form>		
</div>

<div class="btn-posit">
<form>
<input type="button" onclick="location.href='http://localhost:1234/getad.php';" value="View / Approve Ads" />
</form>		
</div>

<div class="btn-posit">
<form>
<input type="button" onclick="location.href='http://localhost:1234/getshow.php';" value="View Schedule / Approve Shows" />
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
