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
<link rel="stylesheet" href="addm.css"/>
</head>
<body>

<form action="http://localhost:1234/manageradded.php" method="post">

<header>
  <div class="container">
     <div id="placehold">
        <h1><span class="highlight">Add a New Manager</span></h1>
     </div>
  </div>
</header>

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
<select name="ManSwipeAccess">
  <option value="Y">Yes</option>
  <option value="N">No</option>
</select>
</p>

<p>Year of Graduation:
<?php
$already_selected_value = date('Y');
$earliest_year = date('Y');

echo '<select name="ManYear">';
foreach (range($earliest_year + 4, $earliest_year) as $x) {
    echo '<option value="'.$x.'"'.($x === $already_selected_value ? ' selected="selected"' : '').'>'.$x.'</option>';
}
echo '</select>';
?>
</p>

<p>Email (Username):
<input type="text" name="ManEmail" size="30" value="" />
</p>

<p>Password:
<input type="password" name="ManPassword" size="30" value="" />
</p>
<p>
    <input type="submit" name="submit" value="Send" />
</p>
</form>
<div class="new-con">

</div>
</body>
</html>
