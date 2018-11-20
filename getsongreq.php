<?php

session_start();

if ( isset( $_SESSION['login_dj'] ) ) {
} 
else {
	// Redirect them to the login page
	header("Location: http://localhost:1234/login.php");
}
	
// Get a connection for the database
require_once('../mysqli_connect.php');

// Create a query for the database
$query = "SELECT ListenerName, SongName, SongArtist, SongGenre FROM songrequest ORDER BY SongRequestID DESC";

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
