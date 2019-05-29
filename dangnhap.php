<style>
	.khungmain
	{
		margin:5% 30%;
	}
</style>

<div class="khungmain"><h1> Trang Đăng Nhập</h1></br>
<form name ="gameform" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  	
			Tài khoản: <input  style='font-size: 30px; ' type="text" name="acc"></br></br>
			Mật khẩu : <input  style='font-size: 30px; ' type="password" name="pass"></br></br></br>
			<input style='background-color: orange; color:white;width:500px;  height:100px; font-size: 36px; ' type="submit" name="btngame" value="Đăng nhập" >				
	</form>
</div>
<?php 
session_start();
	$_SESSION['nhanvien']=NULL;
	$_SESSION["tentk"]=NULL;	
	$_SESSION['quyen']=	NULL;
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "ticket";
	$conn = new mysqli($servername, $username, $password, $dbname);
					if ($conn->connect_error) {
					    die("Connection failed: " . $conn->connect_error);
					} 
					mysqli_set_charset($conn,"utf8");
					$sql = "SELECT id FROM taikhoan where tentaikhoan='admin' ";
					$result = $conn->query($sql);
					if($result->num_rows<1)
					{
						$matkhau = md5('tini123');
						$matkhau =str_split($matkhau,10);

						$sql1 = "insert into  taikhoan   (tentaikhoan,tennhanvien,matkhau,quyen,trungtam) value ('admin','Admin','$matkhau[0]','admin','ALB') ";
						$conn->query($sql1);
					}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	if(isset($_POST["btngame"]))
	{		
			if(isset($_POST["acc"]))
		{
			$acc = $_POST["acc"];
		}				
			if(isset($_POST["pass"]))
		{
			$pass = $_POST["pass"];
			$pass = md5($pass);
			$pass =str_split($pass,10);
		}
		if(!empty($acc)&&!empty($pass))
		{
			
			$conn = new mysqli($servername, $username, $password, $dbname);
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			} 
				$sql = "SELECT * FROM taikhoan where tentaikhoan='$acc' and matkhau='$pass[0]' ";
			$result = $conn->query($sql);
			if($result->num_rows>0)
			{
				while ($row=$result->fetch_assoc()) {
				$_SESSION['nhanvien']=$row["id"];	
				$_SESSION['quyen']=$row["quyen"];	
					if($row["quyen"]!='admin')
					{				
					header("location:trangchu.php");	
					}	
					else
					{
					header("location:maygame.php");
					}	
				}
			}
		
		}
		else
		{
			echo "Vui lòng nhập thông tin đăng nhập.";
		}
	}	
}
?>