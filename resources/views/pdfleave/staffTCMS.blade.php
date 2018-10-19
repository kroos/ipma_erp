<?php
// header('Content-type: application/pdf');

// load model
use App\Model\Staff;
use App\Model\StaffLeave;
use App\Model\StaffTCMS;

use Crabbly\FPDF\FPDF as Fpdf;
use Carbon\Carbon;


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
		$this->Cell(0, 5, 'Attendance Report', 0, 1, 'C');
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

// Instanciation of inherited class
	$pdf = new Pdf('P','mm', 'A4');
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetTitle('Staff Attendance Report - '. Carbon::parse($dts)->format('D, j F Y').' To '.Carbon::parse($dte)->format('D, j F Y'));
	
	// $pdf->Cell(0, 5, $pdf->GetPageHeight(), 0, 1, 'C'); // 297
	// $pdf->Cell(0, 5, $pdf->GetPageWidth(), 0, 0, 'C'); // 210

	$pdf->Ln(5);
	$pdf->SetFont('Arial', 'BU', 10);
	$pdf->MultiCell(0, 5, 'Staff Attendance Report From '. Carbon::parse($dts)->format('D, j F Y').' To '.Carbon::parse($dte)->format('D, j F Y'), 0, 'C');

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// working on all the variables
	$staffTCMS = StaffTCMS::whereBetween('date', [$dts, $dte])->get();
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$pdf->SetFont('Arial', NULL, 10);
	$pdf->MultiCell(0, 5, $staffTCMS, 0, 'L');




















	$filename = 'Staff Attendance Report - '.Carbon::parse($dts)->format('D, j F Y').' To '.Carbon::parse($dte)->format('D, j F Y').'.pdf';
	// use ob_get_clean() to make sure that the correct header is sent to the server so the correct pdf is being output
	ob_get_clean();
	$pdf->Output('I', $filename);		// <-- kalau nak bukak secara direct saja
	// $pdf->Output('D', $filename);			// <-- semata mata 100% download
	// $pdf->Output('F', storage_path().'/uploads/pdf/'.$filename);			// <-- send through email