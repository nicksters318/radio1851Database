<html>
<head>
<link rel="stylesheet" href="standardstyle.css"/>
</head>
<body>

<header>
<div class="container">
<div id="placehold">
<h1><span class="highlight">Song Requests</span></h1>
</div>
</div>
</header>

<?php

session_start();

if ( isset( $_SESSION['login_dj'] ) || isset( $_SESSION['login_manager'] ) ) {
} 
else {
	// Redirect them to the login page
	header("Location: http://localhost:1234/login.php");
}
	
// Get a connection for the database
require_once('../mysqli_connect.php');

// Create a query for the database
if ( isset ( $_SESSION['login_dj'] ) ) {
	$showIDQuery = "SELECT H.ShowID FROM dj D, hosts H, showdesc S WHERE D.DJID = H.DJID and D.DJEmail = '" . $_SESSION['login_dj'] . "' AND H.ShowID = S.ShowID AND S.ShowApproved = 'Y'";	
	$showIDresponse = @mysqli_query($dbc, $showIDQuery);
	if ( !mysqli_num_rows($showIDresponse)== 0 ) {
		$showID = $showIDresponse->fetch_object()->ShowID;
	}
	else {
		$showID = null;
	}
	$query = "SELECT S.ListenerName, S.SongName, S.SongArtist, S.SongGenre FROM songrequest S, views V WHERE S.SongRequestID = V.SongRequestID AND V.ShowID = '" . $showID . "' ORDER BY S.SongRequestID DESC";
}
else if ( isset ( $_SESSION['login_manager'] ) ) {
	$query = "SELECT ListenerName, SongName, SongArtist, SongGenre FROM songrequest ORDER BY SongRequestID DESC";
}

// Get a response from the database by sending the connection
// and the query
$response = @mysqli_query($dbc, $query);

// If the query executed properly proceed
if($response){

echo '<table align="left"
cellspacing="5" cellpadding="8">

<tr><td align="left"><b>Song Name</b></td>
<td align="left"><b>Song Artist</b></td>
<td align="left"><b>Song Genre</b></td>
<td align="left"><b>Listener Name / User Name</b></td>';


// mysqli_fetch_array will return a row of data from the query
// until no further data is available
while($row = mysqli_fetch_array($response)){

if ( is_null($row['ListenerName']) ){
	$listenerName = 'Anonymous';
}
else{
	$listenerName = $row['ListenerName'];
}
	
echo '<tr><td align="left">' . 
$row['SongName'] . '</td><td align="left">' .
$row['SongArtist'] . '</td><td align="left">' . 
$row['SongGenre'] . '</td><td align="left">' .
$listenerName . '</td><td align="left">' ; 

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