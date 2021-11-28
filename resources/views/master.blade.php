<html>
     <head>
          <title>  @yield('title') </title>
          <link rel="icon" href="{!! asset('image/title.png') !!}"/>

          <meta charset="utf-8">
          <meta name="viewport" content="width=device-width, initial-scale=1">
          

          <link rel="stylesheet" type="text/css" href="{{ URL::to('css/bootstrap.min.css')}}">
          <link rel="stylesheet" type="text/css" href="{{ URL::to('css/w3.css')}}">
          <link rel="stylesheet" type="text/css" href="{{ URL::to('css/font-awesome.min.css')}}">
          <link rel="stylesheet" type="text/css" href="{{ URL::to('css/first.css')}}">
          <link rel="stylesheet" type="text/css" href="{{ URL::to('css/data-table.min.css')}}">
          <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css">
          
     </head>


     <body>

          <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
              <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>                        
                </button>
                <a class="navbar-brand" href="{{url('homePage')}}">Robi Vas Rev Report <span class="fa fa-bar-chart"></span></a>
              </div>
              <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                  <li><a href="{{route('report.index')}}">Detail <span class="fa fa-th"></span></a></li>
                  <li><a href="{{route('report.create')}}">Batch <span class="fa fa-upload"></span></a></li>

                    <?php if(session()->get('user_type')=="admin") {?>
                  <li><a href="{{route('shortcode.index')}}">Settings <span class="fa fa-cog"></span></a></li> 
                    <?php } ?>

                  <li><a href="{{url('churn')}}">Churn <span class="fa fa-hourglass-half"></span></a></li> 
                    

                  <li><a href="{{url('bdapps')}}">BDApps Rev <span class="fa fa-money"></span></a></li>

                  <li><a href="{{url('bdapps_batch')}}">BDApps Batch <span class="fa fa-upload"></span></a></li>


                  <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    Miaki Revenue <span class="fa fa-money"></span> <span class="caret"></span></a>
                          <ul class="dropdown-menu">
                            <li><a href="{{url('miaki_revenue')}}"><i class="fa fa-area-chart"></i> Report</a></li>
                            <li><a href="{{url('detail_miaki_revenue')}}"><i class="fa fa-table"></i> Detail Revenue</a></li>
                            <li><a href="{{url('upload_apps_revenue')}}"><i class="fa fa-upload"></i> Batch</a></li>
                            <li><a href="{{url('all_target_revenue')}}"><i class="fa fa-bullseye"></i> Target</a></li>
                            <li><a href="{{url('financial_review')}}"><i class="fa fa-table"></i> Financial Review</a></li>
                          </ul>
                  </li>
                  
                </ul>
                <ul class="nav navbar-nav navbar-right">
                  <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">{{session()->get('user_name')}} <span class="caret"></span></a>
                          <ul class="dropdown-menu">
                            <li><a href="{{route('user.create')}}"><i class="fa fa-user-circle-o"></i> My Profile</a></li>

                              <?php if(session()->get('user_type')=="admin") {?>
                            <li><a href="{{route('user.index')}}"><i class="fa fa-user"></i><i class="fa fa-user" style="font-size:10px"></i> All Users</a></li>
                               <?php } ?>
                               
                            <li><a href="{{route('password.index')}}"><i class="fa fa-lock"></i> Change Password</a></li>
                          </ul>
                  </li>
                  <li><a href="{{route('login.create')}}"><i class="fa fa-sign-out"></i> Logout</a></li>
                </ul>
              </div>
            </div>
          </nav>

          <div class="main-container-wrap" style="margin-top: 50px">
            <div class="container">
                <div class="row">

                  @yield('content')

                </div>
            </div>
            <div class="container-fluid">
                <div class="row">

                  @yield('content_fluid')

                </div>
            </div>
          </div>

          

          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <img src="{{ URL::to('image/footer.png') }}" class="img-responsive footer-image">
              </div>
            </div>
          </div>

          <button onclick="topFunction()" id="myBtnTop" title="Go to top"><i class="fa fa-angle-double-up"></i></button>
	     

         <script src="{{ URL::to('js/new.js') }}"> </script>
         <script src="{{ URL::to('js/jquery.min.js') }}"> </script>
         
         <script src="{{ URL::to('js/bootstrap.min.js') }}"> </script>
         <script src="{{ URL::to('js/canvasjs.min.js') }}"></script>
         <script src="{{ URL::to('js/data-table.min.js') }}"></script>
          <script src="https://cdn.datatables.net/fixedcolumns/3.3.0/js/dataTables.fixedColumns.min.js"></script>
         
         <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>

         <script>
         //Get the button
         var mybutton = document.getElementById("myBtnTop");

         // When the user scrolls down 20px from the top of the document, show the button
         window.onscroll = function() {scrollFunction()};

         function scrollFunction() {
           if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
             mybutton.style.display = "block";
           } else {
             mybutton.style.display = "none";
           }
         }

         // When the user clicks on the button, scroll to the top of the document
         function topFunction() {
           document.body.scrollTop = ({top: 0, behavior: 'smooth'});
           document.documentElement.scrollTop = ({top: 0, behavior: 'smooth'});
         }
         </script>

         <script type="text/javascript">
           var today = new Date();
           // today.setDate(today.getDate() - 1);
           $('.picker').datetimepicker(
           {
             timepicker:true,
             datepicker:true,
             format:'Y-m-d H:i',
             value:this.value,
             hours12:false
           })

           $(document).ready(function () {
               $('.miaki_apps_detail_revenue tr.app_wise_rev').click(function () {
                   if(this.style.background == "" || this.style.background =="white") {
                       $(this).css({background: "#f2ccff", 'text-decoration':'underline', 'opacity':'.8'});
                   }
                   else {
                       $(this).css({background: "white", 'text-decoration':'none', 'opacity':'1'});
                   }
               });
           });
         </script>
         
         <script>
               $(document).ready(function() {

               $('#example').DataTable( {
                       "scrollY":        "385px",
                       "scrollCollapse": true,
                       "paging":         false
                   } );


               $('#data_table_1').DataTable( {
                   "scrollY":        "370px",
                   "scrollCollapse": true,
                   "paging":         false
               } );

               
                if ($(window).width() < 800) {
                  let tbl = $('table.miaki_apps_revenue');
                  // tbl.DataTable().destroy();
                  // tbl.removeClass('miaki_apps_revenue');
                  tbl.parent().toggleClass('mobile-table--parent-div');
                  tbl.find('thead').toggleClass('mobile-table--thead');
                  tbl.find('tbody').toggleClass('mobile-table--tbody');
                } else {
                  let tbl = $('table.miaki_apps_revenue');
                  let colCount = tbl[0].tHead.rows[0].cells.length;
                  // console.log(colCount);
                  // console.log(tbl);
                  tbl.DataTable( {
                                "scrollY":        "420px",
                                "scrollX":        (function() {
                                  return tbl[0].tHead.rows[0].cells.length > 11 ? true : false;
                                })(),
                                "scrollCollapse": true,
                                "paging":         false,
                                "fixedColumns":   {
                                    "leftColumns": 3
                                }
                     } );
                }

               $(window).on('resize', function() {
                  window.location.reload(false);
               });
                
              
           } );

        </script>
       </body>

 </html>