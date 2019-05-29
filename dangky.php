<?php 
session_start();	
	$quyen;
	$trungtam='ALB';
	$hoten='noname';
	$quyen;
	include "header_admin.php" ;
if(isset($_SESSION['quyen']))
{
	$quyen= $_SESSION['quyen'];
	if($quyen!='admin')
	{
	echo " <h1 style='color:red;'>Bạn không có quyền tạo tài khoản.</h1>";
		echo " <a href='trangchu.php' style='font-size:36px;'>Nhấn vào đấy để quay lại </a>";
	}
	else 
	{
		
?>
<style>
	.khungmain
	{
		margin:5% 30%;
	}
</style>
<div class="khungmain"><h1> Trang Đăng Ký Tài Khoản</h1></br>
<form name ="gameform" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  	
			Tài khoản: <input  style='font-size: 30px; ' type="text" name="acc" placeholder="abcd..."></br></br>
			Mật khẩu : <input  style='font-size: 30px; ' type="password" name="pass" placeholder="******"></br></br>
			Họ và tên: <input  style='font-size: 30px; ' type="text" name="hoten" placeholder="Vũ Văn Nam"></br></br>
			Quyền TK   :<select name="quyen"  style='font-size: 26px; width: 200px;'  >
						  <option value="tech">Tech</option>
						  <option value="admin">Admin</option>						 
						</select></br></br>
						Trung tâm  <input style='font-size: 26px;' name="trungtam" placeholder="ALB Long Bien"></input>
			</br></br></br>
			<table><tr> 
				<th><input style='background-color: orange; color:white;width:300px;  height:70px; font-size: 30px; ' type="submit" name="btndangky" value="Đăng ký"  > </input></th> 				
			</tr>
		</table>
	</br>
			<div style="width: 60%;background-color: blue;"><a style ="font-size: 36px;" href="quanlytaikhoan.php"> Xóa tài khoản</a>	</div>		
</form>
</div>
		<?php
		if ($_SERVER["REQUEST_METHOD"] == "POST") 
		{
		 if(isset($_POST["btndangky"]))
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
				if(isset($_POST["quyen"]))
				{
					$quyen = $_POST["quyen"];
				}
				if(isset($_POST["trungtam"]))
				{
					$trungtam = $_POST["trungtam"];
				}
				if(isset($_POST["hoten"]))
				{
					$hoten = $_POST["hoten"];
				}
				if(!empty($acc)&&!empty($pass))
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
						$sql = "SELECT id FROM taikhoan where tentaikhoan='$acc' ";
					$result = $conn->query($sql);
					if($result->num_rows>0)
					{
						echo "Tài khoản đã tồn tại. Vui lòng chọn tài khoản khác. ";						
					}
					else
					{
						$sql = "INSERT INTO taikhoan (tentaikhoan,tennhanvien,matkhau,quyen,trungtam) value('$acc','$hoten','$pass[0]','$quyen','$trungtam') ";
						
						if($conn->query($sql)===true)
						{
							header("location:dangnhap.php");
						}
					}
				}
				else
				{
					echo "Vui lòng nhập thông tin tài khoản, mật khẩu";
				}
		      
			}		
		}		
			
	}
}
?>