@extends('home.partials.base')
@section('title','Egyptian Chef|Home')
@section('main-content')
  <div id="carousel-generic" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#carousel-generic" data-slide-to="0" class="active"></li>
      <li data-target="#carousel-generic" data-slide-to="1"></li>
      <li data-target="#carousel-generic" data-slide-to="2"></li>
      <li data-target="#carousel-generic" data-slide-to="3"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
      <div class="item active">
        <img src="{{asset('img/menu-1.jpg')}}" alt="" height="50%" width="100%">
        <div class="carousel-caption">
          <h1>Prawn Soup With Rice</h1>
          <small>Nothing gets your day going smoothly</small>
        </div>
      </div>
      <div class="item">
        <img src="{{asset('img/menu-5.jpg')}}" alt="" height="50%" width="100%">
        <div class="carousel-caption">
          <h1>Full Chicken With two chips</h1>
          <small>The best family pack in town</small>
        </div>
      </div>
      <div class="item">
        <img src="{{asset('img/menu-1.jpg')}}" alt="" height="50%" width="100%">
        <div class="carousel-caption">
          <h1>Prawn Soup With Rice</h1>
          <small>Nothing gets your day going smoothly</small>
        </div>
      </div>
      <div class="item">
        <img src="{{asset('img/menu-5.jpg')}}" alt="" height="50%" width="100%">
        <div class="carousel-caption">
          <h1>Full Chicken With two chips</h1>
          <small>The best family pack in town</small>
        </div>
      </div>

    </div>

    <!-- Controls -->
    <a class="left carousel-control" href="#carousel-generic" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
    </a>
    <a class="right carousel-control" href="#carousel-generic" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
    </a>
  </div>
@endsection
