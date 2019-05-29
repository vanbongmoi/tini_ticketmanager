<?php  
session_start();
if(!empty($_SESSION['nhanvien']))
{
$tennhanvien_td=$_SESSION['nhanvien'];
}
include "header.php" ;
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "ticket";
		$conn = new mysqli($servername, $username, $password, $dbname);
		if ($conn->connect_error) {
			 die("Connection failed: " . $conn->connect_error);
		} 
		mysqli_set_charset($conn,"utf8");
$idmayNhap;
$myname;
$homnay=date("Y-m-d");
if(!empty($_SESSION["idmay"]))
	{
	$mayNhap= $_SESSION["idmay"];	
	settype($mayNhap, "int");
	$layidmaygame = "select id,name from tenmay where thutu = '$mayNhap'";
	$ketqua_tenmay=$conn->query($layidmaygame);	
	if($ketqua_tenmay->num_rows >0)
	{
		while ($row_idmay=$ketqua_tenmay->fetch_assoc()) {
				$idmayNhap = $row_idmay["id"];
				$myname = $row_idmay["name"];
		}
	}	

			$sqltim ="SELECT count(id_may) as countid from baocaotuan where Ngaynhap='$homnay' and  id_may='$idmayNhap'";
			$rs=$conn->query($sqltim);
			$ketquatim=0;
			if($rs->num_rows>0)
			{
				while ($r = $rs->fetch_assoc()) {
					$ketquatim=$r['countid'];
				}
			}
			if($ketquatim>0)
			{
				echo "<h1 style='color:red;'>Máy game đã nhập dữ liệu rồi. Vui lòng chọn máy khác.</h1>";
			}

	}
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	if(isset($_POST["btngame"]))
	{	
		if(isset($_POST["counter"]))
		{
			$counter = $_POST["counter"];
		}
		if(isset($_POST["startSR"]))
		{
			$startSR = $_POST["startSR"];
		}
		if(!empty($counter)&&!empty($startSR))
		{
			$sqltim ="SELECT count(id_may) as countid from baocaotuan where Ngaynhap='$homnay' and  id_may='$idmayNhap'";
			$rs=$conn->query($sqltim);
			$ketquatim=0;
			if($rs->num_rows>0)
			{
				while ($r = $rs->fetch_assoc()) {
					$ketquatim=$r['countid'];
				}
			}
			if($ketquatim<1)
			{
				$sql = "INSERT INTO baocaotuan (id_may,counter,startseri,Ngaynhap) value('$idmayNhap','$counter','$startSR','$homnay')";
				if($conn->query($sql)===TRUE)
				{
					header("location:trangchubaocao.php");
				}
				else
				{
					echo "Chưa lưu được thông tin. vui lòng thử lại.";
				}
			}
			else
			{
				echo "<h1 style='color:red;'>Máy game đã nhập dữ liệu rồi. Vui lòng chọn máy khác.</h1>";
			}
		}
	}
	}
?>
<div class="khungmain">
<div style=" background-color: Blue; width: 30%;"><a  href='trangchubaocao.php'>Quay lại.</a></div>
	<h1 style='color: orange; '><?php echo "Máy game: ".$myname;?></h1>
<form name ="gameform" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
	<h1> Số Counter:</h1>
	<input  style='font-size: 70px; ' type="text" name="counter"></br></br>
	 <h1>Số StartSeri:</h1>
 <input  style='font-size: 70px; ' type="text" name="startSR"></br></br></br></br></br></br>
	<input style='background-color: orange; color:white;width:100%;  height:200px; font-size: 36px; ' type="submit" name="btngame" value="Lưu" >
	</form>
</div>