<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Products;
use Cart;
use App\Models\Sales;
use App\Models\Invoices;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Carbon\Carbon;
class AdminController extends Controller
{
    public function index()
    {
        $products = Products::all();
        // return redirect(route('admin.home',['products'=>$products, 'day'=>$this->dateFormat()]));
        return view('admin.admin', ['error'=>null,'products'=>$products, 'day'=>$this->dateFormat()]);
    }
    public function print(Request $request)
    {
        $cash = $request->cash;
        $change = $request->change;
        $cart = Cart::content();
        // $connector = new FilePrintConnector("/dev/usb/lp0");
        // $printer = new Printer($connector);

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
        $tax = new item('vat', Cart::tax());
        $total = new item('Total', Cart::subtotal());
        // $cash = new item('Cash', $cash);
        // $change = new item('Change', $change);
        /* Date is kept the same for testing */
        // $date = date('l jS \of F Y h:i:s A');
        $date = Carbon::now(new \DateTimeZone('Africa/Nairobi'));

        // // /* Start the printer */
        // // $logo = EscposImage::load("public/img/menu-1.jpg", false);
        // // $printer = new Printer($connector);
        // //
        // // /* Print top logo */
        // $printer -> setJustification(Printer::JUSTIFY_CENTER);
        // // $printer -> graphics($logo);
        //
        // /* Name of shop */
        // $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
        // $printer -> text("Egyptian Chef\n");
        // $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
        // $printer -> text("PIN : PO51686741Q\n");
        // $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
        // $printer -> text("0707-98-78-78\n");
        // $printer -> feed();
        //
        // /* Title of receipt */
        // $printer -> setEmphasis(true);
        // $printer -> text("SALES INVOICE\n");
        // $printer -> setEmphasis(false);
        //
        // /* Items */
        // $printer -> setJustification(Printer::JUSTIFY_LEFT);
        // // $printer -> setEmphasis(true);
        // // $printer -> text(new item('', 'Ksh'));
        // // $printer -> setEmphasis(false);
        // $printer -> feed();
        // foreach ($items as $item) {
        //     $printer -> selectPrintMode();
        //     $printer -> text($item);
        //     $printer -> selectPrintMode();
        // }
        // $printer -> feed();
        // $printer -> setEmphasis(true);
        // $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
        // $printer -> text($subtotal);
        // $printer -> setEmphasis(false);
        // $printer -> feed();
        //
        // /* Tax and total */
        // $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
        // $printer -> text($tax);
        // $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
        // $printer -> text($total);
        // $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
        // $printer ->text($cash);
        // $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
        // $printer ->text($change);
        // $printer -> selectPrintMode();
        //
        // /* Footer */
        // $printer -> feed(2);
        // $printer -> setJustification(Printer::JUSTIFY_CENTER);
        // $printer -> text("Thank you for shopping at Egyptian Chef\n");
        // $printer -> text("For more info, email: matarikualimited@gmail.com\n");
        // $printer -> feed(2);
        // $printer -> text($date . "\n");
        //
        // /* Cut the receipt and open the cash drawer */
        // $printer -> cut();
        // $printer -> pulse();
        //
        // $printer -> close();
        //save sale to db
        $sales = new Sales();
        $sales->itemscost = Cart::subtotal();
        $sales->tax = Cart::tax();
        $sales->cashpaid = $cash;
        $sales->change = $change;
        $sales->save();

        // save invoice to db
        foreach(Cart::content() as $item){
            $details= new Invoices;
            $details->salesid= $sales->id;
            $details->productid= $item->id;
            $details->save();
        }

        Cart::destroy();
        return redirect(route('admin.home',['error'=>null]));

    }

    public function clearcart()
    {
        Cart::destroy();
        $products = Products::all();
        return redirect(route('admin.home',['error'=>null]));
        // return view('admin.admin', ['products'=>$products, 'day'=>$this->dateFormat()]);

    }

    public function addQuantity(Request $request)
    {
        // echo $request->route('id');
        $ID = null;
        $rowId = Cart::search(function($key, $value) use($request) {return $key->id === $request->route('id');});
        // echo $rowId;
        foreach ($rowId as $array) {
            $ID = $array->rowId;
        }
        $item = Cart::get($ID);
        // echo $ID;
        Cart::update($ID, $item->qty + 1);
        return redirect('/cart');
    }
    public function removeQuantity(Request $request)
    {
        // echo $request->route('id');
        $ID = null;
        $rowId = Cart::search(function($key, $value) use($request) {return $key->id === $request->route('id');});
        // echo $rowId;
        foreach ($rowId as $array) {
            $ID = $array->rowId;
        }
        $item = Cart::get($ID);
        // echo $ID;
        Cart::update($ID, $item->qty - 1);
        return redirect('/cart');
    }
    public function addToCart(Request $request)
    {
        $products = Products::all();
        // fetch the id from the incoming request
        $day = $this->dateFormat();

        $product_id = $request->route('id');
        // fetch the quantity of the product
        $quantity = $request->number;
        if (!$quantity) {
            $quantity = 1;
        }
        // find the product associated with the product id
        $product = Products::find($product_id);
        // add to cart
        // check for days offer
        if ($day == 'WE' || $day == 'SA' || $day == 'SU') {
            if ($product->Name == 'Italian Pizza') {
                if ($quantity % 2 != 0) {
                    if ($product->addon == 'Large') {
                        if ($quantity == 1) {
                            if ($day == 'SA' || $day == "SU") {
                                Cart::add(array('id' => $product_id, 'name' => $product->Name, 'qty' => $quantity, 'price' => 950));
                                // Offer 2 liter soda
                                Cart::add(array('id' => 30, 'name' => '2L soda', 'qty' => 1, 'price' => 0));
                                return view('admin.admin', ['error'=>null,'products'=>$products]);
                            }
                        }
                    }
                    return view('admin.admin', ['error'=>'Must buy two pizzas today', 'products'=>$products]);
                }
                else {
                    if ($product->addon == 'Small') {
                        Cart::add(array('id' => $product_id, 'name' => $product->Name, 'qty' => $quantity, 'price' => 650 * $quantity/2));
                        return view('admin.admin', ['error'=>null,'products'=>$products]);
                    }
                    elseif ($product->addon == 'Medium') {
                        Cart::add(array('id' => $product_id, 'name' => $product->Name, 'qty' => $quantity, 'price' => 750 * $quantity/2));
                        return view('admin.admin', ['error'=>null,'products'=>$products]);
                    }
                    elseif ($product->addon == 'Large') {
                        Cart::add(array('id' => $product_id, 'name' => $product->Name, 'qty' => $quantity, 'price' => 900 * $quantity/2));
                        return view('admin.admin', ['error'=>null,'products'=>$products]);
                    }
                    else {
                        Cart::add(array('id' => $product_id, 'name' => $product->Name, 'qty' => $quantity, 'price' => 900 * $quantity/2));
                        // Free sopplie
                        // Cart::add(array('id' => $product_id, 'name' => $product->Name, 'qty' => $quantity, 'price' => 900 * $quantity/2));

                        return view('admin.admin', ['error'=>null,'products'=>$products]);
                    }
                    // Cart::add(array('id' => $product_id, 'name' => $product->Name, 'qty' => $quantity, 'price' => $product->Price));
                    // return view('admin.admin', ['error'=>null,'products'=>$products]);
                }
            }
            else {
                Cart::add(array('id' => $product_id, 'name' => $product->Name, 'qty' => $quantity, 'price' => $product->Price));
                return view('admin.admin', ['error'=>null,'products'=>$products]);
            }
        }
        else {
            Cart::add(array('id' => $product_id, 'name' => $product->Name, 'qty' => $quantity, 'price' => $product->Price));
            return view('admin.admin', ['error'=>null,'products'=>$products]);
        }

        // return redirect(route('admin.home',['products'=>$products, 'day'=>$this->dateFormat()]));
    }
    public function cart()
    {
        $cart = Cart::content();
        return view('admin.checkout', array('cart' => $cart, 'change'=>null, 'cash'=>null, 'title' => 'Welcome', 'description' => '', 'page' => 'home','day'=>$this->dateFormat()));
        // return redirect(route('checkout', array('cart' => $cart, 'change'=>null, 'cash'=>null, 'title' => 'Welcome', 'description' => '', 'page' => 'home','day'=>$this->dateFormat())));
    }
    public function addCash(Request $request)
    {
        $cash = $request->amount;
        // /return $cash;
        $cart = Cart::content();
        $amount =Cart::subtotal();
        $change = $cash - $amount;
        // dd ($change);
        return view('admin.checkout', array('cart' => $cart, 'change'=>$change, 'cash'=>$cash, 'title' => 'Welcome', 'description' => '', 'page' => 'home','day'=>$this->dateFormat()));
        // return redirect(route('checkout', array('cart' => $cart, 'change'=>null, 'cash'=>null, 'title' => 'Welcome', 'description' => '', 'page' => 'home','day'=>$this->dateFormat())));

    }
    public function dateFormat()
    {
        $weekMap = [
            0 => 'SU',
            1 => 'MO',
            2 => 'TU',
            3 => 'WE',
            4 => 'TH',
            5 => 'FR',
            6 => 'SA',
        ];
        $dayOfTheWeek = Carbon::now()->dayOfWeek;
        $weekday = $weekMap[$dayOfTheWeek];
        return $weekday;
    }
    public function clearCache()
    {
        $exitCode = Artisan::call('config:cache');
        $exitCode = Artisan::call('cache:clear');
        $exitCode = Artisan::call('route:clear');
    }
}
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
