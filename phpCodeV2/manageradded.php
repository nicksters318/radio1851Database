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
<?php

if(isset($_POST['submit'])){
    
    $data_missing = array();
    
    if(empty($_POST['ManID'])){

        // Adds ID to array
        $data_missing[] = 'Student ID';

    } else {

        // Trim white space from the ID and store the ID
        $student_id = trim($_POST['ManID']);
    }

    if(empty($_POST['ManFirstName'])){

        // Adds name to array
        $data_missing[] = 'First Name';

    } else{

        // Trim white space from the name and store the name
        $f_name = trim($_POST['ManFirstName']);

    }

    if(empty($_POST['ManLastName'])){

        // Adds name to array
        $data_missing[] = 'Last Name';

    } else {

        // Trim white space from the name and store the name
        $l_name = trim($_POST['ManLastName']);

    }

    if(empty($_POST['ManSwipeAccess'])){

        // Adds swipe access to array
        $data_missing[] = 'Swipe Access (Y/N)';

    } else {

        // Trim white space from the access and store the access
        $swipe_access = trim($_POST['ManSwipeAccess']);

    }

    if(empty($_POST['ManYear'])){

        // Adds graduation year to array
        $data_missing[] = 'Year of Graduation';

    } else {

        // Trim white space from the year and store the year
        $year = trim($_POST['ManYear']);

    }

    if(empty($_POST['ManEmail'])){

        // Adds email to array
        $data_missing[] = 'Email';

    } else {

        // Trim white space from the email and store the email
        $email = trim($_POST['ManEmail']);

    }

    if(empty($_POST['ManPassword'])){

        // Adds password to array
        $data_missing[] = 'Password';

    } else {

        // Trim white space from the password and store the password
        $password = trim($_POST['ManPassword']);

    }
    
    if(empty($data_missing)){
        
        require_once('../mysqli_connect.php');
        
        $query = "INSERT INTO manager (ManID, ManFirstName, ManLastName, ManSwipeAccess, ManYear, ManEmail, ManPassword) VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($dbc, $query);
        
    
        
        mysqli_stmt_bind_param($stmt, "isssiss", $student_id, $f_name, $l_name, $swipe_access, $year, $email, $password);
        
        mysqli_stmt_execute($stmt);
        
        $affected_rows = mysqli_stmt_affected_rows($stmt);
        
        if($affected_rows == 1){
            
            echo 'Manager Entered';
            
            mysqli_stmt_close($stmt);
            
            mysqli_close($dbc);
            
        } else {
            
            echo 'Error Occurred<br />';
            echo mysqli_error($dbc);
            
            mysqli_stmt_close($stmt);
            
            mysqli_close($dbc);
            
        }
        
    } else {
        
        echo 'You need to enter the following data<br />';
        
        foreach($data_missing as $missing){
            
            echo "$missing<br />";
            
        }
        
    }
    
}

?>
    
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
</body>
</html>
