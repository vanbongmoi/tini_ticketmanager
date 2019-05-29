<?php
require "PHPMailer/src/PHPMailer.php";
require "PHPMailer/src/Exception.php";
require "PHPMailer/src/SMTP.php";
require "PHPMailer/src/OAuth.php";
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
//Load Composer's autoloader
$mailtrungtam;
$mailgui;
$passmailgui;
$dbname='ticket';
$username='root';
$pass='';
$servername='localhost';
            $conn = new mysqli($servername,$username,$pass,$dbname);
            if($conn->connect_error)
            {
                die("khong ket noi dc voi database.");
            }     
            $sql = "select * from DSmail";
            $result = $conn->query($sql);              
            if($result->num_rows>0)
            {
                while ($row=$result->fetch_assoc()) {
                   $mailtrungtam = $row["mail"];
                    $mailgui = $row["mailgui"];
                    $passmailgui = $row["passmailgui"];
                }                    
            }
            $conn->close();    
$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = $mailgui;                 // SMTP username
    $mail->Password = $passmailgui;                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to
    //Recipients
    $mail->setFrom($mailgui, 'Tech tiNi World');
    $mail->addAddress($mailtrungtam, 'tiNi World');     // Add a recipient
    //Attachments
    $mail->addAttachment('report.xlsx');      
    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Ticket Daily Report.';
    $mail->Body    = 'Dear Anh/Chị quản lý </br> Team tech gửi Anh/Chị file báo cáo tiNi điểm hàng ngày.</br> Anh/Chị vui lòng xem chi tiết trong file đính kèm. </br> Trân Trọng!';
   // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
      echo "<h1 style='corlor:Red;'>Gửi báo cáo thành công.</h1> ";
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}