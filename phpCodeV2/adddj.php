<?php
	session_start();

	if ( isset( $_SESSION['login_manager'] ) ) {
	} 
	else {
		// Redirect them to the login page
		header("Location: http://localhost:1234/login.php");
	}
	
	require_once('../mysqli_connect.php');
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
<select name="DJSwipeAccess">
  <option value="Y">Yes</option>
  <option value="N">No</option>
</select>
</p>

<p>Year of Graduation:
<?php
$already_selected_value = date('Y');
$earliest_year = date('Y');

echo '<select name="DJYear">';
foreach (range($earliest_year + 4, $earliest_year) as $x) {
    echo '<option value="'.$x.'"'.($x === $already_selected_value ? ' selected="selected"' : '').'>'.$x.'</option>';
}
echo '</select>';
?>
</p>

<p>Email (Username):
<input type="text" name="DJEmail" size="30" value="" />
</p>

<p>Password:
<input type="password" name="DJPassword" size="30" value="" />
</p>

<p>Manager to Approve:
<select name="ManID">
	<?php 
	$sql = mysqli_query($dbc, "SELECT ManID, CONCAT(manager.ManFirstName, ' ', manager.ManLastName) AS ManFullName FROM manager");
	while ($row = mysqli_fetch_array($sql)){
		echo '<option value="' . $row['ManID'] . '">'. $row['ManFullName'] . '</option>';
	}
	?>
</select>
</p>

<p>
    <input type="submit" name="submit" value="Send" />
</p>

</form>
</body>
</html>
