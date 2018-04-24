<!DOCTYPE html>
<html>
  <head>
    @include('home.partials.head')
  </head>
  <body>
    @include('home.partials.header')
    @section('main-content')

    @show
    @include('home.partials.footer')
  </body>
  <style>
  body {
    background-color: #abcdef;
  }
  </style>
</html>
