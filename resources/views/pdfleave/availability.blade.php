<?php
ini_set('max_execution_time', 3000);
// header('Content-type: application/pdf');

// load model
use App\Model\Staff;
use App\Model\StaffTCMS;
use App\Model\HolidayCalendar;
use App\Model\Location;

use Crabbly\Fpdf\Fpdf as Fpdf;

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
	$pdf = new PDF_MC_Table('L','mm', 'A3');
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
////////////////////////////////////////////////////////////////////////////
// absent
// find public holiday
$h1 = HolidayCalendar::whereYear('date_start', $n->format('Y'))->get();
$h4 = [];
foreach($h1 as $h2) {
	// echo $h2->date_start.' '.$h2->date_end.' hoilday calendar<br />';
	$h3 = CarbonPeriod::create($h2->date_start, '1 days', $h2->date_end);
	foreach ($h3 as $key => $value) {
		$h4[] = $value->format('Y-m-d');
		// echo $value->format('Y-m-d').' iterate<br />';
	}
}

// checking if the array is correct
// foreach($h4 as $h5){
// 	echo $h5.' iterate h4<br />';
// }

$stcms1 = $st->hasmanystafftcms()->whereNull('exception')->whereBetween('date', [$n->copy()->startOfYear()->format('Y-m-d'), $n->copy()->format('Y-m-d')])->where([['in', '00:00:00'], ['break', '00:00:00'], ['resume', '00:00:00'], ['out', '00:00:00'], ['leave_taken', '<>', 'Outstation'], ['daytype', 'WORKDAY'] ])->whereNotIn('date', $h4)->get();
$m = 0;
$v2 = 0;
foreach($stcms1 as $ke) {
	$sl5 = $st->hasmanystaffleave()->whereRaw('"'.$ke->date.'" BETWEEN DATE(staff_leaves.date_time_start) AND DATE(staff_leaves.date_time_end)')->get();
	if($sl5->isEmpty()){
		$m = $m+1;
		// echo $m.' count absent<br />';
	} else {
		// echo $sl5.' <br />';
		$v = 0;
		foreach ($sl5 as $nq) {
			$b = 0;
			$p = 0;
			if($nq->active == 1) {
				$b = 1;
			} else {
				$p = 1;
			}
		}
			$v += $p - $b;
			// echo $v.' absent count<br />';
			if($v == -1) {
				$v1 = 0;
			} else {
				$v1 = $v;
			}
			$v2 += $v1;
			// echo $v2.' v2 absent count<br />';
	}
	// echo $m + $v2.' = m+v2 <br />';
	// echo $ke->name.' '.$ke->date.' '.$ke->in.' '.$ke->break.' '.$ke->resume.' '.$ke->out.' '.$ke->leave_taken.' absent<br />';
	// echo '---------------------------------<br />';
}
			$abs = $m + $v2;	// absent
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

	// starting PDF_MC_Table
	// set width for each column (5 columns)
	$pdf->SetWidths([10, 15, 75, 30, 90, 20, 20, 20, 30, 30, 50]);

	// set alignment
	$pdf->SetAligns(['C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C', 'C']);

	// set line heights. This is the height of each lines, not rows.
	$pdf->SetLineHeight(5);

	$p = 1;
	foreach ($colso as $key => $val) {
		// $pdf->MultiCell(0, 5, $val['username'], 0, 'C');

		$pdf->Row([
			$p++,
			$val['username'],
			$val['name'],
			$val['location'],
			$val['department'],
			$val['al'],
			$val['upl'],
			$val['mc'],
			$val['mc-upl'],
			$val['absent'],
			($val['total'] > 1)?$val['total'].' days':$val['total'].' day',
		]);
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