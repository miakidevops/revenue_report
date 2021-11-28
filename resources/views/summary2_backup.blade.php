@extends('master')
    
    @section('title')
        Home
    @endsection



    @section('content')
    <div class="col-md-12">
      <div class="home-page">
        <h3 class="text-center month"><b> last 30 days revenue summary(dynamic) </b></h3>
        <div class="service_type_rev">
          <table class="table table-striped table-bordered">
              <thead>
                  <tr>
                      <th class="text-center">Name</th>
                      <th class="text-center">Total Revenue</th>
                      <th class="text-center">Miaki Revenue</th>
                  </tr>
              </thead>
              <tbody>
                  @php  
                      $total_rev_sum = 0;
                      $miaki_rev_sum = 0;
                  @endphp
                  @foreach($service_type_data as $data)
                  <tr>
                      <td class="text-center">{{$data->service_type}}</td>
                      <td class="text-right">{{number_format($data->total_rev,2)}}</td>
                      <td class="text-right">{{number_format($data->miaki_rev,2)}}</td>
                      @php  
                          $total_rev_sum += $data->total_rev;
                          $miaki_rev_sum += $data->miaki_rev;
                      @endphp
                  </tr>
                  @endforeach

                  <tr>
                      <th class="text-center">Total</th>
                      <th class="text-right">{{number_format($total_rev_sum,2)}}</th>
                      <th class="text-right">{{number_format($miaki_rev_sum,2)}}</th>
                  </tr>
              </tbody>
          </table>
        </div>


        <!-- :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
        :::::::::::::::::::::shortcode wise last 7 days revenue::::::::::::::::::::::::::
        ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: -->

        <div class="Shortcode_Wise_Revenue" style="margin-top:60px">
          <h3 class="text-center" style="padding-bottom:10px"><ins><b>Shortcode Wise Last 7 Days Revenue</b></ins></h3>
          <div class="table-responsive">
            <table class="table table-hover table-bordered table-condensed">
                <thead>
                    <tr> 
                        <th>Date</th>
                        @for( $i = 0; $i < count($short_code); $i++ )
                            <th class="text-right">{{$short_code[$i]->shortcode}}</th> 
                        @endfor
                        <th class="text-right">Total</th>
                    </tr> 
                </thead>
                <tbody>
                @for( $i = 0; $i < 7; $i++ )
                    <tr>
                        <td>{{$seven_day[$i]}}</td>
                        @for( $j = 0; $j < count($short_code); $j++ )
                            <td class="text-right">
                            @if($i<6)
                                @if($shortcode_rev_7[$i][$j] > $shortcode_rev_7[$i+1][$j])
                                    <i class="fa fa-arrow-up" style="color:green"></i>
                                @elseif($shortcode_rev_7[$i][$j] < $shortcode_rev_7[$i+1][$j])
                                    <i class="fa fa-arrow-down" style="color:red"></i>
                                @endif
                            @endif
                            {{number_format($shortcode_rev_7[$i][$j], 2, '.', ',')  }}
                            </td> 
                        @endfor
                            <td class="text-right">
                            @if($i<6)
                                @if($seven_days_total_rev[$i] > $seven_days_total_rev[$i+1])
                                    <i class="fa fa-arrow-up" style="color:green;font-size:14px"></i>
                                @elseif($seven_days_total_rev[$i]<$seven_days_total_rev[$i+1])
                                    <i class="fa fa-arrow-down" style="color:red;font-size:14px"></i>
                                @endif
                            @endif
                                <b>{{number_format($seven_days_total_rev[$i],2,'.',',')}}</b>
                        </td>

                    </tr>
                @endfor
                </tbody>
            </table>
          </div>
        </div>
        

        
        <br>
        <h3 class="text-center"><b> Last 15 Days Revenue: </b></h3>
        <br>
        <div id="miaki_robi_vas_revenue_daly" style="height: 330px; width: 100%;"></div>
        <br><br>


        <div class="monthly-revenue">
            <br>
            <h3 class="text-center"><b> Last 4 Months Revenue: </b></h3>
            <br>
            <div class="row">
                <div class="col-md-4 col-xs-12 media_query_graph">
                      <div id="current_month_revenue" style="height: 330px; width: 100%;"></div>
                </div>
                <div class="col-md-3 col-xs-12 media_query_graph">
                      <div id="current_month_revenue_forecast" style="height: 330px; width: 100%;"></div>
                </div>
                <div class="col-md-5 col-xs-12 media_query_graph">
                      <div id="miaki_revenue_monthly_last_4_month" style="height: 330px; width: 100%;"></div>
                </div>
            </div>
        

        <!-- last 3 months revenue by company wise:::::: -->
       
          <div class="row" style="padding-top:30px; padding-bottom: 50px">
             <div class="col-md-4 col-xs-12 media_query_graph">
                 <div id="last_month_1_revenue" style="height: 330px; width: 100%;"></div>
             </div>

             <div class="col-md-4 col-xs-12 media_query_graph">
                 <div id="last_month_2_revenue" style="height: 330px; width: 100%;"></div>
             </div>

             <div class="col-md-4 col-xs-12 media_query_graph">
                 <div id="last_month_3_revenue" style="height: 330px; width: 100%;"></div>
             </div>
          </div>


      </div>

      <div class="row">
        <div class="col-md-12">
          <h3 class="text-center" style="padding-bottom: 20px"> <b><ins>Shortcode and Company Wise Revenue</ins></b> </h3>
        </div>
        <div class="col-md-6 col-xs-12 media_query_graph">
            <div id="shortcode_wise_current_month_rev" style="height: 330px; width: 100%;"></div>
        </div>
        <div class="col-md-6 col-xs-12 media_query_graph">
            <div id="shortcode_wise_previous_month_rev" style="height: 330px; width: 100%;"></div>
        </div>
      </div>
     </div>
    </div>

    <script type="text/javascript">
      window.onload = function() { 
        var miaki_robi_vas_revenue_daly = new CanvasJS.Chart("miaki_robi_vas_revenue_daly", {
          animationEnabled: true,
          exportEnabled: true,
          theme: "dark2",
          backgroundColor:"#1f1f14",
          title:{
            text: "Miaki Robi Vas Revenue (Daily)",
            fontSize:20
          },
          axisY: {
            title: "per day revenue (Tk)"
          },
          data: [{
            type: "column",
            indexLabel: "{y}",
            // indexLabelPlacement: "inside",
            indexLabelOrientation: "vertical",
            indexLabelFontWeight: "bolder",
            yValueFormatString: "#,##0.## Tk",
            dataPoints: <?php echo json_encode($ten_days_total_rev, JSON_NUMERIC_CHECK); ?>
          }]
        });
        miaki_robi_vas_revenue_daly.render(); 

        // company wise revenue current month ::::::::::::::::::;


        var current_month_revenue = new CanvasJS.Chart("current_month_revenue", {
          backgroundColor: "#004d2e",
          animationEnabled: true,
          exportEnabled: true,
          theme: "dark2",
          title:{
            text: "Current Month",
            fontSize:20

          },


          axisY: {
            title: "Current Month Revenue (Tk)"
          },
          axisX:{
              labelMaxWidth: 80,  
              labelWrap: true
           },
          data: [{
            type: "column",
            indexLabel: "{y}",
            // indexLabelPlacement: "inside",
            
            indexLabelFontWeight: "bolder",
            yValueFormatString: "#,##0.## Tk",
            dataPoints: <?php echo json_encode($rev_data[0], JSON_NUMERIC_CHECK); ?>
          }]
        });
        current_month_revenue.render();


        var current_month_revenue_forecast = new CanvasJS.Chart("current_month_revenue_forecast", {
          animationEnabled: true,
          exportEnabled: true,
          theme: "dark2",
          title:{
            text: "Forecasted Rev",
            fontSize:20
          },

          subtitles:[
              {
                text: <?php echo json_encode( number_format($rev_data[2],2,'.',',').' Tk', JSON_NUMERIC_CHECK); ?>,
                //Uncomment properties below to see how they behave
                fontColor: "#ffff66",
                fontSize:18
              }
              ],
          axisY: {
            title: "Tk"
          },
          data: [{
            type: "column",
            indexLabel: "{y}",
             // indexLabelPlacement: "inside",
             indexLabelFontWeight: "bolder",
            yValueFormatString: "#,##0.## Tk",
            dataPoints: <?php echo json_encode($rev_data[1], JSON_NUMERIC_CHECK); ?>
          }]
        });
        current_month_revenue_forecast.render();


        var miaki_revenue_monthly_last_4_month = new CanvasJS.Chart("miaki_revenue_monthly_last_4_month", {
          animationEnabled: true,
          exportEnabled: true,
          theme: "dark2",
          title:{
            text: "Miaki Revenue (Monthly)",
            fontSize:20
          },
          axisY: {
            title: "per month revenue (Tk)"
          },
          data: [{
            type: "column",
            indexLabel: "{y}",
             // indexLabelPlacement: "inside",
             // indexLabelOrientation: "vertical",
             indexLabelFontWeight: "bolder",
            yValueFormatString: "#,##0.## Tk",
            dataPoints: <?php echo json_encode($month_wise_miaki_rev, JSON_NUMERIC_CHECK); ?>
          }]
        });
        miaki_revenue_monthly_last_4_month.render();


        // company wise revenue last 3 months:
        var last_month_1_revenue = new CanvasJS.Chart("last_month_1_revenue", {
          backgroundColor: "#392613",
          animationEnabled: true,
          exportEnabled: true,
          theme: "dark2",
          title:{
            text: <?php echo json_encode($month_wise_and_comp_wise_rev[1][0]['month'], JSON_NUMERIC_CHECK); ?>,
            fontColor: "#e6e600",
            fontSize:20
          },
          subtitles:[
              {
                text: <?php echo json_encode(number_format($month_wise_and_comp_wise_rev[0][$month_wise_and_comp_wise_rev[1][0]['ind']][0]['y']+$month_wise_and_comp_wise_rev[0][$month_wise_and_comp_wise_rev[1][0]['ind']][1]['y']+$month_wise_and_comp_wise_rev[0][$month_wise_and_comp_wise_rev[1][0]['ind']][2]['y'],2,'.',',')." Tk", JSON_NUMERIC_CHECK); ?>,
                //Uncomment properties below to see how they behave
                fontColor: "#ffbb33",
                fontSize:18
              }
              ],
          axisY: {
            title: "Previous Month Revenue (Tk)"
          },
          axisX:{
              labelMaxWidth: 68,  
              labelWrap: true
           },
          data: [{
            type: "column",
            indexLabel: "{y}",
            // indexLabelPlacement: "inside",
            
            indexLabelFontWeight: "bolder",
            yValueFormatString: "#,##0.## Tk",
            dataPoints: <?php echo json_encode($month_wise_and_comp_wise_rev[0][$month_wise_and_comp_wise_rev[1][0]['ind']], JSON_NUMERIC_CHECK); ?>
          }]
        });
        last_month_1_revenue.render();


        var last_month_2_revenue = new CanvasJS.Chart("last_month_2_revenue", {
          backgroundColor: "#392613",
          animationEnabled: true,
          exportEnabled: true,
          theme: "dark2",
          title:{
            text: <?php echo json_encode($month_wise_and_comp_wise_rev[1][1]['month'], JSON_NUMERIC_CHECK); ?>,
            fontColor: "#e6e600",
            fontSize:20
          },
          subtitles:[
              {
                text: <?php echo json_encode(number_format($month_wise_and_comp_wise_rev[0][$month_wise_and_comp_wise_rev[1][1]['ind']][0]['y']+$month_wise_and_comp_wise_rev[0][$month_wise_and_comp_wise_rev[1][1]['ind']][1]['y']+$month_wise_and_comp_wise_rev[0][$month_wise_and_comp_wise_rev[1][1]['ind']][2]['y'],2,'.',',')." Tk", JSON_NUMERIC_CHECK); ?>,
                //Uncomment properties below to see how they behave
                fontColor: "#ffbb33",
                fontSize:18
              }
              ],
          axisY: {
            title: "Previous Month Revenue (Tk)"
          },
          axisX:{
              labelMaxWidth: 68,  
              labelWrap: true
           },
          data: [{
            type: "column",
            indexLabel: "{y}",
            // indexLabelPlacement: "inside",
            
            indexLabelFontWeight: "bolder",
            yValueFormatString: "#,##0.## Tk",
            dataPoints: <?php echo json_encode($month_wise_and_comp_wise_rev[0][$month_wise_and_comp_wise_rev[1][1]['ind']], JSON_NUMERIC_CHECK); ?>
          }]
        });
        last_month_2_revenue.render();


        var last_month_3_revenue = new CanvasJS.Chart("last_month_3_revenue", {
          backgroundColor: "#392613",
          animationEnabled: true,
          exportEnabled: true,
          theme: "dark2",
          title:{
            text: <?php echo json_encode($month_wise_and_comp_wise_rev[1][2]['month'], JSON_NUMERIC_CHECK); ?>,
            fontColor: "#e6e600",
            fontSize:20
          },
          subtitles:[
              {
                text: <?php echo json_encode(number_format($month_wise_and_comp_wise_rev[0][$month_wise_and_comp_wise_rev[1][2]['ind']][0]['y']+$month_wise_and_comp_wise_rev[0][$month_wise_and_comp_wise_rev[1][2]['ind']][1]['y']+$month_wise_and_comp_wise_rev[0][$month_wise_and_comp_wise_rev[1][2]['ind']][2]['y'],2,'.',',')." Tk", JSON_NUMERIC_CHECK); ?>,
                //Uncomment properties below to see how they behave
                fontColor: "#ffbb33",
                fontSize:18
              }
              ],
          axisY: {
            title: "Previous Month Revenue (Tk)"
          },
          axisX:{
              labelMaxWidth: 68,  
              labelWrap: true
           },
          data: [{
            type: "column",
            indexLabel: "{y}",
            // indexLabelPlacement: "inside",
            
            indexLabelFontWeight: "bolder",
            yValueFormatString: "#,##0.## Tk",
            dataPoints: <?php echo json_encode($month_wise_and_comp_wise_rev[0][$month_wise_and_comp_wise_rev[1][2]['ind']], JSON_NUMERIC_CHECK); ?>
          }]
        });
        last_month_3_revenue.render();




        var shortcode_wise_current_month_rev = new CanvasJS.Chart("shortcode_wise_current_month_rev", {
          animationEnabled: true,
          exportEnabled: true,
          backgroundColor:"#ecd9c6",
          theme: "light1", // "light1", "light2", "dark1", "dark2"
          title:{
            text: "Current Month",
            fontSize: 18
          },
          axisX:{
            reversed: true
          },
          toolTip:{
            shared: true
          },
          data: [{
            type: "stackedBar",
            name: <?php echo json_encode($company_and_shortcode_wise_rev[1][0], JSON_NUMERIC_CHECK); ?>,
            dataPoints: <?php echo json_encode($company_and_shortcode_wise_rev[0][20000], JSON_NUMERIC_CHECK); ?>
          },{
            type: "stackedBar",
            name: <?php echo json_encode($company_and_shortcode_wise_rev[1][1], JSON_NUMERIC_CHECK); ?>,
            dataPoints: <?php echo json_encode($company_and_shortcode_wise_rev[0][21272], JSON_NUMERIC_CHECK); ?>
          },{
            type: "stackedBar",
            name: <?php echo json_encode($company_and_shortcode_wise_rev[1][2], JSON_NUMERIC_CHECK); ?>,
            dataPoints: <?php echo json_encode($company_and_shortcode_wise_rev[0][21282], JSON_NUMERIC_CHECK); ?>
          },{
            type: "stackedBar",
            name: <?php echo json_encode($company_and_shortcode_wise_rev[1][3], JSON_NUMERIC_CHECK); ?>,
            dataPoints: <?php echo json_encode($company_and_shortcode_wise_rev[0][3636], JSON_NUMERIC_CHECK); ?>
          },{
            type: "stackedBar",
            name: <?php echo json_encode($company_and_shortcode_wise_rev[1][4], JSON_NUMERIC_CHECK); ?>,
            dataPoints: <?php echo json_encode($company_and_shortcode_wise_rev[0][16295], JSON_NUMERIC_CHECK); ?>
          },{
            type: "stackedBar",
            name: <?php echo json_encode($company_and_shortcode_wise_rev[1][5], JSON_NUMERIC_CHECK); ?>,
            dataPoints: <?php echo json_encode($company_and_shortcode_wise_rev[0][3131], JSON_NUMERIC_CHECK); ?>
          },{
            type: "stackedBar",
            name: <?php echo json_encode($company_and_shortcode_wise_rev[1][6], JSON_NUMERIC_CHECK); ?>,
            dataPoints: <?php echo json_encode($company_and_shortcode_wise_rev[0][9090], JSON_NUMERIC_CHECK); ?>
          },{
            type: "stackedBar",
            name: <?php echo json_encode($company_and_shortcode_wise_rev[1][7], JSON_NUMERIC_CHECK); ?>,
            dataPoints: <?php echo json_encode($company_and_shortcode_wise_rev[0][21281], JSON_NUMERIC_CHECK); ?>
          },{
            type: "stackedBar",
            name: <?php echo json_encode($company_and_shortcode_wise_rev[1][8], JSON_NUMERIC_CHECK); ?>,
            indexLabel: "#total",
            indexLabelPlacement: "outside",
            indexLabelFontSize: 15,
            indexLabelFontWeight: "bold",
            dataPoints: <?php echo json_encode($company_and_shortcode_wise_rev[0][27676], JSON_NUMERIC_CHECK); ?>
          }]
        });
        shortcode_wise_current_month_rev.render();




        var shortcode_wise_previous_month_rev = new CanvasJS.Chart("shortcode_wise_previous_month_rev", {
          animationEnabled: true,
          exportEnabled: true,
          backgroundColor: "#e6ccb3",
          theme: "light1", // "light1", "light2", "dark1", "dark2"
          title:{
            text: "Previous Month",
            fontSize: 18
          },
          axisX:{
            reversed: true
          },
          toolTip:{
            shared: true
          },
          data: [{
            type: "stackedBar",
            name: <?php echo json_encode($company_and_shortcode_wise_rev_pre[1][0], JSON_NUMERIC_CHECK); ?>,
            dataPoints: <?php echo json_encode($company_and_shortcode_wise_rev_pre[0][20000], JSON_NUMERIC_CHECK); ?>
          },{
            type: "stackedBar",
            name: <?php echo json_encode($company_and_shortcode_wise_rev_pre[1][1], JSON_NUMERIC_CHECK); ?>,
            dataPoints: <?php echo json_encode($company_and_shortcode_wise_rev_pre[0][21272], JSON_NUMERIC_CHECK); ?>
          },{
            type: "stackedBar",
            name: <?php echo json_encode($company_and_shortcode_wise_rev_pre[1][2], JSON_NUMERIC_CHECK); ?>,
            dataPoints: <?php echo json_encode($company_and_shortcode_wise_rev_pre[0][21282], JSON_NUMERIC_CHECK); ?>
          },{
            type: "stackedBar",
            name: <?php echo json_encode($company_and_shortcode_wise_rev_pre[1][3], JSON_NUMERIC_CHECK); ?>,
            dataPoints: <?php echo json_encode($company_and_shortcode_wise_rev_pre[0][3636], JSON_NUMERIC_CHECK); ?>
          },{
            type: "stackedBar",
            name: <?php echo json_encode($company_and_shortcode_wise_rev_pre[1][4], JSON_NUMERIC_CHECK); ?>,
            dataPoints: <?php echo json_encode($company_and_shortcode_wise_rev_pre[0][16295], JSON_NUMERIC_CHECK); ?>
          },{
            type: "stackedBar",
            name: <?php echo json_encode($company_and_shortcode_wise_rev_pre[1][5], JSON_NUMERIC_CHECK); ?>,
            dataPoints: <?php echo json_encode($company_and_shortcode_wise_rev_pre[0][3131], JSON_NUMERIC_CHECK); ?>
          },{
            type: "stackedBar",
            name: <?php echo json_encode($company_and_shortcode_wise_rev_pre[1][6], JSON_NUMERIC_CHECK); ?>,
            dataPoints: <?php echo json_encode($company_and_shortcode_wise_rev_pre[0][9090], JSON_NUMERIC_CHECK); ?>
          },{
            type: "stackedBar",
            name: <?php echo json_encode($company_and_shortcode_wise_rev_pre[1][7], JSON_NUMERIC_CHECK); ?>,
            dataPoints: <?php echo json_encode($company_and_shortcode_wise_rev_pre[0][21281], JSON_NUMERIC_CHECK); ?>
          },{
            type: "stackedBar",
            name: <?php echo json_encode($company_and_shortcode_wise_rev_pre[1][8], JSON_NUMERIC_CHECK); ?>,
            indexLabel: "#total",
            indexLabelPlacement: "outside",
            indexLabelFontSize: 15,
            indexLabelFontWeight: "bold",
            dataPoints: <?php echo json_encode($company_and_shortcode_wise_rev_pre[0][27676], JSON_NUMERIC_CHECK); ?>
          }]
        });
        shortcode_wise_previous_month_rev.render();
    }
    </script>
    @endsection