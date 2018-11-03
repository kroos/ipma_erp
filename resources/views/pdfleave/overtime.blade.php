<?php
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

$year;
$half;
$month;
$loc;

// location
$lc = Location::find($loc);
$lon = $lc->location;

// half period
if( $half == 1 ) {

	$mon1 = Carbon::create($year, $month, 1);
	$mon2 = Carbon::create($year, $month, 15);
	$fh = 'First Half ';
	$hp = CarbonPeriod::create( $mon1, '1 days', $mon2 );

} elseif ($half == 2) {

	$mon1 = Carbon::create($year, $month, 16);
	$mon2 = $mon1->copy()->endOfMonth();
	$fh = 'Second Half ';
	$hp = CarbonPeriod::create( $mon1, '1 days', $mon2 );

}

// Instanciation of inherited class
	$pdf = new Pdf('P','mm', 'A4');
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetTitle($fh.'Overtime Report On '.$mon1->copy()->format('F Y').' For '.$lon);
	
	// $pdf->Cell(0, 5, $pdf->GetPageHeight(), 0, 1, 'C'); // 297
	// $pdf->Cell(0, 5, $pdf->GetPageWidth(), 0, 0, 'C'); // 210

	$pdf->Ln(3);
	$pdf->SetFont('Arial', 'BU', 10);	// bold & underline
	$pdf->MultiCell(0, 5, $fh.'Overtime Report On '.$mon1->copy()->format('F Y').' For '.$lon, 0, 'C');
	$pdf->SetFont('Arial', NULL, 8);	// bold & underline
	$pdf->Ln(2);

	// setup exception for sunday and holiday
	$tcms = StaffTCMS::whereBetween('date', [$mon1->format('Y-m-d'), $mon2->format('Y-m-d')])->get();

	// staff at specific location and active only
	$s = Staff::where('location_id', $loc)->where('active', 1)->get();

	foreach ($s as $stf) {
			$pdf->MultiCell(0, 5, $stf->name, 0, 'L');
		$ct = $stf->belongtomanyposition()->wherePivot('main', 1)->first();
		if ( $ct->group_id == 4 && $ct->category_id == 2 ) {
			$pdf->MultiCell(0, 5, $stf->name, 0, 'L');
		}
	}


// 	foreach($tcms as $tc) {
// 	if(Carbon::parse($tc->date)->dayOfWeek != 0)

// 		// all of this are for checking sunday and holiday
// 		$hol = [];
// 		// echo $tc->date.' date<br />';
// 		if( Carbon::parse($tc->date)->dayOfWeek != 0 ) {
// 			// echo $tc->date.' kerja <br />';
// 			$cuti = HolidayCalendar::all();
// 			foreach ($cuti as $cu) {
// 				$co = CarbonPeriod::create($cu->date_start, '1 days', $cu->date_end);
// 				// echo $co.' array or string<br />';
// 				foreach ($co as $key) {
// 					if (Carbon::parse($key)->format('Y-m-d') == $tc->date) {
// 						$hol[Carbon::parse($key)->format('Y-m-d')] = 'a';
// 						// echo $key.' key<br />';
// 					}
// 				}
// 			}
// 		}

// 		// print_r($hol);
// 		// echo '<br />';
// 		// if( array_has($hol, '2018-10-22') ) {
// 		// 	echo 'success<br />';
// 		// } else {
// 		// 	echo 'tak jumpa<br />';
// 		// }

// 		$in = Carbon::createFromTimeString($tc->in);
// 		$break = Carbon::createFromTimeString($tc->break);
// 		$resume = Carbon::createFromTimeString($tc->resume);
// 		$out = Carbon::createFromTimeString($tc->out);
// 	}








	$filename = $fh.'Overtime Report On '.$mon1->copy()->format('F Y').' For '.$lon.'.pdf';
	// use ob_get_clean() to make sure that the correct header is sent to the server so the correct pdf is being output
	ob_get_clean();
	$pdf->Output('I', $filename);		// <-- kalau nak bukak secara direct saja
	// $pdf->Output('D', $filename);			// <-- semata mata 100% download
	// $pdf->Output('F', storage_path().'/uploads/pdf/'.$filename);			// <-- send through email