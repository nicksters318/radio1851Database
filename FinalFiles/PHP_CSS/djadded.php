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
<link rel="stylesheet" href="standardstyle.css"/>
</head>
<body>
<?php

if(isset($_POST['submit'])){
    
    $data_missing = array();
    
    if(empty($_POST['DJID'])){

        // Adds ID to array
        $data_missing[] = 'Student ID';

    } else {

        // Trim white space from the ID and store the ID
        $student_id = trim($_POST['DJID']);
    }

    if(empty($_POST['DJFirstName'])){

        // Adds name to array
        $data_missing[] = 'First Name';

    } else{

        // Trim white space from the name and store the name
        $f_name = trim($_POST['DJFirstName']);

    }

    if(empty($_POST['DJLastName'])){

        // Adds name to array
        $data_missing[] = 'Last Name';

    } else {

        // Trim white space from the name and store the name
        $l_name = trim($_POST['DJLastName']);

    }

    if(empty($_POST['DJSwipeAccess'])){

        // Adds swipe access to array
        $data_missing[] = 'Swipe Access (Y/N)';

    } else {

        // Trim white space from the access and store the access
        $swipe_access = trim($_POST['DJSwipeAccess']);

    }

    if(empty($_POST['DJYear'])){

        // Adds graduation year to array
        $data_missing[] = 'Year of Graduation';

    } else {

        // Trim white space from the year and store the year
        $year = trim($_POST['DJYear']);

    }

    if(empty($_POST['DJEmail'])){

        // Adds email to array
        $data_missing[] = 'Email';

    } else {

        // Trim white space from the email and store the email
        $email = trim($_POST['DJEmail']);

    }

    if(empty($_POST['DJPassword'])){

        // Adds password to array
        $data_missing[] = 'Password';

    } else {

        // Trim white space from the password and store the password
        $password = trim($_POST['DJPassword']);

    }
	
    if(empty($_POST['ManID'])){

        // Adds mentor to array
        $data_missing[] = 'Mentor ID';

    } else {

        // Trim white space from the mentor and store the mentor
        $manager_id = trim($_POST['ManID']);

    }	
    
    if(empty($data_missing)){
        
        require_once('../mysqli_connect.php');
        
        $query = "INSERT INTO dj (DJID, DJFirstName, DJLastName, DJSwipeAccess, DJYear, DJEmail, DJPassword, ManID) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($dbc, $query);
        
    
        
        mysqli_stmt_bind_param($stmt, "isssissi", $student_id, $f_name, $l_name, $swipe_access, $year, $email, $password, $manager_id);
        
        mysqli_stmt_execute($stmt);
        
        $affected_rows = mysqli_stmt_affected_rows($stmt);
        
        if($affected_rows == 1){
            
            echo 'DJ Entered';
            
            mysqli_stmt_close($stmt);
            
        } else {
            
            echo 'Error Occurred<br />';
            echo mysqli_error($dbc);
            
            mysqli_stmt_close($stmt);
            
        }
        
    } else {
        
        echo 'You need to enter the following data<br />';
        
        foreach($data_missing as $missing){
            
            echo "$missing<br />";
            
        }
        
    }
    
}

?>
    
<form action="http://localhost:1234/djadded.php" method="post">

<header>
<div class="container">
<div id="placehold">
<h1><span class="highlight">Add a New DJ</span></h1>
</div>
</div>
</header>

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
foreach (range($earliest_year + 8, $earliest_year) as $x) {
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

<p>Manager Mentor:
<select name="ManID">
	<?php 
	require_once('../mysqli_connect.php');
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

<div class="new-con">
</div>

</body>
</html>
