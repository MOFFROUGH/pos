<?php
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Carbon\Carbon;
$connector = new FilePrintConnector("/dev/usb/lp0");
$printer = new Printer($connector);

/* Information for the receipt */
$items = array();
// $items = array(
//     new item("Tea Masala", "100"),
//     new item("Pizza", "400"),
//     new item("Omellete", "250"),
//     new item("Chips + Chicken", "700"),
// );
foreach ( $cart as $term ) {
    $items[] = new item($term->name, $term->subtotal);
}
$subtotal = new item('Subtotal', Cart::subtotal()-Cart::tax());
$tax = new item('VAT', Cart::tax());
$total = new item('Total', Cart::subtotal());
$cash = new item('Cash', $cash);
$change = new item('Change', $change);
/* Date is kept the same for testing */
// $date = date('l jS \of F Y h:i:s A');
$date = Carbon::now(new DateTimeZone('Africa/Nairobi'));

// /* Start the printer */
// $logo = EscposImage::load("public/img/menu-1.jpg", false);
// $printer = new Printer($connector);
//
// /* Print top logo */
$printer -> setJustification(Printer::JUSTIFY_CENTER);
// $printer -> graphics($logo);

/* Name of shop */
$printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
$printer -> text("Egyptian Chef\n");
$printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
$printer -> text("PIN : PO51686741Q\n");
$printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
$printer -> text("0707-98-78-78\n");
$printer -> feed();

/* Title of receipt */
$printer -> setEmphasis(true);
$printer -> text("SALES INVOICE\n");
$printer -> setEmphasis(false);

/* Items */
$printer -> setJustification(Printer::JUSTIFY_LEFT);
// $printer -> setEmphasis(true);
// $printer -> text(new item('', 'Ksh'));
// $printer -> setEmphasis(false);
$printer -> feed();
foreach ($items as $item) {
    $printer -> selectPrintMode();
    $printer -> text($item);
    $printer -> selectPrintMode();
}
$printer -> feed();
$printer -> setEmphasis(true);
$printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
$printer -> text($subtotal);
$printer -> setEmphasis(false);
$printer -> feed();

/* Tax and total */
$printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
$printer -> text($tax);
$printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
$printer -> text($total);
$printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
$printer ->text($cash);
$printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
$printer ->text($change);
$printer -> selectPrintMode();

/* Footer */
$printer -> feed(2);
$printer -> setJustification(Printer::JUSTIFY_CENTER);
$printer -> text("Thank you for shopping at Egyptian Chef\n");
$printer -> text("For more info, Visit egyptchef.com\n");
$printer -> feed(2);
$printer -> text($date . "\n");

/* Cut the receipt and open the cash drawer */
$printer -> cut();
$printer -> pulse();

$printer -> close();

class item
{
    private $name;
    private $price;
    private $dollarSign;

    public function __construct($name = '', $price = '', $dollarSign = false)
    {
        $this -> name = $name;
        $this -> price = $price;
        $this -> dollarSign = $dollarSign;
    }

    public function __toString()
    {
        $rightCols = 10;
        $leftCols = 38;
        if ($this -> dollarSign) {
            $leftCols = $leftCols / 2 - $rightCols / 2;
        }
        $left = str_pad($this -> name, $leftCols) ;

        $sign = ($this -> dollarSign ? 'Ksh. ' : '');
        $right = str_pad($sign . $this -> price, $rightCols, ' ', STR_PAD_LEFT);
        return "$left$right\n";
    }
}
