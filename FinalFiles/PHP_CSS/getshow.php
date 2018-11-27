<html>
<head>
<link rel="stylesheet" href="standardstyle.css"/>
</head>
<body>

<header>
<div class="container">
<div id="placehold">
<h1><span class="highlight">Shows</span></h1>
</div>
</div>
</header>

<form action="" method="POST">

<?php

session_start();

if ( isset( $_SESSION['login_manager'] ) ) {
	$query = "SELECT ShowID, ShowName, ShowLogo, ShowBio, ShowCategory, ShowDay, ShowTime, ManID, ShowApproved FROM showdesc ORDER BY CASE
		WHEN ShowDay = 'Sunday' THEN 1
		WHEN ShowDay = 'Monday' THEN 2
		WHEN ShowDay = 'Tuesday' THEN 3
		WHEN ShowDay = 'Wednesday' THEN 4
		WHEN ShowDay = 'Thursday' THEN 5
		WHEN ShowDay = 'Friday' THEN 6
		WHEN ShowDay = 'Saturday' THEN 7
		END, TIME(ShowTime) ASC";
	$idquery = "SELECT ManID from manager WHERE ManEmail = '" . $_SESSION['login_manager'] . "'";
} 
else {
	$query = "SELECT ShowID, ShowName, ShowLogo, ShowBio, ShowCategory, ShowDay, ShowTime, ManID, ShowApproved FROM showdesc WHERE ShowApproved = 'Y' ORDER BY CASE
		WHEN ShowDay = 'Sunday' THEN 1
		WHEN ShowDay = 'Monday' THEN 2
		WHEN ShowDay = 'Tuesday' THEN 3
		WHEN ShowDay = 'Wednesday' THEN 4
		WHEN ShowDay = 'Thursday' THEN 5
		WHEN ShowDay = 'Friday' THEN 6
		WHEN ShowDay = 'Saturday' THEN 7
		END, TIME(ShowTime) ASC";
}

// Get a connection for the database
require_once('../mysqli_connect.php');

// Get a response from the database by sending the connection
// and the query
$response = @mysqli_query($dbc, $query);
if ( isset( $idquery ) ) {
	$idresponse = @mysqli_query($dbc, $idquery);
	$id = $idresponse->fetch_object()->ManID;
}

// If the query executed properly proceed
if($response){

echo '<table align="left"
cellspacing="5" cellpadding="8">

<tr><td align="left"><b>Show Name</b></td>
<td align="left"><b>Host(s)</b></td>
<td align="left"><b>Logo</b></td>
<td align="left"><b>Bio</b></td>
<td align="left"><b>Category</b></td>
<td align="left"><b>Day</b></td>
<td align="left"><b>Time</b></td>
<td align="left"><b>Social Media</b></td>';
if ( isset( $_SESSION['login_manager'] ) ) {
	echo '<td align="left"><b>Manager to Approve</b></td>' .
	'<td align="left"><b>Approved</b>' ;
	?>
	<p>
    <input type="submit" name="submit" value="Send" />
	</p>
	<?php	
	echo '</td>';
} 

// mysqli_fetch_array will return a row of data from the query
// until no further data is available
$count = 0;
while($row = mysqli_fetch_array($response)){

$img = $row['ShowLogo'];

if ( isset( $_SESSION['login_manager'] ) ) {
$hostQuery = "SELECT CONCAT(DJ.DJFirstName, ' ', DJ.DJLastName) AS DJFullName, H.ShowID
			  FROM dj DJ, showdesc S, hosts H
			  WHERE DJ.DJID = H.DJID and H.ShowID = S.ShowID
              ORDER BY CASE
				WHEN S.ShowDay = 'Sunday' THEN 1
				WHEN S.ShowDay = 'Monday' THEN 2
				WHEN S.ShowDay = 'Tuesday' THEN 3
				WHEN S.ShowDay = 'Wednesday' THEN 4
				WHEN S.ShowDay = 'Thursday' THEN 5
				WHEN S.ShowDay = 'Friday' THEN 6
				WHEN S.ShowDay = 'Saturday' THEN 7
				END, TIME(ShowTime) ASC";
				
$smQuery = "SELECT Facebook, Instagram, Twitter
			  FROM showdesc S, socialmedia SM
			  WHERE S.ShowID = SM.ShowID
              ORDER BY CASE
				WHEN S.ShowDay = 'Sunday' THEN 1
				WHEN S.ShowDay = 'Monday' THEN 2
				WHEN S.ShowDay = 'Tuesday' THEN 3
				WHEN S.ShowDay = 'Wednesday' THEN 4
				WHEN S.ShowDay = 'Thursday' THEN 5
				WHEN S.ShowDay = 'Friday' THEN 6
				WHEN S.ShowDay = 'Saturday' THEN 7
				END, TIME(ShowTime) ASC";		
} 

else {
$hostQuery = "SELECT CONCAT(DJ.DJFirstName, ' ', DJ.DJLastName) AS DJFullName, H.ShowID
			  FROM dj DJ, showdesc S, hosts H
			  WHERE DJ.DJID = H.DJID and H.ShowID = S.ShowID and S.ShowApproved = 'Y'
              ORDER BY CASE
				WHEN S.ShowDay = 'Sunday' THEN 1
				WHEN S.ShowDay = 'Monday' THEN 2
				WHEN S.ShowDay = 'Tuesday' THEN 3
				WHEN S.ShowDay = 'Wednesday' THEN 4
				WHEN S.ShowDay = 'Thursday' THEN 5
				WHEN S.ShowDay = 'Friday' THEN 6
				WHEN S.ShowDay = 'Saturday' THEN 7
				END, TIME(ShowTime) ASC";
				
$smQuery = "SELECT Facebook, Instagram, Twitter
			  FROM showdesc S, socialmedia SM
			  WHERE S.ShowID = SM.ShowID and S.ShowApproved = 'Y'
              ORDER BY CASE
				WHEN S.ShowDay = 'Sunday' THEN 1
				WHEN S.ShowDay = 'Monday' THEN 2
				WHEN S.ShowDay = 'Tuesday' THEN 3
				WHEN S.ShowDay = 'Wednesday' THEN 4
				WHEN S.ShowDay = 'Thursday' THEN 5
				WHEN S.ShowDay = 'Friday' THEN 6
				WHEN S.ShowDay = 'Saturday' THEN 7
				END, TIME(ShowTime) ASC";	
}		

// Get a response from the database by sending the connection
// and the query
$hostResponse = @mysqli_query($dbc, $hostQuery);
$smResponse = @mysqli_query($dbc, $smQuery);

if($hostResponse){
$hosts = array();
$hostCount = 0;
while($hostRow = mysqli_fetch_array($hostResponse)){
	$hosts[$hostCount] = array();
	$hosts[$hostCount][0] = $hostRow['DJFullName'];
	$hosts[$hostCount][1] = $hostRow['ShowID'];
	$hostCount += 1;
}
}
$hostCount -= 1;

$finalHosts = [];
for ($i = 0; $i < $hostCount + 1; $i++) {

	if ($i != $hostCount) {
		if ($hosts[$i][1] == $hosts[$i+1][1]) {
			$hostString = $hosts[$i][0] . '<br />' . $hosts[$i+1][0];
			array_push($finalHosts, $hostString);
		}
		else if ($i != 0) {
			if ($hosts[$i][1] != $hosts[$i-1][1]) {
				array_push($finalHosts, $hosts[$i][0]);
			}
		}
		else {
			array_push($finalHosts, $hosts[$i][0]);
		}
	}
	else if($i == $hostCount AND $hosts[$i][1] != $hosts[$i-1][1]) {
		array_push($finalHosts, $hosts[$i][0]);
	}
}

if($smResponse){
$sm = [];
while($smRow = mysqli_fetch_array($smResponse)){
	$smString = $smRow['Facebook'] . '<br />' . $smRow['Instagram'] . '<br />' . $smRow['Twitter'];
	array_push($sm, $smString);
}
}

echo '<tr><td align="left">' . 
$row['ShowName'] . '</td><td align="left">' .
$finalHosts[$count] . '</td><td align="left">' .
'<img src="'.$img . '" width=100 height=100></td><td align="left">' .
$row['ShowBio'] . '</td><td align="left">' . 
$row['ShowCategory'] . '</td><td align="left">' . 
$row['ShowDay'] . '</td><td align="left">' .
$row['ShowTime'] . '</td><td align="left">' .
$sm[$count] . '</td><td align="left">';
if (isset($id)) {
	if ( $id == $row['ManID'] AND $row['ShowApproved'] != 'Y') {
		echo $row['ManID'] . '</td><td align="left">'; 
		echo '<select name="' . $row['ShowID'] . '">' .
			'<option value="Y">Y</option>' . 
			'<option value="N">N</option>' .
			'</select>';
		echo '</td>';
		
		if(isset($_POST['submit'])){
			$updateQuery = "UPDATE showdesc SET ShowApproved = '" . $_POST[$row['ShowID']] . "' WHERE ShowID = '" . $row['ShowID'] . "'";
			@mysqli_query($dbc, $updateQuery);
		}	
	} 
	else if ( isset ( $_SESSION['login_manager'] ) ) {
		echo $row['ManID'] . '</td><td align="left">' . 
		$row['ShowApproved'] . '</td><td align="left">';
	}
}

$count += 1;

echo '</tr>';
}

echo '</table>';

} else {

echo "Couldn't issue database query<br />";

echo mysqli_error($dbc);

}

// Close connection to the database
mysqli_close($dbc);

?>
</form>

</body>
</html>