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
	$hpl = $mon2->day;

} elseif ($half == 2) {

	$mon1 = Carbon::create($year, $month, 16);
	$mon2 = $mon1->copy()->endOfMonth();
	$fh = 'Second Half ';
	$hp = CarbonPeriod::create( $mon1, '1 days', $mon2 );
	$hpl = $mon2->day;

}

// Instanciation of inherited class
	$pdf = new Pdf('L','mm', 'A4');
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetTitle($fh.'Overtime Report On '.$mon1->copy()->format('F Y').' For '.$lon.' ('.$mon1->copy()->format('D, j F Y').' to '.$mon2->copy()->format('D, j F Y').')');
	
	// $pdf->Cell(0, 5, $pdf->GetPageHeight(), 0, 1, 'C'); // 297
	// $pdf->Cell(0, 5, $pdf->GetPageWidth(), 0, 0, 'C'); // 210

	$pdf->Ln(3);
	$pdf->SetFont('Arial', 'BU', 10);	// bold & underline
	$pdf->MultiCell(0, 5, $fh.'Overtime Report On '.$mon1->copy()->format('F Y').' For '.$lon.' ('.$mon1->copy()->format('D, j F Y').' to '.$mon2->copy()->format('D, j F Y').')', 0, 'C');
	$pdf->SetFont('Arial', NULL, 8);	// bold & underline
	$pdf->Ln(2);

	// 10 left and 10 right, left only 190..so we have 8 column
	$pdf->SetFont('Arial', 'B', 8);	// setting font
	$pdf->Cell(15, 5, 'ID', 1, 0, 'C');
	$pdf->Cell(50, 5, 'Name', 1, 0, 'C');

	foreach ($hp as $h) {
		$d = Carbon::parse($h);
		// $pdf->Cell(50, 5, $tc, 1, 0, 'L');

		// checking for sunday and holiday
		if( $d->dayOfWeek != 0 ) {
			$cuti = HolidayCalendar::whereRaw('"'.Carbon::parse($h)->format('Y-m-d').'" BETWEEN holiday_calendars.date_start AND holiday_calendars.date_end')->first();

			if ( is_null($cuti) ) {
				$pdf->Cell(12, 5, $d->copy()->format('j M'), 1, 0, 'C');
				// $pdf->Cell(12, 5, '2', 1, 0, 'C');
			}
		}
	}
	$pdf->Cell(17, 5, 'Total Hours', 1, 1, 'C');
	$pdf->SetFont('Arial', NULL, 8);	// setting font

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	// staff at specific location and active only
	$s = Staff::where('location_id', $loc)->where('active', 1)->get();

	$ott = 0;

	foreach ($s as $stf) {
		$ct = $stf->belongtomanyposition()->wherePivot('main', 1)->first();

		if ( $ct->group_id == 4 || $ct->category_id == 2 ) {
			// $pdf->MultiCell(0, 5, $stf->name, 0, 'L');

			$us = $stf->hasmanylogin()->where('active', 1)->first();

			$pdf->Cell(15, 5, $us->username, 1, 0, 'L');
			$pdf->Cell(50, 5, $stf->name, 1, 0, 'L');

			foreach ($hp as $h) {

				$d = Carbon::parse($h);
				$tc = $stf->hasmanystafftcms()->where('date', $d->format('Y-m-d'))->first();

				// checking for sunday
				if( $d->dayOfWeek != 0 ) {
					$cuti = HolidayCalendar::whereRaw('"'.Carbon::parse($h)->format('Y-m-d').'" BETWEEN holiday_calendars.date_start AND holiday_calendars.date_end')->first();

					// checking for holiday
					if ( is_null($cuti) ) {

						// checking for time out
						if( $ct->id == 72 && $d->dayOfWeek != 5 ) {	// checking for friday
							$time = \App\Model\WorkingHour::where('year', $d->year)->where('category', 8);
						} else {
							if ( $ct->id == 72 && $d->dayOfWeek == 5 ) {	// checking for friday
								$time = \App\Model\WorkingHour::where('year', $d->year)->where('category', 8);
							} else {
								if( $ct->id != 72 && $d->dayOfWeek != 5 ) {	// checking for friday
									// normal
									$time = \App\Model\WorkingHour::where('year', $d->year)->whereRaw('"'.$d->format('Y-m-d').'" BETWEEN working_hours.effective_date_start AND working_hours.effective_date_end' )->limit(1);
								} else {
									if( $ct->id != 72 && $d->dayOfWeek == 5 ) {	// checking for friday
										$time = \App\Model\WorkingHour::where('year', $d->year)->where('category', 3)->whereRaw('"'.$d->format('Y-m-d').'" BETWEEN working_hours.effective_date_start AND working_hours.effective_date_end' )->limit(1);
									}
								}
							}
						}
						//	echo 'start_am => '.$time->first()->time_start_am;
						//	echo ' end_am => '.$time->first()->time_end_am;
						//	echo ' start_pm => '.$time->first()->time_start_pm;
						//	echo ' end_pm => '.$time->first()->time_end_pm.'<br />';

						$tc = $stf->hasmanystafftcms()->where( 'date', $d->format('Y-m-d') )->first();
						if( is_null($tc) ) {
							$out = Carbon::createFromTimeString( '00:00:00' );
						} else {
							$out = Carbon::createFromTimeString($tc->out);
						}


						if( $ct->category_id == 2 OR $ct->group_id == 4 ) {	// check for OT and ramadhan month
							if ( $out->eq( Carbon::createFromTimeString('00:00:00') ) ) {
								$ot = 0;
							} else {
								// if endPM for category_id = 2 or group_id = 4 => 5:45pm, means normal day
								// if endPM for category_id = 2 or group_id = 4 => 5:00pm, means ramadhan month
								if( Carbon::createFromTimeString($time->first()->time_end_pm)->eq( Carbon::createFromTimeString('17:45:00') ) ) {

									if ( $out->lt( Carbon::createFromTimeString('18:50:00') ) ) {
										$ot = 0;
									} else {
										if( $out->gte( Carbon::createFromTimeString('18:50:00') ) && $out->lt( Carbon::createFromTimeString('19:20:00') ) ) {
											$ot = 1;
										} else {
											if ( $out->gte( Carbon::createFromTimeString('19:20:00') ) && $out->lt( Carbon::createFromTimeString('19:50:00') ) ) {
												$ot = 1.5;
											} else {
												if ( $out->gte( Carbon::createFromTimeString('19:50:00') ) && $out->lt( Carbon::createFromTimeString('20:20:00') ) ) {
													$ot = 2;
												} else {
													if ( $out->gte( Carbon::createFromTimeString('20:20:00') ) && $out->lt( Carbon::createFromTimeString('20:50:00') ) ) {
														$ot = 2.5;
													} else {
														if ( $out->gte( Carbon::createFromTimeString('20:50:00') ) && $out->lt( Carbon::createFromTimeString('21:20:00') ) ) {
															$ot = 3;
														} else {
															if ( $out->gte( Carbon::createFromTimeString('21:20:00') ) && $out->lt( Carbon::createFromTimeString('21:50:00') ) ) {
																$ot = 3.5;
															} else {
																if ( $out->gte( Carbon::createFromTimeString('21:50:00') ) && $out->lt( Carbon::createFromTimeString('22:20:00') ) ) {
																	$ot = 4;
																}
															}
														}
													}
												}
											}
										}
									}
								} else {
									if( Carbon::createFromTimeString($time->first()->time_end_pm)->eq( Carbon::createFromTimeString('17:00:00') ) ) {
										// $ot = 'ramadhan months.<br />';
										if($out->lt(Carbon::createFromTimeString('17:50:00'))) {
											$ot = 0;
										} else {
											if( $out->gte( Carbon::createFromTimeString('17:50:00') ) && $out->lt( Carbon::createFromTimeString('18:20:00') ) ) {
												$ot = 1;
											} else {
												if ( $out->gte( Carbon::createFromTimeString('18:20:00') ) && $out->lt( Carbon::createFromTimeString('18:50:00') ) ) {
													$ot = 1.5;
												} else {
													if ( $out->gte( Carbon::createFromTimeString('18:50:00') ) && $out->lt( Carbon::createFromTimeString('19:20:00') ) ) {	// ramadhan month only at 7pm for OT
														$ot = 2;
													}
												}
											}
										}
									}
								}
							}
						} else {
							$ot = 0;
						}
						$pdf->Cell(12, 5, $ot, 1, 0, 'C');
						$ott += $ot;
					}
				}
			}
			$pdf->Cell(17, 5, $ott.' hours', 1, 1, 'C');
			$ott = 0;
		}
	}


	$filename = $fh.'Overtime Report On '.$mon1->copy()->format('F Y').' For '.$lon.' ('.$mon1->copy()->format('D, j F Y').' to '.$mon2->copy()->format('D, j F Y').').pdf';
	// use ob_get_clean() to make sure that the correct header is sent to the server so the correct pdf is being output
	ob_get_clean();
	$pdf->Output('I', $filename);		// <-- kalau nak bukak secara direct saja
	// $pdf->Output('D', $filename);			// <-- semata mata 100% download
	// $pdf->Output('F', storage_path().'/uploads/pdf/'.$filename);			// <-- send through email