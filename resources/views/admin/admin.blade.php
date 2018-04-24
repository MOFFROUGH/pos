@extends('home.partials.base')
@section('title','Egyptian Chef | Admin')
@section('main-content')
  @if ($error)
    <div class="alert alert-danger alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Warning!</strong> {{$error}}
    </div>

  @endif
  <div class="container-fluid">
    <div class="col-sm-6 col-sm-offset-3">
      <a id="cartbutton" href="{{route('cart')}}" class="btn btn-block btn-xs btn-success"> <span class="badge">{{count(Cart::content())}}</span> My Cart
      <span class="glyphicon glyphicon-shopping-cart"></span></a>
      <style>
        #cartbutton {
          margin: 10px;
        }
      </style>
    </div>

    <table id="myTable" class='table table-striped table-bordered table-hover table-condensed'>
      <thead>
        <tr>
          <th>Food Name</th>
          <th>Price (KSh.)</th>
          <th>Addons</th>
          <th>Number</th>
          <th>Add to cart</th>
        </tr>
      </thead>
      <tbody>
        @forelse($products as $item)
          <tr>
            <td>{{$item->Name}}</td>
            <td>{{$item->Price}}</td>
            <td>{{$item->addon}}</td>
            <form class="" action="{{route('admin.checkout',$item->id)}}" method="post">
              {{ csrf_field() }}
              <td>
                <input type='number' class='form-control input-sm' name="number" value="1" min="1" placeholder='How many? '>
              </td>
              <td>
                <button type='submit' class='btn btn-sm btn-success '><span class="glyphicon glyphicon-shopping-cart"></span> Add to cart</button>

              </td>
            </form>
          </tr>
        @empty
          <p>
            You have no cart items
          </p>
        @endforelse


      </tbody>
    </table>

  </div>
@endsection
