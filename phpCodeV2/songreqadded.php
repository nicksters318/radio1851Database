<?php
require_once('../mysqli_connect.php');
?>

<html>
<head>
<title>Add Song Request</title>
</head>
<body>
<?php

if(isset($_POST['submit'])){
    
    $data_missing = array();
    
    if(!empty($_POST['ListenerName'])){

        // Trim white space from the listener name and store the name 
        $listener_name = trim($_POST['ListenerName']);

    } else {
		
        // Set anonymous
        $listener_name = 'Anonymous';
	}
	
    if(empty($_POST['SongName'])){

        // Adds song name to array
        $data_missing[] = 'Song Name';

    } else {

        // Trim white space from the song name and store the song name
        $song_name = trim($_POST['SongName']);
    }

    if(empty($_POST['SongArtist'])){

        // Adds song artist to the array
        $data_missing[] = 'Song Artist';

    } else{

        // Trim white space from the song artist and store the song artist
        $song_artist = trim($_POST['SongArtist']);

    }

    if(empty($_POST['SongGenre'])){

        // Adds song genre to array
        $data_missing[] = 'Song Genre';

    } else {

        // Trim white space from the song genre and store the song genre
        $song_genre = trim($_POST['SongGenre']);

    }
	
    if(empty($_POST['ShowID'])){

        // Adds showID to array
        $data_missing[] = 'Show Requesting To';

    } else {

        // Trim white space from the showID and store the showID
        $showID = trim($_POST['ShowID']);

    }	
    
    if(empty($data_missing)){
        
        require_once('../mysqli_connect.php');
        
        $query = "INSERT INTO songrequest (ListenerName, SongName, SongArtist, SongGenre) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($dbc, $query);
        mysqli_stmt_bind_param($stmt, "ssss", $listener_name, $song_name, $song_artist, $song_genre);
        mysqli_stmt_execute($stmt);
		
		$id = mysqli_insert_id($dbc);
		
		$viewsQuery = "INSERT INTO views (ShowID, SongRequestID) VALUES (?, ?)";
		$viewsstmt = mysqli_prepare($dbc, $viewsQuery);
		mysqli_stmt_bind_param($viewsstmt, "ii", $showID, $id);	
		mysqli_stmt_execute($viewsstmt);		
        
        $affected_rows = mysqli_stmt_affected_rows($stmt);
		$viewsaffected_rows = mysqli_stmt_affected_rows($viewsstmt);
        
        if($affected_rows == 1 && $viewsaffected_rows == 1){
            
            echo 'Song Request Entered';
            
            mysqli_stmt_close($stmt);
			mysqli_stmt_close($viewsstmt);
            
		} else {
			
			echo 'Error Occurred entering Song Request<br />';
			echo mysqli_error($dbc) . '<br />';
			
            mysqli_stmt_close($stmt);
			mysqli_stmt_close($viewsstmt);
			
		}
        
    } else {
        
        echo 'You need to enter the following data<br />';
        
        foreach($data_missing as $missing){
            
            echo "$missing<br />";
            
        }
        
    }
    
}

?>

<form action="http://localhost:1234/songreqadded.php" method="post" enctype="multipart/form-data">

<b>Add a Song Request</b>

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
	require_once('../mysqli_connect.php');
	$sql = mysqli_query($dbc, "SELECT showDesc.ShowID, showDesc.showName, showDesc.showDay, showDesc.showTime FROM showDesc");
	while ($row = mysqli_fetch_array($sql)){
		echo '<option value="' . $row['ShowID'] . '">'. $row['showName'] . " " . $row['showDay'] . " " . $row['showTime'] . " " .'</option>';
	}
	?>
</select>
</p>

<p>
    <input type="submit" name="submit" value="Send" />
</p>

</form>
</body>
</html>
