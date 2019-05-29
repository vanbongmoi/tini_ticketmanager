<?php
			$servername = "localhost";
			$username = "root";
			$password = "";
			$dbname = "ticket";
			$myidnhap;
			$conn = new mysqli($servername, $username, $password, $dbname);
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			} 		
			$myidnhap=$_GET['id'];
			$sql1 = "DELETE FROM nhap WHERE id='$myidnhap'";
				$sql2 = "DELETE FROM myseri WHERE idnhap='$myidnhap'";
				if($conn->query($sql1)===TRUE)
					{
					if($conn->query($sql2)===TRUE)
					{
						header("location:trangchu.php");
					}
					else
					{

						echo "lỗi không xóa được.";
					}
					}
					else {
						echo "lỗi không xóa được.";
					}
		
	
?>