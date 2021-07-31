<?php
include 'lib/Session.php';
include 'classes/Users.php';
include 'vendor/fpdf/htmlPdf.php';
Session::init();

Session::CheckSession();
$sId =  Session::get('roleid');
$link = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
if ($sId === '1') { 

$pdf = new PDF('L','mm','A4');
$pdf->SetFont('Arial','',12);
$pdf->AddPage();
$pdf->AddCol('id',10,'','C');
$pdf->AddCol('name',50,'','C');
$pdf->AddCol('username',60,'','C');
$pdf->AddCol('roleid',15,'','C');
$pdf->AddCol('email',60,'','C');
$pdf->AddCol('mobile',50,'','C');
$pdf->AddCol('isActive',20,'','C');
$pdf->Table($link,'select * from tbl_users order by id');
$pdf->Output();
exit;

}else{

  header('Location:index.php');



}
 
      