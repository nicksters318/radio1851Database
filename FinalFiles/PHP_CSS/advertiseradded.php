<?php
	session_start();
?>

<html>
<head>
<title>Register as an Advertiser</title>
<link rel="stylesheet" href="standardstyle.css"/>
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
    
    if(empty($_POST['AdvertiserName'])){

        // Adds name to array
        $data_missing[] = 'Advertiser Name';

    } else{

        // Trim white space from the name and store the name
        $name = trim($_POST['AdvertiserName']);

    }	
	
    if(empty($_POST['AdvertiserEmail'])){

        // Adds email to array
        $data_missing[] = 'Advertiser Email';

    } else {

        // Trim white space from the email and store the email
        $email = trim($_POST['AdvertiserEmail']);
    }

    if(empty($_POST['AdvertiserPassword'])){

        // Adds password to array
        $data_missing[] = 'Advertiser Password';

    } else {

        // Trim white space from the password and store the password
        $password = trim($_POST['AdvertiserPassword']);
    }
    
    if(empty($data_missing)){
		
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

			require_once('../mysqli_connect.php');
			
			$query = "INSERT INTO advertiser (AdvertiserEmail, AdvertiserPassword, AdvertiserName, AdvertiserLogo) VALUES (?, ?, ?, ?)";
			
			$stmt = mysqli_prepare($dbc, $query);
			
		
			$uploadPathSimple = $uploadDirectory . basename($fileName);        
			mysqli_stmt_bind_param($stmt, "ssss", $email, $password, $name, $uploadPathSimple);
			
			mysqli_stmt_execute($stmt);
			
			$affected_rows = mysqli_stmt_affected_rows($stmt);
			
			if($affected_rows == 1){
				
				echo 'Advertiser Registered<br />';
				
				mysqli_stmt_close($stmt);
				
				mysqli_close($dbc);
				
			} else {
				
				echo 'Error Occurred<br />';
				echo mysqli_error($dbc);
				
				mysqli_stmt_close($stmt);
				
				mysqli_close($dbc);
				
			}
		}
		else{
			echo "File did not upload successfully!";
        }
    } else {
        
        echo 'You need to enter the following data<br />';
        
        foreach($data_missing as $missing){
            
            echo "$missing<br />";
            
        }
        
    }
    
}

?>
    
<form action="http://localhost:1234/advertiseradded.php" method="post" enctype="multipart/form-data">

<header>
<div class="container">
<div id="placehold">
<h1><span class="highlight">Register as an Advertiser</span></h1>
</div>
</div>
</header>

<p>Company / Corp. Name:
<input type="text" name="AdvertiserName" size="30" value="" />
</p>
    
<p>Company / Corp. Email (Username):
<input type="text" name="AdvertiserEmail" size="30" value="" />
</p>

<p>Company / Corp. Password:
<input type="password" name="AdvertiserPassword" size="30" value="" />
</p>

<p>Company / Corp. Logo:
	<input type="file" name="myfile" id="fileToUpload">
</p>

<p>
    <input type="submit" name="submit" value="Send" />
</p>

</form>

<div class="new-con">
</div>

</body>
</html>

