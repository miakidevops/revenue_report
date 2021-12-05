@extends('master')
    @section('title')
          BDApps Revenue
    @endsection

    @section('content')
    <div class="col-md-12">
      <h4 class="text-center bdapps_heading"><b><span>Total Revenue:</span> {{number_format($current_month_total_revenue[0]['y']+$current_month_total_revenue[1]['y'],2,'.',',')}} <span>Tk</span> &nbsp&nbsp&nbsp||&nbsp&nbsp&nbsp <span>Average Revenue:</span> {{number_format($avg_rev,2,'.',',')}} <span>Tk</span> &nbsp&nbsp&nbsp||&nbsp&nbsp&nbsp <span>Forecasted Revenue:</span> {{number_format($current_month_forecast_revenue[0]['y']+$current_month_forecast_revenue[1]['y'],2,'.',',')}} <span>Tk</span></b></h4>

      @if (session('message')) 
      <div class="alert alert-danger">
          <ul><li><a  class="close" data-dismiss="alert" aria-label="close">&times;</a>{{ session('message') }}</li></ul>
      </div>    
      @endif
    </div>
    <div class="col-md-12">
        <!-- last 30 days miaki_rev vs mmlbd_rev compare -->
        <div id="chartContainer5" style="height: 290px; width: 100%;"></div> 
        <br><br>   
    </div>


    <div class="col-md-4">
        <!-- last 30 days miaki_rev vs mmlbd_rev compare -->
        <div id="chartContainer" style="height: 320px; width: 100%;"></div> 
        <br><br>   
    </div>
    <div class="col-md-4">
        <!-- last 30 days miaki_rev and mmlbd_rev forecast -->
        <div id="chartContainer2" style="height: 320px; width: 100%;"></div>  
        <br><br>
    </div>
    <div class="col-md-4">
        <div id="chartContainer3" style="height: 320px; width: 100%;"></div>  
        <br><br>  
    </div>


    <div class="col-md-12">


      <div class="table-responsive">
       <table class="table table-hover table-bordered table-condensed table-striped bdapps_table">
          <thead>
            <tr>
              <th class="text-center dark">DATE</th>
              <th class="text-center light" >MIAKI REVENUE</th> 
              <th class="text-center dark" >MMLBD REVENUE</th>
              <th class="text-center light" >OTHER REVENUE</th>
              <th class="text-center dark">TOTAL REVENUE</th>
              <th class="text-center light">AVERAGE REVENUE</th>
            </tr> 
          </thead>
          <tbody>
            @foreach($all_days AS $day)     
            <tr>
              <th class="text-center day_list">{{ $day }}</th>

              <th class="text-right"> 
               {{  number_format( $day_wise_rev_array[$day]["miaki_rev"]["rev"] ,2,'.',',') }}  

               @if( $day_wise_rev_array[$day]["miaki_rev"]["ind"] == 1 )
                   <i class="fa fa-arrow-up" style="color:green"></i>
               @elseif( $day_wise_rev_array[$day]["miaki_rev"]["ind"] == -1 )
                   <i class="fa fa-arrow-down" style="color:red"></i>
               @else
                   <i class="fa fa-arrows-h" style="color:orange"></i>
               @endif

              </th>
                
              <th class="text-right"> 
               {{  number_format( $day_wise_rev_array[$day]["mmlbd_rev"]["rev"] ,2,'.',',') }}  

               @if( $day_wise_rev_array[$day]["mmlbd_rev"]["ind"] == 1 )
                   <i class="fa fa-arrow-up" style="color:green"></i>
               @elseif( $day_wise_rev_array[$day]["mmlbd_rev"]["ind"] == -1 )
                   <i class="fa fa-arrow-down" style="color:red"></i>
               @else
                   <i class="fa fa-arrows-h" style="color:orange"></i>
               @endif

              </th> 

              <th class="text-right"> 
               {{  number_format( $day_wise_rev_array[$day]["other_rev"]["rev"] ,2,'.',',') }}  

               @if( $day_wise_rev_array[$day]["other_rev"]["ind"] == 1 )
                   <i class="fa fa-arrow-up" style="color:green"></i>
               @elseif( $day_wise_rev_array[$day]["other_rev"]["ind"] == -1 )
                   <i class="fa fa-arrow-down" style="color:red"></i>
               @else
                   <i class="fa fa-arrows-h" style="color:orange"></i>
               @endif

              </th> 

             
              <th class="text-right" style="font-size: 14px">

                {{  number_format( $day_wise_rev_array[$day]["total_rev"]["rev"] ,2,'.',',') }}  

                @if( $day_wise_rev_array[$day]["total_rev"]["ind"] == 1 )
                    <i class="fa fa-arrow-up" style="color:green"></i>
                @elseif( $day_wise_rev_array[$day]["total_rev"]["ind"] == -1 )
                    <i class="fa fa-arrow-down" style="color:red"></i>
                @else
                    <i class="fa fa-arrows-h" style="color:orange"></i>
                @endif

              </th> 

              <th class="text-right" style="font-size: 14px">
                {{  number_format( $day_wise_rev_array[$day]["avg_rev"]["rev"] ,2,'.',',') }}

                @if( $day_wise_rev_array[$day]["avg_rev"]["ind"] == 1 )
                    <i class="fa fa-arrow-up" style="color:green"></i>
                @elseif( $day_wise_rev_array[$day]["avg_rev"]["ind"] == -1 )
                    <i class="fa fa-arrow-down" style="color:red"></i>
                @else
                    <i class="fa fa-arrows-h" style="color:orange"></i>
                @endif

              </th>

            </tr>
            @endforeach 
          </tbody>
        </table>
        <br><br>
       </div> 

      <div class="table-responsive">
        <table class="table table-hover table-bordered table-condensed table-striped bdapps_table">
           <thead>
             <tr>
               <th class="text-center dark">MONTH</th>
               <th class="text-center light" >MIAKI REVENUE</th> 
               <th class="text-center dark" >MMLBD REVENUE</th>
               <th class="text-center light" >OTHER REVENUE</th>
               <th class="text-center dark">TOTAL REVENUE</th>
               <th class="text-center light">AVERAGE REVENUE</th>
             </tr> 
           </thead>
           <tbody>
             @foreach($month_wise_revenue_in_year AS $key => $val )     
             <tr>
               <th class="text-center day_list">{{ $number_wise_month[$key] }}</th>

               <th class="text-right"> 
                {{  number_format( $month_wise_revenue_in_year[$key]["miaki_revenue"]["rev"] ,2,'.',',') }}  

                @if( $month_wise_revenue_in_year[$key]["miaki_revenue"]["ind"] == 1 )
                    <i class="fa fa-arrow-up" style="color:green"></i>
                @elseif( $month_wise_revenue_in_year[$key]["miaki_revenue"]["ind"] == -1 )
                    <i class="fa fa-arrow-down" style="color:red"></i>
                @else
                    <i class="fa fa-arrows-h" style="color:orange"></i>
                @endif

               </th>
                 
               <th class="text-right"> 
                {{  number_format( $month_wise_revenue_in_year[$key]["mmlbd_revenue"]["rev"] ,2,'.',',') }}  

                @if( $month_wise_revenue_in_year[$key]["mmlbd_revenue"]["ind"] == 1 )
                    <i class="fa fa-arrow-up" style="color:green"></i>
                @elseif( $month_wise_revenue_in_year[$key]["mmlbd_revenue"]["ind"] == -1 )
                    <i class="fa fa-arrow-down" style="color:red"></i>
                @else
                    <i class="fa fa-arrows-h" style="color:orange"></i>
                @endif

               </th>


               <th class="text-right"> 
                {{  number_format( $month_wise_revenue_in_year[$key]["other_revenue"]["rev"] ,2,'.',',') }}  

                @if( $month_wise_revenue_in_year[$key]["other_revenue"]["ind"] == 1 )
                    <i class="fa fa-arrow-up" style="color:green"></i>
                @elseif( $month_wise_revenue_in_year[$key]["other_revenue"]["ind"] == -1 )
                    <i class="fa fa-arrow-down" style="color:red"></i>
                @else
                    <i class="fa fa-arrows-h" style="color:orange"></i>
                @endif

               </th> 

              
               <th class="text-right" style="font-size: 14px">

                 {{  number_format( $month_wise_revenue_in_year[$key]["total_revenue"]["rev"] ,2,'.',',') }}  

                 @if( $month_wise_revenue_in_year[$key]["total_revenue"]["ind"] == 1 )
                     <i class="fa fa-arrow-up" style="color:green"></i>
                 @elseif( $month_wise_revenue_in_year[$key]["total_revenue"]["ind"] == -1 )
                     <i class="fa fa-arrow-down" style="color:red"></i>
                 @else
                     <i class="fa fa-arrows-h" style="color:orange"></i>
                 @endif

               </th> 

               <th class="text-right" style="font-size: 14px">
                 {{  number_format( $month_wise_revenue_in_year[$key]["average_revenue"]["rev"] ,2,'.',',') }}

                 @if( $month_wise_revenue_in_year[$key]["average_revenue"]["ind"] == 1 )
                     <i class="fa fa-arrow-up" style="color:green"></i>
                 @elseif( $month_wise_revenue_in_year[$key]["average_revenue"]["ind"] == -1 )
                     <i class="fa fa-arrow-down" style="color:red"></i>
                 @else
                     <i class="fa fa-arrows-h" style="color:orange"></i>
                 @endif

               </th>

             </tr>
             @endforeach 
           </tbody>
         </table>
       <br><br>
      </div> 

    </div>   

    


    @endsection

    <script>
    window.onload = function() {

      var chart5 = new CanvasJS.Chart("chartContainer5", {
        animationEnabled: true,
        exportEnabled: true,
        backgroundColor:"#194e62",
        theme: "dark2",
        title: {
          text: "Miaki, Mmlbd and Total Revenue",
          fontSize:18
        },
        axisX: {
          valueFormatString: "DD MMM"
        },
        axisY2: {
          // title: "Revenue",
          prefix: "Tk",
          gridThickness: .3,
          // suffix: "K"
        },
        toolTip: {
          shared: true
        },
        legend: {
          cursor: "pointer",
          verticalAlign: "top",
          horizontalAlign: "center",
          dockInsidePlotArea: true,
          itemclick: toogleDataSeries
        },
        data: [{
          type:"line",
          axisYType: "secondary",
          name: "Total",
          showInLegend: true,
          markerSize: 13,
          lineThickness: 5,
          yValueFormatString: "$#,###k",
          xValueType: "dateTime",
          dataPoints: <?php echo json_encode($total_rev_array); ?>,
          lineColor: "#ffff99",
        },
        {
          type: "line",
          axisYType: "secondary",
          name: "Miaki",
          showInLegend: true,
          markerSize: 11,
          lineThickness: 3,
          yValueFormatString: "$#,###k",
          xValueType: "dateTime",
          dataPoints: <?php echo json_encode($total_miaki_array); ?>,
          lineColor: "#ffffff",
        },
        {
          type: "line",
          axisYType: "secondary",
          name: "Mmlbd",
          showInLegend: true,
          markerSize: 11,
          lineThickness: 3,
          yValueFormatString: "$#,###k",
          xValueType: "dateTime",
          dataPoints: <?php echo json_encode($total_mmlbd_array); ?>,
          lineColor:"#ffb3ff",
        }]
      });
      chart5.render();

      function toogleDataSeries(e){
        if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
          e.dataSeries.visible = false;
        } else{
          e.dataSeries.visible = true;
        }
        chart5.render();
      }







      
     
    var chart = new CanvasJS.Chart("chartContainer", {
      backgroundColor: "#480d85",
      animationEnabled: true,
      exportEnabled: true,
      theme: "dark2",
      title:{
        text: "Current Month's Revenue",
        fontColor: "#e2e100",
        fontSize:18
      },
      subtitles:[
          {
            text: <?php echo json_encode( number_format($current_month_total_revenue[0]['y']+$current_month_total_revenue[1]['y'],2,'.',',').' Tk'.'  ||  '.'Avg:'.number_format($avg_rev,2,'.',','), JSON_NUMERIC_CHECK); ?>,
            //Uncomment properties below to see how they behave
            fontColor: "#ffbb33",
            fontSize:16
          }
          ],
      axisY: {
        title: "",
        gridThickness: .3,
      },
      data: [{
        type: "column",
        color: "#846fd4",
        indexLabel: "{y}",
        yValueFormatString: "#,##0.## Tk",
        dataPoints: <?php echo json_encode($current_month_total_revenue, JSON_NUMERIC_CHECK); ?>
      }]
    });
    chart.render();


    var chart2 = new CanvasJS.Chart("chartContainer2", {
      backgroundColor: "#0f337b",
      animationEnabled: true,
      exportEnabled: true,
      theme: "dark2",
      title:{
        text: "Current Month's Forecast",
        fontColor: "#e2e100",
        fontSize:16
      },
      subtitles:[
          {
            text: <?php echo json_encode( number_format($current_month_forecast_revenue[0]['y']+$current_month_forecast_revenue[1]['y']+$current_month_forecast_revenue[2]['y'],2,'.',',').' Tk', JSON_NUMERIC_CHECK); ?>,
            //Uncomment properties below to see how they behave
            fontColor: "#ccffe6",
            fontSize:16
          }
          ],
      axisY: {
        title: "",
        gridThickness: .3,
      },
      data: [{
        type: "column",
        color: "#3c8ad1",
        indexLabel: "{y}",
        yValueFormatString: "#,##0.## Tk",
        dataPoints: <?php echo json_encode($current_month_forecast_revenue, JSON_NUMERIC_CHECK); ?>
      }]
    });
    chart2.render();


    var chart3 = new CanvasJS.Chart("chartContainer3", {
      backgroundColor: "#7e104c",
      animationEnabled: true,
      exportEnabled: true,
      theme: "dark2",
      title:{
        text: <?php echo json_encode($previous_month_revenue[1], JSON_NUMERIC_CHECK); ?>,
        fontColor: "#e2e100",
        fontSize:18
      },
      subtitles:[
          {
            text: <?php echo json_encode( 'Prev Month Rev: '.number_format($previous_month_revenue[0][0]['y']+$previous_month_revenue[0][1]['y'],2,'.',',').' Tk', JSON_NUMERIC_CHECK); ?>,
            //Uncomment properties below to see how they behave
            fontColor: "#66ff66",
            fontSize:16
          }
          ],
      axisY: {
        gridThickness: .3,
      },
      data: [{
        type: "column",
        color:"#cb649c",
        indexLabel: "{y}",
        yValueFormatString: "#,##0.## Tk",
        dataPoints: <?php echo json_encode($previous_month_revenue[0], JSON_NUMERIC_CHECK); ?>
      }]
    });
    chart3.render();
     
    }
    </script>

              