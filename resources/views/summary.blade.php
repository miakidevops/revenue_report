@extends('master')
    
        @section('title')
          SUMMARY
        @endsection



        @section('content')
        <?php
          $dataPoints = array( 
            array("y" => $week1_result, "label" => "Week1 ($week1_first <-> $week1_last)" ),
            array("y" => $week2_result, "label" => "Week2 ($week2_first <-> $week2_last)" ),
            array("y" => $week3_result, "label" => "Week3 ($week3_first <-> $week3_last)" ),
            array("y" => $week4_result, "label" => "Week4 ($week4_first <-> $week4_last)" )
          );

         
        // company wise last 7 days revenue::::
           
           $dataPoints2 = array( 
             array("y" => $company_wise_revenue[0]->miaki_rev, "label" => $company_wise_revenue[0]->company_name ),
             array("y" => $company_wise_revenue[1]->miaki_rev, "label" => $company_wise_revenue[1]->company_name ),
             array("y" => $company_wise_revenue[2]->miaki_rev, "label" => $company_wise_revenue[2]->company_name )
           );


       // monthly calculation :::
         $dataPoints6 = array( 
            
            array("y" => $forecast_btmv, "label" => "BTMV"),
            array("y" => $forecast_miaki_media, "label" => "Miaki_Media"),
            array("y" => $forecast_win_miaki, "label" => "WIN_Miaki")
          );

         $dataPoints3 = array( 
            array("y" => $month_1_result, "label" => "$month_name[0]"),
            array("y" => $month_2_result, "label" => "$month_name[1]"),
            array("y" => $month_3_result, "label" => "$month_name[2]"),
            array("y" => $month_4_result, "label" => "$month_name[3]")
          );
 
              
           

           // company wise revenue current month::::::::::;;;;
           if(empty($company_wise_revenue_30)){
             $dataPoints4 = array();
           }else{
             $dataPoints4 = array( 
               array("y" => $company_wise_revenue_30[0]->miaki_rev, "label" => $company_wise_revenue_30[0]->company_name ),
               array("y" => $company_wise_revenue_30[1]->miaki_rev, "label" => $company_wise_revenue_30[1]->company_name ),
               array("y" => $company_wise_revenue_30[2]->miaki_rev, "label" => $company_wise_revenue_30[2]->company_name )
             );

           }

          // last 3 months company wise revenue:::::::::::::::::::
            // last -1 month
          $dataPoints_1_4 = array( 
            array("y" => $company_wise_revenue_30_last_1[0]->miaki_rev, "label" => $company_wise_revenue_30_last_1[0]->company_name ),
            array("y" => $company_wise_revenue_30_last_1[1]->miaki_rev, "label" => $company_wise_revenue_30_last_1[1]->company_name ),
            array("y" => $company_wise_revenue_30_last_1[2]->miaki_rev, "label" => $company_wise_revenue_30_last_1[2]->company_name )
          );

            // last -2 month
          $dataPoints_2_4 = array( 
            array("y" => $company_wise_revenue_30_last_2[0]->miaki_rev, "label" => $company_wise_revenue_30_last_2[0]->company_name ),
            array("y" => $company_wise_revenue_30_last_2[1]->miaki_rev, "label" => $company_wise_revenue_30_last_2[1]->company_name ),
            array("y" => $company_wise_revenue_30_last_2[2]->miaki_rev, "label" => $company_wise_revenue_30_last_2[2]->company_name )
          );

            // last -3 month
          $dataPoints_3_4 = array( 
            array("y" => $company_wise_revenue_30_last_3[0]->miaki_rev, "label" => $company_wise_revenue_30_last_3[0]->company_name ),
            array("y" => $company_wise_revenue_30_last_3[1]->miaki_rev, "label" => $company_wise_revenue_30_last_3[1]->company_name ),
            array("y" => $company_wise_revenue_30_last_3[2]->miaki_rev, "label" => $company_wise_revenue_30_last_3[2]->company_name )
          );
          $dataPoints_1_4_sum=0;
          $dataPoints_2_4_sum=0;
          $dataPoints_3_4_sum=0;
            for($i=0;$i<3;$i++){
           $dataPoints_1_4_sum+=$company_wise_revenue_30_last_1[$i]->miaki_rev;
           $dataPoints_2_4_sum+=$company_wise_revenue_30_last_2[$i]->miaki_rev;
           $dataPoints_3_4_sum+=$company_wise_revenue_30_last_3[$i]->miaki_rev;

                               }
          // end of last 3 months company wise revenue::::::::::::
         

          // last 7 days total revenue graph:::

           $dataPoints5=array();

           for($i=0;$i<7;$i++)
           {
            
             $dataPoints5[$i]=array();
             $dataPoints5[$i]['y']=$seven_days_total_rev[$i];
             $dataPoints5[$i]['label']=$seven_day[$i]; 
           }



           $s_code1 = array(
            array("label"=> "BTMV", "y"=>$btmv_current_month[0]),
            array("label"=> "Miaki_Media", "y"=>$miaki_media_current_month[0]),
            array("label"=> "WIN_Miaki", "y"=>$win_miaki_current_month[0])
           );
            
           $s_code2 = array(
            array("label"=> "BTMV", "y"=>$btmv_current_month[1]),
            array("label"=> "Miaki_Media", "y"=>$miaki_media_current_month[1]),
            array("label"=> "WIN_Miaki", "y"=>$win_miaki_current_month[1])
           );

           $s_code3 = array(
            array("label"=> "BTMV", "y"=>$btmv_current_month[2]),
            array("label"=> "Miaki_Media", "y"=>$miaki_media_current_month[2]),
            array("label"=> "WIN_Miaki", "y"=>$win_miaki_current_month[2])
           );

           $s_code4 = array(
            array("label"=> "BTMV", "y"=>$btmv_current_month[3]),
            array("label"=> "Miaki_Media", "y"=>$miaki_media_current_month[3]),
            array("label"=> "WIN_Miaki", "y"=>$win_miaki_current_month[3])
           );

           $s_code5 = array(
            array("label"=> "BTMV", "y"=>$btmv_current_month[4]),
            array("label"=> "Miaki_Media", "y"=>$miaki_media_current_month[4]),
            array("label"=> "WIN_Miaki", "y"=>$win_miaki_current_month[4])
           );

           $s_code6 = array(
            array("label"=> "BTMV", "y"=>$btmv_current_month[5]),
            array("label"=> "Miaki_Media", "y"=>$miaki_media_current_month[5]),
            array("label"=> "WIN_Miaki", "y"=>$win_miaki_current_month[5])
           );

           $s_code7 = array(
            array("label"=> "BTMV", "y"=>$btmv_current_month[6]),
            array("label"=> "Miaki_Media", "y"=>$miaki_media_current_month[6]),
            array("label"=> "WIN_Miaki", "y"=>$win_miaki_current_month[6])
           );

           $s_code8 = array(
            array("label"=> "BTMV", "y"=>$btmv_current_month[7]),
            array("label"=> "Miaki_Media", "y"=>$miaki_media_current_month[7]),
            array("label"=> "WIN_Miaki", "y"=>$win_miaki_current_month[7])
           );
            
           $s_code9 = array(
            array("label"=> "BTMV", "y"=>$btmv_current_month[8]),
            array("label"=> "Miaki_Media", "y"=>$miaki_media_current_month[8]),
            array("label"=> "WIN_Miaki", "y"=>$win_miaki_current_month[8])
           );
           


           // ........previous month .....

           $s_code_p1 = array(
            array("label"=> "BTMV", "y"=>$btmv_previous_month[0]),
            array("label"=> "Miaki_Media", "y"=>$miaki_media_previous_month[0]),
            array("label"=> "WIN_Miaki", "y"=>$win_miaki_previous_month[0])
           );
            
           $s_code_p2 = array(
            array("label"=> "BTMV", "y"=>$btmv_previous_month[1]),
            array("label"=> "Miaki_Media", "y"=>$miaki_media_previous_month[1]),
            array("label"=> "WIN_Miaki", "y"=>$win_miaki_previous_month[1])
           );

           $s_code_p3 = array(
            array("label"=> "BTMV", "y"=>$btmv_previous_month[2]),
            array("label"=> "Miaki_Media", "y"=>$miaki_media_previous_month[2]),
            array("label"=> "WIN_Miaki", "y"=>$win_miaki_previous_month[2])
           );

           $s_code_p4 = array(
            array("label"=> "BTMV", "y"=>$btmv_previous_month[3]),
            array("label"=> "Miaki_Media", "y"=>$miaki_media_previous_month[3]),
            array("label"=> "WIN_Miaki", "y"=>$win_miaki_previous_month[3])
           );

           $s_code_p5 = array(
            array("label"=> "BTMV", "y"=>$btmv_previous_month[4]),
            array("label"=> "Miaki_Media", "y"=>$miaki_media_previous_month[4]),
            array("label"=> "WIN_Miaki", "y"=>$win_miaki_previous_month[4])
           );

           $s_code_p6 = array(
            array("label"=> "BTMV", "y"=>$btmv_previous_month[5]),
            array("label"=> "Miaki_Media", "y"=>$miaki_media_previous_month[5]),
            array("label"=> "WIN_Miaki", "y"=>$win_miaki_previous_month[5])
           );

           $s_code_p7 = array(
            array("label"=> "BTMV", "y"=>$btmv_previous_month[6]),
            array("label"=> "Miaki_Media", "y"=>$miaki_media_previous_month[6]),
            array("label"=> "WIN_Miaki", "y"=>$win_miaki_previous_month[6])
           );

           $s_code_p8 = array(
            array("label"=> "BTMV", "y"=>$btmv_previous_month[7]),
            array("label"=> "Miaki_Media", "y"=>$miaki_media_previous_month[7]),
            array("label"=> "WIN_Miaki", "y"=>$win_miaki_previous_month[7])
           );
            
           $s_code_p9 = array(
            array("label"=> "BTMV", "y"=>$btmv_previous_month[8]),
            array("label"=> "Miaki_Media", "y"=>$miaki_media_previous_month[8]),
            array("label"=> "WIN_Miaki", "y"=>$win_miaki_previous_month[8])
           );




                  
                    

          ?>

          


                         <div class="col-md-6 col-md-offset-3 col-xs-12">
                          <h3 class="text-center month"><b> last 30 days revenue summary(dynamic) </b></h3>

                           <table class="table table-hover">
                              <thead>
                                 <tr> 
                                  <th class="text-right"> Name </th>
                                  <th class="text-right"> Total Revenue </th>
                                  <th class="text-right"> Miaki Revenue </th>
                                 </tr> 
                              </thead>
                              <tbody>
                                <tr>
                                  <td class="text-right"> IVR </td>
                                  <td class="text-right"> {{number_format($ivr_amount['ivr_total_revenue'],2,'.',',')}} </td>
                                  <td class="text-right"> {{number_format($ivr_amount['ivr_miaki_revenue'],2,'.',',')}} </td>
                                </tr>
                                <tr>
                                  <td class="text-right"> SMS </td>
                                  <td class="text-right"> {{number_format($sms_amount['sms_total_revenue'],2,'.',',')}} </td>
                                  <td class="text-right"> {{number_format($sms_amount['sms_miaki_revenue'],2,'.',',')}} </td>
                                </tr>
                                <tr>
                                  <td class="text-right"> WAP </td>
                                  <td class="text-right"> {{number_format($wap_amount['wap_total_revenue'],2,'.',',')}} </td>
                                  <td class="text-right"> {{number_format($wap_amount['wap_miaki_revenue'],2,'.',',')}} </td>
                                </tr> 
                              </tbody>
                              <?php
                              $total_revenue=$ivr_amount['ivr_total_revenue']+$sms_amount['sms_total_revenue']+$wap_amount['wap_total_revenue'];
                              $total_revenue= number_format($total_revenue, 2, '.', ',');

                              $miaki_revenue=$ivr_amount['ivr_miaki_revenue']+$sms_amount['sms_miaki_revenue']+$wap_amount['wap_miaki_revenue'];
                              $miaki_revenue= number_format($miaki_revenue, 2, '.', ',');
                              ?>
                             
                              <tfoor>
                                <tr> 
                                  <th class="text-right"> total </th>
                                  <th class="text-right"> {{$total_revenue}} </th>
                                  <th class="text-right"> {{$miaki_revenue}} </th>
                                </tr> 
                              </tfoor>

                           </table>
                              <!-- <div class="row">
                                <div class="col-md-4 col-md-offset-4 col-xs-4 col-xs-offset-4 text-center">
                                    <a href="{{route('report.index')}}"><button type="button" class="btn btn-success nav-button right-bar"> go to detail <i class="fa fa-th-list" aria-hidden="true"></i></button></a>
                                  </div>
                               </div> 
                               <br><br><br>  --> 
                               <br>  
                         </div>


                         <div class="col-md-12">
                          <h3 class="text-center"><ins><b>Shortcode Wise Last 7 Days Revenue</b></ins></h3>
                            <table class="table table-hover">
                               <thead>
                                  <tr> 
                                   <th>Date</th>
                                    <?php for($i=0;$i<count($short_code);$i++){?>
                                    <th class="text-right">{{$short_code[$i]->shortcode}}</th> 
                                    <?php } ?>
                                    <th class="text-right">Total</th>
                                  </tr> 
                               </thead>
                               <tbody>
                                 <?php for($i=0;$i<7;$i++){?>
                                 <tr>
                                   <td>{{$seven_day[$i]}}</td>
                                   <?php for($j=0;$j<count($short_code);$j++){?>
                                   <td class="text-right">
                                    <?php
                                     if($i<6){
                                      if($shortcode_rev_7[$i][$j]>$shortcode_rev_7[$i+1][$j]){
                                        ?>
                                          <i class="fa fa-arrow-up" style="color:green"></i>
                                        <?php
                                      }elseif($shortcode_rev_7[$i][$j]<$shortcode_rev_7[$i+1][$j]){
                                        ?>
                                         <i class="fa fa-arrow-down" style="color:red"></i>
                                        <?php
                                      }

                                      }
                                    ?>
                                   {{number_format($shortcode_rev_7[$i][$j], 2, '.', ',')  }}</td> 
                                   <?php } ?> 
                                   <td class="text-right">
                                    <?php
                                     if($i<6){
                                      if($seven_days_total_rev[$i]>$seven_days_total_rev[$i+1]){
                                        ?>
                                          <i class="fa fa-arrow-up" style="color:green;font-size:14px"></i>
                                        <?php
                                      }elseif($seven_days_total_rev[$i]<$seven_days_total_rev[$i+1]){
                                        ?>
                                         <i class="fa fa-arrow-down" style="color:red;font-size:14px"></i>
                                        <?php
                                      }

                                      }?>


                                   <b> {{number_format($seven_days_total_rev[$i],2,'.',',')}}</b></td>
                                </tr>
                                 <?php } ?>
                               </tbody>
                             </table>
                         </div>


             <div class="col-md-8 col-xs-12 col-md-offset-2">
                   <br><br>
                   <h3 class="text-center"><b> Last 7 Days Revenue: </b></h3>
                   <br>
                   <div id="chartContainer5" style="height: 330px; width: 100%;"></div>
                   <br><br>
             </div>
             


             <!-- weekly revenue : total taka -->
             <div class="col-md-12 col-xs-12">
                     
                     
                     <br>
             </div>


            <div class="col-md-6 col-xs-12">
                  <div id="chartContainer" style="height: 330px; width: 100%;"></div>
            </div>

            <div class="col-md-6 col-xs-12">
                  <div id="chartContainer2" style="height: 330px; width: 100%;"></div>
            </div>
      
             <!-- monthly revenue : total taka -->
             <div class="col-md-12 col-xs-12">
                     <br><br><br>
                     <h3 class="text-center"><b> Last 4 Months Revenue: </b></h3>
                     <br>
             </div>

            <div class="col-md-3 col-xs-12">
                 <div id="chartContainer6" style="height: 330px; width: 100%;"></div>
            </div>

            <div class="col-md-5 col-xs-12">
                
                  <div id="chartContainer3" style="height: 330px; width: 100%;"></div>
            </div> 

            <div class="col-md-4 col-xs-12">
                
                  <div id="chartContainer4" style="height: 330px; width: 100%;"></div>
                  <br>
            </div>  


            <!-- last 3 months revenue by company wise:::::: -->
            <div class="col-md-12">
              <div class="row">
                 <div class="col-md-4">
                     <div id="chartContainer_1_4" style="height: 330px; width: 100%;"></div>
                 </div>

                 <div class="col-md-4">
                     <div id="chartContainer_2_4" style="height: 330px; width: 100%;"></div>
                 </div>

                 <div class="col-md-4">
                     <div id="chartContainer_3_4" style="height: 330px; width: 100%;"></div>
                 </div>
              </div>
            </div>


              <div class="col-md-12">
                 <br><br><br>
                 <h3 class="text-center"><b> Shortcode and Company Wise Revenue: </b></h3>
                 <br>
              </div>
              <div class="col-md-6 col-xs-12">
                  
                    <div id="chartContainer201" style="height: 330px; width: 100%;"></div>
                    <br>
              </div>

              <div class="col-md-6 col-xs-12">
                  
                    <div id="chartContainer202" style="height: 330px; width: 100%;"></div>
                    <br>
              </div>
            
            <script>
            window.onload = function() {
             
            var chart = new CanvasJS.Chart("chartContainer", {
              animationEnabled: true,
              exportEnabled: true,
              theme: "dark2",
              title:{
                text: "Miaki Revenue (Weekly)"
              },
              axisY: {
                title: "per week revenue (Tk)"
              },
              axisX:{
                  labelMaxWidth: 60,  
                  labelWrap: true
               },
              data: [{
                type: "column",
                indexLabel: "{y}",
                // indexLabelPlacement: "inside",
                indexLabelFontWeight: "bolder",
                yValueFormatString: "#,##0.## Tk",
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
              }]
            });
            chart.render();


             // company wise revenue last 7 days::::::::::::::::::;


             var chart2 = new CanvasJS.Chart("chartContainer2", {
               animationEnabled: true,
               exportEnabled: true,
               theme: "dark2",
               title:{
                 text: "Company Wise Revenue"
               },
               axisY: {
                 title: "Last 7 Days Revenue (Tk)"
               },
               axisX:{
                   labelMaxWidth: 60,  
                   labelWrap: true
                },
               data: [{
                 type: "column",
                 indexLabel: "{y}",
                 // indexLabelPlacement: "inside",
                 indexLabelFontWeight: "bolder",
                 yValueFormatString: "#,##0.## Tk",
                 dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
               }]
             });
             chart2.render();


           


      // Monthly revenue:

           var chart6 = new CanvasJS.Chart("chartContainer6", {
             animationEnabled: true,
             exportEnabled: true,
             theme: "dark2",
             title:{
               text: "Forecasted Rev"
             },

             subtitles:[
                 {
                   text: <?php echo json_encode( number_format($forecast,2,'.',',').' Tk', JSON_NUMERIC_CHECK); ?>,
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
               dataPoints: <?php echo json_encode($dataPoints6, JSON_NUMERIC_CHECK); ?>
             }]
           });
           chart6.render();


            var chart3 = new CanvasJS.Chart("chartContainer3", {
              animationEnabled: true,
              exportEnabled: true,
              theme: "dark2",
              title:{
                text: "Miaki Revenue (Monthly)"
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
                dataPoints: <?php echo json_encode($dataPoints3, JSON_NUMERIC_CHECK); ?>
              }]
            });
            chart3.render();


          
          // company wise revenue current month ::::::::::::::::::;


          var chart4 = new CanvasJS.Chart("chartContainer4", {
            backgroundColor: "#004d2e",
            animationEnabled: true,
            exportEnabled: true,
            theme: "dark2",
            title:{
              text: "Current Month"
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
              dataPoints: <?php echo json_encode($dataPoints4, JSON_NUMERIC_CHECK); ?>
            }]
          });
          chart4.render();

          // company wise revenue last 3 months:
            var chart_1_4 = new CanvasJS.Chart("chartContainer_1_4", {
              backgroundColor: "#392613",
              animationEnabled: true,
              exportEnabled: true,
              theme: "dark2",
              title:{
                text: <?php echo json_encode($month_name[1], JSON_NUMERIC_CHECK); ?>,
                fontColor: "#e6e600",
                fontSize:20
              },
              subtitles:[
                  {
                    text: <?php echo json_encode( number_format($dataPoints_1_4_sum,2,'.',',').' Tk', JSON_NUMERIC_CHECK); ?>,
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
                dataPoints: <?php echo json_encode($dataPoints_1_4, JSON_NUMERIC_CHECK); ?>
              }]
            });
            chart_1_4.render();


            var chart_2_4 = new CanvasJS.Chart("chartContainer_2_4", {
              backgroundColor: "#392613",
              animationEnabled: true,
              exportEnabled: true,
              theme: "dark2",
              title:{
                text: <?php echo json_encode($month_name[2], JSON_NUMERIC_CHECK); ?>,
                fontColor: "#e6e600",
                fontSize:20
              },
              subtitles:[
                  {
                    text: <?php echo json_encode( number_format($dataPoints_2_4_sum,2,'.',',').' Tk', JSON_NUMERIC_CHECK); ?>,
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
                dataPoints: <?php echo json_encode($dataPoints_2_4, JSON_NUMERIC_CHECK); ?>
              }]
            });
            chart_2_4.render();

        
            var chart_3_4 = new CanvasJS.Chart("chartContainer_3_4", {
              backgroundColor: "#392613",
              animationEnabled: true,
              exportEnabled: true,
              theme: "dark2",
              title:{
                text: <?php echo json_encode($month_name[3], JSON_NUMERIC_CHECK); ?>,
                fontColor: "#e6e600",
                fontSize:20
              },
              subtitles:[
                  {
                    text: <?php echo json_encode( number_format($dataPoints_3_4_sum,2,'.',',').' Tk', JSON_NUMERIC_CHECK); ?>,
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
                dataPoints: <?php echo json_encode($dataPoints_3_4, JSON_NUMERIC_CHECK); ?>
              }]
            });
            chart_3_4.render();
          // end of it:::



            // per day .................................................................   
             var chart5 = new CanvasJS.Chart("chartContainer5", {
               animationEnabled: true,
               exportEnabled: true,
               theme: "dark2",
               backgroundColor:"#1f1f14",
               title:{
                 text: "Miaki Robi Vas Revenue (Daily)"
               },
               axisY: {
                 title: "per day revenue (Tk)"
               },
               data: [{
                 type: "column",
                 indexLabel: "{y}",
                 // indexLabelPlacement: "inside",
                 indexLabelFontWeight: "bolder",
                 yValueFormatString: "#,##0.## Tk",
                 dataPoints: <?php echo json_encode($dataPoints5, JSON_NUMERIC_CHECK); ?>
               }]
             });
             chart5.render(); 


        // shortcode wise and company wise current month revenue:::::

             var chart201 = new CanvasJS.Chart("chartContainer201", {
              animationEnabled: true,
              exportEnabled: true,
              theme: "dark2", // "light1", "light2", "dark1", "dark2"
              title:{
                text: "Current Month"
              },
              axisX:{
                reversed: true
              },
              toolTip:{
                shared: true
              },
              data: [{
                type: "stackedBar",
                name: <?php echo json_encode($short_code[0]->shortcode, JSON_NUMERIC_CHECK); ?>,
                dataPoints: <?php echo json_encode($s_code1, JSON_NUMERIC_CHECK); ?>
              },{
                type: "stackedBar",
                name: <?php echo json_encode($short_code[1]->shortcode, JSON_NUMERIC_CHECK); ?>,
                dataPoints: <?php echo json_encode($s_code2, JSON_NUMERIC_CHECK); ?>
              },{
                type: "stackedBar",
                name: <?php echo json_encode($short_code[2]->shortcode, JSON_NUMERIC_CHECK); ?>,
                dataPoints: <?php echo json_encode($s_code3, JSON_NUMERIC_CHECK); ?>
              },{
                type: "stackedBar",
                name: <?php echo json_encode($short_code[3]->shortcode, JSON_NUMERIC_CHECK); ?>,
                dataPoints: <?php echo json_encode($s_code4, JSON_NUMERIC_CHECK); ?>
              },{
                type: "stackedBar",
                name: <?php echo json_encode($short_code[4]->shortcode, JSON_NUMERIC_CHECK); ?>,
                dataPoints: <?php echo json_encode($s_code5, JSON_NUMERIC_CHECK); ?>
              },{
                type: "stackedBar",
                name: <?php echo json_encode($short_code[5]->shortcode, JSON_NUMERIC_CHECK); ?>,
                dataPoints: <?php echo json_encode($s_code6, JSON_NUMERIC_CHECK); ?>
              },{
                type: "stackedBar",
                name: <?php echo json_encode($short_code[6]->shortcode, JSON_NUMERIC_CHECK); ?>,
                dataPoints: <?php echo json_encode($s_code7, JSON_NUMERIC_CHECK); ?>
              },{
                type: "stackedBar",
                name: <?php echo json_encode($short_code[7]->shortcode, JSON_NUMERIC_CHECK); ?>,
                dataPoints: <?php echo json_encode($s_code8, JSON_NUMERIC_CHECK); ?>
              },{
                type: "stackedBar",
                name: <?php echo json_encode($short_code[8]->shortcode, JSON_NUMERIC_CHECK); ?>,
                indexLabel: "#total",
                indexLabelPlacement: "outside",
                indexLabelFontSize: 15,
                indexLabelFontWeight: "bold",
                dataPoints: <?php echo json_encode($s_code9, JSON_NUMERIC_CHECK); ?>
              }]
             });
             chart201.render();



             var chart202 = new CanvasJS.Chart("chartContainer202", {
              animationEnabled: true,
              exportEnabled: true,
              theme: "dark2", // "light1", "light2", "dark1", "dark2"
              title:{
                text: "Previous Month"
              },
              axisX:{
                reversed: true
              },
              toolTip:{
                shared: true
              },
              data: [{
                type: "stackedBar",
                name: <?php echo json_encode($short_code[0]->shortcode, JSON_NUMERIC_CHECK); ?>,
                dataPoints: <?php echo json_encode($s_code_p1, JSON_NUMERIC_CHECK); ?>
              },{
                type: "stackedBar",
                name: <?php echo json_encode($short_code[1]->shortcode, JSON_NUMERIC_CHECK); ?>,
                dataPoints: <?php echo json_encode($s_code_p2, JSON_NUMERIC_CHECK); ?>
              },{
                type: "stackedBar",
                name: <?php echo json_encode($short_code[2]->shortcode, JSON_NUMERIC_CHECK); ?>,
                dataPoints: <?php echo json_encode($s_code_p3, JSON_NUMERIC_CHECK); ?>
              },{
                type: "stackedBar",
                name: <?php echo json_encode($short_code[3]->shortcode, JSON_NUMERIC_CHECK); ?>,
                dataPoints: <?php echo json_encode($s_code_p4, JSON_NUMERIC_CHECK); ?>
              },{
                type: "stackedBar",
                name: <?php echo json_encode($short_code[4]->shortcode, JSON_NUMERIC_CHECK); ?>,
                dataPoints: <?php echo json_encode($s_code_p5, JSON_NUMERIC_CHECK); ?>
              },{
                type: "stackedBar",
                name: <?php echo json_encode($short_code[5]->shortcode, JSON_NUMERIC_CHECK); ?>,
                dataPoints: <?php echo json_encode($s_code_p6, JSON_NUMERIC_CHECK); ?>
              },{
                type: "stackedBar",
                name: <?php echo json_encode($short_code[6]->shortcode, JSON_NUMERIC_CHECK); ?>,
                dataPoints: <?php echo json_encode($s_code_p7, JSON_NUMERIC_CHECK); ?>
              },{
                type: "stackedBar",
                name: <?php echo json_encode($short_code[7]->shortcode, JSON_NUMERIC_CHECK); ?>,
                dataPoints: <?php echo json_encode($s_code_p8, JSON_NUMERIC_CHECK); ?>
              },{
                type: "stackedBar",
                name: <?php echo json_encode($short_code[8]->shortcode, JSON_NUMERIC_CHECK); ?>,
                indexLabel: "#total",
                indexLabelPlacement: "outside",
                indexLabelFontSize: 15,
                indexLabelFontWeight: "bold",
                dataPoints: <?php echo json_encode($s_code_p9, JSON_NUMERIC_CHECK); ?>
              }]
             });
             chart202.render();
             
            }
            </script>
                            
           @endsection

             



             