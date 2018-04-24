@extends('home.partials.base')
@section('title','Egyptian Chef | Checkout')
@section('main-content')
<section id="cart_items">
    <div class="container" style="border: 1px solid red">
        <div style="text-align: center">
            <h1>Egyptian  Chef</h1>
        </div>
        <div class="table-responsive cart_info">
            @if(count($cart))
            <table class="table table-condensed" id="ShoppingCheckout">
                <thead>
                    <tr class="cart_menu">
                        <td class="description">Item</td>
                        <td class="price">Price(KSH)</td>
                        <td class="quantity">Quantity</td>
                        <td class="total">Total(KSH)</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $item)
                    <tr>
                        <td class="cart_description">
                            <h4><a href="">{{$item->name}}</a></h4>
                            <p>Product ID: EGYPTCHEF-{{$item->id}}</p>
                        </td>
                        <td class="cart_price">
                            <p>{{$item->price}}</p>
                        </td>
                        <td class="cart_quantity">
                            <div class="cart_quantity_button">
                                <a class="btn btn-xs btn-success" href='{{route("addQuantity",$item->id)}}'> + </a>
                                <input class="cart_quantity_input" type="text" name="quantity" value="{{$item->qty}}" autocomplete="off" size="2">
                                <a class="btn btn-xs btn-danger" href='{{route("removeQuantity",$item->id)}}'> - </a>
                            </div>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price">{{$item->subtotal}}</p>
                        </td>
                        <td class="cart_delete">
                            <a class="cart_quantity_delete" href=""><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                    @endforeach
                    @else
                <p>You have no items in the shopping cart</p>
                @endif
                </tbody>
            </table>
        </div>
    </div>
</section> <!--/#cart_items-->

<section id="do_action">
    <div class="container" style="border: 1px solid red">
        {{-- <div class="heading">
            <h3>What would you like to do next?</h3>
        </div> --}}
        <div class="row">
            <div  style="text-align:left">
                <div class="total_area">
                    @if ($day == 'WE' || $day == 'SU' || $day == 'SA')
                        <ul style="list-style: none">
                            <li>Cart Sub Total <span>{{Cart::subtotal() - Cart::tax()}}</span></li>
                            <li>VAT Tax <span>{{Cart::tax()}}</span></li>
                            <li>Total <span>${{Cart::subtotal()}}</span></li>
                            @if ($cash)
                                    <li>Cash: <span>Ksh {{$cash}}</span></li>
                            @endif
                            @if ($change)
                                <li>Change: <span>Ksh {{$cash - Cart::subtotal()}}</span></li>
                            @endif
                        </ul>
                    @else
                        <ul style="list-style: none">
                            <li>Cart Sub Total <span>Ksh {{Cart::subtotal()-Cart::tax()}}</span></li>
                            <li>VAT Tax <span>Ksh {{Cart::tax()}}</span></li>
                            <li>Total <span>KSh {{Cart::subtotal()}}</span></li>
                            @if ($cash)
                                    <li>Cash: <span>Ksh {{$cash}}</span></li>
                            @endif
                            @if ($change)
                                <li>Change: <span>Ksh {{$cash - Cart::subtotal()}}</span></li>
                            @endif
                        </ul>
                    @endif
                    <a class="btn  btn-warning" href="{{route('admin.home')}}"> <span class="glyphicon glyphicon-plus"></span> Add Items to cart</a>
                    @if (Cart::subtotal() != 0)
                        <button class="btn  btn-primary" data-toggle="modal" data-target="#amount">
                            <span class="glyphicon glyphicon-euro"></span> Pay
                        </button>
                    @endif
                    @if ($cash)
                        <form class="" action="{{route('admin.print')}}" method="post">
                            {{csrf_field()}}
                            <input value="{{$cash}}" name="cash" class="hidden" />
                            <input value="{{$change}}" name="change" class="hidden" />
                            <button type="submit" class="btn  btn-success"name="button">Issue Receipt</button>
                        </form>
                    @endif
                    @if (count(Cart::content())!= 0)
                        <a class="btn  btn-danger" href="{{route('clearcart')}}"> <span class="glyphicon glyphicon-remove"></span> Clear</a>
                    @endif
                    @if (count(Cart::content())== 0)
                        <a class="btn  btn-primary" href="{{route('admin.home')}}"> <span class="glyphicon glyphicon-home"></span> Home</a>
                    @endif



                    {{-- <a class="btn btn-danger update" href="{{route('admin.print',['cash'=>$cash, 'change'=>$change])}}"> <span class="glyphicon glyphicon-remove"></span> Issue Receipt</a> --}}
                    {{-- <a class="btn btn-success check_out"><span class="glyphicon glyphicon-print" href="{{route('admin.print',['cash'=>$cash, 'change'=>$change])}}"></span>Issue Receipt</a> --}}
                </div>
                <div class="modal fade" id="amount" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="">Transaction details</h4>
                      </div>
                      <div class="modal-body">
                          <form class="" action="{{route("addCash")}}" method="post">
                              {{csrf_field()}}
                              <div class="form-group">
                                <label for="amount"></label>
                                <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter the Cash paid">
                              </div>
                              <button type="submit" class="btn btn-success btn-xs" name="button"> Proceed</button>
                          </form>
                      </div>
                      {{-- <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary"></button>
                      </div> --}}
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <style>
    .total_area button {
        margin-bottom: 5px
    }
    </style>
</section><!--/#do_action-->
@endsection
