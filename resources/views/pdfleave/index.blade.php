<?php

// load model
use \App\Model\Staff;
use \App\Model\StaffLeave;
use \App\Model\StaffAnnualMCLeave;
use \App\Model\StaffLeaveBackup;
use \App\Model\StaffLeaveReplacement;
use \App\Model\StaffLeaveApproval;

use Crabbly\FPDF\FPDF as Fpdf;
use Carbon\Carbon;


function my($string)
{
	$rt = Carbon::parse($string);
	return $rt->format('D, j F Y');
}

class PDF extends Fpdf
{
	// Page header
	function Header()
	{
		// Logo
		$this->Image(asset('images/logo2.png'),50,9,30);
		// Arial bold 15
		$this->SetFont('arial','B',15);
		// Move to the right
		// $this->Cell(80);
		// Title
		$this->SetTextColor(128);
		$this->Cell(0, 5, 'IPMA Industry', 0, 1, 'C');
		$this->SetFont('arial','asd',6);
		$this->Cell(0, 5, 'ntah', 0, 1, 'C');
		$this->SetFont('arial','B',8);
		$this->Cell(0, 5, 'company tagline', 0, 1, 'C');
		$this->SetFont('arial','',7);
		$this->Cell(0, 5, 'Phone : '.'+604 917 8799 / 917 1799'.' Email : ipma@ipmaindustry.com'), 0, 1, 'C');
		// Line break
		$this->Ln(5);
	}
	
	// Page footer
	function Footer()
	{
		// invoice number
		$lo2 = Preferences::find(1);

		// due to multicell setLeftMargin from the body of the page
		$this->SetLeftMargin(10);
		$this->SetTextColor(128);
		// Position at 3.0 cm from bottom
		$this->SetY(-23);
		$this->SetFont('arial','I',6);
		$this->Cell(0, 5, 'Lot 1266, Bandar DarulAman Industrial Park, 06000, Jitra, Kedah Darul Aman', 0, 1, 'C');
		// Arial italic 5
		$this->SetFont('Arial','I',5);
		// Page number
		$this->Cell(0,5,'Page '.$this->PageNo().'/{nb}',0,1,'C');
	}
}

// Instanciation of inherited class
$pdf = new PDF('P','mm', 'A5');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetTitle('Borang Permohonan Cuti '.$staffLeave->id);

// echo $pdf->GetPageWidth();		// 210.00155555556
// echo $pdf->GetPageHeight();		// 297.00008333333

$pdf->SetFont('Arial','B',15);
$pdf->SetTextColor(145, 0, 181);
$pdf->SetFillColor(200,220,255);
$pdf->Cell(0, 7, 'Invoice Number : '.$sales->id, 1, 1, 'C', true);

// reset font
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(0, 0, 0);
// $pdf->SetFillColor(200,220,255);

// $pdf->Cell(95, 5, 'test', 0, 0, 'C');
// $pdf->Cell(95, 5, 'Invoice to : ', 0, 1, 'C');
$pdf->Ln(5);

// customer section
$pdf->SetRightMargin(105);
$pdf->SetFont('Arial','B',10);
$pdf->MultiCell(0, 5, 'Invoice to : ', 0, 'L');


$pdf->SetFont('Arial','B',10);
// tracking number column
$pdf->SetRightMargin(55);
$pdf->SetLeftMargin(105);
$pdf->SetY(47);
$pdf->MultiCell(0, 5, 'Invoice Date : ', 0, 'R');
$pdf->MultiCell(0, 5, 'Tracking/Receipt Number : ', 0, 'R');


$pdf->SetFont('Arial','',8);
// tracking number list
$pdf->SetRightMargin(10);
$pdf->SetLeftMargin(155);
$pdf->SetY(47);
$pdf->MultiCell(0, 5, '', 0, 'R');
$pdf->MultiCell(0, 5, '$key->tracking_number', 0, 'R');

$pdf->Ln(30);






// reset margin
$pdf->SetX(10);
$pdf->SetRightMargin(10);
$pdf->SetLeftMargin(10);





// invoice section item
$pdf->SetFont('Arial','B',15);
$pdf->SetTextColor(145, 0, 181);
$pdf->SetFillColor(200,220,255);
$pdf->Cell(0, 7, 'Invoice Item', 1, 1, 'C', true);

// reset font
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(0, 0, 0);
$pdf->Ln(5);

// header
$pdf->Cell(70, 7, 'Product', 1, 0, 'C');
$pdf->Cell(30, 7, 'Retail (RM)', 1, 0, 'C');
$pdf->Cell(30, 7, 'Quantity', 1, 0, 'C');
$pdf->Cell(30, 7, 'Total retail (RM)', 1, 0, 'C');
$pdf->Cell(30, 7, 'Image', 1, 1, 'C');

// list of product
$pdf->SetFont('Arial','',8);
	$pdf->Cell(70, 27, 'App\Product::findOrFail($ke->id_product)->product', 1, 0, 'C');
	$pdf->Cell(30, 27, 'number_format($ke->retail, 2)', 1, 0, 'C');
	$pdf->Cell(30, 27, '$ke->quantity', 1, 0, 'C');
	$pdf->Cell(30, 27, 'number_format(($ke->retail * $ke->quantity)', 2), 1, 0, 'C');

		$pdf->Cell(30, 27, '$pdf->Image(base64ToImage($imu->image, $imu->mime)', $pdf->GetX()+1, $pdf->GetY()+0), 1, 2, 'C');
	$pdf->Cell(0, 0, '', 0, 1, 'C');

// list of taxes
		$pdf->Cell(70, 7, 'Taxes : ', 1, 0, 'C');
		$pdf->Cell(30, 7, '$txd->tax', 1, 0, 'C');
		$pdf->Cell(30, 7, '$txd->amount'.'%', 1, 0, 'C');
		$pdf->Cell(30, 7, 'number_format( ($txd->amount / 100) * $gt' , 2), 1, 0, 'C');
		$pdf->Cell(30, 7, '', 1, 1, 'C');

// footer
$pdf->SetFont('Arial','B',10);
$pdf->Cell(130, 7, 'Grand Total', 1, 0, 'C');
$pdf->Cell(30, 7, 'number_format($gt + $rp, 2)', 1, 0, 'C');
$pdf->Cell(30, 7, '', 1, 1, 'C');
$pdf->Ln(5);





// payment section item
$pdf->SetFont('Arial','B',15);
$pdf->SetTextColor(145, 0, 181);
$pdf->SetFillColor(200,220,255);
$pdf->Cell(0, 7, 'Payment', 1, 1, 'C', true);

// reset font
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(0, 0, 0);
$pdf->Ln(5);


	// header
	$pdf->Cell(130, 7, 'Bank', 1, 0, 'C');
	$pdf->Cell(30, 7, 'Date Payment', 1, 0, 'C');
	$pdf->Cell(30, 7, 'Amount', 1, 1, 'C');
	
		$pdf->Cell(130, 7, 'Banks::findOrFail($k->id_bank)->bank', 1, 0, 'C');
		$pdf->Cell(30, 7, 'my($k->date_payment)', 1, 0, 'C');
		$pdf->Cell(30, 7, 'number_format($k->amount, 2)', 1, 1, 'C');
	
	
	// footer
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(160, 7, 'Grand Total', 1, 0, 'C');
	$pdf->Cell(30, 7, 'number_format($py, 2)', 1, 1, 'C');
$pdf->Ln(5);



// for ($i=0; $i < 100; $i++) { 
// 	$pdf->Cell(0,5,'asd', 1,1,'C');
// }


$pdf->SetFont('Arial','',6);
$pdf->SetY(-31);
$pdf->Cell(0, 4, 'Invoice was created on a computer and is valid without the signature and seal.', 0,1,'L');
$pdf->Cell(0, 4, 'NOTICE: A finance charge of 1.5% will be made on unpaid balances after 30 days from the date of the invoice.', 0,1,'L');

$filename = 'Invoice for '.$cust->client.'.pdf';

$pdf->Output('I', $filename);		// <-- kalau nak bukak secara direct saja
// $pdf->Output('D');			// <-- semata mata 100% download
// $pdf->Output('F', storage_path().'/uploads/pdf/'.$filename);			// <-- send through email

?>