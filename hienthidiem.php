<?php  
	$quyen;
	$trungtam='ALB';
	$hoten='noname';
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
?>
<?php
$tennhanvien=1;
$mayNhap;
$idmayNhap;
$batdau;
$ketthuc;
$mayNhap;
$seriNhap;
$Mytoncuoi;
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ticket";
$thongbao="";
$Ca;
$str;
date_default_timezone_set('Asia/Ho_Chi_Minh');	
$homnay=date("Y-m-d");
$tg_ht=date("H:i:s");
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$sql1 = "SELECT * FROM myseri";
$result1 = $conn->query($sql1);
$countton=$result1->num_rows;
 ?>
 <div class="hienthiton">
 	<div style=" background-color: Blue; width: 30%;"><a  href='trangchu.php'>Quay lại.</a></div>
  <div style="float: right; font-size: 16px;">Còn lại: <?php echo $countton ;?>  cọc.   Số lượng:  <?php echo ($countton*4000) ;?>  tiNi điểm.</div>
	<h2 style='color: Red;'>Chọn tiNi điểm.</h2>
   </div>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
	
<div class="productName"> 

	<?php
	if ($result1->num_rows > 0) {
    // output data of each row			
    while($row = $result1->fetch_assoc()) {
    	$str =str_split($row["Startseri"],7);  
    		
		?>
		<div class="maygame">
				<?php  echo   "<div style='color: Green; height: 30px;font-size: 30px;' ></div>"; ?>
  <input  style='width:250px;height: 150px; background-color: Blue; color:white;font-size: 36px;' type='submit' name='DSseri'
  		 	 value='<?php echo $str[0]; ?>' >  		
	</div>
     <?php   }
 } ?>
	</div>
	<?php
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if(!empty($_POST["DSseri"]))
		{
		$seriNhap=$_POST["DSseri"]."001";
		}	
		if(!empty($_SESSION["nhanvien"]))
	{
	$tennhanvien= $_SESSION["nhanvien"];
	}
	if(!empty($_SESSION["idmay"]))
	{
	$mayNhap= $_SESSION["idmay"];
	settype($mayNhap, "int");
	}
	if(!empty($_SESSION["Ca"]))
	{
		$Ca= $_SESSION["Ca"];
		settype($Ca, "string");
	}
	if(!empty($mayNhap) && !empty($seriNhap) && !empty($tennhanvien))
	{		
// Create connection
	$layidmaygame = "select * from tenmay where thutu = '$mayNhap'";
	$ketqua_tenmay=$conn->query($layidmaygame);	
	if($ketqua_tenmay->num_rows >0)
	{
		while ($row_idmay=$ketqua_tenmay->fetch_assoc()) {
				$idmayNhap = $row_idmay["id"];
		}
	}	
	//////////////////////////
	$layseri = "select * from myseri where Startseri ='$seriNhap'";
	$ketqua=$conn->query($layseri);
	
	if($ketqua->num_rows >0)
	{
		while ($row=$ketqua->fetch_assoc()) {
				$batdau = $row["Startseri"];
				$ketthuc=$row["Endseri"];				
		}
	}		
		$sqltoncuoi = "SELECT * FROM myseri";
		$result_toncuoi = $conn->query($sqltoncuoi);
			if($result_toncuoi->num_rows>0)
			{
				$Mytoncuoi = $result_toncuoi->num_rows;
				$Mytoncuoi=($Mytoncuoi-1)*4000;
			}
	$sql = "insert into baocao (idmay,Ngaynhap,Ca,Xuat,Startseri,Endseri,Nhanvien,thoigian) 
	value('$idmayNhap','$homnay','$Ca','4000','$batdau','$ketthuc','$tennhanvien','$tg_ht');";
	
	if($conn->query($sql)===TRUE)
	{			
	$sqlnv = "DELETE  FROM myseri where Startseri= '$seriNhap' ";
	if ($conn->query($sqlnv) === TRUE) { 	
	 header("location:trangchu.php");
	} else {
	    echo "Error deleting record: " . $conn->error;
	}
	}
	$conn->close();
}
}
?>
</form>
</body>
<?php include "footer.php" ?>