@extends('master')

    @section('title')
        Upload Apps Revenue
    @endsection

    @section('content_fluid')
    <div class="col-md-12">
        <br>
        @if (session('message')) 
        <div class="alert alert-success">
             <ul class="text-center"><li><a  class="close" data-dismiss="alert" aria-label="close">&times;</a>{{ session('message') }}</li></ul>
        </div>    
        @endif

        @if (session('message1')) 
        <div class="alert alert-danger">
             <ul class="text-center"><li><a  class="close" data-dismiss="alert" aria-label="close">&times;</a>{{ session('message1') }}</li></ul>
        </div>    
        @endif

        <div class="miaki_rev_div">
          <div class="row">
            <div class="col-md-3">

                <div class="daily_status_div">
                    <div class="panel panel-default">
                        <div class="panel-heading text-center">
                            Daily Status
                        </div>
                        <div class="panel-body">
                            <table class="table">
                                <tbody>
                                    <tr class="mobile_highlite">
                                        <td>Yesterday's Revenue</td>
                                        <td class="text-right">{{number_format($daily_status['yesday_rev'])}} Tk</td>
                                    </tr>
                                    <tr class="mobile_highlite">
                                        <td>Day Before Yesterday</td>
                                        <td class="text-right">{{number_format($daily_status['day_bef_yesday_rev'])}} Tk</td>
                                    </tr>
                                    <tr>
                                        <td>Increase/Decrease</td>
                                        <td class="text-right">
                                          @if( $daily_status['inc_dec'] > 0 )
                                              <i class="fa fa-arrow-up" style="font-size:12px; color:green"></i>
                                          @else
                                              <i class="fa fa-arrow-down" style="font-size:12px; color:red"></i>
                                          @endif
                                          {{$daily_status['inc_dec']}} %
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Daily Revenue Target</td>
                                        <td class="text-right">{{number_format($daily_status['daily_target'])}} Tk</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="monthly_status_div">
                    <div class="panel panel-default">
                        <div class="panel-heading text-center">
                            Monthly Status
                        </div>
                        <div class="panel-body">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>MTD Revenue</td>
                                        <td class="text-right">{{number_format($monthly_status['current_mon_rev'])}} Tk</td>
                                    </tr>
                                    <tr>
                                        <td>MTD Target</td>
                                        <td class="text-right">{{number_format($monthly_status['current_mon_target'])}} Tk</td>
                                    </tr>
                                    <tr>
                                        <td>MTD Achievement</td>
                                        <td class="text-right">{{number_format($monthly_status['current_mon_achiev'],2,'.',',')}} %</td>
                                    </tr>
                                    <tr>
                                        <td>Projection Revenue</td>
                                        <td class="text-right">{{number_format($monthly_status['projection_rev'])}} Tk</td>
                                    </tr>
                                    <tr>
                                        <td>Last Month's Revenue</td>
                                        <td class="text-right">{{number_format($monthly_status['previous_mon_rev'])}} Tk</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="yearly_status_div">
                    <div class="panel panel-default">
                        <div class="panel-heading text-center">
                            Yearly Status
                        </div>
                        <div class="panel-body">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>YTD Revenue</td>
                                        <td class="text-right">{{number_format($yearly_status['current_year_rev'])}} Tk</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <div class="account_status_div">
                    <div class="panel panel-default">
                        <div class="panel-heading text-center">
                            Account-wise Status
                        </div>
                        <div class="panel-body">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>Miaki Rev On Yesterday</td>
                                        <td class="text-right">
                                        @if(array_key_exists('Miaki',$account_wise_status['yesterday_rev_array']) && array_key_exists('Miaki',$account_wise_status['day_bef_yesterday_rev_array'])) 

                                            @if( $account_wise_status['yesterday_rev_array']['Miaki'] > $account_wise_status['day_bef_yesterday_rev_array']['Miaki'] )
                                                <i class="fa fa-arrow-up" style="font-size:12px; color:green"></i>
                                            @else
                                                <i class="fa fa-arrow-down" style="font-size:12px; color:red"></i>
                                            @endif 

                                        @endif
                                         
                                        @if( array_key_exists('Miaki',$account_wise_status['yesterday_rev_array']) )
                                            
                                            {{ number_format($account_wise_status['yesterday_rev_array']['Miaki']) }} Tk

                                        @endif    
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>MMLBD Rev On Yesterday</td>
                                        <td class="text-right">
                                        @if(array_key_exists('MMLBD',$account_wise_status['yesterday_rev_array']) && array_key_exists('MMLBD',$account_wise_status['day_bef_yesterday_rev_array']))
                                            
                                            @if( $account_wise_status['yesterday_rev_array']['MMLBD'] > $account_wise_status['day_bef_yesterday_rev_array']['MMLBD'] )
                                                <i class="fa fa-arrow-up" style="font-size:12px; color:green"></i>
                                            @else
                                                <i class="fa fa-arrow-down" style="font-size:12px; color:red"></i>
                                            @endif

                                        @endif
                                        
                                        @if( array_key_exists('MMLBD',$account_wise_status['yesterday_rev_array']) )

                                            {{ number_format($account_wise_status['yesterday_rev_array']['MMLBD']) }} Tk

                                        @endif    
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Other Rev On Yesterday</td>
                                        <td class="text-right">
                                        @if(array_key_exists('Other',$account_wise_status['yesterday_rev_array']) && array_key_exists('Other',$account_wise_status['day_bef_yesterday_rev_array']))
                                            
                                            @if( $account_wise_status['yesterday_rev_array']['Other'] > $account_wise_status['day_bef_yesterday_rev_array']['Other'] )
                                                <i class="fa fa-arrow-up" style="font-size:12px; color:green"></i>
                                            @else
                                                <i class="fa fa-arrow-down" style="font-size:12px; color:red"></i>
                                            @endif

                                        @endif
                                        
                                        @if( array_key_exists('Other',$account_wise_status['yesterday_rev_array']) )

                                            {{ number_format($account_wise_status['yesterday_rev_array']['Other']) }} Tk

                                        @endif    
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

               

            </div>
            <div class="col-md-6" style="padding-left: 0px; padding-right: 0px">
                <div id="day_wise_revenue_in_current_month" style="height: 300px; width: 100%; display: none"></div>
                <!-- <br> -->
                <div id="day_wise_revenue_in_current_month_stacked" style="height: 300px; width: 100%;"></div>
                <br>
                <div id="month_wise_revenue_in_current_year" style="height: 275px; width: 100%;"></div>  
            </div>
            <div class="col-md-3">
                
                <div class="yesterday_status_div">
                    <div class="panel panel-default">
                        <div class="panel-heading text-center">
                            Yesterday's Top Apps
                        </div>
                        <div class="panel-body">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>Ranking</th>
                                        <th>App Name</th>
                                        <th class="text-center">Revenue</th>
                                    </tr>
                                    @foreach($yesterdays_top_5_apps['yesterday_apps'] as $key => $val)
                                    <tr>
                                        <td>{{++$loop->index}}</td>
                                        <td>{{$key}}</td>
                                        <td class="text-right">  
                                            {{ number_format($val) }}
                                            @if( array_key_exists($key,$yesterdays_top_5_apps['day_bef_yesterday_apps']) )
                                              @if( $val > $yesterdays_top_5_apps['day_bef_yesterday_apps'][$key] )
                                                  <i class="fa fa-arrow-up" style="font-size:12px; color:green"></i>
                                              @else
                                                  <i class="fa fa-arrow-down" style="font-size:12px; color:red"></i>
                                              @endif 
                                            @endif
                                        </td>
                                    </tr>    
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="last_month_status_div">
                    <div class="panel panel-default">
                        <div class="panel-heading text-center">
                            Last Month's Top App
                        </div>
                        <div class="panel-body">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>Ranking</th>
                                        <th>App Name</th>
                                        <th class="text-center">Revenue</th>
                                    </tr>
                                    @foreach($last_months_top_5_apps['last_month_app'] as $key => $val)
                                    <tr>
                                        <td>{{++$loop->index}}</td>
                                        <td>{{$key}}</td>
                                        <td class="text-right">  
                                            {{ number_format($val) }}
                                            @if( array_key_exists($key,$last_months_top_5_apps['last_2_month_app']) )
                                              @if( $val > $last_months_top_5_apps['last_2_month_app'][$key] )
                                                  <i class="fa fa-arrow-up" style="font-size:12px; color:green"></i>
                                              @else
                                                  <i class="fa fa-arrow-down" style="font-size:12px; color:red"></i>
                                              @endif 
                                            @endif
                                        </td>
                                    </tr>    
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="comparison_status_div">
                    <div class="panel panel-default">
                        <div class="panel-heading text-center">
                            Revenue Trend Change Comparison
                        </div>
                        <div class="panel-body">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>Status</th>
                                        <th class="text-center">Count</th>
                                    </tr>
                                    @foreach($revenue_trend_comparison as $key => $val)
                                    <tr>
                                        <td>{{ ucwords($key) }}</td>
                                        <td class="text-right">    
                                            {{ number_format($val) }}
                                            @if($key=='increased')
                                                <i class="fa fa-arrow-up" style="font-size:12px; color:green"></i>
                                            @elseif($key=='decreased')
                                                <i class="fa fa-arrow-down" style="font-size:12px; color:red"></i>
                                            @else
                                                <i class="fa fa-arrows-h" style="font-size:12px; color:blue"></i>
                                            @endif
                                        </td>
                                    </tr>    
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
          </div>
        </div>

 
    </div>
    @endsection
    <script>
        window.onload = function () {
         
            var day_wise_rev_in_month = new CanvasJS.Chart("day_wise_revenue_in_current_month", {
                animationEnabled: true,
                backgroundColor: "#f2f2f2",
                exportEnabled: true,
                theme: "light2", // "light1", "light2", "dark1", "dark2"
                title: {
                    text: "Current Month Revenue",
                    fontSize: 18,
                    padding: 5,
                },
                axisY: {
                    title: "Revenue",
                    includeZero: false,
                    interval: 3000,
                    minimum: 98000,
                    suffix: " Tk",
                },
                data: [{
                    type: "column",
                    indexLabel: "{y}",
                    indexLabelPlacement: "inside",
                    indexLabelOrientation: "vertical",
                    indexLabelFontColor: "black",
                    dataPoints: <?php echo json_encode($day_wise_revenue_in_month, JSON_NUMERIC_CHECK); ?>
                }]
            });
            day_wise_rev_in_month.render();


            var day_wise_rev_in_month_stacked = new CanvasJS.Chart("day_wise_revenue_in_current_month_stacked", {

                backgroundColor: "#f2f2f2",
                exportEnabled: true,
                title: {
                    text: "Current Month Revenue",
                    fontSize: 18,
                    padding: 5,
                },
                theme: "light2",
                animationEnabled: true,
                toolTip:{
                    shared: true,
                    reversed: true
                },
                axisY: {
                    title: "Revenue",
                    interval: 15000,
                    suffix: " Tk"
                },
                legend: {
                    cursor: "pointer",
                    itemclick: toggleDataSeries
                },
                data: [
                    {
                        type: "stackedColumn",
                        name: "Other",
                        showInLegend: true,
                        yValueFormatString: "#,##0 Tk",
                        dataPoints: <?php echo json_encode($day_wise_revenue_in_month_v2['other'], JSON_NUMERIC_CHECK); ?>
                    },
                    {
                        type: "stackedColumn",
                        name: "Miaki",
                        showInLegend: true,
                        yValueFormatString: "#,##0 Tk",
                        dataPoints: <?php echo json_encode($day_wise_revenue_in_month_v2['miaki'], JSON_NUMERIC_CHECK); ?>
                    },{
                        type: "stackedColumn",
                        name: "Mmlbd",
                        showInLegend: true,
                        yValueFormatString: "#,##0 Tk",
                        indexLabel: "#total",
                        indexLabelPlacement: "inside",
                        indexLabelOrientation: "vertical",
                        indexLabelFontColor: "black",
                        indexLabelFontSize: 13,
                        indexLabelFontWeight: "bold",
                        dataPoints: <?php echo json_encode($day_wise_revenue_in_month_v2['mmlbd'], JSON_NUMERIC_CHECK); ?>
                    }
                ]
            });
            day_wise_rev_in_month_stacked.render();
             
            function toggleDataSeries(e) {
                if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                    e.dataSeries.visible = false;
                } else {
                    e.dataSeries.visible = true;
                }
                e.day_wise_rev_in_month_stacked.render();
            }


            var month_wise_rev_in_year = new CanvasJS.Chart("month_wise_revenue_in_current_year", {
                animationEnabled: true,
                backgroundColor: "#f5f5f0",
                exportEnabled: true,
                theme: "light2", // "light1", "light2", "dark1", "dark2"
                title: {
                    text: "Current Year Revenue",
                    fontSize: 18,
                    padding: 5,
                },
                axisY: {
                    title: "Revenue",
                    includeZero: true,
                    suffix: " Tk",
                },
                data: [{
                    type: "column",
                    indexLabel: "{y}",
                    indexLabelPlacement: "inside",
                    indexLabelOrientation: "vertical",
                    indexLabelFontColor: "white",
                    dataPoints: <?php echo json_encode($month_wise_revenue_in_year, JSON_NUMERIC_CHECK); ?>
                }]
            });
            month_wise_rev_in_year.render();
         
        }
    </script>