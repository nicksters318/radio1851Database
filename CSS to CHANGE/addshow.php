<?php
	session_start();

	if ( isset( $_SESSION['login_manager'] ) || isset( $_SESSION['login_dj'] ) ) {
	}
	else {
		// Redirect them to the login page
		header("Location: http://localhost:1234/login.php");
	}
	
	require_once('../mysqli_connect.php');
	
?>

<html>
<head>
<title>Request Show</title>
<link rel="stylesheet" href="addad.css"/>
</head>
<body>
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
	$sql = mysqli_query($dbc, "SELECT ManID, CONCAT(manager.ManFirstName, ' ', manager.ManLastName) AS ManFullName FROM manager");
	while ($row = mysqli_fetch_array($sql)){
		echo '<option value="' . $row['ManID'] . '">'. $row['ManFullName'] . '</option>';
	}
	?>
</select>
</p>

<p id="social">Social Media Accounts [Optional]:</p>

<p>Facebook Link (i.e. https://www.facebook.com/radio1851)</p>
<p><input type="text" name="Facebook" size="30" value="" /></p>

<p>Instagram Link (i.e. https://www.instagram.com/radio1851/)</p>
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
