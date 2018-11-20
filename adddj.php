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
<title>Add DJ</title>
</head>
<body>
<form action="http://localhost:1234/djadded.php" method="post">

<b>Add a New DJ</b>

<p>Student ID:
<input type="text" name="DJID" size="30" maxlength="8" value="" />
</p>
    
<p>First Name:
<input type="text" name="DJFirstName" size="30" value="" />
</p>

<p>Last Name:
<input type="text" name="DJLastName" size="30" value="" />
</p>

<p>Swipe Access (Y or N):
<input type="text" name="DJSwipeAccess" size="30" maxlength="1" value="" />
</p>

<p>Year of Graduation:
<input type="text" name="DJYear" size="30" maxlength="4" value="" />
</p>

<p>Email (Username):
<input type="text" name="DJEmail" size="30" value="" />
</p>

<p>Password:
<input type="text" name="DJPassword" size="30" value="" />
</p>

<p>Mentor ID:
<input type="text" name="ManID" size="30" maxlength="8" value="" />
</p>

<p>
    <input type="submit" name="submit" value="Send" />
</p>

</form>
</body>
</html>
