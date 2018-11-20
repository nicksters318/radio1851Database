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
<title>Manager Home</title>
</head>
<body>

<b>Welcome, Manager!</b>

<p>This is your home page!</p>

<form>
<input type="button" onclick="location.href='http://localhost:1234/addmanager.php';" value="Add a Manager" />
</form>

<form>
<input type="button" onclick="location.href='http://localhost:1234/adddj.php';" value="Add a DJ" />
</form>

<form>
<input type="button" onclick="location.href='http://localhost:1234/addshow.php';" value="Add Show" />
</form>

<form>
<input type="button" onclick="location.href='http://localhost:1234/getmanager.php';" value="View Managers" />
</form>

<form>
<input type="button" onclick="location.href='http://localhost:1234/getdj.php';" value="View DJs" />
</form>

<form>
<input type="button" onclick="location.href='http://localhost:1234/getadvertiser.php';" value="View Advertisers" />
</form>		

<form>
<input type="button" onclick="location.href='http://localhost:1234/getshow.php';" value="View Schedule" />
</form>

<form>
<input type="button" onclick="location.href='http://localhost:1234/logout.php';" value="Logout" />
</form>
    
</body>
</html>
