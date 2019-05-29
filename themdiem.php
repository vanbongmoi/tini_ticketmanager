
<?php
	$quyen;
	$trungtam='ALB';
	$hoten='noname';
	$quyen;
	session_start();
if(isset($_SESSION['quyen']))
{
	$quyen= $_SESSION['quyen'];
	if($quyen!='admin')
	{
		include "header.php" ;
	}
	else
	{
		include "header_admin.php" ;
	}
}
$startseri=0;
$mykytu;
$allseri_bd;
$allseri_kt;
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ticket";
$batdau;
$ketthuc;
$ketthuc1;
$tennhanvien='1';
$Ca;
?>
<style>
.khung
{
	width: 90%;
	margin: 0 8%;
	
}
</style>
<div class="khung">
	<div  style="background-color: Blue; width: 30%;"><a href='trangchu.php'>Quay lại.</a></div>
</br>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
   Ký tự bắt đầu:<select name="kytu"  style='font-size: 60px; width: 200px;'  >
						  <option value="A">A</option>
						  <option value="B">B</option>
						  <option value="C">C</option>
						   <option value="D">D</option>
						   <option value="E">E</option>
						  <option value="F">F</option>
						  <option value="G">G</option>
						   <option value="H">H</option>
						   <option value="I">I</option>
						   <option value="J">J</option>
						  <option value="K">K</option>
						  <option value="L">L</option>
						   <option value="M">M</option>
						   <option value="N">N</option>
						  <option value="O">O</option>
						  <option value="P">P</option>
						   <option value="Q">Q</option>
						   <option value="R">R</option>
						   <option value="S">S</option>
					           <option value="T">T</option>
						   <option value="U">U</option>
						   <option value="V">V</option>
						   <option value="W">W</option>
						  <option value="X">X</option>
						  <option value="Y">Y</option>
						  <option value="Z">Z</option>
						</select><br></br></br>
  Start Seri: </br><input style=' font-size: 60px; ' type="text" name="seri" placeholder="12345001"></br></br></br></br>
  <table>
  	<tr>
  	<th> <input style='background-color: orange; color:white;width:700px;  height:100px; font-size: 36px; '  type="submit"  name="btnsubmit" id="btnsubmit" value="Nhập điểm">    </th>  	
  </tr>
</table>
</br> </br> 
<style>		
				.viewgame
				{
					margin:10px 0px; 
				}
				</style>
<div class="viewgame">	
				<input style='background-color: Green; color:white;width:300px;  height:80px; font-size: 30px; ' type="submit" name="xemdiemnhap" value="Xem điểm đã nhập " > <input style='background-color: Blue; color:white;width:300px;  height:80px; font-size: 30px; ' type="submit" name="btnhide" value="Ẩn danh sách điểm" > 
			</div>
<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") 
	{		
			if(isset($_POST["btnsubmit"]))
			{
				if(!empty($_POST["seri"]))
				{
				$startseri = $_POST["seri"];
				$startseri=trim($startseri);
				}
				if(!empty($_POST["kytu"]))
				{
				$mykytu=$_POST["kytu"];
				$mykytu= trim(strtoupper($mykytu));
				settype($startseri, "int");
				}
				if(!empty($startseri) && !empty($mykytu))
				{
				$allseri_bd=  $mykytu." ". $startseri;
				$allseri_kt=  $mykytu." ". ($startseri+159999);
			date_default_timezone_set("Asia/Ho_Chi_Minh");
			$gio=date("H");
			$phut=date("i");
			if($gio<14)
			{
				$Ca="Sang";
			}
			else
			{
				$Ca="Chieu";
			}
		// Create connection
			$conn = new mysqli($servername, $username, $password, $dbname);
			// Check connection
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			} 
			if(!empty($_SESSION["nhanvien"]))
			{
			$tennhanvien =  $_SESSION["nhanvien"];
			}
			$nnhap = date('Y-m-d');
			$sqltondau = "select Tondau from tonkho where Ngayton='$nnhap' ";
			$result_tondau = $conn->query($sqltondau);
			$kt_tondau=false;
			if($result_tondau->num_rows<1)			
			{
				$sqlthemtondau="insert into tonkho (Ngayton,Tondau,Nhanvien) value('$nnhap','160000','$tennhanvien_td')";
				$conn->query($sqlthemtondau);	
			}			
			else {
				while ($row = $result_tondau->fetch_assoc()) {
				$sltam = $row["Tondau"];				
				}
				$tam = $sltam+160000;		
				$sqlthemtondau="update tonkho set tonkho.Tondau= '$tam' where Ngayton='$nnhap'";
				$conn->query($sqlthemtondau);	
			}	
			$sqlnhapbaocao = "insert into nhap (Ngaynhap,Soluong,Startseri,Endseri,Nhanvien) value('$nnhap','160000',
								'$allseri_bd','$allseri_kt','$tennhanvien');";			
			if ($conn->query($sqlnhapbaocao) === TRUE) {
				$last_id = $conn->insert_id;
					for ($i=0; $i < 40; $i++) { 
					$batdau=$mykytu ." ". $startseri;
					$startseri+=4000;

					$ketthuc= $mykytu." ". ($startseri-1);	
					$sql = "INSERT INTO MYSERI (idnhap,Startseri,Endseri) VALUES ('$last_id','$batdau', '$ketthuc');";
					$conn->query($sql);	
					}
				header("location:trangchu.php");
			} else {
			   echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}
				$conn->close();
			}
			else
			{
				echo " <h1 style='color:Red;'>Chưa nhập dữ liệu </h1>";
			}
	
	if(isset($_POST["xemdiemnhap"]))
		{
			$sql1 = "SELECT * FROM nhap";
			$result1 = $conn->query($sql1);
			if($result1->num_rows>0)
			{
?>
</br>
	<table border="solid" style=' width:100%;font-size: 36px; border-spacing: 5px;' >	
		<tr >
				
				<th>Ngày nhập</th>	
				<th>Start seri</th>
				<th>Xóa điểm nhập</th>							
			</tr>
<?php	
			while ($row=$result1->fetch_assoc()) {
			echo "<tr>";
			//echo "<th>  <input style='font-size:18px;' type='submit' name='btnxoa' value='".$row["name"]."'> </th>" ;
			echo "<th>" .$row["Ngaynhap"]. "</th>" ;
				echo "<th>" .$row["Startseri"]. "</th>" ;			
			echo "<th>  <a style='font-size:24px; color:Blue; border:none; ' href='delete_diemnhap.php?id=".$row['id']."'   > Xóa điểm nhập</th>" ;					
			echo "</tr>";					
				}
			}
		
		}

		if(isset($_POST["btnhide"]))
	{
		header("location:themdiem.php");
	}
			;
}

?>
</table>
</form>
</div>
</body>
<?php include "footer.php"?>