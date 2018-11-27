<?php
	session_start();
?>

<html>
<head>
<title>Register as an Advertiser</title>
<link rel="stylesheet" href="addad.css"/>
</head>
<body>
<form action="http://localhost:1234/advertiseradded.php" method="post" enctype="multipart/form-data">

<header>
  <div class="container">
     <div id="placehold">
        <h1><span class="highlight">Register as an Advertiser</span></h1>
     </div>
  </div>
</header>

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

<div class="new-con">

</div>
</body>
</html>
