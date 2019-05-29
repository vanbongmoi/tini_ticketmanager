<?php
$quyen;
$trungtam='ALB';
$hoten='noname';
session_start();
include "header_admin.php" ;
?>
<div class="khung">
	<div style="background: Blue; width: 20%;"><a href='caidatmail.php'>Quay lại.</a></div>
</br>
<form method="get"<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
	<input type="hidden" name="id" value="<?php echo $_GET['id']?>"  >
	 Email:<input style=' font-size: 60px; ' type="text" name="email" placeholder="testmail@nkidgroup.com"></br></br></br></br>
  	  <input style=' font-size: 36px;  width: 100px;' type="hidden" name="thoigiangio" placeholder="21">
  	 <input style=' font-size: 36px; width: 100px; ' type="hidden" name="thoigianphut" placeholder="55"></br></br></br></br>
  <table>
  	<tr>
  	<th> <input style='background-color: orange; color:white;width:700px;  height:100px; font-size: 36px; '  type="submit"  name="btnsubmit" id="btnsubmit" value="Lưu">    </th>  	
  </tr>
</table>
<?php
			$servername = "localhost";
			$username = "root";
			$password = "";
			$dbname = "ticket";			
			$myemail;			
			$myidnhap;		
			if ($_SERVER["REQUEST_METHOD"] == "GET")
			{		
				if(isset($_GET["btnsubmit"]))
				{
					if(!empty($_GET["email"]))
					{
					$myemail = $_GET["email"];					
					}					
					$myidnhap=$_GET["id"];
					if(!empty($myemail))
					{						
						$conn = new mysqli($servername, $username, $password, $dbname);
						if ($conn->connect_error) {
							  die("Connection failed: " . $conn->connect_error);
							} 								
							$sql1 = "UPDATE DSmail SET mail='$myemail' WHERE id='$myidnhap'";							
							if($conn->query($sql1)===TRUE)
							{
							header("location:caidatmail.php");
							}								
					}
		}
	}	
?>
</form>
</div>