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
	$rev = '-'.$quot->hasmanyrevision()->get()->count('id');
} else {
	$rev = NULL;
}

// header and footer
class PDF extends Fpdf
{
	// Page header
	function Header()
	{
		// Logo
		$this->Image('images/quot/header.png', 10, 5, 190);
		$this->Image('images/quot/body.png', 10, 80, 190);
		$this->Ln(25);
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

	// $pdf->Cell(0, 5, $pdf->GetX(), 0, 1, 'L'); // 210
	// $pdf->Cell(0, 5, $pdf->GetPageHeight(), 0, 1, 'L'); // 148
	// $pdf->Cell(0, 5, $pdf->GetPageWidth(), 0, 1, 'L'); // 210

	// reset font
	$pdf->SetFont('Arial', NULL, 9);

	$pdf->Cell(20, 5, 'Our Ref :', 0, 0, 'L');
	$pdf->Cell(20, 5, 'QT-'.$quot->id.'/'.$arr[1].$rev, 0, 1, 'L');

	$pdf->Cell(20, 5, 'Date :', 0, 0, 'L');
	$pdf->Cell(20, 5, Carbon::parse($quot->date)->format('d F Y'), 0, 1, 'L');

	$pdf->Ln(5);
	$pdf->SetFont('Arial', 'B', 9);
	$pdf->Cell(20, 5, $quot->belongtocustomer->customer, 0, 1, 'L');
	$pdf->SetFont('Arial', NULL, 9);
	$pdf->Cell(20, 5, $quot->belongtocustomer->address1, 0, 1, 'L');
	$pdf->Cell(20, 5, $quot->belongtocustomer->address2, 0, 1, 'L');
	$pdf->Cell(20, 5, $quot->belongtocustomer->address3, 0, 1, 'L');
	$pdf->Cell(20, 5, $quot->belongtocustomer->address4, 0, 1, 'L');
	$pdf->Ln(5);

	$pdf->SetFont('Arial', 'IB', 9);
	$pdf->Cell(20, 5, 'Attn :', 0, 0, 'L');
	$pdf->Cell(20, 5, $quot->attn, 0, 1, 'L');

	$pdf->Ln(5);
	$pdf->SetFont('Arial', NULL, 9);
	$pdf->Cell(20, 5, 'Dear Sir,', 0, 1, 'L');

	$pdf->SetFont('Arial', 'B', 9);
	$pdf->Cell(20, 5, $quot->subject, 0, 1, 'L');

	$pdf->Ln(5);
	$pdf->SetFont('Arial', NULL, 9);
	$pdf->Cell(20, 5, 'Thank you very much for your enquiry of the above. We are pleased to quote below for your kind consideration :', 0, 1, 'L');
	$pdf->Ln(5);


	// set width for each column (5 columns)
	$pdf->SetWidths([10, 90, 20, 35, 35]);

	// set alignment
	$pdf->SetAligns(['C', 'L', 'C', 'R', 'R']);

	// set line heights. This is the height of each lines, not rows.
	$pdf->SetLineHeight(5);


// ITEM SECTION
	// if there is only 1 section
	if($quot->hasmanyquotsection()->get()->count()) {
				// grand total
				$gp1 = 0;
		if($quot->hasmanyquotsection()->get()->count() == 1) {

			$pdf->SetFont('Arial', 'B', 9);
			$pdf->Cell(10, 5, 'No', 'B', 0, 'L');
			$pdf->Cell(90, 5, 'Description', 'B', 0, 'L');
			$pdf->Cell(20, 5, 'Quantity', 'B', 0, 'C');
			$pdf->Cell(35, 5, 'Unit Price', 'B', 0, 'R');
			$pdf->Cell(35, 5, 'Total Price', 'B', 1, 'R');

			foreach(){

			}

		} else {

			$pdf->SetFont('Arial', 'B', 9);
			$pdf->Cell(10, 5, 'No', 'B', 0, 'L');
			$pdf->Cell(90, 5, 'Description', 'B', 0, 'L');
			$pdf->Cell(20, 5, 'Quantity', 'B', 0, 'C');
			$pdf->Cell(35, 5, 'Unit Price', 'B', 0, 'R');
			$pdf->Cell(35, 5, 'Total Price', 'B', 1, 'R');

			if($quot->hasmanyquotsection()->get()->count()) {
				foreach ($quot->hasmanyquotsection()->get() as $k1 => $v1) {

					$pdf->SetFont('Arial', 'BU', 9);
					$pdf->MultiCell(0, 5, $v1->section, 1, 'L');

					if( $v1->hasmanyquotsectionitem()->get()->count() ){
						// iterate item
						$i1 = 1;
						$p1 = 0;
						foreach( $v1->hasmanyquotsectionitem()->get() as $k2 => $v2 ) {
							
							$pdf->SetFont('Arial', NULL, 9);

							if($v2->quantity > 1){
								$uom = $v2->belongtoquotuom->uom.'s';
							} else {
								$uom = $v2->belongtoquotuom->uom;
							}

							// write data using Row() method containing array of values
							$pdf->Row([
								$i1++,		//nanti kena ganti dengan bilangan
								$v2->belongtoquotitem->item,
								$v2->quantity.' '.$uom,
								$quot->belongtocurrency->iso_code.' '.number_format($v2->price_unit, 2),
								$quot->belongtocurrency->iso_code.' '.number_format($v2->quantity * $v2->price_unit, 2)
							]);

							if( $v2->hasmanyquotsectionitemattrib()->get()->count() ){
								// set width for each column (5 columns)
								$pdf->SetWidths([10, 20, 70]);

								// set alignment
								$pdf->SetAligns(['C', 'L', 'L']);

								// set line heights. This is the height of each lines, not rows.
								$pdf->SetLineHeight(5);

								foreach ($v2->hasmanyquotsectionitemattrib()->get() as $k3 => $v3) {

									if( $v3->belongtoquotitemattrib->id == 10 ) {

										if( !is_null($v3->image) ) {

											$att = $pdf->Image('storage/'.$v3->image, 40, $pdf->GetY(), NULL, 25).'                                                                                                                                                                                                                                                                                                                                                                                                     ';		// definitely fit for 5 rows (line heights (5) * rows 5) => 390 space
										} else {
											$att = NULL;
										}

									} else {
										$att = $v3->description_attribute;
									}
									$pdf->Row([
										NULL,
										$v3->belongtoquotitemattrib->attribute,
										$att,
									]);
								}
								// reset it back to suit for the items part.
								$pdf->SetWidths([10, 90, 20, 35, 35]);
								$pdf->SetAligns(['C', 'L', 'C', 'R', 'R']);
							}

							$p1 += $v2->quantity * $v2->price_unit;
						}
						$pdf->SetFont('Arial', 'B', 9);
						$pdf->Cell(155, 5, 'Sub Total', 1, 0, 'R');
						$pdf->Cell(35, 5, $quot->belongtocurrency->iso_code.' '.number_format($p1, 2), 1, 1, 'R');
						$pdf->SetFont('Arial', NULL, 9);
						$pdf->Ln(5);
					}
					$gp1 += $p1;
				}
			}
			$pdf->SetFont('Arial', 'B', 9);
			$pdf->Cell(155, 5, 'Grand Total', 1, 0, 'R');
			$pdf->Cell(35, 5, $quot->belongtocurrency->iso_code.' '.number_format($gp1, 2), 1, 1, 'R');
			$pdf->SetFont('Arial', NULL, 9);
			$pdf->Ln(5);
		}
	}



	$filename = 'Quotation.pdf';

	// use ob_get_clean() to make sure that the correct header is sent to the server so the correct pdf is being output
	ob_get_clean();
	$pdf->Output('I', $filename);		// <-- kalau nak bukak secara direct saja
	// $pdf->Output('D', $filename);			// <-- semata mata 100% download
	// $pdf->Output('F', storage_path().'/uploads/pdf/'.$filename);			// <-- send through email