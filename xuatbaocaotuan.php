<?php  
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
include_once 'Classes\PHPExcel.php';
$dbname='ticket';
$username='root';
$pass='';
$servername='localhost';
$homnay;
$homnay1;
$tonkho_dau;
$tonkho_cuoi;
$counttoncauoi;
$SLnhap=0;
$Sserinhap='';
$Eserinhap='';
$rowcount;
$rowcount_nhap;
?>
<h1>Báo cáo tuần tiNi điểm tiNi World</h1>

	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
		<div class="xuatbaocao">			
		Từ ngày:<input  style='font-size:40px; '  type="date" name="date_baocao" value="<?php echo date('Y-m-d') ?>"></input>
		Đến ngày:<input  style='font-size:40px; '  type="date" name="date_baocao1" value="<?php echo date('Y-m-d') ?>"></input>
		 <table style='width: 100%;border: none; margin-top:30px'>
  	<tr style='border: none;'>
  	<th style='border: none;'> 
	<input  style='background-color: orange; color:white;width:100%;  height:80px; font-size: 36px; margin-bottom: 10px;' type="submit" name="view_BC" value="Xem báo cáo"> </input> </th>
		<th style='border: none;'><input  style='background-color: Green; color:white;width:100%;  height:80px; font-size: 36px; margin-bottom: 10px;' type="submit" name="Gui_BC" value="Gửi báo cáo"> </input> </th>

		</tr></table>
</div>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	if(!empty($_POST["view_BC"]))
	{	
			$conn = new mysqli($servername,$username,$pass,$dbname);
			if($conn->connect_error)
			{
				die("khong ket noi dc voi database.");
			}		
			mysqli_set_charset($conn,"utf8");
			$homnay=$_POST["date_baocao"];
			$homnay1=$_POST["date_baocao1"];		
			$nam = str_split($homnay,4);
			$thang = str_split($nam[1],1);
			$mthang = $thang[1].$thang[2];
			$thu_homnay= date("l", mktime(0,0,0,$nam[0],$mthang,$nam[2]));
				
			$sqlnhap = "SELECT `baocaotuan`.`Ngaynhap`, `baocaotuan`.`counter`, `baocaotuan`.`startseri`,`tenmay`.`name` FROM `tenmay`  INNER JOIN `baocaotuan` on `baocaotuan`.`id_may` = `tenmay`.`id`
			   where Ngaynhap  between '$homnay' and '$homnay1'";
			$resultnhap = $conn->query($sqlnhap);
?>
		<div class="bangbaocao" style='width: 80%; float: right;font-size: 16px'>
			<h1 style='color:red;'>Thông tin điểm nhập vào máy game.</h1>
			<div class="top" style='width: 500px;float: left'>
		<table>		
		<tr> 		
				<th>No</th>		
				<th>Máy game</th>	
				<th>Endseri</th>
				<th>Ngày</th>
				<th>thời gian</th>
				
		</tr>
		<?php
			$sqltenmay = "select id,name from tenmay";
			$result_tenmay = $conn->query($sqltenmay);	
			if($result_tenmay->num_rows>0)
			{			
			while($row1=$result_tenmay->fetch_assoc())
				{
				$myid = $row1["id"] ;
				$date=date_create($homnay);
				for($x=0;$x<7;$x++)
				{
				$date_tk= date_format($date,"Y-m-d");
				date_add($date,date_interval_create_from_date_string("1 days"));
				$sql = "SELECT `baocao`.`Ngaynhap`,`baocao`.`Endseri`,`baocao`.`thoigian`   FROM  baocao  JOIN tenmay on `tenmay`.`id` = `baocao`.`idmay` WHERE `baocao`.`idmay` = '$myid' and Ngaynhap  ='$date_tk'";	  
				$result = $conn->query($sql);
				while($row=$result->fetch_assoc())
				{
							echo "<tr>";
							echo "<th>" .($x+1)   . "</th>" ;
							echo "<th>" .$row1["name"]   . "</th>" ;
							echo "<th>" .$row["Endseri"]   . "</th>" ;
							echo "<th>" .  $row["Ngaynhap"]. "</th>" ;
							echo "<th>" .  $row["thoigian"]. "</th>" ;
							echo "</tr>";						
				}
			}
		}
	}	
?>
	</table>
</div>
<div class="bot" style='width: 500px;float: left'>
	<table>		
		<tr> 
				<th>Máy game</th>
				<th>Ngày</th>
				<th>StartSeri</th>
				<th>Thời gian</th>
		</tr>
		<?php
		if($resultnhap->num_rows>0)
		{
			while($row=$resultnhap->fetch_assoc())
			{	
				echo "<tr>";
					echo "<th>" .$row["name"]   . "</th>" ;
					echo "<th>" .  $row["Ngaynhap"]. "</th>" ;
					echo "<th>" .  $row["counter"]   . "</th>" ;
					echo "<th>" .  $row["startseri"]   . "</th>" ;
				echo "</tr>";
			}
		}
		?>
			</table>
		</div>
	<?php
}
  if(!empty($_POST["Gui_BC"]))
	{
			$objEX = new PHPExcel;
			$objEX->setActiveSheetIndex(0);
			$sheet = $objEX->getActiveSheet();			
			$rowcount  = 2;
			$rowcount_ton  = 5;
			$trungtam;			
			$sheet->setCellValue('C'.$rowcount,"Báo cáo tiNi điểm");	
			$rowcount++;
			$sheet->setCellValue('E'.$rowcount,"Ngày:". date('Y-m-d'));			
			$rowcount++;
			$sheet->setCellValue('B'.$rowcount,"Máy game");
			$sheet->setCellValue('C'.$rowcount,"Tồn đầu");			
			$sheet->setCellValue('D'.$rowcount,"Counter đầu");
			$sheet->setCellValue('E'.$rowcount,"Thứ 7");
			$sheet->setCellValue('F'.$rowcount,"Chủ nhật");
			$sheet->setCellValue('G'.$rowcount,"Thứ 2");
			$sheet->setCellValue('H'.$rowcount,"Thứ 3");
			$sheet->setCellValue('I'.$rowcount,"Thứ 4");
			$sheet->setCellValue('J'.$rowcount,"Thứ 5");
			$sheet->setCellValue('K'.$rowcount,"Thứ 6");
			$sheet->setCellValue('L'.$rowcount,"Counter cuối");
			$sheet->setCellValue('M'.$rowcount,"Tồn cuối");
			$sheet->getcolumnDimension("A")->setAutoSize(true);
				$sheet->getcolumnDimension("B")->setAutoSize(true);
					$sheet->getcolumnDimension("E")->setAutoSize(true);
						$sheet->getcolumnDimension("F")->setAutoSize(true);
							$sheet->getcolumnDimension("G")->setAutoSize(true);
								$sheet->getcolumnDimension("H")->setAutoSize(true);
								$sheet->getcolumnDimension("K")->setAutoSize(true);
						$sheet->getcolumnDimension("L")->setAutoSize(true);
							$sheet->getcolumnDimension("M")->setAutoSize(true);
							$sheet->getcolumnDimension("N")->setAutoSize(true);
			$conn = new mysqli($servername,$username,$pass,$dbname);
			if($conn->connect_error)
			{
				die("khong ket noi dc voi database.");
			}		
			mysqli_set_charset($conn,"utf8");
			$homnay=$_POST["date_baocao"];
			$homnay1=$_POST["date_baocao1"];			
			$sqltenmay = "select id,name from tenmay order by thutu";
			$result_tenmay = $conn->query($sqltenmay);
			$ct="";
			$st="";	
			if($result_tenmay->num_rows>0)
			{
				while($row=$result_tenmay->fetch_assoc())
				{
					$rowcount++;
					$myid = $row['id'];
					$sql1 = "SELECT * FROM  baocaotuan WHERE id_may = '$myid ' and Ngaynhap  between '$homnay' and '$homnay1'";	 
					$result = $conn->query($sql1);	
					if($result->num_rows>0)
					{
						while ($row1=$result->fetch_assoc()) {
							$ct = $row1["counter"];
							$st=$row1["startseri"];
						}	
					}
					else
					{
						$ct="";
						$st=0;	
					}			
					$sheet->setCellValue('B'.$rowcount,$row["name"]);
					$sheet->setCellValue('L'.$rowcount,$ct);
				$sql = "SELECT max(`baocao`.`id`) as tg  FROM  baocao  JOIN tenmay on `tenmay`.`id` = `baocao`.`idmay` WHERE `baocao`.`idmay` = '$myid' and Ngaynhap  between '$homnay' and '$homnay1'";	  
				$result = $conn->query($sql);
				while($row=$result->fetch_assoc())
				{
					$mytg = $row['tg'];
					$sqlm = "SELECT Endseri FROM baocao where id='$mytg' ";
					$rs = $conn->query($sqlm);
					if($rs->num_rows>0)
					{
						while ($r=$rs->fetch_assoc()) {		
						$str = str_split($r["Endseri"],1);
							$newstr="";
							for($x=2;$x<count($str);$x++)
							{
								$newstr.=$str[$x];
							}	
							$tinh = $newstr-$st;
						$sheet->setCellValue('M'.$rowcount,$tinh);
						}
					}
				}
				$date=date_create($homnay);
				for($x=0;$x<7;$x++)
				{
				$date_tk= date_format($date,"Y-m-d");
				date_add($date,date_interval_create_from_date_string("1 days"));
				$sql = "SELECT count(`baocao`.`id`) as countid,`baocao`.`Ngaynhap`,`baocao`.`StartSeri`   FROM  baocao  JOIN tenmay on `tenmay`.`id` = `baocao`.`idmay` WHERE `baocao`.`idmay` = '$myid' and Ngaynhap  ='$date_tk'";	  
				$result = $conn->query($sql);
				while($row=$result->fetch_assoc())
				{
					$sum = ($row["countid"]*4000);
				}
				switch ($x) {
						case 2:
						$sheet->setCellValue('E'.$rowcount,$sum);
						break;
						case 3:
						$sheet->setCellValue('F'.$rowcount,$sum);
						break;
						case 4:
						$sheet->setCellValue('G'.$rowcount,$sum);
						break;
						case 5:
						$sheet->setCellValue('H'.$rowcount,$sum);
						break;
						case 6:
						$sheet->setCellValue('I'.$rowcount,$sum);
						break;
						case 0:
						$sheet->setCellValue('J'.$rowcount,$sum);
						break;
						case 1:
						$sheet->setCellValue('K'.$rowcount,$sum);
						break;
					default:
						# code...
						break;
				}

			}				
			}	
		}
			$styleArray = array(
				'borders'=>array(
					'allborders'=>array(
						'style'=> PHPExcel_Style_Border::BORDER_THIN
					)
				)
			);
			$sheet->getStyle('A4:'.'M'.$rowcount)->applyFromArray($styleArray);
			$objWrite = new PHPExcel_Writer_Excel2007($objEX);
			$filename='reporttuan.xlsx';
			$objWrite->save($filename)	;
				//echo "<h1 style='color:RED;'>  Ok done. Báo cáo sẽ được gửi đi sau 5 phút nữa. Vui lòng kiểm tra email sau 5 phút nữa.</h1>"  ;				
			$conn->close();
} 
}
 ?>
</div>
</form>
</body>

<?php include "footer.php"?>