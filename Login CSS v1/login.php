<?php



	require_once("../mysqli_connect.php");

    session_start();

	

	if ( isset( $_SESSION['login_manager'] ) ) {

		header("Location: http://localhost:1234/managerhomepage.php");

	} 

	else if ( isset( $_SESSION['login_dj'] ) ) {

		header("Location: http://localhost:1234/djhomepage.php");

	} 

	

?>



<html>

	<head>

		<meta http-equiv='content-type' content='text/html;charset=utf-8' />

		<title>Login</title>
		
		<link rel="stylesheet" href="csstest.css"/>

	</head>

<body>

	<div class="container">

	<h3 class="text-center">Login</h3>

	

    <?php

		if($_SERVER["REQUEST_METHOD"] == "POST") {



			$myusername = mysqli_real_escape_string($dbc,$_POST['username']); 

			$mypassword = mysqli_real_escape_string($dbc,$_POST['password']);



			$manSQL = "SELECT ManID from manager WHERE ManEmail = '$myusername' and ManPassword = '$mypassword'";

			$manResult = mysqli_query($dbc,$manSQL);

			$manRow = mysqli_fetch_array($manResult,MYSQLI_ASSOC);

			$manCount = mysqli_num_rows($manResult);

			

			$djSQL = "SELECT DJID from dj WHERE DJEmail = '$myusername' and DJPassword = '$mypassword'";

			$djResult = mysqli_query($dbc,$djSQL);

			$djRow = mysqli_fetch_array($djResult,MYSQLI_ASSOC);

			$djCount = mysqli_num_rows($djResult);			

			

			if($manCount == 1){

				$_SESSION = array();

				$_SESSION['login_manager'] = $myusername;

				header("location: managerhomepage.php");

			} 

			else if($djCount == 1){

				$_SESSION = array();

				$_SESSION['login_dj'] = $myusername;

				header("location: djhomepage.php");

			} 							

			else {

				echo "<div class='alert alert-danger'>Username or Password is invalid.</div>";

			}	

		}

    ?>

	

    <form action="" method="post">

		<p>

		<div class="form-group">

			<label for="username">Username:</label>

			<input type="text" class="form-control" id="username" name="username" required>

		</div>

		</p>

		<p>

		<div class="form-group">

			<label for="pwd">Password:</label>

			<input type="password" class="form-control" id="pwd" name="password" required>

		</div>

		</p>

	       <div class="btn-pos">

	       		<form>

			<button type="submit" name="submit" class="btn btn-  			default">Login</button>

			</form>
                
	       </div>

	       <div class="btn-posit">	

			<form>

			<input type="button" 		onclick="location.href='http://localhost:1234/listenerhomepage.php';" value="I'm a Listener" id ="listenerbtn" />

			</form>
	      </div>

	      <div class="btn-posit">

		

		<form>

		<input type="button" onclick="location.href='http://localhost:1234/advertiserhomepage.php';" value="I'm an Advertiser" id="advertiserbtn" />

		</form>		
             </div>



    </form>

	</div>
	
	<div class="new-container">
	
	</div>

</body>

</html>	