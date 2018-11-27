<html>
<head>
<link rel="stylesheet" href="standardstyle.css"/>
</head>
<body>

<header>
<div class="container">
<div id="placehold">
<h1><span class="highlight">Advertisers</span></h1>
</div>
</div>
</header>

<?php
// Get a connection for the database
require_once('../mysqli_connect.php');

// Create a query for the database
$query = "SELECT AdvertiserEmail, AdvertiserName, AdvertiserLogo FROM advertiser";

// Get a response from the database by sending the connection
// and the query
$response = @mysqli_query($dbc, $query);

// If the query executed properly proceed
if($response){

echo '<table align="left"
cellspacing="5" cellpadding="8">

<tr><td align="left"><b>Advertiser Name</b></td>
<td align="left"><b>Logo</b></td>
<td align="left"><b>Email</b></td>';

// mysqli_fetch_array will return a row of data from the query
// until no further data is available
while($row = mysqli_fetch_array($response)){

$img = $row['AdvertiserLogo'];

echo '<tr><td align="left">' . 
$row['AdvertiserName'] . '</td><td align="left">' . 
'<img src="'.$img . '" width=100 height=100></td><td align="left">' .
$row['AdvertiserEmail'] . '</td><td align="left">' ;

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