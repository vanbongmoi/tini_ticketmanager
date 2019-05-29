<?php
			$servername = "localhost";
			$username = "root";
			$password = "";
			$dbname = "ticket";
			$gameid;
			$conn = new mysqli($servername, $username, $password, $dbname);
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			} 		
			$gameid=$_GET['id'];
			$sql = "DELETE FROM tenmay WHERE id = '$gameid'";
			if($conn->query($sql)===true)
			{			
				header("location:maygame.php");
			}
?>