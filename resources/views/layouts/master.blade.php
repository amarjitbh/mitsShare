<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title></title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">

    <!-- Custom styles for this template -->

    <link href="{!! asset('/css/justified-nav.css') !!}" rel="stylesheet">
    <style>
    .open>.dropdown-menu {
    display: block;
}
.navbar-right {
    float: right!important;
    margin-right: -15px;
}
    </style>
    <!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
    <script src="http://code.jquery.com/jquery-1.11.1.js"></script> 
   <!-- <script
  src="https://code.jquery.com/jquery-3.1.1.js"
  integrity="sha256-16cdPddA6VdVInumRGo6IbivbERE8p7CQR3HzTBuELA="
  crossorigin="anonymous"></script>-->
    <script> 
    $( document ).ready(function() {
    $('form').on("click",".btn-danger", function(e){ //user click on remove text links
        
        if (!confirm('Are you sure?')) {
        e.preventDefault();
    }
      
    });  
});
</script>
  </head>

  <body>

    <div class="container">

      @include ('layouts.nav')

      @yield('jumbotron')

      <div class="container">
          @yield('content')
      </div>
     

      

    </div>
    
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}"></script>
  </body>

</html> 
