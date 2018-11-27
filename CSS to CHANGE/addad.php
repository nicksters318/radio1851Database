<?php
	session_start();
	require_once('../mysqli_connect.php');
?>

<html>
<head>
<title>Add an Advertisement</title>
<link rel="stylesheet" href="addad.css"/>
</head>
<body>
<form action="http://localhost:1234/adadded.php" method="post" enctype="multipart/form-data">

<header>
  <div class="container">
     <div id="placehold">
        <h1><span class="highlight">Add an Advertisement</span></h1>
     </div>
  </div>
</header>

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