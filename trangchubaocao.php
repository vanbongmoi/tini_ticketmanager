<?php 
	$quyen;
	$trungtam='ALB';
	$hoten='noname';
session_start();
include "header.php" ;
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ticket";
$_SESSION["idmay"]=NULL;
$homnay=date("Y-m-d");
$mayNhap;
$Mytondau;
$tennhanvien_td;
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * FROM Tenmay order by thutu";
$result = $conn->query($sql);
$sql1 = "SELECT * FROM myseri";
$result1 = $conn->query($sql1);
$tondau_ = $result1->num_rows;
$sqltondau = "select Tondau from tonkho where Ngayton='$homnay' ";
$result_tondau = $conn->query($sqltondau);

if(!empty($_SESSION['nhanvien']))
{
$tennhanvien_td=$_SESSION['nhanvien'];
}
if($result_tondau->num_rows<1)
{
	if($tondau_>0)
	{
			$Mytondau=$tondau_*4000;
			$sqlthemtondau="insert into tonkho (Ngayton,Tondau,Nhanvien) value('$homnay','$Mytondau','$tennhanvien_td')";
			$conn->query($sqlthemtondau);	
}
}
?>
<form name ="gameform" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  	
		<h1 style='color: Red;' >Danh sách máy Game.</h1>
<div class="productName"> 
<?php
if ($result->num_rows > 0) {
    // output data of each row

    while($row = $result->fetch_assoc()) {
    	?>
   <div class="maygame">
  		<?php echo   "<div style='color: Green; font-size: 24px;' >". $row["name"]  . "</div>" ?>
  		<input  style='width:250px;height: 130px; background-color: silver; font-size: 70px;' type='submit' name='btngame' value='<?php echo $row["thutu"] ?>' >  		
	</div>
  <?php  }} ?>
</div>
<?php   $conn->close();  ?>
</form>
<?php 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	if(isset($_POST["btngame"]))
	{		
		$_SESSION["Ca"]= $Ca;
		$_SESSION["idmay"]= $_POST["btngame"];	
		
	header("location:baocaohangtuan.php");
	}
}
?>
</body>
<?php include "footer.php"?>
