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
<title>Add Manager</title>
</head>
<body>
<form action="http://localhost:1234/manageradded.php" method="post">

<b>Add a New Manager</b>

<p>Student ID:
<input type="text" name="ManID" size="30" maxlength="8" value="" />
</p>
    
<p>First Name:
<input type="text" name="ManFirstName" size="30" value="" />
</p>

<p>Last Name:
<input type="text" name="ManLastName" size="30" value="" />
</p>

<p>Swipe Access (Y or N):
<input type="text" name="ManSwipeAccess" size="30" maxlength="1" value="" />
</p>

<p>Year of Graduation:
<input type="text" name="ManYear" size="30" maxlength="4" value="" />
</p>

<p>Email (Username):
<input type="text" name="ManEmail" size="30" value="" />
</p>

<p>Password:
<input type="text" name="ManPassword" size="30" value="" />
</p>

<p>
    <input type="submit" name="submit" value="Send" />
</p>

</form>
</body>
</html>
