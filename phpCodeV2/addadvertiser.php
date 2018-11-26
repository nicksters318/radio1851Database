<?php
	session_start();
?>

<html>
<head>
<title>Register as an Advertiser</title>
</head>
<body>
<form action="http://localhost:1234/advertiseradded.php" method="post" enctype="multipart/form-data">

<b>Register as an Advertiser</b>

<p>Company / Corp. Name:
<input type="text" name="AdvertiserName" size="30" value="" />
</p>
    
<p>Company / Corp. Email (Username):
<input type="text" name="AdvertiserEmail" size="30" value="" />
</p>

<p>Company / Corp. Password:
<input type="password" name="AdvertiserPassword" size="30" value="" />
</p>

<p>Company / Corp. Logo:
	<input type="file" name="myfile" id="fileToUpload">
</p>

<p>
    <input type="submit" name="submit" value="Send" />
</p>

</form>
</body>
</html>
