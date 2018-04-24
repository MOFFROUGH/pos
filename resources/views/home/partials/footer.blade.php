<footer>
  <div>
    &copy; 2018
  </div>
</footer>
<style>
footer div{
  text-align: center;
}
</style>
{{-- <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script> --}}
<script src="{{asset('js/jquery-3.3.1.js')}}" ></script>
<script src="{{asset('js/bootstrap.min.js')}}" ></script>
<!-- Latest compiled and minified JavaScript -->
{{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> --}}
<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
{{-- <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" async defer></script> --}}
{{-- <script src="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css" async defer></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js" async defer></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js" async defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.debug.js" integrity="sha384-CchuzHs077vGtfhGYl9Qtc7Vx64rXBXdIAZIPbItbNyWIRTdG0oYAqki3Ry13Yzu" crossorigin="anonymous"></script> --}}
<script>
$(document).ready(function(){
    $('#myTable').DataTable();
});
$(document).ready(function(){
    $('#ShoppingCheckout').DataTable();
});
</script>
