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

// ref no
$dts = Carbon::parse($staffLeave->created_at)->format('Y');
$arr = str_split( $dts, 2 );

// time leave based on day
// $userposition = \Auth::user()->belongtostaff->belongtomanyposition()->wherePivot('main', 1)->first();
$userposition = $staffLeave->belongtostaff->belongtomanyposition()->wherePivot('main', 1)->first();
$dt = \Carbon\Carbon::parse($staffLeave->date_time_start);

// echo $userposition->id; // 60
// echo $dt->year; // 2019
// echo $dt->dayOfWeek; // dayOfWeek returns a number between 0 (sunday) and 6 (saturday) // 5

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
$start_am = Carbon::parse($time->first()->time_start_am)->format('g:i a');
$end_am = Carbon::parse($time->first()->time_end_am)->format('g:i a');
$start_pm = Carbon::parse($time->first()->time_start_pm)->format('g:i a');
$end_pm = Carbon::parse($time->first()->time_end_pm)->format('g:i a');




if ( ($staffLeave->leave_id == 9) || ($staffLeave->leave_id != 9 && $staffLeave->half_day == 2) ) {
	$dts = \Carbon\Carbon::parse($staffLeave->date_time_start)->format('g:i a');
	$dte = \Carbon\Carbon::parse($staffLeave->date_time_end)->format('g:i a');

	if( ($staffLeave->leave_id != 9 && $staffLeave->half_day == 2) && $staffLeave->active == 1 ) {
		$dper = 'Half Day';
	} else {
		if(($staffLeave->leave_id != 9 && $staffLeave->half_day != 2) && $staffLeave->active == 1) {
			$i = $staffLeave->period;
					$hour = floor($i/60);
					$minute = ($i % 60);
			$dper = $hour.' hours '.$minute.' minutes';
		} else {
			$dper = '0 Day/s';
		}
	}
} else {
	$dts = $start_am;
	$dte = $end_pm;
	$dper = $staffLeave->period.' Day/s';
}

// backup resolve
$bakvalid = $staffLeave->hasonestaffleavebackup()->first();

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
		$this->Cell(0, 5, 'Borang Permohonan Cuti', 0, 1, 'C');
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
	$pdf = new Pdf('L','mm', 'A5');
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetTitle('Staff Leave Form '.$staffLeave->belongtostaff->name.' HR9-'.str_pad( $staffLeave->leave_no, 5, "0", STR_PAD_LEFT ).'/'.$arr[1]);
	
	// $pdf->Cell(0, 5, $pdf->GetPageHeight(), 0, 1, 'C'); // 148
	// $pdf->Cell(0, 5, $pdf->GetPageWidth(), 0, 0, 'C'); // 210

	$pdf->SetRightMargin(105);
	$pdf->SetFont('Arial',NULL,10);
	$pdf->MultiCell(0, 4, 'No Pekerja : '.$staffLeave->belongtostaff->hasmanylogin()->where('active', 1)->first()->username, 0, 'L');
	$pdf->MultiCell(0, 4, 'Nama : '.$staffLeave->belongtostaff->name, 0, 'L');
	$pdf->MultiCell(0, 4, 'Tarikh Bercuti : '.Carbon::parse($staffLeave->date_time_start)->format('D, j M Y').' - '.Carbon::parse($staffLeave->date_time_end)->format('D, j M Y'), 0, 'L');
	$pdf->MultiCell(0, 4, 'Telephone : '.$staffLeave->belongtostaff->mobile, 0, 'L');

	// $pdf->SetFont('Arial',NULL,8);
	$pdf->SetRightMargin(10);
	$pdf->SetLeftMargin(105);
	$pdf->SetY(26);
	$pdf->MultiCell(0, 4, 'Ref No : HR9-'.str_pad( $staffLeave->leave_no, 5, "0", STR_PAD_LEFT ).'/'.$arr[1], 0, 'R');
	$pdf->MultiCell(0, 4, 'Tarikh Pohon : '.Carbon::parse($staffLeave->created_at)->format('D, j M Y'), 0, 'R');
	$pdf->MultiCell(0, 4, 'Masa : '.$dts.' - '.$dte, 0, 'R');
	$pdf->MultiCell(0, 4, 'Tempoh Masa : '.$dper, 0, 'R');

// more like line height
	$pdf->Ln(1);

// reset margin
	$pdf->SetX(10);
	$pdf->SetRightMargin(10);
	$pdf->SetLeftMargin(10);

// sebab
	$pdf->MultiCell(0, 4, 'Sebab : '.ucwords(strtolower($staffLeave->reason)), 0, 'L');

// jenis cuti
	$pdf->Cell(0, 4, 'Jenis Cuti : '.$staffLeave->belongtoleave->leave, 0, 1, 'L');

	$pdf->Ln(2);

// check for backup
if ( !is_null( $bakvalid ) ) :
	if($bakvalid->acknowledge == 1){
		$ack = 'Ditandatangani';
	} else {
		$ack = NULL;
	}

	$pdf->Cell(0, 4, 'Semasa saya bercuti, penama dibawah akan menggantikan saya.', 0, 1, 'C');
	$pdf->Cell(80, 4, 'Nama : ', 1, 0, 'C');
	$pdf->Cell(50, 4, 'Tandatangan : ', 1, 0, 'C');
	$pdf->Cell(60, 4, 'Tarikh : ', 1, 1, 'C');
	// data
	$pdf->Cell(80, 4, $bakvalid->belongtostaff->name, 'LRB', 0, 'C');
	$pdf->Cell(50, 4, $ack, 'LRB', 0, 'C');
if (is_null($ack)) {
	$de = NULL;
} else {
	$de = Carbon::parse($bakvalid->created_at)->format('D, j M Y g:i a');
}

	$pdf->Cell(60, 4, $de, 'LRB', 1, 'C');
endif;
	$pdf->Ln(5);
	$pdf->SetFont('Arial','IB',8);
	$pdf->Cell(110, 4, '*PERMOHONAN CUTI MESTILAH SEKURANG-KURANGNYA', 0, 1, 'C');
	$pdf->Cell(110, 4, 'TIGA (3) HARI LEBIH AWAL DARI TARIKH BERCUTI.', 0, 0, 'C');

	$pdf->SetFont('Arial','U',7);
	$pdf->Cell(80, 4, 'Tandatangan Pemohon', 0, 1, 'C');
	$pdf->Ln();
	$pdf->SetFont('Arial',NULL,7);
	$pdf->Cell(0, 0, '****************************************************************************************************************************************************************************************************', 0, 1, 'C');

	// font resaet
	$pdf->SetFont('Arial','U',10);
	$pdf->Cell(0, 4, 'UNTUK KEGUNAAN PEJABAT', 0, 1, 'C');
	$pdf->Ln(1);
	$pdf->SetFont('Arial',NULL,10);

	// catatan only valid if this form is rejected. so..
	// check the status this leave
	$staffapproval = $staffLeave->hasmanystaffapproval();
	if($staffLeave->active == 4) { //meaning that this leave is rejected.

		// we need to find who is rejecting this leave.
		// first, check the approval, consist of supervisor and HOD
		$catatan = ucwords(strtolower($staffapproval->where('approval', 0)->whereNotNull('notes_by_approval')->first()->notes_by_approval));
	} else {
		$catatan = '';
	}
	$pdf->Cell(0, 4, 'Catatan : '.$catatan, 0, 1, 'L');
	$pdf->Ln(1);

	// get this approval not HR from group
	$dept = $staffapproval->whereNull('hr')->first();
	$deptapp = $staffapproval->whereNull('hr')->first();
	$deptnotes = $staffapproval->whereNull('hr')->first();
	if(!is_null($dept)) {
		$dept = $staffapproval->whereNull('hr')->first()->belongtostaff->belongtomanyposition()->wherePivot('main', 1)->first()->belongtogroup->group;
	} else {
		$dept = 'Head Of Department';
	}

	if(!is_null($deptapp)) {
		$deptapp = $staffapproval->whereNull('hr')->first()->approval;
	} else {
		$deptapp = NULL;
	}

	if (!is_null($deptnotes)) {
		$deptnotes = $staffapproval->whereNull('hr')->first()->notes_by_approval;
	} else {
		$deptnotes = NULL;
	}

	if (is_null($deptapp)) {
		$dru = NULL;
	} else {
		$dru = Carbon::parse($staffapproval->whereNull('hr')->first()->updated_at)->format('D, j M Y g:i a');
	}

	if(is_null($deptapp)) {
		$sok = 'Disokong/Ditolak';
	} else {
		if($deptapp == 0) {
			$sok = 'Ditolak';
		} else {
			$sok = 'Disokong';
		}
	}

	// heran.. nak kena redeclare utk HR
	$hr = $staffLeave->hasmanystaffapproval()->where('hr', 1)->first()->belongtostaff->belongtomanyposition()->wherePivot('main', 1)->first()->belongtodepartment->department;
	$hrapp = $staffLeave->hasmanystaffapproval()->where('hr', 1)->first()->approval;
	$hrnotes = $staffLeave->hasmanystaffapproval()->where('hr', 1)->first()->notes_by_approval;
	if(is_null($hrapp)) {
		$hrsok = 'Diluluskan/Ditolak';
	} else {
		if($hrapp == 0) {
			$hrsok = 'Ditolak';
		} else {
			$hrsok = 'Diluluskan';
		}
	}

	// utk director
	$dr = $staffLeave->hasmanystaffapproval()->where('hr', 2)->first();

	if (is_null($dr)) {
		$drnotes = NULL;
	} else {
		$drnotes = $staffLeave->hasmanystaffapproval()->where('hr', 2)->first()->notes_by_approval;
	}
	

	if(is_null($dr)) {
		$drsok = 'Diluluskan/Ditolak';
	} else {
		if($staffLeave->hasmanystaffapproval()->where('hr', 2)->first()->approval == 0) {
			$drsok = 'Ditolak';
		} else {
			$drsok = 'Diluluskan';
		}
	}
	if(is_null($dr)) {
		$diru = NULL;
	} else {
		$diru = Carbon::parse($staffLeave->hasmanystaffapproval()->where('hr', 2)->first()->updated_at)->format('D, j M Y g:i a');
	}

	if(!is_null($dr)) {
		$dir = $dr->belongtostaff->belongtomanyposition()->wherePivot('main', 1)->first()->belongtogroup->group;
	} else {
		$dir = NULL;
	}

	if(is_null($staffLeave->hasmanystaffapproval()->where('hr', 1)->first()->approval)) {
		$hru = NULL;
	} else {
		$hru = Carbon::parse($staffLeave->hasmanystaffapproval()->where('hr', 1)->first()->updated_at)->format('D, j M Y g:i a');
	}

	// approval part
	$pdf->Ln(10);
	// $pdf->MultiCell(0, 4, $staffapproval->get(), 0, 'C');
	$pdf->Cell(50, 4, $dept, 0, 0, 'C');
	$pdf->Cell(70, 4, $hr, 0, 0, 'C');
	$pdf->Cell(70, 4, 'Disemak Oleh '.$dir, 0, 1, 'C');
	// data
	$pdf->Cell(50, 4, $sok, 0, 0, 'C');
	$pdf->Cell(70, 4, $hrsok, 0, 0, 'C');
	$pdf->Cell(70, 4, $drsok, 0, 1, 'C');

	$pdf->Cell(50, 4, $deptnotes, 0, 0, 'C');
	$pdf->Cell(70, 4, $hrnotes, 0, 0, 'C');
	$pdf->Cell(70, 4, $drnotes, 0, 1, 'C');

	$pdf->Cell(50, 4, $dru, 0, 0, 'C');
	$pdf->Cell(70, 4, $hru, 0, 0, 'C');
	$pdf->Cell(70, 4, $diru, 0, 1, 'C');

	// bahagian last sekali untuk hr resources file hr9
	$pdf->Cell(50, 4, NULL, 0, 0, 'C');
	$pdf->Cell(70, 4, '(H/Resouces File) HR9', 0, 0, 'C');
	$pdf->Cell(70, 4, NULL, 0, 1, 'C');

	$filename = 'Staff Leave Form '.$staffLeave->belongtostaff->name.' HR9-'.str_pad( $staffLeave->leave_no, 5, "0", STR_PAD_LEFT ).'-'.$arr[1].'.pdf';

	// use ob_get_clean() to make sure that the correct header is sent to the server so the correct pdf is being output
	ob_get_clean();
	$pdf->Output('I', $filename);		// <-- kalau nak bukak secara direct saja
	// $pdf->Output('D', $filename);			// <-- semata mata 100% download
	// $pdf->Output('F', storage_path().'/uploads/pdf/'.$filename);			// <-- send through email