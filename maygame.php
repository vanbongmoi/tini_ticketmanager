<?php
	$quyen;
	$trungtam='ALB';
	$hoten='noname';
	$quyen;
	session_start();
		include "header_admin.php" ;	
?> 
<div class="khungmain">
	<h1>Tạo máy game</h1>
<form name ="gameform" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  	
			Tên máy game: <input  style='font-size: 24px; ' type="text" name="tenmay" placeholder="Safari Ranger">
			Số thứ tự máy  : <input  style='font-size: 24px; ' type="number" name="stt" placeholder="1"></br></br>
				<table style='width:100%;'><tr> 
				<th><input style='background-color: orange; color:white; width:100%; height:70px; font-size: 30px; ' type="submit" name="btndangky" value="Thêm"  ></th> 				
			</tr>
		</table>
			<style>
				.daimau
				{
				height: 5px;
				background-color: Blue;
				}
				.viewgame
				{

					margin:10px 0px; 
				}
				</style>
			<div class="viewgame">				
				<div class="daimau"></div>
					<table style='width:100%;'><tr> 
				<th><input style='background-color: Green; color:white;width:100%;  height:70px; font-size: 24px; ' type="submit" name="xemmaygame" value="Xem tất cả máy game " > </th> 
				<th><input style='background-color: Blue; color:white;width:100%;  height:70px; font-size: 24px; ' type="submit" name="btnhide" value="Ẩn danh sách máy game" > </th> 
			</tr>
		</table>
			</div>

<?php 
	$productname;
	$stt;
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	if(isset($_POST["btndangky"]))
	{		
			if(isset($_POST["tenmay"]))
		{
			$productname = $_POST["tenmay"];
		}				
			if(isset($_POST["stt"]))
		{
			$stt = $_POST["stt"];
		}
		if(!empty($productname)&&!empty($stt))
		{
			$servername = "localhost";
			$username = "root";
			$password = "";
			$dbname = "ticket";
			$conn = new mysqli($servername, $username, $password, $dbname);
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			} 
				mysqli_set_charset($conn,"utf8");
				$sql = "SELECT id FROM tenmay where name='$productname' ";
				$sql1 = "SELECT id FROM tenmay where thutu='$stt' ";
				$result1 = $conn->query($sql1);
				$result = $conn->query($sql);
			if($result->num_rows>0)
			{
				echo "<h1>Máy game đã tồn tại. Vui lòng nhập máy  khác. ";					
			}
			else
			{
				if($result1->num_rows>0)
				{
				echo "<h1 style='color:Red;'>Số thứ tự máy game đã tồn tại. Vui lòng chọn số khác. </h1>";					
				}
				else
				{
				$sql = "INSERT INTO tenmay (name,thutu) value('$productname','$stt') ";				
				if($conn->query($sql)===true)
				{
					echo " <h1 style='color:Red;'>Thêm máy game thành công. </h1>";					
				}
				}
			}
		}
		else
		{
			echo " <h1 style='color:Red;'>Vui lòng nhập thông tin máy game. </h1>";
		}
	}
	if(isset($_POST["btnhide"]))
	{
		header("location:maygame.php");
	}
	if(isset($_POST["xemmaygame"]))
		{
			$sql = "SELECT * FROM tenmay";
			$result = $conn->query($sql);
			if($result->num_rows>0)
			{
?>
	<h1 style="color:Red;">Nhấn nút 'Xóa' để xóa máy game.</h1>
	<table border="solid" style=' width:100%;font-size: 36px; border-spacing: 5px;' >	
		<tr >
				<th>Tên máy game</th>
				<th>Số thứ tự</th>		
				<th>Xóa</th>			
			</tr>
<?php	
			while ($row=$result->fetch_assoc()) {
			echo "<tr>";
			//echo "<th>  <input style='font-size:18px;' type='submit' name='btnxoa' value='".$row["name"]."'> </th>" ;
			echo "<th>" .$row["name"]. "</th>" ;	
			echo "<th>" .  $row["thutu"]   . "</th>" ;	
			echo "<th>  <a style='font-size:24px; color:Blue; border:none;' href='delete.php?id=".$row['id']."'   > Xóa máy game</th>" ;					
			echo "</tr>";					
				}
			}
		}
}
?>
</table>
</form>
</div>
<?php include "footer.php"?>