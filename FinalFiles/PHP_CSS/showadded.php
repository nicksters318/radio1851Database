<?php

	session_start();

	if ( isset( $_SESSION['login_manager'] ) || isset( $_SESSION['login_dj'] ) ) {
	}
	else {
		// Redirect them to the login page
		header("Location: http://localhost:1234/login.php");
	}
?>

<html>
<head>
<title>Request Show</title>
<link rel="stylesheet" href="standardstyle.css"/>
</head>
<body>
<?php

	$cohostID = NULL;

	$uploadSuccess = False;
	$djMatch = False;
	$timeMatch = True;
	
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

    if(empty($_POST['ShowName'])){

        // Adds name to array
        $data_missing[] = 'Show Name';

    } else{

        // Trim white space from the name and store the name
        $name = trim($_POST['ShowName']);

    }

    if(empty($_POST['hostID'])){

        // Adds ID to array
        $data_missing[] = 'Show Host ID';

    } else{

        // Trim white space from the ID and store the ID
        $hostID = trim($_POST['hostID']);

    }
	
    if(empty($_POST['ShowBio'])){

        // Adds bio to array
        $data_missing[] = 'Show Bio';

    } else {

        // Trim white space from the bio and store the bio
        $bio = trim($_POST['ShowBio']);

    }
	
    if(empty($_POST['ShowCategory'])){

        // Adds bio to array
        $data_missing[] = 'Show Category';

    } else {

        // Trim white space from the bio and store the bio
        $category = trim($_POST['ShowCategory']);

    }	

    if(empty($_POST['ShowDay'])){

        // Adds show day to array
        $data_missing[] = 'Show Day';

    } else {

        // Trim white space from the show day and store the show day
        $day = trim($_POST['ShowDay']);

    }

    if(empty($_POST['ShowTime'])){

        // Adds time to array
        $data_missing[] = 'Show Time';

    } else {

        //  Format time
		$time = date('h:i A', strtotime($_POST['ShowTime']));

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
        
		if(!empty($_POST['Facebook'])){
			// Trim white space from the social media and store the social media
			$facebook = trim($_POST['Facebook']);
		}
		if(!empty($_POST['Instagram'])){
			// Trim white space from the social media and store the social media
			$instagram = trim($_POST['Instagram']);
		}
		if(!empty($_POST['Twitter'])){
			// Trim white space from the social media and store the social media
			$twitter = trim($_POST['Twitter']);
		}				
		if(!empty($_POST['cohostID'])){
			// Trim white space from the ID and store the ID
			$cohostID = trim($_POST['cohostID']);
		}			
		
		if( is_null($cohostID) ) {
			$djexistsquery = "SELECT COUNT(DJ.DJID) AS djCount
						FROM dj DJ
						WHERE DJ.DJID = '" . $hostID . "'";	
		}
		else {
			$djexistsquery = "SELECT COUNT(DJ.DJID) AS djCount
						FROM dj DJ
						WHERE DJ.DJID = '" . $hostID . "' or DJ.DJID = '" . $cohostID . "'";			
		}	
			
		$djexistsresponse = @mysqli_query($dbc, $djexistsquery);
		$djCount = $djexistsresponse->fetch_object()->djCount;					
		
		$timeexistsquery = "SELECT COUNT(S.ShowID) AS timeCount
						FROM showdesc S
						WHERE S.ShowDay = '" . $day . "' and S.ShowTime = '" . $time . "'";
		
		$timeexistsresponse = @mysqli_query($dbc, $timeexistsquery);
		$timeCount = $timeexistsresponse->fetch_object()->timeCount;		
		
		if( ( isset($hostID) and isset($cohostID) and $djCount == 2 ) || ( isset($hostID) and is_null($cohostID) and $djCount == 1) ) {
			$djMatch = True;
		}
		
		if( $timeCount != 1 ) {
			$timeMatch = False;
		}
		
		if( $djMatch and !$timeMatch ){
					
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
				
				$query = "INSERT INTO showdesc (ShowID, ShowName, ShowLogo, ShowBio, ShowCategory, ShowDay, ShowTime, ManID, ShowApproved) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
				$smquery = "INSERT INTO socialmedia (Facebook, Instagram, Twitter, ShowID) VALUES (?, ?, ?, ?)";
				$hostquery = "INSERT INTO hosts (DJID, ShowID) VALUES (?, ?)";
				$cohostquery = "INSERT INTO hosts (DJID, ShowID) VALUES (?, ?)";
				
				$stmt = mysqli_prepare($dbc, $query);
				$uploadPathSimple = $uploadDirectory . basename($fileName);  
				$approved = "N";				
				mysqli_stmt_bind_param($stmt, "issssssis", $id, $name, $uploadPathSimple, $bio, $category, $day, $time, $manID, $approved);
				mysqli_stmt_execute($stmt);
				
				$id = mysqli_insert_id($dbc);	
				
				$smstmt = mysqli_prepare($dbc, $smquery);
				$hoststmt = mysqli_prepare($dbc, $hostquery);
				
				mysqli_stmt_bind_param($smstmt, "sssi", $facebook, $instagram, $twitter, $id);
				mysqli_stmt_bind_param($hoststmt, "ii", $hostID, $id);
							
				mysqli_stmt_execute($smstmt);
				mysqli_stmt_execute($hoststmt);
				
	
				if( !is_null($cohostID) ) {
					$cohoststmt = mysqli_prepare($dbc, $cohostquery);
					mysqli_stmt_bind_param($cohoststmt, "ii", $cohostID, $id);	
					mysqli_stmt_execute($cohoststmt);
				}
				
				$affected_rows = mysqli_stmt_affected_rows($stmt);
				
				if($affected_rows == 1){
					
					echo 'Show Entered and Pending Approval!<br />';
					
					$smaffected_rows = mysqli_stmt_affected_rows($smstmt);
					$hostaffected_rows = mysqli_stmt_affected_rows($hoststmt);
					
					if($smaffected_rows == 1){
						
						echo 'Social Media Entered<br />';
						
						mysqli_stmt_close($smstmt);
										
					} else {
						
						echo 'Error Occurred entering Social Media<br />';
						echo mysqli_error($dbc);
						
						mysqli_stmt_close($smstmt);
										
					}			
					
					if($hostaffected_rows >= 1){
						
						echo 'Host(s) Entered<br />';
						
						mysqli_stmt_close($hoststmt);
										
					} else {
						
						echo 'Error Occurred entering Host(s)<br />';
						echo mysqli_error($dbc) . '<br />';
						
						mysqli_stmt_close($hoststmt);
										
					}						
					
					mysqli_stmt_close($stmt);
										
				} else {
					
					echo 'Error Occurred entering Show<br />';
					echo mysqli_error($dbc) . '<br />';
					
					mysqli_stmt_close($stmt);
										
				}
			}
			else {
				echo 'Photo upload unsuccessful<br />';
			}									
		}
		else {
			
			echo 'Error Occurred entering Show<br />';
			if(!$djMatch) {
				echo 'DJs entered as hosts are not registered in the system!<br />';
			}
			if($timeMatch) {
				echo 'Time slot entered already taken by another show!<br />';
			}
		}
			
    } else {
        
        echo 'You need to enter the following data<br />';
        
        foreach($data_missing as $missing){
            
            echo "$missing<br />";
            
        }
        
    }
    
}

?>
    
<form action="http://localhost:1234/showadded.php" method="post" enctype="multipart/form-data">

<header>
<div class="container">
<div id="placehold">
<h1><span class="highlight">Request a New Show</span></h1>
</div>
</div>
</header>

<p>Show Name:
<input type="text" name="ShowName" size="30" value="" />
</p>

<p>Host ID (Student ID):
<input type="text" name="hostID" size="30" value="" />
</p>

<p>Cohost ID (Student ID) [Optional]:
<input type="text" name="cohostID" size="30" value="" />
</p>

<p>Show Logo:
	<input type="file" name="myfile" id="fileToUpload">
</p>

<p>Show Bio:
<input type="text" name="ShowBio" size="30" maxlength="255" value="" />
</p>

<p>Show Category:
<select name="ShowCategory">
  <option value="Music">Music</option>
  <option value="News">News</option>
  <option value="Sports">Sports</option>
  <option value="Talk">Talk</option>
  <option value="Variety">Variety</option>
</select>
</p>

<p>Show Day:
<select name="ShowDay">
  <option value="Sunday">Sunday</option>
  <option value="Monday">Monday</option>
  <option value="Tuesday">Tuesday</option>
  <option value="Wednesday">Wednesday</option>
  <option value="Thursday">Thursday</option>
  <option value="Friday">Friday</option>
  <option value="Saturday">Saturday</option>
</select>
</p>

<p>Show Time:
<input type="time" name="ShowTime" size="30" value="" min="09:00:00" max="23:00:00" step="3600"/>
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

<p>Social Media Accounts [Optional]:</p>

<p>Facebook Link (i.e. https://www.facebook.com/radio1851)</p>
<p><input type="text" name="Facebook" size="30" value="" /></p>

<p>Instagram Link (i.e. https://www.instagram.com/radio1851)</p>
<p><input type="text" name="Instagram" size="30" value="" /></p>

<p>Twitter Link (i.e. https://twitter.com/radio1851)</p>
<p><input type="text" name="Twitter" size="30" value="" /></p>

<p>
    <input type="submit" name="submit" value="Send" />
</p>

</form>

<div class="new-con">
</div>

</body>
</html>