<?php
ini_set('max_execution_time', 3000);
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
	$pdf = new Pdf('L','mm', 'A4');
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetTitle('Staff Attendance Report - '. Carbon::parse($dts)->format('D, j F Y').' To '.Carbon::parse($dte)->format('D, j F Y'));
	
	// $pdf->Cell(0, 5, $pdf->GetPageHeight(), 0, 1, 'C'); // 297
	// $pdf->Cell(0, 5, $pdf->GetPageWidth(), 0, 0, 'C'); // 210

	$pdf->Ln(3);
	$pdf->SetFont('Arial', 'BU', 10);	// bold & underline
	$pdf->MultiCell(0, 5, 'Staff Attendance Report From '. Carbon::parse($dts)->format('D, j F Y').' To '.Carbon::parse($dte)->format('D, j F Y'), 0, 'C');
	$pdf->Ln(2);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// working on all the variables
	$staffTCMS = StaffTCMS::whereBetween('date', [$dts, $dte])->orderBy('date', 'DESC')->orderBy('leave_taken', 'desc')->get();
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$pdf->SetFont('Arial', NULL, 10);
	// $pdf->MultiCell(0, 5, $staffTCMS, 0, 'L');


	// 10 left and 10 right, left only 190..so we have 8 column
	$pdf->SetFont('Arial', 'B', 10);	// setting font

	$pdf->Cell(20, 5, 'Date', 1, 0, 'C');
	$pdf->Cell(18, 5, 'Status', 1, 0, 'C');
	$pdf->Cell(15, 5, 'Loc', 1, 0, 'C');
	$pdf->Cell(52, 5, 'Dept', 1, 0, 'C');
	$pdf->Cell(15, 5, 'Staff ID', 1, 0, 'C');
	$pdf->Cell(60, 5, 'Name', 1, 0, 'C');
	$pdf->Cell(72, 5, 'Remarks', 1, 0, 'C');
	$pdf->Cell(25, 5, 'Leave Form', 1, 1, 'C');

	$pdf->SetFont('Arial', NULL, 8);	// setting font
	foreach( $staffTCMS as $stcms ):

		$lea = StaffLeave::where('staff_id', $stcms->staff_id)->whereRaw('"'.$stcms->date.'" BETWEEN staff_leaves.date_time_start AND  staff_leaves.date_time_end')->first();
		if ( !empty( $lea ) ) {
			$dts = Carbon::parse($lea->created_at)->format('Y');
			$arr = str_split( $dts, 2 );
			$leaid = 'HR9-'.str_pad( $lea->leave_no, 5, "0", STR_PAD_LEFT ).'/'.$arr[1];
		} else {

			$leaid = NULL;
		}
		if($stcms->belongtostaff->active == 1):
			if($stcms->in == '00:00:00' && $stcms->work_hour == 0 && $stcms->break == '00:00:00' && $stcms->leave_taken != 'Outstation' ):
				$pdf->Cell(20, 10, Carbon::parse($stcms->date)->format('j M Y'), 1, 0, 'L');
				$pdf->Cell(18, 10, $stcms->leave_taken, 1, 0, 'L');
				$pdf->Cell(15, 10, $stcms->belongtostaff->belongtolocation->location, 1, 0, 'L');
				$pdf->Cell(52, 10, $stcms->belongtostaff->belongtomanyposition()->wherePivot('main', 1)->first()->belongtodepartment->department, 1, 0, 'L');
				$pdf->Cell(15, 10, $stcms->belongtostaff->hasmanylogin()->where('active', 1)->first()->username, 1, 0, 'L');
				$pdf->Cell(60, 10, $stcms->belongtostaff->name, 1, 0, 'L');
				$pdf->Cell(72, 10, $stcms->remark, 1, 0, 'L');
				$pdf->Cell(25, 10, $leaid, 1, 1, 'L');
			endif;
		endif;

	endforeach;

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$pdf->Ln(5);
	$pdf->SetFont('Arial', 'B', 10);	// setting font

	$pdf->Cell(20, 5, 'Date', 1, 0, 'C');
	$pdf->Cell(18, 5, 'Status', 1, 0, 'C');
	$pdf->Cell(15, 5, 'Loc', 1, 0, 'C');
	$pdf->Cell(52, 5, 'Dept', 1, 0, 'C');
	$pdf->Cell(15, 5, 'Staff ID', 1, 0, 'C');
	$pdf->Cell(60, 5, 'Name', 1, 0, 'C');
	$pdf->Cell(72, 5, 'Remarks', 1, 0, 'C');
	$pdf->Cell(25, 5, 'Leave Form', 1, 1, 'C');

	$pdf->SetFont('Arial', NULL, 8);	// setting font

	foreach( $staffTCMS as $stcms ):
		if($stcms->belongtostaff->active == 1):

		$lea = StaffLeave::where('staff_id', $stcms->staff_id)->whereRaw('"'.$stcms->date.'" BETWEEN staff_leaves.date_time_start AND  staff_leaves.date_time_end')->first();
		if ( !empty( $lea ) ) {
			$dts = Carbon::parse($lea->created_at)->format('Y');
			$arr = str_split( $dts, 2 );
			$leaid = 'HR9-'.str_pad( $lea->leave_no, 5, "0", STR_PAD_LEFT ).'/'.$arr[1];
		} else {

			$leaid = NULL;
		}
		/////////////////////////////////////////////////////////////////////////////////////////////////////
		// time constant
		$userposition = $stcms->belongtostaff->belongtomanyposition()->wherePivot('main', 1)->first();
		$dt = Carbon::parse($stcms->date);

		if( $userposition->id == 72 && $dt->dayOfWeek != 5 ) {	// checking for friday
			$time = \App\Model\WorkingHour::where('year', $dt->year)->where('category', 8);
		} else {
			if ( $userposition->id == 72 && $dt->dayOfWeek == 5 ) {	// checking for friday
				$time = \App\Model\WorkingHour::where('year', $dt->year)->where('category', 8);
			} else {
				if( $userposition->id != 72 && $dt->dayOfWeek != 5 ) {	// checking for friday
					// normal
					$time = \App\Model\WorkingHour::where('year', $dt->year)->whereRaw('"'.$dt.'" BETWEEN working_hours.effective_date_start AND working_hours.effective_date_end' )->limit(1);
				} else {
					if( $userposition->id != 72 && $dt->dayOfWeek == 5 ) {	// checking for friday
						$time = \App\Model\WorkingHour::where('year', $dt->year)->where('category', 3)->whereRaw('"'.$dt.'" BETWEEN working_hours.effective_date_start AND working_hours.effective_date_end' )->limit(1);
					}
				}
			}
		}
		//	echo 'start_am => '.$time->first()->time_start_am;
		//	echo ' end_am => '.$time->first()->time_end_am;
		//	echo ' start_pm => '.$time->first()->time_start_pm;
		//	echo ' end_pm => '.$time->first()->time_end_pm.'<br />';

		$in = Carbon::createFromTimeString($stcms->in);
		$break = Carbon::createFromTimeString($stcms->break);
		$resume = Carbon::createFromTimeString($stcms->resume);
		$out = Carbon::createFromTimeString($stcms->out);
		/////////////////////////////////////////////////////////////////////////////////////////////////////

			if( Carbon::createFromTimeString($stcms->in)->gt( Carbon::createFromTimeString($time->first()->time_start_am) && $stcms->leave_taken != 'Outstation' ) ):
				$pdf->Cell(20, 10, Carbon::parse($stcms->date)->format('j M Y'), 1, 0, 'L');
				$pdf->Cell(18, 10, $stcms->leave_taken, 1, 0, 'L');
				$pdf->Cell(15, 10, $stcms->belongtostaff->belongtolocation->location, 1, 0, 'L');
				$pdf->Cell(52, 10, $stcms->belongtostaff->belongtomanyposition()->wherePivot('main', 1)->first()->belongtodepartment->department, 1, 0, 'L');
				$pdf->Cell(15, 10, $stcms->belongtostaff->hasmanylogin()->where('active', 1)->first()->username, 1, 0, 'L');
				$pdf->Cell(60, 10, $stcms->belongtostaff->name, 1, 0, 'L');
				$pdf->Cell(72, 10, $stcms->remark, 1, 0, 'L');
				$pdf->Cell(25, 10, $leaid, 1, 1, 'L');
			endif;
		endif;

	endforeach;



































	$filename = 'Staff Attendance Report - '.Carbon::parse($dts)->format('D, j F Y').' To '.Carbon::parse($dte)->format('D, j F Y').'.pdf';
	// use ob_get_clean() to make sure that the correct header is sent to the server so the correct pdf is being output
	ob_get_clean();
	$pdf->Output('I', $filename);		// <-- kalau nak bukak secara direct saja
	// $pdf->Output('D', $filename);			// <-- semata mata 100% download
	// $pdf->Output('F', storage_path().'/uploads/pdf/'.$filename);			// <-- send through email