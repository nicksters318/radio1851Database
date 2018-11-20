<html>
<head>
<title>Add Song Request</title>
</head>
<body>
<form action="http://localhost:1234/songreqadded.php" method="post">

<b>Add a Song Request</b>

<p>Listener Name / User Name:
<input type="text" name="ListenerName" size="30" value="" />
</p>

<p>Song Name:
<input type="text" name="SongName" size="30" value="" />
</p>

<p>Song Artist:
<input type="text" name="SongArtist" size="30" value="" />
</p>

<p>Song Genre:
<input type="text" name="SongGenre" size="30" value="" />
</p>

<p>
    <input type="submit" name="submit" value="Send" />
</p>

</form>
</body>
</html>
