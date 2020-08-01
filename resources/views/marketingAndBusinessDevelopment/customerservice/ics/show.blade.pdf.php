<?php
use \App\Model\ICSServiceReport;

use \Carbon\Carbon;
use \Carbon\CarbonPeriod;

use Crabbly\FPDF\Fpdf as FPDF;

// https://www.youtube.com/watch?v=pELrw9P5ywM
class PDF_MC_Table extends FPDF {

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

class PDF extends PDF_MC_Table
{
	// Page header
	function Header()
	{
		// Logo
		$this->Image('images/sr_header.png', NULL, NULL, 181);
		// just to round up the topMargin
		$this->Ln(0.01175);
	}

	// Page footer
	function Footer()
	{
		// due to multicell setLeftMargin from the body of the page
		$this->SetLeftMargin(10);
		$this->SetRightMargin(10);
		$this->SetTextColor(128);
		// Position at 3.0 cm from bottom
		$this->SetY(-15);
		$this->SetFont('Arial', 'I', 6);
		$this->Cell(0, 4, 'Lot 1266, Bandar DarulAman Industrial Park, 06000, Jitra, Kedah Darul Aman', 0, 1, 'C');
		// Arial italic 5
		$this->SetFont('Arial','I',5);
		// Page number
		$this->Cell(0,4,'Page '.$this->PageNo().'/{nb}',0,1,'C');
	}
}

// Instanciation of inherited class
$pdf = new PDF('P', 'mm' , [210, 297]);	// A4 Paper
// $pdf = new PDF_MC_Table();	// A4 Paper

$pdf->SetTitle('Service Report SAQ'.$serviceReport->id);

$pdf->SetLeftMargin(10);
$pdf->SetRightMargin(10);

$pdf->SetFont('Arial', NULL, 8);

// determine serial number count
$servreport = $serviceReport->hasmanyserial()->get();




if ($servreport->count() == 1) {	// serial number always 1, need to check if its null or has a value

	// start creating the page
	foreach($servreport as $sr1) {

		///////////////////////////////////////////////////////////////////
		// make sure pages = serial number count
		$pdf->AliasNbPages();
		$pdf->AddPage();
		///////////////////////////////////////////////////////////////////
		// from top is 33, from left is 10 (according as marginLeft command)


	}

} elseif ($servreport->count() > 1) {	// jika lebih dari 2 serial maka ada 2 service report

	// start creating the page
	foreach ($servreport as $sr2) {	// means pages = serial number

		///////////////////////////////////////////////////////////////////
		// make sure pages = serial number count
		$pdf->AliasNbPages();
		$pdf->AddPage();
		///////////////////////////////////////////////////////////////////
		// from top is 33, from left is 10 (according as marginLeft command)

		$pdf->Cell(0, 5, $pdf->GetX().' = getx, '.$pdf->GetY().' = gety', 0, 1, 'C');














	}
}

$filename = 'Service Report SAQ'.$serviceReport->id.'.pdf';

// use ob_get_clean() to make sure that the correct header is sent to the server so the correct pdf is being output
ob_get_clean();
$pdf->Output('I', $filename);		// <-- kalau nak bukak secara direct saja
// $pdf->Output('D', $filename);			// <-- semata mata 100% download
// $pdf->Output('F', storage_path().'/uploads/pdf/'.$filename);			// <-- send through email