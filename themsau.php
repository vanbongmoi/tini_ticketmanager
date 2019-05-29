<?php
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if(!empty($_POST["DSseri"]))
		{
		$seriNhap=$_POST["DSseri"];
		}
		settype($seriNhap, "int");
		 $_SESSION["DSseri"] =	$seriNhap;
			
	if(!empty($mayNhap) && !empty($seriNhap) && !empty($tennhanvien))
	{		
// Create connection

	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 
	$layseri = "select * from myseri where id=$seriNhap";
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
	$sql = "insert into baocao (idmay,Ngaynhap,Ca,Xuat,Startseri,Endseri,Nhanvien) 
	value('$mayNhap','$homnay','$Ca','4000','$batdau','$ketthuc','$tennhanvien');";
	
	if($conn->query($sql)===TRUE)
	{			
	$sqlnv = "DELETE  FROM myseri where id= $seriNhap ";
	if ($conn->query($sqlnv) === TRUE) { 		

	   $_SESSION["thongbao"] ="OK";
	} else {
	    echo "Error deleting record: " . $conn->error;
	}
	}
	$conn->close();
}
}
?>