<?php
// header('Content-type: application/pdf');

// load model
use App\Model\CSOrder;
use App\Model\CSOrderItem;
use App\Model\CSOrderDelivery;

use Crabbly\FPDF\FPDF as Fpdf;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class PDF extends Fpdf
{
	// Page header
	function Header()
	{
		// Logo
		$this->Image('images/logo2.png', 50, 10, 20);

		// set margin
		$this->SetRightMargin(10);
		$this->SetLeftMargin(10);

		// Arial bold 15 and font color grey scale
		// $this->SetFont('Arial', NULL, 6);
		// $this->SetTextColor(100);

		// pointer positioning
		// $this->SetX(45);

		// $this->Cell(27, 4, 'DOCUMENT:', 'LTR', 0, 'L');
		// $this->Cell(27, 4, 'RET PERIOD:', 'LTR', 0, 'L');
		// $this->Cell(27, 4, 'DOC NO:', 'LTR', 0, 'L');
		// $this->Cell(27, 4, 'REV NO:', 'LTR', 0, 'L');
		// $this->Cell(27, 4, 'EFF. DATE:', 'LTR', 0, 'L');
		// $this->Cell(15, 4, 'PAGE:', 'LTR', 1, 'L');
		// $this->SetX(45);
		// $this->Cell(27, 4, 'QUALITY RECORD', 'LBR', 0, 'L');
		// $this->Cell(27, 4, '3 YEARS', 'LBR', 0, 'L');
		// $this->Cell(27, 4, 'IPMA(SM)-F01', 'LBR', 0, 'L');
		// $this->Cell(27, 4, 'E', 'LBR', 0, 'L');
		// $this->Cell(27, 4, '28/3/2016', 'LBR', 0, 'L');
		// $this->Cell(15, 4, $this->PageNo().' OF {nb}', 'LBR', 1, 'L');
		// $this->Ln(1);

		// Arial bold 15 and font color grey scale
		$this->SetY( $this->GetY() + 1);
		$this->SetFont('Arial', 'B', 15);
		$this->SetTextColor(100);

		$this->Cell(0, 5, 'IPMA INDUSTRY SDN BHD', 0, 1, 'C');
		$this->SetFont('Arial', 'UB', 10);
		$this->Cell(0, 5, 'CUSTOMER ORDER ITEMS/PARTS', 0, 1, 'C');

		// reset again for content
		$this->SetRightMargin(10);
		$this->SetLeftMargin(10);

		// set pointer
		$this->SetX(10);

		// Line break
		$this->Ln(10);
	}
	
	// Page footer
	function Footer()
	{
		// due to multicell setLeftMargin from the body of the page
		// $this->SetLeftMargin(10);
		$this->SetTextColor(128);
		// Position at 3.0 cm from bottom
		$this->SetY(-18);
		$this->SetFont('Arial','I',6);
		$this->Cell(0, 4, 'Lot 1266, Bandar DarulAman Industrial Park, 06000, Jitra, Kedah Darul Aman', 0, 1, 'C');
		// $this->Cell(0, 4, 'Lot 1266, Bandar DarulAman Industrial Park, 06000, Jitra, Kedah Darul Aman '.$this->GetY(), 0, 1, 'C');	// just to check the position
		// Arial italic 5
		$this->SetFont('Arial', 'I', 5);
		// Page number
		$this->Cell(0,4,'Page '.$this->PageNo().'of {nb}', 0, 1, 'C');
		// $this->Cell(0,4,'Page '.$this->PageNo().'of {nb} '.$this->GetY(), 0, 1, 'C');	// just to check the position
	}
}

// cari csOrder
$arr = $request->orderitem;
$induk = CSOrderItem::find($arr[0])->belongtoorder;

// Instanciation of inherited class
	$pdf = new Pdf('P','mm', 'A4');
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetTitle('Customer Order Items/Parts');

	// $pdf->Cell(0, 5, $induk, 0, 1, 'L'); // 210

	// $pdf->Cell(0, 5, $pdf->GetY(), 0, 1, 'L'); // 210
	// $pdf->Cell(0, 5, $pdf->GetX(), 0, 1, 'L'); // 210
	// $pdf->Cell(0, 5, $pdf->GetPageHeight(), 0, 1, 'L'); // 148
	// $pdf->Cell(0, 5, $pdf->GetPageWidth(), 0, 1, 'L'); // 210

	// reset font
	$pdf->SetFont('Arial', NULL, 9);

	$pdf->Cell(30, 5, 'Order Date :', 0, 0, 'L');
	$pdf->SetFont('Arial', 'B', 9);
	$pdf->Cell(30, 5, Carbon::parse($induk->date)->format('D, j F Y'), 0, 0, 'L');

	$pdf->SetX(115);
	$pdf->SetFont('Arial', NULL, 9);
	$pdf->Cell(30, 5, 'Delivery Date:', 0, 0, 'L');
	$pdf->SetFont('Arial', 'B', 9);
	$pdf->Cell(30, 5, Carbon::parse($request->delivery_date)->format('D, j F Y'), 0, 1, 'L');

	// gap between 1st and 2nd row
	// $pdf->Ln(5);

	// $pdf->SetX(10);
	$pdf->SetFont('Arial', NULL, 9);
	$pdf->Cell(30, 5, 'Customer Name:', 0, 0, 'L');
	$pdf->SetFont('Arial', 'B', 9);
	$pdf->Cell(30, 5, $induk->belongtocustomer->customer, 0, 0, 'L');

	$pdf->SetX(115);
	$pdf->SetFont('Arial', NULL, 9);
	$pdf->Cell(30, 5, 'Order By:', 0, 0, 'L');
	$pdf->SetFont('Arial', 'B', 9);
	$pdf->Cell(30, 5, $induk->requester, 0, 1, 'L');

	$pdf->SetX(115);
	$pdf->SetFont('Arial', NULL, 9);
	$pdf->Cell(30, 5, 'Customer PO No:', 0, 0, 'L');
	$pdf->SetFont('Arial', 'B', 9);
	$pdf->Cell(30, 5, $induk->customer_PO_no, 0, 1, 'L');

	$pdf->SetFont('Arial', NULL, 7);
	$pdf->Cell(30, 5, 'Description Of Goods Order.', 0, 0, 'L');
	$pdf->SetX(115);
	$pdf->SetFont('Arial', NULL, 9);
	$pdf->Cell(30, 5, 'Ref No:', 0, 0, 'L');
	$pdf->SetFont('Arial', 'B', 9);
	$pdf->SetTextColor(220, 0, 0);
	$pdf->Cell(30, 5, 'COP-'.$induk->id, 0, 1, 'L');
	$pdf->SetTextColor(0, 0, 0);

	// reset pointer
	// $pdf->SetX(10);

	$pdf->SetFont('Arial', 'B', 9);

	$pdf->Cell(10, 10, 'ID', 1, 0, 'C');
	$pdf->Cell(90, 10, 'Items / Parts', 1, 0, 'C');
	$pdf->Cell(20, 10, 'Quantity', 1, 0, 'C');
	$pdf->Cell(20, 10, 'Status', 1, 0, 'C');
	$pdf->Cell(0, 10, 'Remarks', 1, 1, 'C');

$item = CSOrderItem::whereIn('id', $arr)->get();

	$pdf->SetFont('Arial', NULL, 9);
	foreach($item as $it) {
		$pdf->Cell(10, 10, $it->id, 'LB', 0, 'C');
		$pdf->Cell(90, 5, $it->order_item, 'L', 2, 'L');
		$pdf->Cell(90, 5, $it->item_additional_info, 'LB', 0, 'L');
		$pdf->SetY( $pdf->GetY() - 5 );
		$pdf->SetX( 110 );
		$pdf->Cell(20, 10, $it->quantity, 'LB', 0, 'C');
		$pdf->Cell(20, 10, $it->belongtoorderstatus->order_item_status, 1, 0, 'C');
		$pdf->Cell(0, 10, $it->description, 'LBR', 1, 'C');
	}

	$pdf->Cell(40, 10, 'Special Request', 'LBR', 0, 'L');
	$pdf->Cell(10, 5, 'Yes', 'BR', 2, 'C');
	$pdf->Cell(10, 5, 'No', 'BR', 0, 'C');
	$pdf->SetY( $pdf->GetY() - 5 );
	$pdf->SetX( 60 );
	$pdf->Cell(10, 5, NULL, 'BR', 2, 'C');
	$pdf->Cell(10, 5, NULL, 'BR', 0, 'C');
	$pdf->SetY( $pdf->GetY() - 5 );
	$pdf->SetX( 70 );
	$pdf->Cell(18, 10, 'Remarks :', 'BR', 0, 'C');
	$pdf->Cell(0, 10, $induk->description, 'BR', 1, 'C');

	$pdf->Ln(5);
	$pdf->Cell(40, 5, 'Delivery Instructions:', 0, 0, 'L');
	$pdf->SetFont('Arial', 'B', 9);
	$pdf->Cell(0, 5, CSOrderItem::find($arr[0])->belongtoorderdelivery->delivery_method, 0, 1, 'L');
	$pdf->SetFont('Arial', NULL, 9);
	$pdf->Cell(40, 5, 'Delivery Remarks:', 0, 0, 'L');
	$pdf->SetFont('Arial', 'B', 9);
	$pdf->Cell(0, 5, CSOrderItem::find($arr[0])->delivery_remarks, 0, 1, 'L');


	// 43mm from bottom
	$pdf->SetY(-50);
	$pdf->SetFont('Arial', NULL, 9);
	// $pdf->Cell(20, 5, $pdf->GetY(), 1, 1, 'L');		// just to check the position
	$pdf->Cell(63, 5, 'Order Confirmed By :', 0, 0, 'L');
	$pdf->Cell(63, 5, 'Verified By :', 0, 0, 'L');
	$pdf->Cell(0, 5, 'Sender :', 0, 1, 'L');

	$pdf->Cell(63, 15, NULL, 0, 0, 'L');
	$pdf->Cell(63, 15, NULL, 0, 0, 'C');
	$pdf->Cell(0, 15, NULL, 0, 1, 'R');

	$pdf->Cell(63, 5, 'Name:', 0, 0, 'L');
	$pdf->Cell(63, 5, 'Name:', 0, 0, 'L');
	$pdf->Cell(0, 5, 'For Store Department', 0, 1, 'L');






	$filename = 'Customer Order Item ID '.$induk->id.'.pdf';

	// use ob_get_clean() to make sure that the correct header is sent to the server so the correct pdf is being output
	ob_get_clean();
	$pdf->Output('I', $filename);		// <-- kalau nak bukak secara direct saja
	// $pdf->Output('D', $filename);			// <-- semata mata 100% download
	// $pdf->Output('F', storage_path().'/uploads/pdf/'.$filename);			// <-- send through email