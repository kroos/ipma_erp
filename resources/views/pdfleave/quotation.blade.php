<?php
// header('Content-type: application/pdf');

// load model
use App\Model\QuotQuotation;

// load pdf library
use Crabbly\FPDF\FPDF as Fpdf;

// load time library
use Carbon\Carbon;
use Carbon\CarbonPeriod;

// initialize constant
$dts = \Carbon\Carbon::parse($quot->date);
$arr = str_split( $dts->format('Y'), 2 );
if($quot->hasmanyrevision()->get()->count()) {
	$rev = '-'.$quot->hasmanyrevision()->get()->max('id');
} else {
	$rev = NULL;
}

class PDF extends Fpdf
{
	// Page header
	function Header()
	{
		// Logo
		$this->Image('images/quot/header.png', 10, 5, 190);
		$this->Image('images/quot/body.png', 10, 80, 190);

	}
	
	// Page footer
	function Footer()
	{
		$this->SetY(-18);
		$this->Image('images/quot/footer.png', 10, 261, 190);
		$this->SetFont('Arial', 'I', 5);
		// Page number
		$this->Cell(0,4,'Page '.$this->PageNo().'of {nb}', 0, 1, 'C');
		// $this->Cell(0,4,'Page '.$this->PageNo().'of {nb} '.$this->GetY(), 0, 1, 'C');	// just to check the position
	}
}

	// https://www.youtube.com/watch?v=pELrw9P5ywM
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
	$pdf = new PDF_MC_Table('P','mm', 'A4');
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetTitle('QT');

	// $pdf->Cell(0, 5, $induk, 0, 1, 'L'); // 210

	// $pdf->Cell(0, 5, $pdf->GetY(), 0, 1, 'L'); // 210
	// $pdf->Cell(0, 5, $pdf->GetX(), 0, 1, 'L'); // 210
	// $pdf->Cell(0, 5, $pdf->GetPageHeight(), 0, 1, 'L'); // 148
	// $pdf->Cell(0, 5, $pdf->GetPageWidth(), 0, 1, 'L'); // 210

	// reset font
	$pdf->SetFont('Arial', NULL, 9);

	$pdf->Cell(15, 5, 'Our Ref :', 1, 0, 'L');
	$pdf->Cell(15, 5, 'QT-'.$quot->id.'/'.$arr[1].$rev, 1, 0, 'L');

	$filename = 'Quotation .pdf';

	// use ob_get_clean() to make sure that the correct header is sent to the server so the correct pdf is being output
	ob_get_clean();
	$pdf->Output('I', $filename);		// <-- kalau nak bukak secara direct saja
	// $pdf->Output('D', $filename);			// <-- semata mata 100% download
	// $pdf->Output('F', storage_path().'/uploads/pdf/'.$filename);			// <-- send through email