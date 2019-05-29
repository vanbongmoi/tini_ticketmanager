<?php

$quyen;
	$trungtam='ALB';
	$hoten='noname';
session_start();
		include "header_admin.php" ;
			$servername = "localhost";
			$username = "root";
			$password = "";
			$dbname = "ticket";
			$conn = new mysqli($servername, $username, $password, $dbname);
				mysqli_set_charset($conn,"utf8");
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			} 
				$sql = "SELECT * FROM taikhoan";
			$result = $conn->query($sql);

			?>
			<div style="background: Blue; width: 20%; "><a  href='dangky.php'>Quay lại.</a></div>
		</br>
			<h1 style="color:red;">Xóa tài khoản.</h1>
<div class="bangbaocao" style='width: 100%; float: center;font-size: 24px;'>
	<table border="solid" style=' width:100%;font-size: 36px; border-spacing: 5px;' >	
		<tr> 
				<th>Tài khoản</th>
				<th>Mật khẩu</th>
				<th>Quyền</th>					
				<th>Trung tâm</th>					
				<th>Xóa</th>				
		</tr>
	<?php
			if($result->num_rows>0)
			{
			while ($row=$result->fetch_assoc()) {								
			echo "<tr>";
			echo "<th>" . $row["tentaikhoan"]  . "</th>" ;
			echo "<th> ****** </th>" ;
			echo "<th>" .  $row["quyen"]   . "</th>" ;		
			echo "<th>" .  $row["trungtam"]   . "</th>" ;			
			echo "<th> <a style='font-size:30px; color:Blue' href='xoataikhoan.php?id=".$row['id']."'> Xóa tài khoản</th>" ;				
			echo "</tr>";	
			              //<a href='delete.php?id=".$row['id']."'   > Xóa</th>" ;			# code...
				}						
			}

?>
	</table>
</div>
<?php

$conn->close();
?>