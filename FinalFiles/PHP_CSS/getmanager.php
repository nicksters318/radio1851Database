<html>
<head>
<link rel="stylesheet" href="standardstyle.css"/>
</head>
<body>

<header>
<div class="container">
<div id="placehold">
<h1><span class="highlight">Managers</span></h1>
</div>
</div>
</header>

<?php
// Get a connection for the database
require_once('../mysqli_connect.php');

// Create a query for the database
$query = "SELECT ManID, ManFirstName, ManLastName, ManSwipeAccess, ManYear, ManEmail FROM manager";

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
<td align="left"><b>Email</b></td>';

// mysqli_fetch_array will return a row of data from the query
// until no further data is available
while($row = mysqli_fetch_array($response)){

echo '<tr><td align="left">' . 
$row['ManID'] . '</td><td align="left">' . 
$row['ManFirstName'] . '</td><td align="left">' .
$row['ManLastName'] . '</td><td align="left">' . 
$row['ManSwipeAccess'] . '</td><td align="left">' .
$row['ManYear'] . '</td><td align="left">' . 
$row['ManEmail'] . '</td><td align="left">';

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