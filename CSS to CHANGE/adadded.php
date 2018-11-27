<?php
	session_start();
?>

<html>
<head>
<title>Add Advertisement</title>
</head>
<body>
<?php

	$uploadSuccess = False;
    $currentDir = getcwd();
    $uploadDirectory = "/uploads/";

    $errors = []; // Store all foreseen and unforseen errors here

    $fileExtensions = ['jpeg','jpg','png']; // Get all the file extensions

    $fileName = $_FILES['myfile']['name'];
    $fileSize = $_FILES['myfile']['size'];
    $fileTmpName  = $_FILES['myfile']['tmp_name'];
    $fileType = $_FILES['myfile']['type'];
	$text1 = explode('.',$fileName);
    $text2 = end($text1);
	$fileExtension = strtolower($text2);

    $uploadPath = $currentDir . $uploadDirectory . basename($fileName); 

if(isset($_POST['submit'])){
    
    $data_missing = array();

	if(empty($_POST['AdvertiserEmail'])){

        // Adds advertiser email to array
        $data_missing[] = 'Advertiser Email';

    } else {

        // Trim white space from the advertiser email and store the email of the advertiser
        $email = trim($_POST['AdvertiserEmail']);
    }

	if(empty($_POST['AdvertiserPassword'])){

        // Adds advertiser password to array
        $data_missing[] = 'Advertiser Password';

    } else {

        // Trim white space from the advertiser password and store the password of the advertiser
        $password = trim($_POST['AdvertiserPassword']);
    }	
	
    if(empty($_POST['AdDescription'])){

        // Adds ad description to the array
        $data_missing[] = 'Ad Description';

    } else{

        // Trim white space from the ad description and store the ad description
        $description = trim($_POST['AdDescription']);

    }
		
	if(empty($_POST['StartDate'])){

        // Adds ad Start date to array
        $data_missing[] = 'Start Date';

    } else {

        // Format date
		$start = date('Y-m-d', strtotime($_POST['StartDate']));
    }

    if(empty($_POST['EndDate'])){

        // Adds ad end date to the array
        $data_missing[] = 'End Date';

    } else{

        // Format date
        $end = date('Y-m-d', strtotime($_POST['EndDate']));
    }

    if(empty($_POST['TimesPerWeek'])){

        // Adds ad times per week to array
        $data_missing[] = 'Times Per Week';

    } else {

        // Trim white space from the times per week and store the number
        $timesperweek = trim($_POST['TimesPerWeek']);
	}
	
    if(empty($_POST['ManagerID'])){

        // Adds ID to array
        $data_missing[] = 'Manager ID';

    } else {

        // Trim white space from the ID and store the ID
        $manID = trim($_POST['ManagerID']);
	}	
	
    if(empty($data_missing)){
    
		require_once('../mysqli_connect.php');
	
		$advertiserquery = "SELECT COUNT(*) AS advertiserCount
									FROM advertiser A
									WHERE A.AdvertiserEmail = '" . $email . "' AND A.AdvertiserPassword = '" . $password . "'";
	
		$advertiserresponse = @mysqli_query($dbc, $advertiserquery);
		$advertiserCount = $advertiserresponse->fetch_object()->advertiserCount;

		if($advertiserCount == 1){
			
			if (! in_array($fileExtension,$fileExtensions)) {
				$errors[] = "This file extension is not allowed. Please upload a JPEG or PNG file <br />";
			}

			if ($fileSize > 2000000) {
				$errors[] = "This file is more than 2MB. Sorry, it has to be less than or equal to 2MB <br />";
			}

			if (empty($errors)) {
				$didUpload = move_uploaded_file($fileTmpName, $uploadPath);

				if ($didUpload) {
					echo "The file " . basename($fileName) . " has been uploaded <br />";
					$uploadSuccess = True;
				} else {
					echo "An error occurred somewhere. Try again or contact the admin";
				}
			} else {
				foreach ($errors as $error) {
					echo $error . "These are the errors <br />" . "\n";
				}
			}			
		
			if($uploadSuccess) {	
				
				$query = "INSERT INTO ad (AdDescription, AdLogo, StartDate, EndDate, TimesPerWeek, AdvertiserEmail, ManID, AdApproved) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
				
				$stmt = mysqli_prepare($dbc, $query);
				
				$uploadPathSimple = $uploadDirectory . basename($fileName);        
				$approved = "N";
				mysqli_stmt_bind_param($stmt, "ssssisis", $description, $uploadPathSimple, $start, $end, $timesperweek, $email, $manID, $approved);
				
				mysqli_stmt_execute($stmt);
				
				$affected_rows = mysqli_stmt_affected_rows($stmt);
				
				if($affected_rows == 1){
					
					echo 'Advertisement Entered and Pending Approval';
					
					mysqli_stmt_close($stmt);
					
					
				} else {
					
					echo 'Error Occurred<br />';
					echo mysqli_error($dbc);
					
					mysqli_stmt_close($stmt);
						
				}
			}
			else {
				echo "File did not upload successfully!";
			}
		}
		else{
			echo "Advertiser Username or Password incorrect / Advertiser not registered";
		}
		
    } else {
        
        echo 'You need to enter the following data<br />';
        
        foreach($data_missing as $missing){
            
            echo "$missing<br />";
            
        }
        
    }
    
}


?>

<form action="http://localhost:1234/adadded.php" method="post" enctype="multipart/form-data">

<b>Add an Advertisement</b>

<p>Advertiser Email:
<input type="text" name="AdvertiserEmail" size="30" value="" />
</p>

<p>Advertiser Password:
<input type="password" name="AdvertiserPassword" size="30" value="" />
</p>

<p>Ad Description:
<input type="text" name="AdDescription" size="30" value="" />
</p>

<p>Ad Logo:
<input type="file" name="myfile" id="fileToUpload">
</p>

<p>Start Date:
<input type="date" name="StartDate" size="30" maxlength="30" min="<?php echo date('Y-m-d'); ?>" value="<?php echo date('Y-m-d'); ?>" />
</p>

<p>End Date:
<input type="date" name="EndDate" size="30" min="<?php echo date('Y-m-d'); ?>" value=<?php echo date('Y-m-d'); ?>" />
</p>

<p>Times Per Week:
<input type="text" name="TimesPerWeek" size="30" value="" />
</p>

<p> Manager to Approve:
<select name="ManagerID">
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