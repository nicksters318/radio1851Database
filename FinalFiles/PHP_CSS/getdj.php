<html>
<head>
<link rel="stylesheet" href="standardstyle.css"/>
</head>
<body>

<header>
<div class="container">
<div id="placehold">
<h1><span class="highlight">DJs</span></h1>
</div>
</div>
</header>

<form action="" method="POST">

<?php

session_start();

// Get a connection for the database
require_once('../mysqli_connect.php');

// Create a query for the database
$query = "SELECT DJID, DJFirstName, DJLastName, DJSwipeAccess, DJYear, DJEmail, ManID FROM dj";

// Get a response from the database by sending the connection
// and the query
$response = @mysqli_query($dbc, $query);

// If the query executed properly proceed
if($response){

echo '<table align="left"
cellspacing="5" cellpadding="8">

<tr><td align="left"><b>Student ID</b></td>
<td align="left"><b>First Name</b></td>
<td align="left"><b>Last Name</b></td>
<td align="left"><b>Swipe Access (Y/N)</b></td>
<td align="left"><b>Year of Graduation</b></td>
<td align="left"><b>Email</b></td>
<td align="left"><b>Mentor ID</b></td>';
if ( isset( $_SESSION['login_manager'] ) ) {
	echo '<td align="left"><b>Delete?</b>' ;
	?>
	<p>
    <input type="submit" name="submit" value="Send" />
	</p>
	<?php	
	echo '</td>';
} 

// mysqli_fetch_array will return a row of data from the query
// until no further data is available
while($row = mysqli_fetch_array($response)){

echo '<tr><td align="left">' . 
$row['DJID'] . '</td><td align="left">' . 
$row['DJFirstName'] . '</td><td align="left">' .
$row['DJLastName'] . '</td><td align="left">' . 
$row['DJSwipeAccess'] . '</td><td align="left">' .
$row['DJYear'] . '</td><td align="left">' . 
$row['DJEmail'] . '</td><td align="left">'.
$row['ManID'] . '</td><td align="left">';
if ( isset( $_SESSION['login_manager'] ) ) {
	echo '<select name="' . $row['DJID'] . '">' .
		'<option value="N">N</option>' . 
		'<option value="Y">Y</option>' .
		'</select>';
	echo '</td>';
		
	if(isset($_POST['submit'])){
		if ($_POST[$row['DJID']] == 'Y') {
			$showQuery = "SELECT H.ShowID FROM hosts H WHERE H.DJID = '" . $row['DJID'] . "'";
			$showresponse = @mysqli_query($dbc, $showQuery);
			$showID = $showresponse->fetch_object()->ShowID;
			
			$songQuery = "SELECT V.SongRequestID FROM views V WHERE V.ShowID = '" . $showID . "'";
			$songresponse = @mysqli_query($dbc, $songQuery);
			
			$deleteQuery = "DELETE FROM hosts WHERE DJID = '" .$row['DJID'] . "'";
			@mysqli_query($dbc, $deleteQuery);
			
			$deleteQuery = "DELETE FROM socialmedia WHERE ShowID = '" . $showID . "'";
			@mysqli_query($dbc, $deleteQuery);
			
			$deleteQuery = "DELETE FROM views WHERE ShowID = '" . $showID . "'";
			@mysqli_query($dbc, $deleteQuery);
			
			$deleteQuery = "DELETE FROM showdesc WHERE ShowID = '" . $showID . "'";
			@mysqli_query($dbc, $deleteQuery);
			
			$deleteQuery = "DELETE FROM dj WHERE DJID = '" . $row['DJID'] . "';";
			@mysqli_query($dbc, $deleteQuery);
			
			if($songresponse) {
				while($row = mysqli_fetch_array($songresponse)){
					$songRequestID = $songresponse->fetch_object()->SongRequestID;
					$deleteSongQuery = "DELETE FROM songrequest WHERE SongRequestID = '" . $songRequestID . "'";
					@mysqli_query ($dbc, $deleteSongQuery);
				}
			}														
		}
	}	
}

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