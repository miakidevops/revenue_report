<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use App\BdappsRevenue;
use DB;
use Carbon\Carbon;
class BdappsRevenueController extends Controller
{

    public function index()
    {
    	  $first_last_day = $this->get_first_last_day();
        $all_days = $this->get_all_days_between_two_date($first_last_day['first_date'],$first_last_day['last_date']);
        $all_days = array_reverse($all_days);
        // dd($all_days);
        $day_wise_rev_array = array();

        $rev_category = array('miaki_rev','mmlbd_rev');

        $day_wise_rev = BdappsRevenue::where('rev_date','>=',$first_last_day['first_date'])
                                       ->where('rev_date','<=',$first_last_day['last_date'])
                                       ->select('rev_date','miaki_rev','mmlbd_rev','other_rev',DB::raw('miaki_rev + mmlbd_rev + other_rev as total_rev'))
                                       ->orderBy('rev_date','asc')
                                       ->get();
        
     
        // dd($day_wise_rev);

      
        foreach ($all_days as $day) {
          $day_wise_rev_array[$day] = array(
            "miaki_rev" => array(
               "rev" => 0,
               "ind" => 0
            ),
            "mmlbd_rev" => array(
               "rev" => 0,
               "ind" => 0
            ),
            "other_rev" => array(
               "rev" => 0,
               "ind" => 0
            ),
            "total_rev" => array(
               "rev" => 0,
               "ind" => 0
            ),
            "avg_rev" => array(
               "rev" => 0,
               "ind" => 0
            )
          );

        }
 
        $total_rev_array = array();
        $total_miaki_array = array();
        $total_mmlbd_array = array();
        $total_other_array = array();
        $whole_revenue = 0;
        $whole_day = 0;

        foreach( $day_wise_rev as  $key => $value )
        {
            $total_rev_array[] = array(
              'x' => strtotime($value->rev_date)*1000,
              'y' => $value->total_rev
            );

            $total_miaki_array[] = array(
              'x' => strtotime($value->rev_date)*1000,
              'y' => $value->miaki_rev
            );

            $total_mmlbd_array[] = array(
              'x' => strtotime($value->rev_date)*1000,
              'y' => $value->mmlbd_rev
            );

            $total_other_array[] = array(
              'x' => strtotime($value->other_rev)*1000,
              'y' => $value->mmlbd_rev
            );


           if( array_key_exists($value->rev_date, $day_wise_rev_array ))
           {
               $whole_revenue += $value->total_rev;
               $whole_day++;
               $avg_revenue = $whole_revenue/$whole_day;

               $day_wise_rev_array[$value->rev_date]["miaki_rev"]["rev"] = $value->miaki_rev;
               $day_wise_rev_array[$value->rev_date]["mmlbd_rev"]["rev"] = $value->mmlbd_rev;
               $day_wise_rev_array[$value->rev_date]["other_rev"]["rev"] = $value->other_rev;
               $day_wise_rev_array[$value->rev_date]["total_rev"]["rev"] = $value->total_rev;
               $day_wise_rev_array[$value->rev_date]["avg_rev"]["rev"] = $avg_revenue;

               $prev_day = date("Y-m-d", strtotime($value->rev_date." -1 DAY"));
               if( array_key_exists($prev_day, $day_wise_rev_array) ) {
                  
                  if(($prev_miaki_rev = $day_wise_rev_array[$prev_day]["miaki_rev"]["rev"]) > 0){
                    $miaki_rev_ind = -1;
                    if( $value->miaki_rev > $prev_miaki_rev ){
                      $miaki_rev_ind = 1;
                    }
                    $day_wise_rev_array[$value->rev_date]["miaki_rev"]["ind"] = $miaki_rev_ind;
                  }

                  if(($prev_mmlbd_rev = $day_wise_rev_array[$prev_day]["mmlbd_rev"]["rev"]) > 0){
                    $mmlbd_rev_ind = -1;
                    if( $value->mmlbd_rev > $prev_mmlbd_rev ){
                      $mmlbd_rev_ind = 1;
                    }
                    $day_wise_rev_array[$value->rev_date]["mmlbd_rev"]["ind"] = $mmlbd_rev_ind;
                  }

                  if(($prev_other_rev = $day_wise_rev_array[$prev_day]["other_rev"]["rev"]) > 0){
                    $other_rev_ind = -1;
                    if( $value->other_rev > $prev_other_rev ){
                      $other_rev_ind = 1;
                    }
                    $day_wise_rev_array[$value->rev_date]["other_rev"]["ind"] = $other_rev_ind;
                  }

                  if(($prev_total_rev = $day_wise_rev_array[$prev_day]["total_rev"]["rev"]) > 0){
                    $total_rev_ind = -1;
                    if( $value->total_rev > $prev_total_rev ){
                      $total_rev_ind = 1;
                    }
                    $day_wise_rev_array[$value->rev_date]["total_rev"]["ind"] = $total_rev_ind;
                  }

                  if(($prev_avg_rev = $day_wise_rev_array[$prev_day]["avg_rev"]["rev"]) > 0){
                    $avg_rev_ind = -1;
                    if( $avg_revenue > $prev_avg_rev ){
                      $avg_rev_ind = 1;
                    }
                    $day_wise_rev_array[$value->rev_date]["avg_rev"]["ind"] = $avg_rev_ind;
                  }

               }
           }  
        
        }

        // dd($day_wise_rev_array);
        // $total_rev_array = array_reverse($total_rev_array);
        // dd($total_rev_array);
        // $total_miaki_array = array_reverse($total_miaki_array);
        // $total_mmlbd_array = array_reverse($total_mmlbd_array);
         // dd($total_rev_array);

    $sql="SELECT  sum(`miaki_rev`) as miaki_rev, sum(`mmlbd_rev`) as mmlbd_rev, sum(`other_rev`) as other_rev FROM `bdapps_revenue` where `rev_date` >= '".$first_last_day['first_date']."' and `rev_date` <= '".$first_last_day['last_date']."' ";

    $company_wise_rev = DB::select(DB::raw($sql));
    // dd($company_wise_rev);

    $current_month_total_revenue = array( 
       array("y" => $company_wise_rev[0]->miaki_rev, "label" => "miaki" ),
       array("y" => $company_wise_rev[0]->mmlbd_rev, "label" => "mmlbd" ),
       array("y" => $company_wise_rev[0]->other_rev, "label" => "other" )
    );

    // dd($current_month_total_revenue);
    // ::::::::::::::::::::::: forecast revenue :::::::::::::::::::::::::::

    $forecast_revenue = $this->current_month_revenue_forecast($company_wise_rev[0]->miaki_rev, $company_wise_rev[0]->mmlbd_rev, $company_wise_rev[0]->other_rev);

    $avg_rev = $forecast_revenue['avgrev'];
    $current_month_forecast_revenue = array( 
       array("y" => $forecast_revenue['miaki'], "label" => "miaki" ),
       array("y" => $forecast_revenue['mmlbd'], "label" => "mmlbd" ),
       array("y" => $forecast_revenue['other'], "label" => "other" )
    );

    // :::::::::::::::::::::::::: end of it ::::::::::::::::::::::::::::::


    


    // :::::::::::::::::::::::::::::: previous month's revenue :::::::::::::::::::::::::::
    
    $previous_month_rev = $this->previous_month_revenue(); 
    // dd($previous_month_rev);
    $previous_month_revenue = array(); 
    $previous_month_revenue[0] = array( 
       array("y" => $previous_month_rev['rev'][0]->miaki_rev, "label" => "miaki" ),
       array("y" => $previous_month_rev['rev'][0]->mmlbd_rev, "label" => "mmlbd" ),
       array("y" => $previous_month_rev['rev'][0]->other_rev, "label" => "other" )
    );

    $previous_month_revenue[1] = $previous_month_rev['month'] ;

    // dd($previous_month_revenue[0][0]['y']);
    // ::::::::::::::::::::::::::::::::: end of it :::::::::::::::::::::::::::::::::::::::


    // :::::::::::::::::::::::::::::::: MONTH WISE REVENUE IN A YEAR :::::::::::::::::::::::::::::::::::::
    $number_wise_month = array(
        "1" => "Jan",
        "2" => "Feb",
        "3" => "Mar",
        "4" => "Apr",
        "5" => "May",
        "6" => "Jun",
        "7" => "Jul",
        "8" => "Aug",
        "9" => "Sep",
        "10" => "Oct",
        "11" => "Nov",
        "12" => "Dec"
      );
    $month_wise_revenue_in_year = $this->month_wise_revenue_in_year();
    // :::::::::::::::::::::::::::::::::::::::: end of it ::::::::::::::::::::::::::::::::::::::::::::::::

    
    return view('bdapps.bdapps',compact('rev_category','all_days','day_wise_rev_array','current_month_total_revenue','current_month_forecast_revenue','previous_month_revenue','total_rev_array','total_miaki_array','total_mmlbd_array','total_other_array','avg_rev','number_wise_month','month_wise_revenue_in_year'));
    }

    
    public function get_first_last_day()
    {
        $current_month_num = date('m');
        // dd($current_month_num );
        $data['last_date'] = date("Y-m-d");
        $data['first_date'] = date("Y-$current_month_num-01",strtotime($data['last_date']));
      
        // dd($data);
        if( $data['first_date'] == $data['last_date'] || date('d')=='02')
        {
          $current_month_num = date('Y-m', strtotime('-1 month', time()));
          // dd($current_month_num);
          $data['first_date'] = date("$current_month_num-01",strtotime($data['last_date']));
          // dd($data['first_date']);
        }

        // dd($data);

        return $data;
    }



    public function get_all_days_between_two_date( $first_date,$last_date )
    {
        $days = array();
        $datediff = round((strtotime($last_date)-strtotime($first_date))/(24*60*60));
        for( $i=0; $i <= $datediff; $i++ ) {
          $days[] = date('Y-m-d', strtotime($first_date ." +$i day"));
        }
        // dd($days);
        // dd($datediff);
        session()->put('datediff',$datediff);
        // dd(session()->get('datediff'));
        return $days;
    }


    public function current_month_revenue_forecast( $miaki_rev,$mmlbd_rev,$other_rev )
    {
        $total_day = date('t');
        $current_day = date('d')-1;
        if( !$current_day ){
          $total_day = session()->get('datediff');
          $current_day = session()->get('datediff');
        }
        // dd($current_day);
     
        $miaki_forecast_rev = 0;
        $mmlbd_forecast_rev = 0;
        $other_forecast_rev = 0;
        $avg_Rev = 0;

        if( $miaki_rev > 0 ){
            $miaki_forecast_rev = (int)(( $miaki_rev/$current_day )*$total_day);
        }

        if( $mmlbd_rev > 0 ){
            $mmlbd_forecast_rev = (int)(( $mmlbd_rev/$current_day )*$total_day);
        }

        if( $other_rev > 0 ){
            $other_forecast_rev = (int)(( $other_rev/$current_day )*$total_day);
        }

        if( ( $miaki_rev + $mmlbd_rev + $other_rev ) > 0 && $current_day > 0 ){
            $avg_Rev = ( $miaki_rev + $mmlbd_rev + $other_rev )/$current_day;
        }

        $forecast_revenue = array(
                 "miaki" => $miaki_forecast_rev,
                 "mmlbd" => $mmlbd_forecast_rev,
                 "other" => $other_forecast_rev,
                 "avgrev" => $avg_Rev
            );
        // dd($forecast_revenue);
        return $forecast_revenue;
    }


    public function previous_month_revenue()
    {
         $lastmonth1_last_day = Carbon::now()->startofMonth()->subMonth('1')->endOfMonth()->toDateString();
        
         $lastmonth2_last_day = Carbon::now()->startofMonth()->subMonth('2')->endOfMonth()->toDateString();
          // dd($lastmonth2_last_day,'-', $lastmonth1_last_day);
         $month_name = date("M", strtotime($lastmonth1_last_day));
          
         $sql="SELECT  sum(`miaki_rev`) as miaki_rev, sum(`mmlbd_rev`) as mmlbd_rev, sum(`other_rev`) as other_rev FROM `bdapps_revenue` where `rev_date` > '".$lastmonth2_last_day."' and `rev_date` <= '".$lastmonth1_last_day."' ";

         $company_wise_rev = DB::select(DB::raw($sql));

         $data['rev'] = $company_wise_rev;
         $data['month'] = $month_name;

         return $data;

    }


    public function bdapps_batch_upload()
    {
    	return view('bdapps.bdapps_batch');
    }



    public function bdapps_data_submit(Request $request)
    {
       $this->validate($request, [
                                   'rev_date' => 'required',
                                   'miaki_rev' => 'required',
                                   'mmlbd_rev' => 'required',
                                   'other_rev' => 'required',
                      ]); 

       $input = $request->all();

       $infos = BdappsRevenue::where('rev_date', '=', $input['rev_date'])->first();
       if( !$infos ) {
           $infos = new BdappsRevenue();
       }
       $infos->rev_date = $input['rev_date'];
       $infos->miaki_rev = $input['miaki_rev'];
       $infos->mmlbd_rev = $input['mmlbd_rev'];
       $infos->other_rev = $input['other_rev'];
       $infos->save();

       $message="Successfully content added";
       return redirect('bdapps')->with('message',$message);
    }

    public function bdapps_batch_submit(Request $request)
    {
        $this->validate($request, [
                                   'excell' => 'required',
                      ]);

        $filename='';


        if($request->hasFile('excell'))
         {
            $str = 'excel10101010';
            $shuffled  = str_shuffle($str);
            $filename=$request->excell->getClientOriginalName();
            
            $filename=$shuffled.$filename;
            $request->excell->move('bdapps_file',$filename);
         }

        $data = Excel::load('bdapps_file/'.$filename, function($reader) {
           })->get();

        // dd($data);
        $total_row = count($data);
        $condition=0;

        Excel::load('bdapps_file/'.$filename, function($reader) use ($request, &$condition){
           $firstrow = $reader->first()->toArray();
           if(isset($firstrow['rev_date']) && isset($firstrow['miaki_rev']) && isset($firstrow['mmlbd_rev']) ) {
                       $condition=1;
                   
              }else{
                        $condition=0;
                        
                    }
          });



        
        if( $condition ){
           for( $i=0; $i<$total_row; $i++ ) {
              if($data[$i]->rev_date!=="" && $data[$i]->miaki_rev!=="" && $data[$i]->mmlbd_rev!=="") {
                               

                  $times=$data[$i]->rev_date;
                  $times=explode(" ",$times);

                  $input['rev_date'] = $times[0];
                  $input['miaki_rev'] = $data[$i]->miaki_rev;
                  $input['mmlbd_rev'] = $data[$i]->mmlbd_rev;
             
                  $infos = BdappsRevenue::where('rev_date', '=', $input['rev_date'])->first();
                  if( !$infos ) {
                      $infos = new BdappsRevenue();
                  }
                  $infos->rev_date = $input['rev_date'];
                  $infos->miaki_rev = $input['miaki_rev'];
                  $infos->mmlbd_rev = $input['mmlbd_rev'];
                  $infos->save();
                  
              }else{
                            
                    $message="Successfully $i content added. But there are some invalid/null rows!!! Please check. ";
                    return redirect('bdapps')->with('message',$message);

              }     
            }
                
            $message="Successfully content added";
            return redirect('bdapps')->with('message',$message);
                                                        
        }else{
           $message="Excel column format is worng"; 
           return redirect()->back()->with('message',$message);
         }

    }

    public function month_wise_revenue_in_year()
    {
      $toDay =  date("Y-m-d");
      $firstDay = date("Y-01-01");
      // dd($firstDay,'=====',$toDay);
      $month_wise_revenue_obj = BdappsRevenue::where('rev_date', '>=', $firstDay)
                ->where('rev_date', '<=', $toDay)
                ->select(DB::raw("MONTH(rev_date) AS month"), DB::raw("sum(miaki_rev) AS miaki_revenue"), DB::raw("sum(mmlbd_rev) AS mmlbd_revenue"), DB::raw("sum(other_rev) AS other_revenue"), DB::raw("sum(miaki_rev+mmlbd_rev+other_rev) AS total_revenue"))
                ->groupBy(DB::raw("MONTH(rev_date)"))
                ->orderBy(DB::raw("MONTH(rev_date)"),'desc')
                ->get();
      // dd($month_wise_revenue_obj);  

      $month_wise_revenue_array = array();
      $ind = 0;
      foreach ($month_wise_revenue_obj as $obj) {

          if($ind){
            $days = cal_days_in_month(CAL_GREGORIAN,$obj->month,date('Y'));
          }else{
            $days = date('d')-1;
            if(!$days) $days = 1;
          }

          $month_wise_revenue_array[$obj->month] = array(
            "miaki_revenue" => array(
               "rev" => round($obj->miaki_revenue,2),
               "ind" => 0
            ),
            "mmlbd_revenue" => array(
               "rev" => round($obj->mmlbd_revenue,2),
               "ind" => 0
            ),
            "other_revenue" => array(
               "rev" => round($obj->other_revenue,2),
               "ind" => 0
            ),
            "total_revenue" => array(
               "rev" => round($obj->total_revenue),
               "ind" => 0
            ),
            "average_revenue" => array(
               "rev" => round($obj->total_revenue/$days),
               "ind" => 0
            )
          );
          $ind++;
        }  

        // dd($month_wise_revenue_array);


        foreach ($month_wise_revenue_array as $key => $val) {
          if( array_key_exists($key-1, $month_wise_revenue_array)){
            if( $month_wise_revenue_array[$key]["miaki_revenue"]["rev"] > $month_wise_revenue_array[$key-1]["miaki_revenue"]["rev"]){
               $month_wise_revenue_array[$key]["miaki_revenue"]["ind"] = 1;
            }else{
               $month_wise_revenue_array[$key]["miaki_revenue"]["ind"] = -1;
            }

            if( $month_wise_revenue_array[$key]["mmlbd_revenue"]["rev"] > $month_wise_revenue_array[$key-1]["mmlbd_revenue"]["rev"]){
               $month_wise_revenue_array[$key]["mmlbd_revenue"]["ind"] = 1;
            }else{
               $month_wise_revenue_array[$key]["mmlbd_revenue"]["ind"] = -1;
            }

            if( $month_wise_revenue_array[$key]["other_revenue"]["rev"] > $month_wise_revenue_array[$key-1]["other_revenue"]["rev"]){
               $month_wise_revenue_array[$key]["other_revenue"]["ind"] = 1;
            }else{
               $month_wise_revenue_array[$key]["other_revenue"]["ind"] = -1;
            }

            if( $month_wise_revenue_array[$key]["total_revenue"]["rev"] > $month_wise_revenue_array[$key-1]["total_revenue"]["rev"]){
               $month_wise_revenue_array[$key]["total_revenue"]["ind"] = 1;
            }else{
               $month_wise_revenue_array[$key]["total_revenue"]["ind"] = -1;
            }

            if( $month_wise_revenue_array[$key]["average_revenue"]["rev"] > $month_wise_revenue_array[$key-1]["average_revenue"]["rev"]){
               $month_wise_revenue_array[$key]["average_revenue"]["ind"] = 1;
            }else{
               $month_wise_revenue_array[$key]["average_revenue"]["ind"] = -1;
            }
          }
        }

      // dd($month_wise_revenue_array);
      return $month_wise_revenue_array; 
    }
}

