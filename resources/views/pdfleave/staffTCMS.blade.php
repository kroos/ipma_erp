<?php
ini_set('max_execution_time', 3000);
// header('Content-type: application/pdf');

// load model
use App\Model\Staff;
use App\Model\StaffLeave;
use App\Model\StaffTCMS;
use App\Model\HolidayCalendar;

use Crabbly\Fpdf\Fpdf as Fpdf;
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

class PDF_MC_Table extends PDF {
// variable to store widths and aligns of cells, and line height
	var $widths;
	var $aligns;
	var $lineHeight;
//Set the array of column widths
	function SetWidths($w){
		$this->widths=$w;
	}
//Set the array of column alignments
	function SetAligns($a){
		$this->aligns=$a;
	}
//Set line height
	function SetLineHeight($h){
		$this->lineHeight=$h;
	}
//Calculate the height of the row
	function Row($data)
	{
// number of line
		$nb=0;
// loop each data to find out greatest line number in a row.
		for($i=0;$i<count($data);$i++){
// NbLines will calculate how many lines needed to display text wrapped in specified width.
// then max function will compare the result with current $nb. Returning the greatest one. And reassign the $nb.
			$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
		}

//multiply number of line with line height. This will be the height of current row
		$h=$this->lineHeight * $nb;
//Issue a page break first if needed
		$this->CheckPageBreak($h);
//Draw the cells of current row
		for($i=0;$i<count($data);$i++)
		{
// width of the current col
			$w=$this->widths[$i];
// alignment of the current col. if unset, make it left.
			$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
//Save the current position
			$x=$this->GetX();
			$y=$this->GetY();
//Draw the border
			$this->Rect($x,$y,$w,$h);
//Print the text
			$this->MultiCell($w,5,$data[$i],0,$a);
//Put the position to the right of the cell
			$this->SetXY($x+$w,$y);
		}
//Go to the next line
		$this->Ln($h);
	}
	function CheckPageBreak($h)
	{
//If the height h would cause an overflow, add a new page immediately
		if($this->GetY()+$h>$this->PageBreakTrigger)
			$this->AddPage($this->CurOrientation);
	}
	function NbLines($w,$txt)
	{
//calculate the number of lines a MultiCell of width w will take
		$cw=&$this->CurrentFont['cw'];
		if($w==0)
			$w=$this->w-$this->rMargin-$this->x;
		$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
		$s=str_replace("\r",'',$txt);
		$nb=strlen($s);
		if($nb>0 and $s[$nb-1]=="\n")
			$nb--;
		$sep=-1;
		$i=0;
		$j=0;
		$l=0;
		$nl=1;
		while($i<$nb)
		{
			$c=$s[$i];
			if($c=="\n")
			{
				$i++;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
				continue;
			}
			if($c==' ')
				$sep=$i;
			$l+=$cw[$c];
			if($l>$wmax)
			{
				if($sep==-1)
				{
					if($i==$j)
						$i++;
				}
				else
					$i=$sep+1;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
			}
			else
				$i++;
		}
		return $nl;
	}
}

// Instanciation of inherited class
	$pdf = new PDF_MC_Table('L','mm', 'A4');
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetTitle('Staff Attendance Report - '. Carbon::parse($dts)->format('D, j F Y').' To '.Carbon::parse($dte)->format('D, j F Y'));
	
	// $pdf->Cell(0, 5, $pdf->GetPageHeight(), 0, 1, 'C'); // 297
	// $pdf->Cell(0, 5, $pdf->GetPageWidth(), 0, 0, 'C'); // 210

	$pdf->Ln(3);
	$pdf->SetFont('Arial', 'BU', 10);	// bold & underline
	$pdf->MultiCell(0, 5, 'Staff Attendance Report From '. Carbon::parse($dts)->format('D, j F Y').' To '.Carbon::parse($dte)->format('D, j F Y'), 0, 'C');
	$pdf->Ln(2);

	$pdf->MultiCell(0, 5, 'Not Available', 0, 'C');
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
	$pdf->Cell(52, 5, 'Department', 1, 0, 'C');
	$pdf->Cell(15, 5, 'Staff ID', 1, 0, 'C');
	$pdf->Cell(60, 5, 'Name', 1, 0, 'C');
	$pdf->Cell(72, 5, 'Remarks', 1, 0, 'C');
	$pdf->Cell(25, 5, 'Leave Form', 1, 1, 'C');

	$pdf->SetFont('Arial', NULL, 8);	// setting font

	// starting PDF_MC_Table
	// set width for each column (5 columns)
	$pdf->SetWidths([20, 18, 15, 52, 15, 60, 72, 25]);

	// set alignment
	$pdf->SetAligns(['L', 'L', 'L', 'L', 'L', 'L', 'L', 'L']);

	// set line heights. This is the height of each lines, not rows.
	$pdf->SetLineHeight(5);

	$i = 0;
	foreach( $staffTCMS as $stcms ):
		$lea = StaffLeave::where('staff_id', $stcms->staff_id)->whereRaw('"'.$stcms->date.'" BETWEEN DATE(staff_leaves.date_time_start) AND DATE(staff_leaves.date_time_end)')->whereIn('active', [1, 2])->first();
		// $pdf->MultiCell(0, 5, $lea, 0, 'L');

		// all of this are for checking sunday and holiday
		$hol = [];
		// echo $tc->date.' date<br />';
		if( Carbon::parse($stcms->date)->dayOfWeek != 0 ) {
			// echo $tc->date.' kerja <br />';
			$cuti = HolidayCalendar::all();
			foreach ($cuti as $cu) {
				$co = CarbonPeriod::create($cu->date_start, '1 days', $cu->date_end);
				// echo $co.' array or string<br />';
				foreach ($co as $key) {
					if (Carbon::parse($key)->format('Y-m-d') == $stcms->date) {
						$hol[Carbon::parse($key)->format('Y-m-d')] = 'a';
						// echo $key.' key<br />';
					}
				}
			}
			if( !Arr::has($hol, $stcms->date) ) {


				if( $stcms->leave_taken == 'ABSENT' /*&& is_null($lea)*/ || $stcms->leave_taken != 'Outstation' && !empty($stcms->leave_taken )  ) {
					if ( !empty( $lea ) ) {
						$dts = Carbon::parse($lea->created_at)->format('Y');
						$arr = str_split( $dts, 2 );
						$leaid = 'HR9-'.str_pad( $lea->leave_no, 5, "0", STR_PAD_LEFT ).'/'.$arr[1];
					} else {
						$leaid = NULL;
					}

					if( $stcms->belongtostaff->active == 1 ){
							$i++;
							$pdf->Row([
								Carbon::parse($stcms->date)->format('j M Y'),
								$stcms->leave_taken,
								$stcms->belongtostaff->belongtolocation->location,
								$stcms->belongtostaff->belongtomanyposition()->wherePivot('main', 1)->first()->belongtodepartment->department,
								$stcms->belongtostaff->hasmanylogin()->where('active', 1)->first()->username,
								$stcms->belongtostaff->name,
								$stcms->remark,
								$leaid,
							]);
							// $pdf->Cell(20, 10, Carbon::parse($stcms->date)->format('j M Y'), 1, 0, 'L');
							// $pdf->Cell(18, 10, $stcms->leave_taken, 1, 0, 'L');
							// $pdf->Cell(15, 10, $stcms->belongtostaff->belongtolocation->location, 1, 0, 'L');
							// $pdf->Cell(52, 10, $stcms->belongtostaff->belongtomanyposition()->wherePivot('main', 1)->first()->belongtodepartment->department, 1, 0, 'L');
							// $pdf->Cell(15, 10, $stcms->belongtostaff->hasmanylogin()->where('active', 1)->first()->username, 1, 0, 'L');
							// $pdf->Cell(60, 10, $stcms->belongtostaff->name, 1, 0, 'L');
							// $pdf->Cell(72, 10, $stcms->remark, 1, 0, 'L');
							// $pdf->Cell(25, 10, $leaid, 1, 1, 'L');
					}
				}
			}
		}
	endforeach;

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$pdf->Ln(5);

	$pdf->SetFont('Arial', 'BU', 10);	// setting font
	$pdf->MultiCell(0, 5, 'Lateness', 0, 'C');
	$pdf->Ln(2);
	$pdf->SetFont('Arial', 'B', 10);	// setting font

	$pdf->Cell(20, 5, 'Date', 1, 0, 'C');
	$pdf->Cell(18, 5, 'Status', 1, 0, 'C');
	$pdf->Cell(15, 5, 'Loc', 1, 0, 'C');
	$pdf->Cell(52, 5, 'Dept', 1, 0, 'C');
	$pdf->Cell(15, 5, 'Staff ID', 1, 0, 'C');
	$pdf->Cell(60, 5, 'Name', 1, 0, 'C');
	$pdf->Cell(14, 5, 'In', 1, 0, 'C');
	$pdf->Cell(58, 5, 'Remarks', 1, 0, 'C');
	$pdf->Cell(25, 5, 'Leave Form', 1, 1, 'C');

	$pdf->SetFont('Arial', NULL, 8);	// setting font

	$ii = 0;
	foreach( $staffTCMS as $stcms1 ):
		if($stcms1->belongtostaff->active == 1):

		$lea = StaffLeave::where('staff_id', $stcms1->staff_id)->whereRaw('"'.$stcms1->date.'" BETWEEN DATE(staff_leaves.date_time_start) AND DATE(staff_leaves.date_time_end)')->first();
		if ( !empty( $lea ) ) {
			$dts = Carbon::parse($lea->created_at)->format('Y');
			$arr = str_split( $dts, 2 );
			$leaid = 'HR9-'.str_pad( $lea->leave_no, 5, "0", STR_PAD_LEFT ).'/'.$arr[1];
		} else {
			$leaid = NULL;
		}
		/////////////////////////////////////////////////////////////////////////////////////////////////////
		// time constant
		$userposition = $stcms1->belongtostaff->belongtomanyposition()->wherePivot('main', 1)->first();
		$dt = Carbon::parse($stcms1->date);

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

		$in = Carbon::createFromTimeString($stcms1->in);
		$break = Carbon::createFromTimeString($stcms1->break);
		$resume = Carbon::createFromTimeString($stcms1->resume);
		$out = Carbon::createFromTimeString($stcms1->out);
		/////////////////////////////////////////////////////////////////////////////////////////////////////

			if( Carbon::createFromTimeString($stcms1->in)->gt( Carbon::createFromTimeString($time->first()->time_start_am) )  ):
				$ii++;
				$pdf->Row([
				]);
				$pdf->MultiCell(20, 5, Carbon::parse($stcms1->date)->format('j M Y'), 1, 'L');
				$pdf->SetXY($pdf->GetX() + 20, $pdf->GetY() - 5 );
				$pdf->MultiCell(18, 5, ($stcms1->exception != 1)?'Late':'Exception', 1, 'L');
				$pdf->SetXY($pdf->GetX() + 38, $pdf->GetY() - 5 );
				$pdf->MultiCell(15, 5, $stcms1->belongtostaff->belongtolocation->location, 1, 'L');
				$pdf->SetXY($pdf->GetX() + 53, $pdf->GetY() - 5 );
				$pdf->MultiCell(52, 5, $stcms1->belongtostaff->belongtomanyposition()->wherePivot('main', 1)->first()->belongtodepartment->department, 1, 'L');
				$pdf->SetXY($pdf->GetX() + 105, $pdf->GetY() - 5 );
				$pdf->MultiCell(15, 5, $stcms1->belongtostaff->hasmanylogin()->where('active', 1)->first()->username, 1, 'L');
				$pdf->SetXY($pdf->GetX() + 120, $pdf->GetY() - 5 );
				$pdf->MultiCell(60, 5, $stcms1->belongtostaff->name, 1, 'L');
				$pdf->SetXY($pdf->GetX() + 180, $pdf->GetY() - 5 );
				$pdf->SetTextColor(255, 0, 0);
				$pdf->MultiCell(14, 5, Carbon::createFromTimeString($stcms1->in)->format('h:i a'), 1, 'L');
				$pdf->SetXY($pdf->GetX() + 194, $pdf->GetY() - 5 );
				$pdf->SetTextColor(0, 0, 0);
				$pdf->MultiCell(58, 5, $stcms1->remark, 1, 'L');
				$pdf->SetXY($pdf->GetX() + 252, $pdf->GetY() - 5 );
				$pdf->MultiCell(25, 5, $leaid, 1, 'L');
				// $pdf->SetXY($pdf + 20->GetX(), $pdf->GetY() + 5);
			endif;
		endif;

	endforeach;

/////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$pdf->Ln(5);

	$pdf->SetFont('Arial', 'BU', 10);	// setting font
	$pdf->MultiCell(0, 5, 'Outstation', 0, 'C');
	$pdf->Ln(2);
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

	// starting PDF_MC_Table
	// set width for each column (5 columns)
	$pdf->SetWidths([20, 18, 15, 52, 15, 60, 72, 25]);

	// set alignment
	$pdf->SetAligns(['L', 'L', 'L', 'L', 'L', 'L', 'L', 'L']);

	// set line heights. This is the height of each lines, not rows.
	$pdf->SetLineHeight(5);


	$iii = 0;
	foreach( $staffTCMS as $stcms2 ):
		if($stcms2->belongtostaff->active == 1):

		$lea = StaffLeave::where('staff_id', $stcms2->staff_id)->whereRaw('"'.$stcms2->date.'" BETWEEN DATE(staff_leaves.date_time_start) AND DATE(staff_leaves.date_time_end)')->first();
		if ( !empty( $lea ) ) {
			$dts = Carbon::parse($lea->created_at)->format('Y');
			$arr = str_split( $dts, 2 );
			$leaid = 'HR9-'.str_pad( $lea->leave_no, 5, "0", STR_PAD_LEFT ).'/'.$arr[1];
		} else {
			$leaid = NULL;
		}
		/////////////////////////////////////////////////////////////////////////////////////////////////////

			if( $stcms2->leave_taken == 'Outstation' ):
				$iii++;
				$pdf->Row([
					Carbon::parse($stcms2->date)->format('j M Y'),
					$stcms2->leave_taken,
					$stcms2->belongtostaff->belongtolocation->location,
					$stcms2->belongtostaff->belongtomanyposition()->wherePivot('main', 1)->first()->belongtodepartment->department,
					$stcms2->belongtostaff->hasmanylogin()->where('active', 1)->first()->username,
					$stcms2->belongtostaff->name,
					$stcms2->remark,
					$leaid,
				]);
			endif;
		endif;

	endforeach;

	$pdf->Ln(2);
	$pdf->SetFont('Arial', 'B', 10);	// setting font

	$pdf->MultiCell(0, 5, 'Summary', 0, 'L');
	$pdf->MultiCell(0, 5, 'Staff Not Available : '.$i, 0, 'L');
	$pdf->MultiCell(0, 5, 'Late Arrival : '.$ii, 0, 'L');
	$pdf->MultiCell(0, 5, 'Outstation : '.$iii, 0, 'L');

	$filename = 'Staff Attendance Report - '.Carbon::parse($dts)->format('D, j F Y').' To '.Carbon::parse($dte)->format('D, j F Y').'.pdf';
	// use ob_get_clean() to make sure that the correct header is sent to the server so the correct pdf is being output
	ob_get_clean();
	$pdf->Output('I', $filename);		// <-- kalau nak bukak secara direct saja
	// $pdf->Output('D', $filename);			// <-- semata mata 100% download
	// $pdf->Output('F', storage_path().'/uploads/pdf/'.$filename);			// <-- send through email