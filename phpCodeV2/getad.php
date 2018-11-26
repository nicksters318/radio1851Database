<form action="" method="POST">

<?php

session_start();

if ( isset( $_SESSION['login_manager'] ) ) {
	$query = "SELECT AdID, AdDescription, AdLogo, StartDate, EndDate, TimesPerWeek, AdvertiserEmail, ManID, AdApproved FROM ad";
	$idquery = "SELECT ManID from manager WHERE ManEmail = '" . $_SESSION['login_manager'] . "'";
} 
else {
	$query = "SELECT AdID, AdDescription, AdLogo, StartDate, EndDate, TimesPerWeek, AdvertiserEmail, ManID, AdApproved FROM ad WHERE AdApproved = 'Y'";
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

<tr><td align="left"><b>Ad Description</b></td>
<td align="left"><b>Logo</b></td>
<td align="left"><b>Start Date</b></td>
<td align="left"><b>End Date</b></td>
<td align="left"><b>Times Per Week</b></td>
<td align="left"><b>Advertiser Email</b></td>';
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
while($row = mysqli_fetch_array($response)){

$img = $row['AdLogo'];

echo '<tr><td align="left">' . 
$row['AdDescription'] . '</td><td align="left">' . 
'<img src="'.$img . '" width=100 height=100></td><td align="left">' .
$row['StartDate'] . '</td><td align="left">' .
$row['EndDate'] . '</td><td align="left">' .
$row['TimesPerWeek'] . '</td><td align="left">' .
$row['AdvertiserEmail'] . '</td><td align="left">' ;
if (isset($id)) {
	if ( $id == $row['ManID'] AND $row['AdApproved'] != 'Y') {
		echo $row['ManID'] . '</td><td align="left">'; 
		echo '<select name="' . $row['AdID'] . '">' .
			'<option value="Y">Y</option>' . 
			'<option value="N">N</option>' .
			'</select>';
		echo '</td>';
		
		if(isset($_POST['submit'])){
			$updateQuery = "UPDATE ad SET AdApproved = '" . $_POST[$row['AdID']] . "' WHERE AdID = '" . $row['AdID'] . "'";
			@mysqli_query($dbc, $updateQuery);
		}	
	} 
	else if ( isset ( $_SESSION['login_manager'] ) ) {
		echo $row['ManID'] . '</td><td align="left">' . 
		$row['AdApproved'] . '</td><td align="left">';
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
