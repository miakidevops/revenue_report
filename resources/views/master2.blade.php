<html>
     <head>
          <title>  @yield('title') </title>
          <meta charset="utf-8">
          <meta name="viewport" content="width=device-width, initial-scale=1">
          

          <link rel="stylesheet" type="text/css" href="{{ URL::to('css/bootstrap.min.css')}}">
          <link rel="stylesheet" type="text/css" href="{{ URL::to('css/w3.css')}}">
          <link rel="stylesheet" type="text/css" href="{{ URL::to('css/font-awesome.min.css')}}">
          <link rel="stylesheet" type="text/css" href="{{ URL::to('css/first.css')}}">
          <!-- <link rel="stylesheet" type="text/css" href="{{ URL::to('css/data-table.min.css')}}"> -->
     </head>


     <body>
          


          <div class="container-fluid">
              <div class="row">

                @yield('content')

              </div>
          </div>


       

         <script src="{{ URL::to('js/new.js') }}"> </script>
         <script src="{{ URL::to('js/jquery.min.js') }}"> </script>
         <script src="{{ URL::to('js/bootstrap.min.js') }}"> </script>
         <!-- <script src="{{ URL::to('js/canvasjs.min.js') }}"></script>
         <script src="{{ URL::to('js/data-table.min.js') }}"></script> -->
        <!--  <script>
               $(document).ready(function() {

               $('#example').DataTable( {
                       "scrollY":        "385px",
                       "scrollCollapse": true,
                       "paging":         false
                   } );
           } );

               
             </script> -->
       </body>

 </html>