<?php
	require_once('../mysqli_connect.php');
?>
<html>
<head>
<title>Add Song Request</title>
<link rel="stylesheet" href="standardstyle.css"/>
</head>
<body>
<form action="http://localhost:1234/songreqadded.php" method="post" enctype="multipart/form-data">

<header>
<div class="container">
<div id="placehold">
<h1><span class="highlight">Add a Song Request</span></h1>
</div>
</div>
</header>

<p>Listener Name / User Name [Optional]:
<input type="text" name="ListenerName" size="30" value="" />
</p>

<p>Song Name:
<input type="text" name="SongName" size="30" value="" />
</p>

<p>Song Artist:
<input type="text" name="SongArtist" size="30" value="" />
</p>

<p>Song Genre:
<select name="SongGenre">
  <option value="Pop">Pop</option>
  <option value="Rock">Rock</option>
  <option value="Jazz">Jazz</option>
  <option value="Hip-hop">Hip-hop</option>
  <option value="R&B">R&amp;B</option>
  <option value="Christian">Christian</option>
  <option value="Electro">Electro</option>
  <option value="Synth">Synth</option>
  <option value="Alternative">Alternative</option>
  <option value="Country">Country</option>
</select>
</p>

<p> Show Requesting To:
<select name="ShowID">
	<?php 	
	$sql = mysqli_query($dbc, "SELECT showDesc.showID, showDesc.showName, showDesc.showDay, showDesc.showTime FROM showDesc WHERE showDesc.showApproved = 'Y'");
	while ($row = mysqli_fetch_array($sql)){
		echo '<option value="' . $row['showID'] . '">'. $row['showName'] . " " . $row['showDay'] . " " . $row['showTime'] . " " .'</option>';
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
