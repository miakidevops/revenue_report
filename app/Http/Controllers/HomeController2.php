<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Content;
use App\Shortcode;
use Carbon\Carbon;

class HomeController2 extends Controller
{
    public function index()
    {
        $start_day = strtotime("-2 days");
        $start_day = date("Y-m-d", $start_day);

        $end_day = strtotime("-31 days");
        $end_day = date("Y-m-d", $end_day);

        // dd($start_day,'',$end_day);


         $service_type_data = DB::table('content')
                           ->select('service_type', DB::raw('sum(total_revenue) as total_rev'), DB::raw('sum(miaki_revenue) as miaki_rev'))
                           ->where('time','>=',$end_day)
                           ->where('time','<=',$start_day)
                           ->whereNotIn('service_type', ["empth"])
                           ->groupBy('service_type')->get();

        // dd($service_type_data);   


       // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
       // :::::::::::::::::::::shortcode wise last 7 days revenue::::::::::::::::::::::::::
       // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

        $days_7_data = $this->get_last_7_date();
        // dd($days_7_data);

        $sql = "SELECT `shortcode`, sum(`miaki_revenue`) as rev FROM `content` where shortcode not in ('21200','empth') and (`time` between '".$days_7_data[0]."' and '".$days_7_data[1]."') group by `shortcode` order by rev desc";

        $short_code = DB::select(DB::raw($sql));
        $seven_day = array();
        $shortcode_rev_7 = array();

        for( $i = 0; $i < 7; $i++ )
        {
           $cons = 2;
           $j = 0;
           $j = $i+$cons;
           $seven_day[$i] = strtotime("-$j days");
           $seven_day[$i] = date("Y-m-d",$seven_day[$i]);
           $shortcode_rev_7[$i] = array();
           $j = 0;

           foreach ($short_code as $short){
             //echo $short->shortcode,' ';
             $shortcode_rev_7[$i][$j] = Content::where('time','=',$seven_day[$i])->
                                where('shortcode','=',$short->shortcode)->sum('miaki_revenue');
                                $j++;
            }
         }

        $seven_days_total_rev = array();
        for( $i = 0; $i < 7; $i++ )
        {
         $seven_days_total_rev[$i] = Content::where('time','=',$seven_day[$i])->sum('miaki_revenue');
        }


// :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
// :::::::::::::::::::::::::::::::Day wise revenue::::::::::::::::::::::::::::::::::::::::::::
// :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

        $ten_days_total_rev = $this->last_15_day_wise_revenue();

        $rev_data = $this->current_month_revenue();

        $month_wise_miaki_rev = $this->month_wise_miaki_rev();

        $month_wise_and_comp_wise_rev = $this->month_wise_and_comp_wise_rev();
        // dd($month_wise_and_comp_wise_rev);



        $company_and_shortcode_wise_rev = $this->current_month_rev_by_company_and_shortcode();
        if( empty($company_and_shortcode_wise_rev[0]) ){
          $company_and_shortcode_wise_rev = $this->null_array_assign_zero();
        }


        $company_and_shortcode_wise_rev_pre = $this->previous_month_rev_by_company_and_shortcode();
        if( empty($company_and_shortcode_wise_rev_pre[0]) ){
          $company_and_shortcode_wise_rev_pre = $this->null_array_assign_zero();
        }


        return view('summary2',compact('service_type_data','short_code','shortcode_rev_7','seven_day','seven_days_total_rev','ten_days_total_rev','rev_data','month_wise_miaki_rev','month_wise_and_comp_wise_rev','company_and_shortcode_wise_rev','company_and_shortcode_wise_rev_pre'));
    }

    public function get_last_7_date()
    {
      $day_2 = strtotime("-2 days");
      $day_2 = date("Y-m-d",$day_2);

      $day_8 = strtotime("-8 days");
      $day_8 = date("Y-m-d",$day_8);

      return $data= array(
        '0' => $day_8,
        '1' => $day_2
      );
    }


    public function last_15_day_wise_revenue()
    {
      $end = strtotime("-2 days");
      $end = date("Y-m-d",$end);

      $start = strtotime("-16 days");
      $start = date("Y-m-d",$start);

      $ten_days_total_rev = DB::table('content')
                                ->select( DB::raw('sum(miaki_revenue) as miaki_rev'),'time' )
                                ->where('time','>=',$start)
                                ->where('time','<=',$end)
                                ->groupBy('time')
                                ->orderBy('time','desc')
                                ->get();
      // dd($ten_days_total_rev);
      $ten_days_total_rev_array = array();

      $i = 0;
      foreach ($ten_days_total_rev as $key) {
        $ten_days_total_rev_array[$i] = array();
        $ten_days_total_rev_array[$i]['y'] = $key->miaki_rev;
        $ten_days_total_rev_array[$i]['label'] = $key->time;
        $i++;
      }
      // dd($ten_days_total_rev_array);
      return $ten_days_total_rev_array;
    }


    public function current_month_revenue()
    {
      $first_date = date('Y-m-01');
      $last_date = date('Y-m-t');
      
      $current_month_rev = DB::table('content')
                                ->select( DB::raw('sum(miaki_revenue) as miaki_rev'),'company_name' )
                                ->where('time','>=',$first_date)
                                ->where('time','<=',$last_date)
                                ->whereNotIn('company_name', ['empth'])
                                ->groupBy('company_name')
                                ->orderBy('miaki_rev','desc')
                                ->get();


      $current_month_rev_array = array();
      $i = 0;
      foreach ($current_month_rev as $key) {
        $current_month_rev_array[$i] = array();
        $current_month_rev_array[$i]['y'] = $key->miaki_rev;
        $current_month_rev_array[$i]['label'] = $key->company_name;
        $i++;
      }



      $month_interval = date('t');
      $current_interval = floor((time()- strtotime($first_date))/(60*60*24));
      $current_interval = $current_interval-1;
      if( $current_interval < 1 )
      {
       $current_interval = 1;
      }
      // dd($month_interval.'--'.$current_interval);
      $current_month_rev_forceast_array = array();
      $j = 0;
      $total_rev_forecast = 0;
      foreach ($current_month_rev as $key) {
        $current_month_rev_forceast_array[$j] = array();
        $current_month_rev_forceast_array[$j]['y'] = round(($key->miaki_rev/$current_interval)*$month_interval);
        $current_month_rev_forceast_array[$j]['label'] = $key->company_name;
        
        $total_rev_forecast += $current_month_rev_forceast_array[$j]['y'];
        $j++;
      }
      // dd($total_rev_forecast);

      $rev_data = array(
          "0" => $current_month_rev_array,
          "1" => $current_month_rev_forceast_array,
          "2" => $total_rev_forecast
      );
      // dd($rev_data);

      return $rev_data;
    }



    public function month_wise_miaki_rev()
    {
      $month_wise_miaki_rev = DB::table('content')
                                ->select(DB::raw('sum(miaki_revenue) as miaki_rev'), DB::raw('YEAR(time) year, MONTH(time) month'))
                                ->groupBy('year','month')
                                ->orderBy('year','desc')
                                ->orderBy('month','desc')
                                ->take(4)->get();

      $month_wise_miaki_rev_array = array();
      foreach ($month_wise_miaki_rev as $value) {
        static $ind = 0;
        $monthName = date('F', mktime(0, 0, 0, $value->month, 10));
        $month_wise_miaki_rev_array[$ind] = array();
        $month_wise_miaki_rev_array[$ind]['y'] = $value->miaki_rev;
        $month_wise_miaki_rev_array[$ind]['label'] = $monthName.'-'.$value->year;
        $ind++;
      }
      // dd($month_wise_miaki_rev_array);

      return $month_wise_miaki_rev_array;
    }



    public function month_wise_and_comp_wise_rev()
    {
      $month_wise_miaki_rev = DB::table('content')
                                ->select('company_name', DB::raw('sum(miaki_revenue) as miaki_rev'), DB::raw('YEAR(time) year, MONTH(time) month'))
                                ->whereNotIn('company_name', ["empth"])
                                ->groupBy('company_name','year','month')
                                ->orderBy('year','desc')
                                ->orderBy('month','desc')
                                ->orderBy('company_name','asc')
                                ->skip(3)->take(9)->get();
      // dd($month_wise_miaki_rev);

      $month_wise_miaki_rev_array = array();
      $month_track_array = array();
      $j = 0;
      foreach ($month_wise_miaki_rev as $key => $value) {
        if( !array_key_exists($value->month, $month_wise_miaki_rev_array) )
        {
            $month_wise_miaki_rev_array[$value->month] = array();
            $i = -1;

            $month_track_array[$j] = array();
            $month_track_array[$j]['ind'] = $value->month;
            $month_track_array[$j]['month'] = date('F', mktime(0, 0, 0, $value->month, 10));
            $j++;
        }
        $i++;
        $month_wise_miaki_rev_array[$value->month][$i]["y"] = $value->miaki_rev;
        $month_wise_miaki_rev_array[$value->month][$i]["label"] = $value->company_name;

      }
      // dd($month_wise_miaki_rev_array);
      // dd($month_track_array);

      $datas =array(
        "0" => $month_wise_miaki_rev_array,
        "1" => $month_track_array
      );

      // dd($datas);
      return $datas;
    }



    public function current_month_rev_by_company_and_shortcode()
    {
      $first_date = date('Y-m-01');
      $last_date = date('Y-m-t');
      // dd($first_date,'-',$last_date);

      // $sql="SELECT  `company_name` , `shortcode` , ifnull(sum(`miaki_revenue`), 0 ) as miaki_rev FROM `content` where company_name not in ('empth') and shortcode not in ('21200') and `time` >= '".$first_date."' and `time` <= '".$last_date."' group by `company_name` , `shortcode`";

      // $company_wise_revenue=DB::select(DB::raw($sql));
      // dd( $company_wise_revenue);

      $company_and_shortcode_wise_rev = DB::table('content')
                          ->select('company_name', DB::raw('sum(miaki_revenue) as miaki_rev'), 'shortcode')
                          ->whereNotIn('company_name', ["empth"])
                          ->whereNotIn('shortcode', ["21200"])
                          ->where('time','>=',$first_date)
                          ->where('time','<=',$last_date)
                          ->groupBy('company_name')
                          ->groupBy('shortcode')
                          ->get();
      // dd($company_and_shortcode_wise_rev);
      $company_and_shortcode_wise_rev_array = array();
      $short_code_name = array();
      $j = 0;

      foreach ($company_and_shortcode_wise_rev as $value) {
        if( !array_key_exists($value->shortcode, $company_and_shortcode_wise_rev_array) )
        {
          $company_and_shortcode_wise_rev_array[$value->shortcode] = array();
          $company_and_shortcode_wise_rev_array[$value->shortcode]['BTMV'] = 0;
          $company_and_shortcode_wise_rev_array[$value->shortcode]['Miaki_Media'] = 0;
          $company_and_shortcode_wise_rev_array[$value->shortcode]['WIN_Miaki'] = 0;

          $short_code_name[$j] = $value->shortcode;
          $j++;
        }
        $company_and_shortcode_wise_rev_array[$value->shortcode][$value->company_name] = $value->miaki_rev;
      }
      // dd($company_and_shortcode_wise_rev_array);

      $company_and_shortcode_wise_rev_array_struc = array();
      foreach( $company_and_shortcode_wise_rev_array as $key => $value )
      {
        $company_and_shortcode_wise_rev_array_struc[$key] = array();
        $i = 0;
        foreach ($value as $key2 => $value2) {
          $company_and_shortcode_wise_rev_array_struc[$key][$i]['label'] = $key2;
          $company_and_shortcode_wise_rev_array_struc[$key][$i]['y'] = $value2;
          $i++;
        }
      }

      // dd($company_and_shortcode_wise_rev_array_struc);

      $company_shortcode_wise_rev_full =array(
        "0" => $company_and_shortcode_wise_rev_array_struc,
        "1" =>$short_code_name
      );
      // dd($company_shortcode_wise_rev_full);
      return $company_shortcode_wise_rev_full;
    }



    public function previous_month_rev_by_company_and_shortcode()
    {

      $first_date = date('Y-m-01',strtotime('first day of last month'));
      $last_date = date('Y-m-t',strtotime('last day of last month'));
      

      $company_and_shortcode_wise_rev = DB::table('content')
                          ->select('company_name', DB::raw('sum(miaki_revenue) as miaki_rev'), 'shortcode')
                          ->whereNotIn('company_name', ["empth"])
                          ->whereNotIn('shortcode', ["21200"])
                          ->where('time','>=',$first_date)
                          ->where('time','<=',$last_date)
                          ->groupBy('company_name')
                          ->groupBy('shortcode')
                          ->get();
      // dd($company_and_shortcode_wise_rev);
      $company_and_shortcode_wise_rev_array = array();
      $short_code_name = array();
      $j = 0;

      foreach ($company_and_shortcode_wise_rev as $value) {
        if( !array_key_exists($value->shortcode, $company_and_shortcode_wise_rev_array) )
        {
          $company_and_shortcode_wise_rev_array[$value->shortcode] = array();
          $company_and_shortcode_wise_rev_array[$value->shortcode]['BTMV'] = 0;
          $company_and_shortcode_wise_rev_array[$value->shortcode]['Miaki_Media'] = 0;
          $company_and_shortcode_wise_rev_array[$value->shortcode]['WIN_Miaki'] = 0;

          $short_code_name[$j] = $value->shortcode;
          $j++;
        }
        $company_and_shortcode_wise_rev_array[$value->shortcode][$value->company_name] = $value->miaki_rev;
      }
      // dd($company_and_shortcode_wise_rev_array);

      $company_and_shortcode_wise_rev_array_struc = array();
      foreach( $company_and_shortcode_wise_rev_array as $key => $value )
      {
        $company_and_shortcode_wise_rev_array_struc[$key] = array();
        $i = 0;
        foreach ($value as $key2 => $value2) {
          $company_and_shortcode_wise_rev_array_struc[$key][$i]['label'] = $key2;
          $company_and_shortcode_wise_rev_array_struc[$key][$i]['y'] = $value2;
          $i++;
        }
      }

      // dd($company_and_shortcode_wise_rev_array_struc);

      $company_shortcode_wise_rev_full =array(
        "0" => $company_and_shortcode_wise_rev_array_struc,
        "1" =>$short_code_name
      );
      // dd($company_shortcode_wise_rev_full);
      return $company_shortcode_wise_rev_full;
    }


    public function current_month_rev_by_company_and_shortcode_backup()
    {
      $first_date = date('Y-m-01');
      $last_date = date('Y-m-t');
      // dd($first_date,'-',$last_date);

      $sql="SELECT  `company_name` , `shortcode` , ifnull(sum(`miaki_revenue`), 0 ) as miaki_rev FROM `content` where company_name not in ('empth') and shortcode not in ('21200') and `time` >= '".$first_date."' and `time` <= '".$last_date."' group by `company_name` , `shortcode`";

      $company_wise_revenue=DB::select(DB::raw($sql));
      dd( $company_wise_revenue);

      $company_and_shortcode_wise_rev = DB::table('content')
                          ->select('company_name', DB::raw('sum(miaki_revenue) as miaki_rev'), 'shortcode')
                          ->whereNotIn('company_name', ["empth"])
                          ->whereNotIn('shortcode', ["21200"])
                          ->where('time','>=',$first_date)
                          ->where('time','<=',$last_date)
                          ->groupBy('company_name')
                          ->groupBy('shortcode')
                          ->get();
      // dd($company_and_shortcode_wise_rev);
      $company_and_shortcode_wise_rev_array = array();
      $short_code_name = array();
      $j = 0;

      foreach ($company_and_shortcode_wise_rev as $value) {
        if( !array_key_exists($value->shortcode, $company_and_shortcode_wise_rev_array) )
        {
          $company_and_shortcode_wise_rev_array[$value->shortcode] = array();
          $i = 0;
          $short_code_name[$j] = $value->shortcode;
          $j++;
        }
        $company_and_shortcode_wise_rev_array[$value->shortcode][$i]['label'] = $value->company_name;
        $company_and_shortcode_wise_rev_array[$value->shortcode][$i]['y'] = $value->miaki_rev;
        $i++;
      }
      // dd($company_and_shortcode_wise_rev_array);

      $company_shortcode_wise_rev_full =array(
        "0" => $company_and_shortcode_wise_rev_array,
        "1" =>$short_code_name
      );
      // dd($company_shortcode_wise_rev_full);
      return $company_shortcode_wise_rev_full;
    }



    public function null_array_assign_zero()
    {
      $data = array(
              "0" => array(
                    "20000"   => array(
                                "0" => array(
                                      "label" => "BTMV",
                                      "y" => 0
                                ),
                                "1" => array(
                                      "label" => "Miaki_Media",
                                      "y" => 0
                                ),
                                "2" => array(
                                      "label" => "WIN_Miaki",
                                      "y" => 0
                                )
                    ),
                    "21272"   => array(
                                "0" => array(
                                      "label" => "BTMV",
                                      "y" => 0
                                ),
                                "1" => array(
                                      "label" => "Miaki_Media",
                                      "y" => 0
                                ),
                                "2" => array(
                                      "label" => "WIN_Miaki",
                                      "y" => 0
                                )
                    ),
                    "21282"   => array(
                                "0" => array(
                                      "label" => "BTMV",
                                      "y" => 0
                                ),
                                "1" => array(
                                      "label" => "Miaki_Media",
                                      "y" => 0
                                ),
                                "2" => array(
                                      "label" => "WIN_Miaki",
                                      "y" => 0
                                )
                    ),
                    "3636"   => array(
                                "0" => array(
                                      "label" => "BTMV",
                                      "y" => 0
                                ),
                                "1" => array(
                                      "label" => "Miaki_Media",
                                      "y" => 0
                                ),
                                "2" => array(
                                      "label" => "WIN_Miaki",
                                      "y" => 0
                                )
                    ),
                    "16295"   => array(
                                "0" => array(
                                      "label" => "BTMV",
                                      "y" => 0
                                ),
                                "1" => array(
                                      "label" => "Miaki_Media",
                                      "y" => 0
                                ),
                                "2" => array(
                                      "label" => "WIN_Miaki",
                                      "y" => 0
                                )
                    ),
                    "3131"   => array(
                                "0" => array(
                                      "label" => "BTMV",
                                      "y" => 0
                                ),
                                "1" => array(
                                      "label" => "Miaki_Media",
                                      "y" => 0
                                ),
                                "2" => array(
                                      "label" => "WIN_Miaki",
                                      "y" => 0
                                )
                    ),
                    "9090"   => array(
                                "0" => array(
                                      "label" => "BTMV",
                                      "y" => 0
                                ),
                                "1" => array(
                                      "label" => "Miaki_Media",
                                      "y" => 0
                                ),
                                "2" => array(
                                      "label" => "WIN_Miaki",
                                      "y" => 0
                                )
                    ),
                    "21281"   => array(
                                "0" => array(
                                      "label" => "BTMV",
                                      "y" => 0
                                ),
                                "1" => array(
                                      "label" => "Miaki_Media",
                                      "y" => 0
                                ),
                                "2" => array(
                                      "label" => "WIN_Miaki",
                                      "y" => 0
                                )
                    ),
                    "27676"   => array(
                                "0" => array(
                                      "label" => "BTMV",
                                      "y" => 0
                                ),
                                "1" => array(
                                      "label" => "Miaki_Media",
                                      "y" => 0
                                ),
                                "2" => array(
                                      "label" => "WIN_Miaki",
                                      "y" => 0
                                )
                    )
              ),

        "1" => array(
              "0" => "20000",
              "1" => "21272",
              "2" => "21282",
              "3" => "3636",
              "4" => "16295",
              "5" => "3131",
              "6" => "9090",
              "7" => "21281",
              "8" => "27676"
        )
      );

  // dd($data);
  return $data;

    }

}
