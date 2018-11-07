<?php
ini_set('max_execution_time', 3000);
// header('Content-type: application/pdf');

// load model
use App\Model\Staff;
use App\Model\StaffTCMS;
use App\Model\HolidayCalendar;
use App\Model\Location;

use Crabbly\FPDF\FPDF as Fpdf;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

class PDF extends Fpdf
{
	// Page header
	function Header()
	{
		// Logo
		$this->Image('images/logo2.png',50,9,20);
		// Arial bold 15
		$this->SetFont('Arial','B',15);

		// set margin
		$this->SetX(10);
		$this->SetRightMargin(10);
		$this->SetLeftMargin(10);

		$this->SetTextColor(128);
		$this->Cell(0, 5, 'IPMA Industry Sdn Bhd', 0, 1, 'C');
		$this->SetFont('arial','B',10);
		$this->Cell(0, 5, 'Overtime Report', 0, 1, 'C');
		$this->SetFont('arial',NULL,7);
		$this->Cell(0, 5, 'Phone : +604 917 8799 / 917 1799 Email : ipma@ipmaindustry.com', 0, 1, 'C');

		// reset again for content
		$this->SetX(10);
		$this->SetRightMargin(10);
		$this->SetLeftMargin(10);
		// Line break
		$this->Ln(1);
	}
	
	// Page footer
	function Footer()
	{
		// due to multicell setLeftMargin from the body of the page
		$this->SetLeftMargin(10);
		$this->SetTextColor(128);
		// Position at 3.0 cm from bottom
		$this->SetY(-15);
		$this->SetFont('Arial','I',6);
		$this->Cell(0, 4, 'Lot 1266, Bandar DarulAman Industrial Park, 06000, Jitra, Kedah Darul Aman', 0, 1, 'C');
		// Arial italic 5
		$this->SetFont('Arial','I',5);
		// Page number
		$this->Cell(0,4,'Page '.$this->PageNo().'/{nb}',0,1,'C');
	}
}

$ye = $year;
$mo = $month;
$ca = $cat;

// Instanciation of inherited class
	$pdf = new Pdf('L','mm', 'A3');
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetTitle(' ');
	
	$pdf->Cell(0, 5, $pdf->GetPageHeight(), 0, 1, 'C'); // 297
	$pdf->Cell(0, 5, $pdf->GetPageWidth(), 0, 0, 'C'); // 420

	$pdf->Ln(3);
	$pdf->SetFont('Arial', 'BU', 10);	// bold & underline
	$pdf->MultiCell(0, 5, ' ', 0, 'C');
	$pdf->SetFont('Arial', NULL, 8);	// normal font
	$pdf->Ln(2);

	$pdf->SetFont('Arial', 'B', 8);	// setting font
	$pdf->Cell(15, 5, 'ID', 1, 0, 'C');
	$pdf->Cell(50, 5, 'Name', 1, 0, 'C');


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


	$filename = 'dunno yet.pdf';
	// use ob_get_clean() to make sure that the correct header is sent to the server
	ob_get_clean();
	$pdf->Output('I', $filename);											// <-- kalau nak bukak secara direct saja
	// $pdf->Output('D', $filename);										// <-- semata mata 100% download
	// $pdf->Output('F', storage_path().'/uploads/pdf/'.$filename);			// <-- send through email