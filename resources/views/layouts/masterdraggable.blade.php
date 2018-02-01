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
     <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous"> -->

     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> 
    
    
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous"> -->

<!-- <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous"> -->
    <!-- Custom styles for this template -->

    <link href="{!! asset('/css/justified-nav.css') !!}" rel="stylesheet">
    <style>
    .open>.dropdown-menu {
    display: block;
}
.navbar-right {
    float: right !important;
    margin-right: -15px;
}

ul#sortable2 {
    list-style-type: none;
}
#sortable2 li {
    margin: 0 3px 3px 3px;
    padding: 0.4em;
    padding-left: 0em;
    font-size: 1.4em;
    height: auto;
}



ul#unsortable {
    list-style-type: none;
}
#unsortable li {
    margin: 0 3px 3px 3px;
    padding: 0.4em;
    padding-left: 0em;
    font-size: 1.4em;
    height: auto;
}


#sortable3 li {
    margin: 0 3px 3px 3px;
    padding: 0.4em;
    padding-left: 0em;
    font-size: 1.4em;
    height: auto;
}
ul#sortable3 {
    list-style-type: none;
}


ul.alert.alert-danger {
    list-style-type: none;
}
ul.alert.alert-success {
    list-style-type: none;
}
input:read-only
{
	background-color: rgb(235, 235, 228);
	border: solid 1px #afafaf;
}
    </style>
    
    
    
    
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <style>
  #sortable { list-style-type: none; margin: 0; padding: 0; width: 72%; }
  #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 0em; font-size: 1.4em; height: auto; }
  #sortable li span { margin-left: 0em; }
  </style>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
	  function sortupdate(){

        var new_ajax_url =  "{{route('rrPropertyTypeSectionFieldOrder')}}" + "/";

        $.ajax({
            url: new_ajax_url,
            type:'GET',
            data: $("input[name='section_field_id[]']").serialize(),
            success:function(result){


            }

        });

}
  $( function() {
    //$( "#sortable" ).sortable();
    
    
    $('#sortable').sortable({
    items: "li:not(.non-draggable)"
});
$( "#sortable" ).disableSelection();
    
    $( "#sortable2" ).sortable();
    $( "#sortable2" ).disableSelection();
 
     $( ".ui-sortable3" ).sortable();
    $( ".ui-sortable3" ).disableSelection();
   // $( "#div_sortable" ).sortable();
    
    $('#div_sortable').sortable({
   // items: "div:not(.non-draggable)",
     start: function (event, ui) {
            $(ui.item).data("startindex", ui.item.index());

        },
    stop: function (event, ui)
    {


        var startIndex = ui.item.data("startindex");
        var stopindex = ui.item.index();

        var prev_element_index = stopindex;
       // var prev_element_classname = $("#div_sortable").find('div:nth-child('+prev_element_index+')').attr('class');

       //alert("previous element index is" + prev_element_index);

       var prev_element = $('div#div_sortable>div:nth-child('+ prev_element_index + ')');

        //var prev_element = $("#div_sortable").children(prev_element_index);
              //alert(prev_element);


        if (prev_element.hasClass( "non-draggable" ))
        {
                $(this).sortable('cancel');
			}
			else
			{
				sortupdate();
			}
    }
});
    
    $("#div_sortable").disableSelection();
     $('#div_sortable').sortable({ cancel: '.non-draggable' });


    
  } );
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
  
  <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script> -->
  
  {{--  <script src="{{ asset('js/app.js') }}"></script>
    --}}
  </body>

</html> 
