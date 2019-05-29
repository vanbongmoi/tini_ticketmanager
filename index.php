<?php 
	if(!empty($_SESSION["nhanvien"]))
	{
		header("location:trangchu.php");
	}
	else
	{
		header("location:dangnhap.php");
	}

?>