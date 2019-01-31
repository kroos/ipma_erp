<?php
// header('Content-type: application/pdf');

// load model
use App\Model\Staff;
use App\Model\StaffLeave;
use App\Model\StaffAnnualMCLeave;
use App\Model\StaffLeaveBackup;
use App\Model\StaffLeaveReplacement;
use App\Model\StaffLeaveApproval;

use Crabbly\FPDF\FPDF as Fpdf;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

// class PDF extends Fpdf
// {
	// Page header
	// function Header()
	// {
		// Logo
		// $this->Image('images/logo2.png',50,9,20);
		// Arial bold 15
		// $this->SetFont('Arial','B',15);

		// set margin
		// $this->SetX(10);
		// $this->SetRightMargin(10);
		// $this->SetLeftMargin(10);

		// $this->SetTextColor(128);
		// $this->Cell(0, 5, 'IPMA Industry Sdn Bhd', 0, 1, 'C');
		// $this->SetFont('arial','B',10);
		// $this->Cell(0, 5, 'Borang Permohonan Cuti', 0, 1, 'C');
		// $this->SetFont('arial',NULL,7);
		// $this->Cell(0, 5, 'Phone : +604 917 8799 / 917 1799 Email : ipma@ipmaindustry.com', 0, 1, 'C');

		// reset again for content
		// $this->SetX(10);
		// $this->SetRightMargin(10);
		// $this->SetLeftMargin(10);
		// Line break
		// $this->Ln(1);
	// }
	// 
	// Page footer
	// function Footer()
	// {
		// due to multicell setLeftMargin from the body of the page
		// $this->SetLeftMargin(10);
		// $this->SetTextColor(128);
		// Position at 3.0 cm from bottom
		// $this->SetY(-15);
		// $this->SetFont('Arial','I',6);
		// $this->Cell(0, 4, 'Lot 1266, Bandar DarulAman Industrial Park, 06000, Jitra, Kedah Darul Aman', 0, 1, 'C');
		// Arial italic 5
		// $this->SetFont('Arial','I',5);
		// Page number
		// $this->Cell(0,4,'Page '.$this->PageNo().'/{nb}',0,1,'C');
	// }
// }

// Instanciation of inherited class
	$pdf = new Fpdf('P','mm', array(215, 279));
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetTitle('Printing Service Report In Progress');
	
	// $pdf->Cell(0, 5, $pdf->GetPageHeight(), 0, 1, 'C'); // 148
	// $pdf->Cell(0, 5, $pdf->GetPageWidth(), 0, 0, 'C'); // 210

	// $pdf->SetLeftMargin(180);
	$pdf->SetFont('Arial', NULL, 10);

	// date
	$pdf->SetXY(155, 43);
	$pdf->Cell(35, 5, Carbon::parse($sr->date)->format('D, j M Y'), 0, 1, 'L');

	// customer
	$pdf->SetXY(23, 53);
	$pdf->Cell(100, 5, strtoupper(strtolower($sr->belongtocustomer->customer)), 0, 1, 'L');
	$pdf->SetX(23);
	$pdf->Cell(100, 5, strtoupper(strtolower($sr->belongtocustomer->address1)), 0, 1, 'L');
	$pdf->SetX(23);
	$pdf->Cell(100, 5, strtoupper(strtolower($sr->belongtocustomer->address2)), 0, 1, 'L');
	$pdf->SetX(23);
	$pdf->Cell(100, 5, strtoupper(strtolower($sr->belongtocustomer->address3)), 0, 1, 'L');
	$pdf->SetX(23);
	$pdf->Cell(100, 5, strtoupper(strtolower($sr->belongtocustomer->address4)), 0, 1, 'L');

	// attn to:
	$pdf->SetXY(15, 80);
	$pdf->Cell(44, 5, strtoupper(strtolower($sr->belongtocustomer->pc)), 0, 1, 'L');
	// $pdf->Cell(44, 5, 'Test PC', 0, 1, 'L');

	// phone
	$pdf->SetX(17);
	$pdf->Cell(44, 5, $sr->belongtocustomer->phone, 0, 1, 'L');

	$pdf->SetXY(110, 55);
	$i = 1;
	foreach ($sr->hasmanyattendees()->get() as $key) {
		$pdf->Cell(44, 5,$i++.') '. strtoupper(strtolower($key->belongtostaff->name)), 0, 1, 'L');
		$pdf->SetX(110);
	}

	$pdf->SetXY(2, 96);
	$pdf->MultiCell(80, 5, strtoupper(strtolower($sr->hasmanycomplaint()->first()->complaint)), 0, 'L');

	// $pdf->SetXY(20, 103);
	$pdf->SetX(2);
	$pdf->MultiCell(80, 5, 'REPORT BY : '.strtoupper(strtolower($sr->hasmanycomplaint()->first()->complaint_by)), 0, 'L');


	// for($i=1;$i<=300;$i++)
	// $pdf->Cell(0,5,"Line $i",0,1);

	// $pdf->SetY(-26);
	// $pdf->Cell(0, 5, 'Bottom', 0, 1, 'L');

	$filename = 'Service Report Print Prelimenery '.$sr->id.'.pdf';

	// use ob_get_clean() to make sure that the correct header is sent to the server so the correct pdf is being output
	ob_get_clean();
	$pdf->Output('I', $filename);		// <-- kalau nak bukak secara direct saja
	// $pdf->Output('D', $filename);			// <-- semata mata 100% download
	// $pdf->Output('F', storage_path().'/uploads/pdf/'.$filename);			// <-- send through email