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

use Illuminate\Support\Collection;

class PDF extends Fpdf
{
	// Page header
	function Header()
	{
		// Logo
		$this->Image('images/logo2.png',150,10,20);
		// Arial bold 15
		$this->SetFont('Arial','B',15);

		// set margin
		$this->SetX(10);
		$this->SetRightMargin(10);
		$this->SetLeftMargin(10);

		$this->SetTextColor(128);
		$this->Cell(0, 5, 'IPMA Industry Sdn Bhd', 0, 1, 'C');
		$this->SetFont('arial','B',10);
		$this->Cell(0, 5, 'Leave And Availability Report', 0, 1, 'C');
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
		$this->SetFont('Arial','I',7);
		$this->Cell(0, 5, 'Lot 1266, Bandar DarulAman Industrial Park, 06000, Jitra, Kedah Darul Aman', 0, 1, 'C');
		// Arial italic 5
		$this->SetFont('Arial','I',6);
		// Page number
		$this->Cell(0,4,'Page '.$this->PageNo().'/{nb}',0,1,'C');
	}
}

$now = Carbon::now();
$ye = $now->copy()->format('Y');
$n = Carbon::now();
$dn = $n->copy()->today();
$ca = $cate;

switch ($ca) {
	case '1':
	$cat = 'Office';
		break;

	case '2':
	$cat = 'Production';
		break;
}

// Instanciation of inherited class
	$pdf = new Pdf('L','mm', 'A3');
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetTitle('Staff Leave And Availability Report For '.$cat.' Category ('.$ye.')');
	
	// $pdf->Cell(0, 5, $pdf->GetPageHeight(), 0, 1, 'C'); // 297
	// $pdf->Cell(0, 5, $pdf->GetPageWidth(), 0, 0, 'C'); // 420

	$pdf->Ln(3);
	$pdf->SetFont('Arial', 'B', 15);	// bold & underline
	$pdf->MultiCell(0, 5, 'Staff Leave And Availability Report For Category '.$cat.' ('.$ye.')', 0, 'C');
	$pdf->SetFont('Arial', NULL, 8);	// normal font
	$pdf->Ln(2);

	// header
	$pdf->SetFont('Arial', 'B', 15);	// setting font
	$pdf->Cell(10, 14, '#', 1, 0, 'C');
	$pdf->Cell(15, 14, 'ID', 1, 0, 'C');
	$pdf->Cell(75, 14, 'Name', 1, 0, 'C');
	$pdf->Cell(30, 14, 'Location', 1, 0, 'C');
	$pdf->Cell(90, 14, 'Department', 1, 0, 'C');
	$pdf->Cell(120, 7, 'Leave Taken', 1, 2, 'C');

	$pdf->Cell(20, 7, 'AL', 1, 0, 'C');
	$pdf->Cell(20, 7, 'UPL', 1, 0, 'C');
	$pdf->Cell(20, 7, 'MC', 1, 0, 'C');
	$pdf->Cell(30, 7, 'MC-UPL', 1, 0, 'C');
	$pdf->Cell(30, 7, 'ABSENT', 1, 0, 'C');

	$y = $pdf->GetY();
	$x = $pdf->GetX();

	$pdf->SetXY( $x, $y-7 );
	$pdf->Cell(50, 14, 'Total Leave', 1, 1, 'C');

	$pdf->SetFont('Arial', NULL, 12);	// setting font
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	// calculation and put all this into collection for sorting
	$staff = Staff::whereNotIn('id', [191, 192])->where('active', 1)->get();
	foreach ($staff as $st) {
		$std = $st->belongtomanyposition()->wherePivot('main', 1)->first();
		if( $std->category_id == $ca ) {

			$username = $st->hasmanylogin()->where('active', 1)->first()->username;
			$name = $st->name;
			$location = $st->belongtolocation->location;
			$dept = $std->belongtodepartment->department;

			$leaveALMC = $st->hasmanystaffannualmcleave()->where('year', date('Y'))->first();

			$alu = ($leaveALMC->annual_leave + $leaveALMC->annual_leave_adjustment) - ($leaveALMC->annual_leave_balance); //al utilize
			$mcu = ($leaveALMC->medical_leave + $leaveALMC->medical_leave_adjustment) - ($leaveALMC->medical_leave_balance); // mc utilize
			$mcuplu = $st->hasmanystaffleave()->whereYear( 'date_time_start', date('Y') )->where('leave_id', 11)->get()->sum('period'); // mc-upl utilize
			$uplu = $st->hasmanystaffleave()->whereYear( 'date_time_start', date('Y') )->whereIn('leave_id', [3, 6])->whereIn('active', [1, 2])->get()->sum('period'); // upl utilize

			////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			$absent = $st->hasmanystafftcms()->where('leave_taken', 'ABSENT')->whereBetween('date', [$dn->copy()->startOfYear()->format('Y-m-d'), $n->copy()->format('Y-m-d')])->whereNull('exception')->get();
			$b = 0;
			foreach($absent as $ab) {
				$lea1 = $st->hasmanystaffleave()->whereRaw('"'.$ab->date.'" BETWEEN DATE(staff_leaves.date_time_start) AND DATE(staff_leaves.date_time_end)')->whereIn('active', [1, 2])->first();

				// all of this are for checking sunday and holiday
				$hol = [];
				// echo $tc->date.' date<br />';
				if( Carbon::parse($ab->date)->dayOfWeek != 0 ) {
					// echo $tc->date.' kerja <br />';
					$cuti = HolidayCalendar::all();
					foreach ($cuti as $cu) {
						$co = CarbonPeriod::create($cu->date_start, '1 days', $cu->date_end);
						// echo $co.' array or string<br />';
						foreach ($co as $key) {
							if (Carbon::parse($key)->format('Y-m-d') == $ab->date) {
								$hol[Carbon::parse($key)->format('Y-m-d')] = 'a';
								// echo $key.' key<br />';
							}
						}
					}
					if( !array_has($hol, $ab->date) ) {
						if( $ab->leave_taken == 'ABSENT' && is_null($lea1) ) {
							$b++;
						}
					}
				}
			}
			$abs = $b;	// absent
			////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			$total = $alu + $mcu + $mcuplu + $uplu + $abs;
			// $pdf->MultiCell(0, 7, $location.'|'.$dept.'|'.$alu.'|'.$mcu.'|'.$mcuplu.'|'.$uplu.'|'.'|'.$abs.'|'.$total.'|', 1, 'L');
			////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			$col[] = ['username' => $username, 'name' => $name, 'location' => $location, 'department' => $dept, 'al' => $alu, 'mc' => $mcu, 'mc-upl' => $mcuplu, 'upl' => $uplu, 'absent' => $abs, 'total' => $total];
		}
	}
	// dd($col);
	// initializing collection class from laravel
	$collect = collect($col);
	// $pdf->MultiCell(0, 5, $collect->values()->all(), 0, 'C');
	// $pdf->MultiCell(0, 5, ($col), 0, 'C');

	// dd($collect);

	$colso = $collect->sortByDesc('total');

	// dd($colso);

	$p = 1;
	foreach ($colso as $key => $val) {
		// $pdf->MultiCell(0, 5, $val['username'], 0, 'C');

		$pdf->Cell(10, 10, $p++, 1, 0, 'C');
		$pdf->Cell(15, 10, $val['username'], 1, 0, 'C');
		$pdf->Cell(75, 10, $val['name'], 1, 0, 'C');
		$pdf->Cell(30, 10, $val['location'], 1, 0, 'C');
		$pdf->Cell(90, 10, $val['department'], 1, 0, 'C');
		$pdf->Cell(20, 10, $val['al'], 1, 0, 'C');
		$pdf->Cell(20, 10, $val['upl'], 1, 0, 'C');
		$pdf->Cell(20, 10, $val['mc'], 1, 0, 'C');
		$pdf->Cell(30, 10, $val['mc-upl'], 1, 0, 'C');
		$pdf->Cell(30, 10, $val['absent'], 1, 0, 'C');
		$pdf->Cell(50, 10, ($val['total'] > 1)?$val['total'].' days':$val['total'].' day', 1, 1, 'C');
	}
// $pdf->Cell(0, 5, $pdf->GetY(), 1, 1, 'C');
// $pdf->SetY( -1 );
$pdf->SetFont('Arial', NULL, 10);	// setting font
$pdf->Cell(0, 5, 'Valid as of '.$now->format('l, j F Y'), 0, 1, 'C');
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$filename = 'Staff Leave And Availability Report For '.$cat.' Category ('.$ye.').pdf';
	// use ob_get_clean() to make sure that the correct header is sent to the server
	ob_get_clean();
	$pdf->Output('I', $filename);											// <-- kalau nak bukak secara direct saja
	// $pdf->Output('D', $filename);										// <-- semata mata 100% download
	// $pdf->Output('F', storage_path().'/uploads/pdf/'.$filename);			// <-- send through email