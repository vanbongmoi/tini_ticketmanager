<?php
			$servername = "localhost";
			$username = "root";
			$password = "";
			$dbname = "ticket";
		
			$conn = new mysqli($servername, $username, $password, $dbname);
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			} 				
				$sql = "DELETE FROM nhap";
			if	($conn->query($sql)===true)
				{		
					$conn->close();
				}	
			$conn = new mysqli($servername, $username, $password, $dbname);
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			} 		
				$sql = "DELETE FROM tonkho";
			if	($conn->query($sql)===true)
				{
					$conn->close();
				}
			$conn = new mysqli($servername, $username, $password, $dbname);
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);	
			}
				$sql = "DELETE FROM myseri";
			if	($conn->query($sql)===true)
				{
					$conn->close();
				}
			$conn = new mysqli($servername, $username, $password, $dbname);
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);	
			}
					$sql = "DELETE FROM baocao";
			if	($conn->query($sql)===true)
				{
					$conn->close();
					header("location:maygame.php");
				}
		
?>