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
			$sql = "SELECT * FROM DSmail";
			$result = $conn->query($sql);

?>
	<h1 style="color:red;">Cài đặt mail nhận</h1>
<div class="bangbaocao" style='width: 100%; float: center;font-size: 24px;'>
	<table border="solid" style=' width:100%;font-size: 36px; border-spacing: 5px;' >	
		<tr> 
				<th>Stt</th>
				<th>Mail nhận</th>
				<th>" Mật khẩu "</th>				
				<th>"        "</th>	
		</tr>
	<?php
			if($result->num_rows>0)
			{
			while ($row=$result->fetch_assoc()) {	

			echo "<tr>";
			echo "<th>" . $row["id"]  . "</th>" ;			
			echo "<th>" .  $row["mail"]   . "</th>" ;	
			echo "<th>**************</th>" ;	
			//echo "<th>" .  $row["thoigianguimail"]   . "</th>" ;	
			echo "<th> <a style='font-size:30px; color:Blue;' href='suathongtinmail.php?id=".$row["id"]."'> Sửa thông tin</th>" ;				
			echo "</tr>";	
			              //<a href='delete.php?id=".$row['id']."'   > Xóa</th>" ;			# code...
				}						
			}

?>
	</table>
</div>
<div class="bangbaocao" style='width: 100%; float: center;font-size: 24px;'>
	<table border="solid" style=' width:100%;font-size: 36px; border-spacing: 5px;' >	
		<tr> 
				<th>Stt</th>
				<th>Mail gửi</th>
				<th>" Mật khẩu "</th>				
				<th>"        "</th>		
		</tr>
	<?php
			$sql = "SELECT * FROM DSmail";
			$result1 = $conn->query($sql);
			if($result1->num_rows>0)
			{
			while ($row=$result1->fetch_assoc()) {	

			echo "<tr>";
			echo "<th>" . $row["id"]  . "</th>" ;			
			echo "<th>" .  $row["mailgui"]   . "</th>" ;	
			echo "<th>**************</th>" ;	
			//echo "<th>" .  $row["thoigianguimail"]   . "</th>" ;	
			echo "<th> <a style='font-size:30px; color:Blue;' href='suathongtinmailgui.php?id=".$row["id"]."'> Sửa thông tin</th>" ;				
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