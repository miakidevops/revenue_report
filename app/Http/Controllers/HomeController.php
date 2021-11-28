<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Content;
use App\Shortcode;
use Carbon\Carbon;
class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $ivr_amount['ivr_miaki_revenue']=0;
       $ivr_amount['ivr_total_revenue']=0;

       $sms_amount['sms_miaki_revenue']=0;
       $sms_amount['sms_total_revenue']=0;

       $wap_amount['wap_miaki_revenue']=0;
       $wap_amount['wap_total_revenue']=0;


       $start_day=strtotime("today");
       $start_day= date("Y-m-d", $start_day);

       $end_day=strtotime("-30 days");
       $end_day= date("Y-m-d", $end_day);


               $all_data=Content::where('service_type','LIKE','IVR')->
                                  where('time','>=',$end_day)->
                                  where('time','<=',$start_day)->get();

              foreach($all_data as $result){   
                $ivr_amount['ivr_miaki_revenue']+=$result['miaki_revenue'];
                $ivr_amount['ivr_total_revenue']+=$result['total_revenue'];
              }    


               $all_data2=Content::where('service_type','LIKE','SMS')->
                                  where('time','>=',$end_day)->
                                  where('time','<=',$start_day)->get();

              foreach($all_data2 as $result){   
                $sms_amount['sms_miaki_revenue']+=$result['miaki_revenue'];
                $sms_amount['sms_total_revenue']+=$result['total_revenue'];
              } 


               $all_data3=Content::where('service_type','LIKE','WAP')->
                                  where('time','>=',$end_day)->
                                  where('time','<=',$start_day)->get();

              foreach($all_data3 as $result){   
                $wap_amount['wap_miaki_revenue']+=$result['miaki_revenue'];
                $wap_amount['wap_total_revenue']+=$result['total_revenue'];
              }      


             $week1_first=strtotime("-2 days");
             $week1_first= date("Y-m-d", $week1_first);

             $week1_last=strtotime("-8 days");
             $week1_last= date("Y-m-d", $week1_last);

               $week1_result=Content::where('time','>=',$week1_last)->
                                  where('time','<=',$week1_first)->sum('miaki_revenue');

                                 

             $week2_first=strtotime("-9 days");
             $week2_first= date("Y-m-d", $week2_first);

             $week2_last=strtotime("-15 days");
             $week2_last= date("Y-m-d", $week2_last);

                  $week2_result=Content::where('time','>=',$week2_last)->
                                     where('time','<=',$week2_first)->sum('miaki_revenue');

                                     

             $week3_first=strtotime("-16 days");
             $week3_first= date("Y-m-d", $week3_first);

             $week3_last=strtotime("-22 days");
             $week3_last= date("Y-m-d", $week3_last);

                   $week3_result=Content::where('time','>=',$week3_last)->
                                      where('time','<=',$week3_first)->sum('miaki_revenue');

             $week4_first=strtotime("-23 days");
             $week4_first= date("Y-m-d", $week4_first);

             $week4_last=strtotime("-29 days");
             $week4_last= date("Y-m-d", $week4_last);

                   $week4_result=Content::where('time','>=',$week4_last)->
                                     where('time','<=',$week4_first)->sum('miaki_revenue');
     
  $fromDate  = Carbon::now()->startofMonth()->subMonth('0')->endOfMonth()->toDateString();
  $fromDate0 = Carbon::now()->startofMonth()->subMonth('1')->endOfMonth()->toDateString();
  $fromDate1 = Carbon::now()->startofMonth()->subMonth('2')->endOfMonth()->toDateString();
  $fromDate2 = Carbon::now()->startofMonth()->subMonth('3')->endOfMonth()->toDateString();
  $fromDate3 = Carbon::now()->startofMonth()->subMonth('4')->endOfMonth()->toDateString();

    


             // $fromDate = Carbon::now()->subMonth('-1')->startOfMonth()->toDateString();
             // $fromDate0 = Carbon::now()->subMonth('0')->startOfMonth()->toDateString();
             // $fromDate1 = Carbon::now()->subMonth('1')->startOfMonth()->toDateString();
             // $fromDate2 = Carbon::now()->subMonth('2')->startOfMonth()->toDateString();
             // $fromDate3 = Carbon::now()->subMonth('3')->startOfMonth()->toDateString();
            $month_1_result_win_miaki=Content::where('time','>',$fromDate0)->
                               where('time','<=',$fromDate)->
                               where('company_name','like','WIN_Miaki')->sum('miaki_revenue');

            $month_1_result_miaki_media=Content::where('time','>',$fromDate0)->
                               where('time','<=',$fromDate)->
                               where('company_name','like','Miaki_Media')->sum('miaki_revenue');
                               
            $month_1_result_btmv=Content::where('time','>',$fromDate0)->
                               where('time','<=',$fromDate)->
                               where('company_name','like','BTMV')->sum('miaki_revenue');                                      

                       // dd($month_1_result_win_miaki);        

            $month_1_result=Content::where('time','>',$fromDate0)->
                               where('time','<=',$fromDate)->sum('miaki_revenue');

            $month_2_result=Content::where('time','>',$fromDate1)->
                               where('time','<=',$fromDate0)->sum('miaki_revenue');
                               
            $month_3_result=Content::where('time','>',$fromDate2)->
                               where('time','<=',$fromDate1)->sum('miaki_revenue');
                          
            $month_4_result=Content::where('time','>',$fromDate3)->
                               where('time','<=',$fromDate2)->sum('miaki_revenue');                                                         
            
             $month_interval=(strtotime($fromDate)- strtotime($fromDate0))/(60*60*24);
             $current_interval=floor((time()- strtotime($fromDate0))/(60*60*24));
             $current_interval=$current_interval-2;
             if($current_interval<1)
             {
              $current_interval=1;
             }
             // dd($current_interval);
             $forecast=round(($month_1_result/($current_interval))*$month_interval);
             $forecast_win_miaki=round(($month_1_result_win_miaki/($current_interval))*$month_interval);
             $forecast_miaki_media=round(($month_1_result_miaki_media/($current_interval))*$month_interval);
             $forecast_btmv=round(($month_1_result_btmv/($current_interval))*$month_interval);


            $month_name=array();
            $month_name[0]=date("M", strtotime($fromDate));
            $month_name[1]=date("M", strtotime($fromDate0));
            $month_name[2]=date("M", strtotime($fromDate1));
            $month_name[3]=date("M", strtotime($fromDate2));



         //7 days calculation ...............................
              $day_2=strtotime("-2 days");
              $day_2=date("Y-m-d",$day_2);

              $day_8=strtotime("-8 days");
              $day_8=date("Y-m-d",$day_8); 

          $sql="SELECT `shortcode`, sum(`miaki_revenue`) as rev FROM `content` where shortcode not in ('21200','empth') and (`time` between '".$day_8."' and '".$day_2."') group by `shortcode` order by rev desc";

                    $short_code=DB::select(DB::raw($sql));

                    

          $sql="SELECT  `company_name` , sum(`miaki_revenue`) as miaki_rev FROM `content` where company_name not in ('empth') and (`time` between '".$day_8."' and '".$day_2."') group by `company_name` order by   miaki_rev desc";

                     $company_wise_revenue=DB::select(DB::raw($sql));

           // current month::::::::::::::::::::

          $sql="SELECT  `company_name` , sum(`miaki_revenue`) as miaki_rev FROM `content` where company_name not in ('empth') and `time` > '".$fromDate0."' and `time` <= '".$fromDate."' group by `company_name` order by   miaki_rev desc";

                     $company_wise_revenue_30=DB::select(DB::raw($sql));   

                // echo $fromDate0,'  ',$fromDate;
                 //if(empty($company_wise_revenue_30)) {$company_wise_revenue_30=0;}

                 // dd($company_wise_revenue_30);

            // now last 3 months revenue: company wise:::::::::::
               
           $sql="SELECT  `company_name` , sum(`miaki_revenue`) as miaki_rev FROM `content` where company_name not in ('empth') and `time` > '".$fromDate1."' and `time` <= '".$fromDate0."' group by `company_name` order by   miaki_rev desc";

                     $company_wise_revenue_30_last_1=DB::select(DB::raw($sql));
                        // dd($$company_wise_revenue_30_last_1);

           $sql="SELECT  `company_name` , sum(`miaki_revenue`) as miaki_rev FROM `content` where company_name not in ('empth') and `time` > '".$fromDate2."' and `time` <= '".$fromDate1."' group by `company_name` order by   miaki_rev desc";

                      $company_wise_revenue_30_last_2=DB::select(DB::raw($sql)); 


           $sql="SELECT  `company_name` , sum(`miaki_revenue`) as miaki_rev FROM `content` where company_name not in ('empth') and `time` > '".$fromDate3."' and `time` <= '".$fromDate2."' group by `company_name` order by   miaki_rev desc";

                      $company_wise_revenue_30_last_3=DB::select(DB::raw($sql));                      

            // end of previous 3 months company wise revenue         
                     

           $seven_day=array();
           $shortcode_rev_7=array();

           for($i=0;$i<7;$i++)
           {
              $cons=2;
              $j=0;
              $j=$i+$cons;
              $seven_day[$i]=strtotime("-$j days");
              $seven_day[$i]=date("Y-m-d",$seven_day[$i]);
              $shortcode_rev_7[$i]=array();
              $j=0;

              foreach ($short_code as $short) {
                //echo $short->shortcode,' ';

                $shortcode_rev_7[$i][$j]=Content::where('time','=',$seven_day[$i])->
                                   where('shortcode','=',$short->shortcode)->sum('miaki_revenue');
                                   $j++;

              }

           }

           $seven_days_total_rev=array();
           for($i=0;$i<7;$i++)
           {
            $seven_days_total_rev[$i]=Content::where('time','=',$seven_day[$i])->sum('miaki_revenue');
           }


// dd($seven_days_total_rev);
           // php stacked bar chart for 2 months revenue according to its shortcode:::

          $btmv_current_month=array();
          $btmv_previous_month=array();
          $miaki_media_current_month=array();
          $miaki_media_previous_month=array();
          $win_miaki_current_month=array();
          $win_miaki_previous_month=array();


           $index=0;
           foreach ($short_code as $short) {

            $btmv_current_month[$index]=Content::where('shortcode','=',$short->shortcode)
                               ->where('company_name','=','BTMV')
                               ->where('time','>',$fromDate0)
                               ->where('time','<=',$fromDate)->sum('miaki_revenue');

            $miaki_media_current_month[$index]=Content::where('shortcode','=',$short->shortcode)
                               ->where('company_name','=','Miaki_Media')
                               ->where('time','>',$fromDate0)
                               ->where('time','<=',$fromDate)->sum('miaki_revenue');
                               
            $win_miaki_current_month[$index]=Content::where('shortcode','=',$short->shortcode)
                               ->where('company_name','=','WIN_Miaki')
                               ->where('time','>',$fromDate0)
                               ->where('time','<=',$fromDate)->sum('miaki_revenue');


                     // ............previous month .......


              $btmv_previous_month[$index]=Content::where('shortcode','=',$short->shortcode)
                                 ->where('company_name','=','BTMV')
                                 ->where('time','>',$fromDate1)
                                 ->where('time','<=',$fromDate0)->sum('miaki_revenue');

              $miaki_media_previous_month[$index]=Content::where('shortcode','=',$short->shortcode)
                                 ->where('company_name','=','Miaki_Media')
                                 ->where('time','>',$fromDate1)
                                 ->where('time','<=',$fromDate0)->sum('miaki_revenue');
                                 
              $win_miaki_previous_month[$index]=Content::where('shortcode','=',$short->shortcode)
                                 ->where('company_name','=','WIN_Miaki')
                                 ->where('time','>',$fromDate1)
                                 ->where('time','<=',$fromDate0)->sum('miaki_revenue');                                                               
         // echo $short_code[0]->shortcode,'  ';  
         // echo $win_miaki_current_month[$index],'   ';
            $index++;
           }
             


           // end of its code here:::



            return view('summary',compact('ivr_amount','sms_amount','wap_amount','week1_result','week2_result','week3_result','week4_result','week1_first','week1_last','week2_first','week2_last','week3_first','week3_last','week4_first','week4_last','month_1_result','month_2_result','month_3_result','month_4_result','month_name','short_code','seven_day','shortcode_rev_7','seven_days_total_rev','forecast','forecast_win_miaki','forecast_miaki_media','forecast_btmv','company_wise_revenue','company_wise_revenue_30','btmv_current_month','miaki_media_current_month','win_miaki_current_month','btmv_previous_month','miaki_media_previous_month','win_miaki_previous_month','company_wise_revenue_30_last_1','company_wise_revenue_30_last_2','company_wise_revenue_30_last_3'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        echo " ",$fromDate = Carbon::now()->subMonth('-1')->startOfMonth()->toDateString();
        echo ' = ',$nmonth = date("M", strtotime($fromDate));
        echo " ",$fromDate0 = Carbon::now()->subMonth('0')->startOfMonth()->toDateString();
        echo " ",$fromDate1 = Carbon::now()->subMonth('1')->startOfMonth()->toDateString();
        echo " ",$fromDate2 = Carbon::now()->subMonth('2')->startOfMonth()->toDateString();
        echo " ",$fromDate3 = Carbon::now()->subMonth('3')->startOfMonth()->toDateString();
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
