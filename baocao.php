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
<div style="background-color: Blue; width: 30%;"><a  href='trangchu.php'>Quay lại.</a></div>
<h1>Báo cáo tiNi điểm tiNi World</h1>

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
			$sql = "SELECT `baocao`.`Ngaynhap`, `tenmay`.`name`, `baocao`.`nhanvien`, `baocao`.`Ca`, `baocao`.`Xuat`, `baocao`.`Startseri`, `baocao`.`Endseri`, `baocao`.`thoigian` FROM `tenmay`  INNER JOIN `baocao` on `baocao`.`idmay` = `tenmay`.`id`
			   where Ngaynhap  between '$homnay' and '$homnay1'";
			
			$sql_laynhap = "select * from nhap where Ngaynhap  between '$homnay' and '$homnay1'";
			$result_nhap = $conn->query($sql_laynhap);			
			$result = $conn->query($sql);		
			$sql_laytondau = "select * from tonkho where Ngayton between '$homnay' and '$homnay1'";
			$result_tonkho = $conn->query($sql_laytondau);				
			if($result_tonkho->num_rows>0)
			{
				?>
				<style> 
					.thongke
					{
						width: 28%;
						float: left;
						box-shadow: 5px 0px 10px gray;
					}
					.bangbaocao
					{
						box-shadow: -5px 0px 10px gray;
					}
				</style>
				<div class="thongke">
				<div class="thongketon">
			<h3 style='color:red;'>Thông tin tồn đầu,cuối hàng ngày.</h3>
				<table style="width: 100%">  <tr> 
				 <th> Ngày tồn </th> 
				 <th>  Tồn đầu </th> 
				 <th>  tồn cuối </th> 
				  </tr>
			<?php				
			while ($row_ton=$result_tonkho->fetch_assoc()) 
				{	
					$tonkho_dau = $row_ton["Tondau"];	
					if($tonkho_dau>0)
					{
					$myngayton= $row_ton["Ngayton"] ;					
					$sql_tc = "select Ngaynhap from baocao where Ngaynhap='$myngayton'";
					$result_tc = $conn->query($sql_tc);	
					$counttoncauoi = $result_tc->num_rows*4000;	
					$tonkho_cuoi = $tonkho_dau-$counttoncauoi;
					echo "<tr>";
					echo "<th>" . $row_ton["Ngayton"]  . "</th>" ;
					echo "<th>" .   $tonkho_dau   . "</th>" ;
					echo "<th>" . $tonkho_cuoi . "</th>" ;
					echo "</tr>";						
			}
				}
			}
			?>
			</table></div>
			<div class="thongkenhap">
			<h3  style='color:red; font-size: 24px;' >Số Serri ghi trên thùng.</h3>
			<table style="width: 100%">	
			<tr >  
					<th>Ngày nhập</th>
					<th>Số lượng</th>
					<th>Startseri</th>
					<th>Endseri</th>			
			</tr>		
			 <?php	
		
				if($result_nhap->num_rows>0)
				{
					while ($row_nhap=$result_nhap->fetch_assoc()) {				
						echo "<tr>";
					echo "<th>" . $row_nhap["Ngaynhap"]  . "</th>" ;
					echo "<th>" . $row_nhap["Soluong"]  . "</th>" ;
					echo "<th>" .   $row_nhap["Startseri"]   . "</th>" ;
					echo "<th>" .  $row_nhap["Endseri"]  . "</th>" ;
					echo "</tr>";
					}			
				}	
		
?>
		</table>
		</div>
	</div>
		<div class="bangbaocao" style='width: 70%; float: right;font-size: 16px'>
			<h1 style='color:red;'>Thông tin điểm nhập vào máy game.</h1>
			<table>		
		<tr> 
				<th>Máy game</th>
				<th>Ngày</th>				
				<th>Ca</th>					
				<th>Xuất</th>
				<th>Start seri</th>
				<th>End seri</th>			
				<th>Nhân viên</th>
		</tr>
		<?php
		if($result->num_rows>0)
		{
		while($row=$result->fetch_assoc())
		{		
			$tennhanvien;
			$myid=$row["nhanvien"];
			$tennv = "select tennhanvien from taikhoan where id='$myid'";
				$resultnv=$conn->query($tennv);
				if($resultnv->num_rows>0)
				{
					while ($rownv=$resultnv->fetch_assoc()) {
						$tennhanvien=$rownv["tennhanvien"];
					}
				}
			echo "<tr>";
				echo "<th>" .$row["name"]   . "</th>" ;
				echo "<th>" .  $row["Ngaynhap"]   ." ".  $row["thoigian"]. "</th>" ;
				echo "<th>" .  $row["Ca"]   . "</th>" ;							
				echo "<th>" .  $row["Xuat"]   . "</th>" ;
				echo "<th>" .  $row["Startseri"]   . "</th>" ;
				echo "<th>" .  $row["Endseri"]   . "</th>" ;		
				echo "<th>" . $tennhanvien   . "</th>" ;	
			echo "</tr>";
		}
	}
			 echo "</table>"; 
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
			$sheet->setCellValue('A'.$rowcount,"Máy game");
			$sheet->setCellValue('B'.$rowcount,"Ngày");
			$sheet->setCellValue('C'.$rowcount,"Ca");
			$sheet->setCellValue('D'.$rowcount,"Xuất");
			$sheet->setCellValue('E'.$rowcount,"Startseri");
			$sheet->setCellValue('F'.$rowcount,"Endseri");
			$sheet->setCellValue('G'.$rowcount,"Nhân Viên");
			$sheet->setCellValue('H'.$rowcount,"Ngày tồn");
			$sheet->setCellValue('I'.$rowcount,"Tồn đầu");
			$sheet->setCellValue('J'.$rowcount,"Tồn cuối");
			$sheet->setCellValue('K'.$rowcount,"Ngày nhập");
			$sheet->setCellValue('L'.$rowcount,"Số lượng");
			$sheet->setCellValue('M'.$rowcount,"StartSeri");
			$sheet->setCellValue('N'.$rowcount,"EndSeri");
			
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
			$sql1 = "SELECT `baocao`.`Ngaynhap`, `tenmay`.`name`, `baocao`.`nhanvien`, `baocao`.`Ca`, `baocao`.`Xuat`, `baocao`.`Startseri`, `baocao`.`Endseri`, `baocao`.`thoigian` FROM `tenmay`  INNER JOIN `baocao` on `baocao`.`idmay` = `tenmay`.`id`  where Ngaynhap  between '$homnay' and '$homnay1'";
			$result1 = $conn->query($sql1);			
			$sql_laytondau = "select * from tonkho where Ngayton  between '$homnay' and '$homnay1'";
			$result_tonkho1 = $conn->query($sql_laytondau);				

			
			if($result_tonkho1->num_rows>0)
			{				
				while ($row_ton=$result_tonkho1->fetch_assoc()) {
					$tonkho_dau = $row_ton["Tondau"];	
					if($tonkho_dau>0)
					{
					$myngayton= $row_ton["Ngayton"] ;				
					$sql_tc = "select Ngaynhap from baocao where Ngaynhap='$myngayton'";
					$result_tc = $conn->query($sql_tc);	
					$counttoncauoi = $result_tc->num_rows*4000;	
				$tonkho_cuoi =$tonkho_dau-$counttoncauoi;
				$sheet->setCellValue('H'.($rowcount_ton),$row_ton["Ngayton"]);
				$sheet->setCellValue('I'.($rowcount_ton),$tonkho_dau);
				$sheet->setCellValue('J'.($rowcount_ton),$tonkho_cuoi);
				$rowcount_ton++;
				}
			}
			}
			$sumxuat=0;
			if($result1->num_rows>0)
			{
				$sumxuat=0;
				while ($row=$result1->fetch_assoc()) {
			$tennhanvien;		
			$myid=$row["nhanvien"];
			$tennv = "select * from taikhoan where id='$myid'";
			$resultnv=$conn->query($tennv);
			if($resultnv->num_rows>0)
			{
				while ($rownv=$resultnv->fetch_assoc()) {
					$tennhanvien=$rownv["tennhanvien"];
					$sheet->setCellValue('C3','Trung tâm: '.$rownv["trungtam"]);
				}
			}
					$rowcount++;	
					$sumxuat+=$row["Xuat"];				
					$sheet->setCellValue('A'.$rowcount,$row["name"]);
					$sheet->setCellValue('B'.$rowcount,$row["Ngaynhap"]." ".$row["thoigian"]);
					$sheet->setCellValue('C'.$rowcount,$row["Ca"]);
					$sheet->setCellValue('D'.$rowcount,$row["Xuat"]);
					$sheet->setCellValue('E'.$rowcount,$row["Startseri"]);
					$sheet->setCellValue('F'.$rowcount,$row["Endseri"]);
					$sheet->setCellValue('G'.$rowcount,$tennhanvien);

				}	
				$sheet->setCellValue('D'.($rowcount+1),'Tổng xuất:'.$sumxuat);
			}
			
			$sql_laynhap = "select * from nhap where Ngaynhap  between '$homnay' and '$homnay1' ";
			$result_nhap = $conn->query($sql_laynhap);
			
			$rowcount_nhap=5;
			$sumsoluong=0;
			if($result_nhap->num_rows>0)
			{
				$sumsoluong=0;
				while ($row_nhap=$result_nhap->fetch_assoc()) {								
					$sheet->setCellValue('K'.$rowcount_nhap, $homnay);
					$sumsoluong+=$row_nhap["Soluong"];
					$sheet->setCellValue('L'.$rowcount_nhap, $row_nhap["Soluong"]);
					$sheet->setCellValue('M'.$rowcount_nhap, $row_nhap["Startseri"]);
					$sheet->setCellValue('N'.$rowcount_nhap, $row_nhap["Endseri"]);
					$rowcount_nhap	++;	
				}		
					$sheet->setCellValue('L'.$rowcount_nhap,'Tổng nhập:'. $sumsoluong);
			}	

			$styleArray = array(
				'borders'=>array(
					'allborders'=>array(
						'style'=> PHPExcel_Style_Border::BORDER_THIN
					)
				)
			);

			$sheet->getStyle('A4:G4')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)
				->getStartColor()->setARGB('C0C0C0');
				$sheet->getStyle('D'.($rowcount+1))->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)
				->getStartColor()->setARGB('C0C0C0');
				$sheet->getStyle('L'.$rowcount_nhap)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)
				->getStartColor()->setARGB('C0C0C0');
				$sheet->getStyle('H4:J4')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)
				->getStartColor()->setARGB('4B0082');
					$sheet->getStyle('K4:N4')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)
				->getStartColor()->setARGB('FF7F00');
			$sheet->getStyle('A2:G4')->getFont()->setBold(true);

			$sheet->getStyle('A4:'.'G'.$rowcount)->applyFromArray($styleArray);
			$sheet->getStyle('H4:'.'J'.($rowcount_ton-1))->applyFromArray($styleArray);
			$sheet->getStyle('K4:'.'N'.($rowcount_nhap-1))->applyFromArray($styleArray);
			//////////////////////////////////
			$objWrite = new PHPExcel_Writer_Excel2007($objEX);
			$filename='report.xlsx';
			$objWrite->save($filename)	;
				//echo "<h1 style='color:RED;'>  Ok done. Báo cáo sẽ được gửi đi sau 5 phút nữa. Vui lòng kiểm tra email sau 5 phút nữa.</h1>"  ;				
			$conn->close();
			include "guimail.php";
			
	}
} 
 ?>
 </table>
</div>
</form>
</body>

<?php include "footer.php"?>