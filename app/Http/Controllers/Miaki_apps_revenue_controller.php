<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Miaki_revenue;
use App\BdappsRevenue;
use App\TargetRevenue;
use Excel;
use DB;

class Miaki_apps_revenue_controller extends Controller
{
	public function index()
	{
		$daily_status = $this->daily_status();
		$monthly_status = $this->monthly_status();
		$yearly_status = $this->yearly_status();
		$account_wise_status = $this->account_wise_status();
		$yesterdays_top_5_apps = $this->yesterdays_top_5_apps();
		$last_months_top_5_apps = $this->last_months_top_5_apps();
		$revenue_trend_comparison = $this->revenue_trend_comparison();
		$day_wise_revenue_in_month = $this->day_wise_revenue_in_month();
        $day_wise_revenue_in_month_v2 = $this->day_wise_revenue_in_month_v2();
		$month_wise_revenue_in_year = $this->month_wise_revenue_in_year();

		// dd($day_wise_revenue_in_month_v2);
		return view('miaki_apps_rev.revenue_report',compact('daily_status','monthly_status','yearly_status','account_wise_status','yesterdays_top_5_apps','last_months_top_5_apps','revenue_trend_comparison','day_wise_revenue_in_month','day_wise_revenue_in_month_v2','month_wise_revenue_in_year'));
	}


	public function daily_status()
	{
	    // dd(\Config::get('constant.million'));
		$yesterday = date('Y-m-d',strtotime('-1 day'));
		$yesterday_rev =  Miaki_revenue::where('date',$yesterday)->sum('revenue');
	    $yesterday_rev = round($yesterday_rev,2);
	    // dd($yesterday_rev);

		$day_before_yesterday = date('Y-m-d',strtotime('-2 day'));
		$day_before_yesterday_rev =  Miaki_revenue::where('date',$day_before_yesterday)->sum('revenue');
	    $day_before_yesterday_rev = round($day_before_yesterday_rev,2);
	    // dd($day_before_yesterday_rev);

		if(!$day_before_yesterday_rev) 
	        $increase_decrease = 0;
	    else
		   $increase_decrease = round((($yesterday_rev - $day_before_yesterday_rev) * 100)/$day_before_yesterday_rev,2);

        // dd(date('d'));
        if( date('d') == '01'){

            $time = explode("-",date('Y-m', strtotime(' -1 days')));
            $tot_day = (int)date('t',strtotime(' -1 days'));  

        }else {

           $time = explode("-",date('Y-m')); 
           $tot_day = (int)date('t');   
        }
	    
	    // dd($tot_day);

	    $daily_target = 0;
	    $target_revenue = TargetRevenue::where('year','LIKE',$time[0])->
	                              where('month','LIKE',$time[1])->first();
	    if($target_revenue){
	        $daily_target = round($target_revenue->revenue/$tot_day,2);
	    }  

	    // dd($daily_target);                        

		$daily_status = array(
			'yesday_rev' => $yesterday_rev,
			'day_bef_yesday_rev' => $day_before_yesterday_rev,
			'inc_dec' => $increase_decrease,
	        'daily_target' => $daily_target
		);

		// dd($daily_status);
		return $daily_status;
	}


	public function monthly_status()
	{
        if( date('d')=='01' ){

            $first_date_current_month = date('Y-m-01',strtotime('first day of last month'));
            $last_date_current_month = date('Y-m-t',strtotime('last day of last month'));

            $first_date_previous_month = date('Y-m-01',strtotime('first day of -2 month'));
            $last_date_previous_month = date('Y-m-t',strtotime('last day of -2 month'));

            $time = explode("-",date('Y-m', strtotime(' -1 days')));

            $div_day = (int)date('d',strtotime(' -1 days'));
            if(!$div_day)
                $div_day = 1;
            $tot_day = (int)date('t',strtotime(' -1 days'));


        }else{

            $first_date_current_month = date('Y-m-01');
            $last_date_current_month = date('Y-m-d');

            $first_date_previous_month = date('Y-m-01',strtotime('first day of last month'));
            $last_date_previous_month = date('Y-m-t',strtotime('last day of last month'));

            $time = explode("-",date('Y-m'));

            $div_day = (int)date('d')-1;
            if(!$div_day)
                $div_day = 1;
            $tot_day = (int)date('t');

        }

	    
        // dd($time[0],'-',$time[1]);

	    $current_month_rev = Miaki_revenue::where('date','>=',$first_date_current_month)
	    								   ->where('date','<=',$last_date_current_month)
	    								   ->sum('revenue');

	    // dd($current_month_rev) ; 								   

		$previous_month_rev = Miaki_revenue::where('date','>=',$first_date_previous_month)
										   ->where('date','<=',$last_date_previous_month)
										   ->sum('revenue');									    
	    // dd($previous_month_rev);


	    $monthly_target = 1;
	    $current_month_achievement = 0;
	    $target_revenue = TargetRevenue::where('year','LIKE',$time[0])->
	                              where('month','LIKE',$time[1])->first();
        // dd($div_day,'-',$tot_day);                          
       
                                  
	    if($target_revenue){
	        $monthly_target = $target_revenue->revenue;
            $monthly_target = round(($monthly_target*$div_day)/$tot_day,2);
	        $current_month_achievement = round(($current_month_rev*100)/$monthly_target,2);
	    } 

	    
	    $projection_rev = round(($current_month_rev*$tot_day)/$div_day,2);
	    // dd($projection_rev);

	    $monthly_status = array(
	    	'current_mon_rev' => $current_month_rev,
	        'current_mon_target' => $monthly_target,
	        'current_mon_achiev' => $current_month_achievement,
	        'projection_rev' => $projection_rev,
	    	'previous_mon_rev' => $previous_month_rev
	    );
	    // dd($monthly_status);

	    return $monthly_status;							   
	}


	public function yearly_status()
	{
		$first_date_current_year = date('Y-01-01');
		$last_date_current_year = date('Y-12-31');
		$current_year_rev = Miaki_revenue::where('date','>=',$first_date_current_year)
										   ->where('date','<=',$last_date_current_year)
										   ->sum('revenue');								   

	    $yearly_status = array(
	        'current_year_rev' => $current_year_rev
	    );

	    return $yearly_status;   									   
	}

    public function account_wise_status()
    {
    	$yesterday = date('Y-m-d',strtotime('-1 day'));
    	$yesterday_rev_obj = Miaki_revenue::select('corporate_user',DB::raw('sum(revenue) as tot_revenue'))
    	                                   ->where('date','=',$yesterday)
    									   ->groupBy('corporate_user')
    									   ->orderBy('corporate_user')
    									   ->get();
        // dd($yesterday_rev_obj); 
        $yesterday_rev_array = array();
        foreach ($yesterday_rev_obj as $obj) {
        	$yesterday_rev_array[$obj->corporate_user] = $obj->tot_revenue;	
        } 		
        // dd( $yesterday_rev_array);

    	$day_bef_yesterday = date('Y-m-d',strtotime('-2 day'));
    	$day_bef_yesterday_rev_obj = Miaki_revenue::select('corporate_user',DB::raw('sum(revenue) as tot_revenue'))
    	                                   ->where('date','=',$day_bef_yesterday)
    									   ->groupBy('corporate_user')
    									   ->orderBy('corporate_user')
    									   ->get();
        // dd($yesterday_rev_obj); 
        $day_bef_yesterday_rev_array = array();
        foreach ($day_bef_yesterday_rev_obj as $obj) {
        	$day_bef_yesterday_rev_array[$obj->corporate_user] = $obj->tot_revenue;									   	# c
        } 		
        // dd( $day_bef_yesterday_rev_array);

        $account_wise_status = array(
        	'yesterday_rev_array' => $yesterday_rev_array,
        	'day_bef_yesterday_rev_array' => $day_bef_yesterday_rev_array 
        );	

        // dd($account_wise_status);
        return $account_wise_status;



    }

	public function yesterdays_top_5_apps()
	{
		$yesterday = date('Y-m-d',strtotime('-1 day'));
		$yesterday_top_apps_array = Miaki_revenue::select('app_name','revenue')
											->where('date',$yesterday)
											->orderBy('revenue','desc')
											->take(5)->get()->toArray();


	    $yesterday_top_apps = array();
	    $app_name_list = array();
	    foreach ($yesterday_top_apps_array as $yesterday_apps) {
	    	$yesterday_top_apps[$yesterday_apps['app_name']] = $yesterday_apps['revenue'];  	
	    	array_push($app_name_list,$yesterday_apps['app_name']);
	    }
	    // dd($yesterday_top_apps); 	
	    // dd($app_name_list);	



	    $day_before_yesterday = date('Y-m-d',strtotime('-2 day'));	
	    $day_before_yesterday_top_apps_array = Miaki_revenue::select('app_name','revenue')
	    									->where('date',$day_before_yesterday)
	    									->whereIn('app_name',$app_name_list)
	    									->get()->toArray();	

	    $day_before_yesterday_top_apps = array();
	    foreach ($day_before_yesterday_top_apps_array as $day_before_yesterday_apps) {
	    	$day_before_yesterday_top_apps[$day_before_yesterday_apps['app_name']] = $day_before_yesterday_apps['revenue'];
	    } 									
	    // dd($yesterday_top_apps);	


	    $yesterdays_top_5_apps = array(
	    	'yesterday_apps' => $yesterday_top_apps,
	    	'day_bef_yesterday_apps' => $day_before_yesterday_top_apps
	    ); 

	    return $yesterdays_top_5_apps;														
	}


	public function last_months_top_5_apps()
	{
		$first_date_last_month = date('Y-m-d', strtotime("first day of -1 month"));
		$last_date_last_month = date('Y-m-d', strtotime("last day of -1 month"));
		$last_month_rev_obj = Miaki_revenue::select('app_name',DB::raw('sum(revenue) as tot_revenue'))
		                                   ->where('date','>=',$first_date_last_month)
										   ->where('date','<=',$last_date_last_month)
										   ->groupBy('app_name')
										   ->orderBy(DB::raw('sum(revenue)'),'desc')
										   ->take(5)->get();
	    
	    $last_month_rev = array();
	    $app_name_list = array();

	    foreach ($last_month_rev_obj as $obj) {
	     	array_push($app_name_list, $obj->app_name);
	     	$last_month_rev[$obj->app_name] = $obj->tot_revenue;
	    } 
	 	

	    $first_date_last_2_month = date('Y-m-d', strtotime("first day of -2 month"));
	    $last_date_last_2_month = date('Y-m-d', strtotime("last day of -2 month"));
	    
	    $last_2_month_rev_obj = Miaki_revenue::select('app_name',DB::raw('sum(revenue) as tot_revenue'))
	                                       ->where('date','>=',$first_date_last_2_month)
	    								   ->where('date','<=',$last_date_last_2_month)
	    								   ->whereIn('app_name',$app_name_list)
	    								   ->groupBy('app_name')
	    								   ->orderBy(DB::raw('sum(revenue)'),'desc')
	    								   ->get();	

	    
	    
	    $last_2_month_Rev = array();  
	    foreach ($last_2_month_rev_obj as $obj) {
	    	$last_2_month_Rev[$obj->app_name] = $obj->tot_revenue;
	    }
	    // dd($last_2_month_Rev);		

	    $last_months_top_5_apps = array(
	    	'last_month_app' => $last_month_rev,
	    	'last_2_month_app' => $last_2_month_Rev,
	    );

	    return $last_months_top_5_apps;					   							   
	}


    public function revenue_trend_comparison()
    {
    	$yesterday = date('Y-m-d',strtotime('-1 day'));
    	$yesterday_rev = Miaki_revenue::select('app_name','revenue')
    	                               ->where('date', '=', $yesterday)
    	                               ->get();
    	// dd($yesterday_rev);                               


    	$day_bef_yesterday = date('Y-m-d',strtotime('-2 day'));
    	$day_bef_yesterday_rev = Miaki_revenue::select('app_name','revenue')
    	                               ->where('date', '=', $day_bef_yesterday)
    	                               ->get();

    	$day_bef_yes_array = array();
    	foreach ($day_bef_yesterday_rev as $obj) {
    		$day_bef_yes_array[$obj->app_name] = $obj->revenue;
    	}
    	// dd($day_bef_yes_array);

    	$comparison = array(
    		"increased" => 0,
    		"decreased" => 0,
    		"unchanged" => 0
    	);

    	foreach ($yesterday_rev as $obj) {
    		if( array_key_exists($obj->app_name,$day_bef_yes_array) ){
	    		if( $obj->revenue > $day_bef_yes_array[$obj->app_name] ){
	    			$comparison["increased"]++;
	    		}elseif( $obj->revenue < $day_bef_yes_array[$obj->app_name] ){
	    			$comparison["decreased"]++;
	    		}else{
	    			$comparison["unchanged"]++;
	    		}
    	    }
    	}  

    	// dd($comparison); 
    	return $comparison;                            
    } 

    public function day_wise_revenue_in_month()
    {
    	$date['first_date'] = date("Y-m-01");
        $date['last_date'] = date("Y-m-d");

        if( $date['first_date'] == $date['last_date'] )
        {
          $date['first_date'] = date('Y-m-01', strtotime('-1 month', time()));
        }
    	

    	$day_wise_rev_obj = Miaki_revenue::where('date','>=',$date['first_date'])
    	                               ->where('date','<=',$date['last_date'])
    	                               ->select('date',DB::raw('sum(revenue) as tot_revenue'))
    	                               ->groupBy('date')
    	                               ->orderBy('date','asc')
    	                               ->get();

    	$day_wise_rev_in_month = array();
    	foreach ($day_wise_rev_obj as $obj) {
    	    $day_wise_rev_in_month[] = array(
    	    	"label" => date("d", strtotime($obj->date)),
    	    	"y" => $obj->tot_revenue
    	    );           
    	}

    	// dd($day_wise_rev_in_month);
    	return $day_wise_rev_in_month;                              
    }


    public function day_wise_revenue_in_month_v2()
    {
        $date['first_date'] = date("Y-m-01");
        $date['last_date'] = date("Y-m-d");

        if( $date['first_date'] == $date['last_date'] )
        {
          $date['first_date'] = date('Y-m-01', strtotime('-1 month', time()));
        }
        

        $day_wise_rev_obj_miaki = Miaki_revenue::where('date','>=',$date['first_date'])
                                       ->where('date','<=',$date['last_date'])
                                       ->where('corporate_user','=','Miaki')
                                       ->select('date',DB::raw('sum(revenue) as tot_revenue'))
                                       ->groupBy('date')
                                       ->orderBy('date','asc')
                                       ->get();

        $day_wise_rev_in_month_miaki = array();
        foreach ($day_wise_rev_obj_miaki as $obj) {
            $day_wise_rev_in_month_miaki[] = array(
                "label" => date("d", strtotime($obj->date)),
                "y" => $obj->tot_revenue
            );           
        }

        $day_wise_rev_obj_mmlbd = Miaki_revenue::where('date','>=',$date['first_date'])
                                       ->where('date','<=',$date['last_date'])
                                       ->where('corporate_user','=','MMLBD')
                                       ->select('date',DB::raw('sum(revenue) as tot_revenue'))
                                       ->groupBy('date')
                                       ->orderBy('date','asc')
                                       ->get();

        $day_wise_rev_in_month_mmlbd = array();
        foreach ($day_wise_rev_obj_mmlbd as $obj) {
            $day_wise_rev_in_month_mmlbd[] = array(
                "label" => date("d", strtotime($obj->date)),
                "y" => $obj->tot_revenue
            );           
        }


        $day_wise_rev_obj_other = Miaki_revenue::where('date','>=',$date['first_date'])
                                       ->where('date','<=',$date['last_date'])
                                       ->where('corporate_user','=','Other')
                                       ->select('date',DB::raw('sum(revenue) as tot_revenue'))
                                       ->groupBy('date')
                                       ->orderBy('date','asc')
                                       ->get();

        $day_wise_rev_in_month_other = array();
        foreach ($day_wise_rev_obj_other as $obj) {
            $day_wise_rev_in_month_other[] = array(
                "label" => date("d", strtotime($obj->date)),
                "y" => $obj->tot_revenue
            );           
        }

        // dd($day_wise_rev_in_month_mmlbd);  
        return $data = array(
                            "miaki" => $day_wise_rev_in_month_miaki,
                            "mmlbd" => $day_wise_rev_in_month_mmlbd,
                            "other" => $day_wise_rev_in_month_other
                       );                           
    }


     public function month_wise_revenue_in_year()
     {
     	$toDay =  date("Y-m-d");
     	$firstDay = date("Y-01-01");
     	// dd($firstDay,'=====',$toDay);
     	$month_wise_revenue_obj = Miaki_revenue::where('date', '>=', $firstDay)
     	          ->where('date', '<=', $toDay)
     	          ->select(DB::raw("MONTH(date) AS month"), DB::raw("sum(revenue) AS tot_revenue"))
     	          ->groupBy(DB::raw("MONTH(date)"))
     	          ->orderBy(DB::raw("MONTH(date)"),'asc')
     	          ->get();
     	// dd($month_wise_revenue);  

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

     	$month_wise_revenue_in_year = array();

     	foreach ($month_wise_revenue_obj as $obj) {
     	     $month_wise_revenue_in_year[] = array(
     	     	"label" => $number_wise_month[$obj->month],
     	     	"y" => $obj->tot_revenue
     	     );
     	}
     	// dd($month_wise_revenue_in_year);

        return $month_wise_revenue_in_year;	
     }

	// ------------------........---------------------........---------------
	// ======================================================================
	// ----------------------------------------------------------------------

    public function upload_revenue()
    {
    	return view('miaki_apps_rev.batch');
    }

    public function save_revenue(Request $request)
    {
    	$this->validate($request, [
    	                            'excell' => 'required',
    	                           ]);

    	$filename='';

        // :::::::::::::::::: BdappsRevenue :::::::::::::
        $bdappsRevenue = [];
        // $BdappsDate = [];
        // ::::::::::::::::::::::::::::::::::::::::::::::

    	if($request->hasFile('excell'))
    	{
    	    $file = $request->file('excell');
    	    // dd($file); 
    	    $str = 'excel10101010555';
    	    $shuffled  = str_shuffle($str);

    	    $filename = $file->getClientOriginalName();
    	    $filename = $shuffled.$filename;
    	    $file->move('miaki_apps_file/content/',$filename);
    	  
    	 }

    	$data = Excel::load('miaki_apps_file/content/'.$filename, function($reader) {
    	        })->get();
    	// dd($data);

    	$total_row = count($data);
    	for($i=0;$i<$total_row;$i++)
    	{    
    		if($data[$i]->app_name!==null && $data[$i]->date!==null && $data[$i]->revenue!==null && $data[$i]->corporate_user!==null) {    
    	        
    	        $times=$data[$i]->date;
    	        $times=explode(" ",$times);

    	        $miaki_rev = Miaki_revenue::where('date', '=', $times[0])->
    	        							where('app_name','=',$data[$i]->app_name)->first();
    	        if( !$miaki_rev ) {
    	            $miaki_rev = new Miaki_revenue();
    	        }
    	        
    	        $miaki_rev->app_name = $data[$i]->app_name;
    	        $miaki_rev->date =  $times[0];
    	        $miaki_rev->revenue = $data[$i]->revenue;
    	        $miaki_rev->registration = $data[$i]->registration;
    	        $miaki_rev->deregistration = $data[$i]->deregistration;
    	        $miaki_rev->tot_subscribers = $data[$i]->tot_subscribers;
    	        $miaki_rev->corporate_user = $data[$i]->corporate_user;

    	        $miaki_rev->save();


                // ::::::::::::::::: BdappsRevenue ::::::::::::::::
                if (!array_key_exists($miaki_rev->date, $bdappsRevenue)){

                    // array_push($BdappsDate, $miaki_rev->date);

                    $bdappsRevenue[$miaki_rev->date] = [];
                    $bdappsRevenue[$miaki_rev->date]['miaki_rev'] = 0;
                    $bdappsRevenue[$miaki_rev->date]['mmlbd_rev'] = 0;
                    $bdappsRevenue[$miaki_rev->date]['other_rev'] = 0;

                }

                if ($miaki_rev->corporate_user == "Miaki") {

                    $bdappsRevenue[$miaki_rev->date]['miaki_rev'] += $miaki_rev->revenue;

                } elseif ($miaki_rev->corporate_user == "MMLBD") {

                     $bdappsRevenue[$miaki_rev->date]['mmlbd_rev'] += $miaki_rev->revenue;
                    
                } else {

                    $bdappsRevenue[$miaki_rev->date]['other_rev'] += $miaki_rev->revenue;

                }

                
                // ::::::::::::::::::::::::::::::::::::::::::::::::


    	    }else{
                $this->updateOrInsert($bdappsRevenue);
    	        $message1 = "Successfully content added. But there are some invalid/null rows!!! Please check."; 
    	        return redirect('miaki_revenue')->with('message1',$message1); 
    	    }  
    	}
        $this->updateOrInsert($bdappsRevenue);
    	$message="Successfully content added";
    	return redirect('miaki_revenue')->with('message',$message); 
    }

    private function updateOrInsert($all_data) {

        foreach ($all_data as $key => $data) {
            
            $info = BdappsRevenue::where('rev_date', '=', $key)->first();
            if( !$info ) {
                $info = new BdappsRevenue();
            }
            $info->rev_date = $key;
            $info->miaki_rev = $data['miaki_rev'];
            $info->mmlbd_rev = $data['mmlbd_rev'];
            $info->other_rev = $data['other_rev'];
            $info->save();

        }
    }


    public function save_target_revenue(Request $request)
    {
    	$data = $request->all();
    	$time = explode("-",$data['target_date']);
    	// dd($time);
    	$message = "Successfully Targeted Revenue Data Updated!";

    	$revenue = TargetRevenue::where('year','LIKE',$time[0])->
    							  where('month','LIKE',$time[1])->first();
    	if( !$revenue ){
    		$revenue = new TargetRevenue;
    		$message = "Successfully Targeted Revenue Data Added!";
    	}
    	$revenue->year = $time[0];
    	$revenue->month = $time[1];
    	$revenue->revenue = $data['revenue'];
    	$revenue->save();

    	return redirect('all_target_revenue')->with('message2',$message);
    }

    public function all_target_revenue()
    {
    	$all_data = TargetRevenue::orderBy('year','desc')->orderBy('month','desc')->get();
    	// dd($all_data);
    	$month_name = array(
    		"01" => "January",
    		"02" => "February",
    		"03" => "March",
    		"04" => "April",
    		"05" => "May",
    		"06" => "June",
    		"07" => "July",
    		"08" => "August",
    		"09" => "September",
    		"10" => "October",
    		"11" => "November",
    		"12" => "December"
    	);
    	// dd($month_name);

        $toDay =  date("Y-m-d");
        $firstDay = date("2019-12-01");
        // dd($firstDay,'=====',$toDay);
        $month_wise_revenue_obj = Miaki_revenue::where('date', '>=', $firstDay)
                  ->where('date', '<=', $toDay)
                  ->select(DB::raw("MONTH(date) AS month"), DB::raw("YEAR(date) AS year"), DB::raw("sum(revenue) AS tot_revenue"))
                  ->groupBy(DB::raw("MONTH(date)"))
                  ->groupBy(DB::raw("YEAR(date)"))
                  ->orderBy(DB::raw("YEAR(date)"),'desc')
                  ->orderBy(DB::raw("MONTH(date)"),'desc')
                  ->get();
        // dd($month_wise_revenue_obj);

        $month_wise_revenue = array();
        foreach ($month_wise_revenue_obj as $obj) {
            $month_wise_revenue[] = $obj->tot_revenue;         
        } 
        // dd($month_wise_revenue);         

    	return view('miaki_apps_rev.target',compact('all_data','month_name','month_wise_revenue'));
    }

    // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    // -----------------------------------------------------------
    // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    public function detail_miaki_revenue( Request $request )
    {
        $first_day = $request->start; 
        $last_day = $request->end;

        if( !$first_day ){
            $first_day = date('Y-m-01');
        }

        if( !$last_day ){
            $last_day = date('Y-m-d');
        }
         
        if( $first_day == $last_day )
        {
          $current_month_num = date('Y-m', strtotime('-1 month', time()));
          $first_day = date("$current_month_num-01",strtotime($last_day));
        }

        $all_days = $this->get_all_days_between_two_date($first_day,$last_day);
        // dd($all_days);

        $sql = "SELECT app_name FROM miaki_revenue GROUP BY app_name ORDER BY SUM(revenue) DESC";
        $distinct_app_name = DB::select(DB::raw($sql));
        // dd($distinct_app_name); 

        $all_revenue = Miaki_revenue::where('date','>=',$first_day)
                                      ->where('date','<=',$last_day)
                                      ->orderBy('date','desc')
                                      ->get();

        $app_wise_account = array();
        foreach ($all_revenue as $obj) {
            if( !array_key_exists($obj->app_name, $app_wise_account) ){
                $app_wise_account[$obj->app_name] = $obj->corporate_user;
            }                
        }      
        // dd($app_wise_account);                    

        
        $all_data = array();
        foreach( $all_revenue as $obj )
        {
            if( !array_key_exists($obj->app_name, $all_data) ){
                $all_data[$obj->app_name] = array();
            }

            if( !array_key_exists($obj->date, $all_data[$obj->app_name]) ){
                $all_data[$obj->app_name][$obj->date] = array(
                    'revenue' => $obj->revenue,
                    'ind' => 0
                );
            }
        }


        foreach ($all_data as $key_as_appname => $value) {
            foreach ($value as $key_as_date => $value2) {
                $prev_day = date("Y-m-d", strtotime($key_as_date." -1 DAY"));

                if( array_key_exists($prev_day, $value)){
                    if(($prev_day_rev = $all_data[$key_as_appname][$prev_day]["revenue"]) > 0){
                        $ind = 0;
                        if( $value2['revenue'] > $prev_day_rev ){
                            $ind = 1;
                        }elseif($value2['revenue'] < $prev_day_rev){
                            $ind = -1;
                        }

                        $all_data[$key_as_appname][$key_as_date]["ind"] = $ind;
                    }
                }
            }
        }

        $total_rev_of_a_date_range = Miaki_revenue::where('date','>=',$first_day)
                                      ->where('date','<=',$last_day)
                                      ->sum('revenue');

        $sql = "SELECT date, sum(revenue) as sum_rev FROM miaki_revenue where date >= '".$first_day."' and date <= '".$last_day."' GROUP BY date order by date desc";
        $revenue_by_date = DB::select(DB::raw($sql));
        // dd($revenue_by_date);
        $revenue_by_date_array = array();
        foreach ($revenue_by_date as $obj) {
            if(!array_key_exists($obj->date, $revenue_by_date_array)){
                $revenue_by_date_array[$obj->date] = array(
                    "rev" => $obj->sum_rev,
                    "ind" => 0
                );
            }
        }
        // dd($revenue_by_date_array);

        foreach ($revenue_by_date_array as $key_as_date => $value) {
            $prev_day = date("Y-m-d", strtotime($key_as_date." -1 DAY"));

            if( array_key_exists($prev_day, $revenue_by_date_array) ){
                if( ($prev_day_rev = $revenue_by_date_array[$prev_day]['rev'])>0 ){
                    $ind = 0;
                    if( $value['rev'] > $prev_day_rev ){
                        $ind = 1;
                    }elseif($value['rev'] < $prev_day_rev){
                        $ind = -1;
                    }
                    $revenue_by_date_array[$key_as_date]['ind'] = $ind;
                }
                
            }
        }
        // dd($revenue_by_date_array);
        
        $sql = "SELECT app_name, sum(revenue) as sum_rev FROM miaki_revenue where date >= '".$first_day."' and date <= '".$last_day."' GROUP BY app_name order by sum_rev desc";
        $revenue_by_apps = DB::select(DB::raw($sql));
        // dd($revenue_by_apps);
        $revenue_by_apps_array = array();
        foreach ($revenue_by_apps as $obj) {
            if( !array_key_exists($obj->app_name, $revenue_by_apps_array) ){
                $revenue_by_apps_array[$obj->app_name] = $obj->sum_rev;
            }
        }
        // dd($revenue_by_apps_array);


        // dd($all_data);   
        // return view('miaki_apps_rev.detail_revenue',compact('all_days','distinct_app_name','app_wise_account','all_data','revenue_by_date_array'));

        return view('miaki_apps_rev.detail_revenue_2',compact('all_days','first_day','last_day','total_rev_of_a_date_range','distinct_app_name','app_wise_account','all_data','revenue_by_date_array','revenue_by_apps_array'));
                                  
    }

    public function get_all_days_between_two_date( $first_date,$last_date )
    {
        $days = array();
        $datediff = round((strtotime($last_date)-strtotime($first_date))/(24*60*60));
        for( $i=0; $i <= $datediff; $i++ ) {
          $days[] = date('Y-m-d', strtotime($first_date ." +$i day"));
        }
        
        return $days;
    }


    // ==========================================================================================

    public function financial_review(Request $request)
    {
        if( $request->has('start') && $request->has('end') ){
            $search['start'] = $request->input('start');
            $search['end'] = $request->input('end');
        }else{
            $search['start'] = date("Y-m-d", strtotime("-29 day"));
            $search['end'] = date('Y-m-d');
        }


        $month_name = array(
            "1" => "January",
            "2" => "February",
            "3" => "March",
            "4" => "April",
            "5" => "May",
            "6" => "June",
            "7" => "July",
            "8" => "August",
            "9" => "September",
            "10" => "October",
            "11" => "November",
            "12" => "December"
        );

        $month_wise_all_revenue_obj = BdappsRevenue::select( DB::raw('sum(miaki_rev) as tot_miaki_rev'),
                                            DB::raw('sum(mmlbd_rev) as tot_mmlbd_rev'),
                                            DB::raw('sum(other_rev) as tot_other_rev'), 
                                            DB::raw('YEAR(rev_date) year, 
                                                    MONTH(rev_date) month')) 
                                      ->where('rev_date','>=',$search['start'])
                                      ->where('rev_date','<=',$search['end']) 
                                      ->groupby('year','month')
                                      ->get();


        $month_wise_all_revenue = [];

        foreach ($month_wise_all_revenue_obj as $obj) {
            $month_wise_all_revenue[] = array(
                "year" => $obj->year,
                "month" => $obj->month,
                "miaki_rev" => $this->getCalculatedValue($obj->tot_miaki_rev),
                "mmlbd_rev" => $this->getCalculatedValue($obj->tot_mmlbd_rev),
                "other_rev" => $this->getCalculatedValue($obj->tot_other_rev),
            );
        }

        dd($month_wise_all_revenue);


        return view('miaki_apps_rev.financial_review',compact('search', 'month_name', 'month_wise_all_revenue'));
    }


    private function getCalculatedValue ( $value ) 
    {

        $value =  ( $value - ($value * (6.5/100)) )/2;
        $value = round( $value - ($value * (5/100)) );
        return $value;

    }


    public function financial_review2(Request $request)
    {
        if( $request->has('start') && $request->has('end') ){
            $search['start'] = $request->input('start');
            $search['end'] = $request->input('end');
        }else{
            $search['start'] = date("Y-m-d", strtotime("-29 day"));
            $search['end'] = date('Y-m-d');
        }
        // dd($search);

        $tot_revenue = Miaki_revenue::select(DB::raw('sum(revenue) as tot_rev'), 
                                            DB::raw('YEAR(created_at) year, 
                                                    MONTH(created_at) month')) 
                                      ->where('date','>=',$search['start'])
                                      ->where('date','<=',$search['end']) 
                                      ->groupby('year','month')
                                      ->get();

        // dd($tot_revenue);

        // $btrc_revenue = ($tot_revenue[0]->tot_rev * 6.5)/100; 
        // $miaki_robi_rev = $tot_revenue[0]->tot_rev - $btrc_revenue; 
        // $miaki_rev = $miaki_robi_rev/2;    
        // $vat = ($miaki_rev * 5)/105;
        // $final_revenue = $miaki_rev - $vat;                    
                
        // $data = array(
        //     'tot_revenue' => $tot_revenue[0]->tot_rev,
        //     'btrc_revenue' => $btrc_revenue,
        //     'miaki_robi_rev' => $miaki_robi_rev,
        //     'miaki_rev' => $miaki_rev,
        //     'vat' => $vat,
        //     'final_revenue' => $final_revenue
        // );  

        $all_data = [];
        $ind = 0;
        foreach ($tot_revenue as $revenue) {

            $btrc_revenue = ($revenue->tot_rev * 6.5)/100; 
            $miaki_robi_rev = $revenue->tot_rev - $btrc_revenue; 
            $miaki_rev = $miaki_robi_rev/2;    
            $vat = ($miaki_rev * 5)/105;
            $final_revenue = $miaki_rev - $vat;

            $all_data[$ind] = [];
            $all_data[$ind]['tot_revenue'] = $revenue->tot_rev;
            $all_data[$ind]['btrc_revenue'] = $btrc_revenue;
            $all_data[$ind]['miaki_robi_rev'] = $miaki_robi_rev;
            $all_data[$ind]['miaki_rev'] = $miaki_rev;
            $all_data[$ind]['vat'] = $vat;
            $all_data[$ind]['final_revenue'] = $final_revenue;
            $all_data[$ind]['month'] = $revenue->month;
            $all_data[$ind]['year'] = $revenue->year;

            $ind++;
        }      
        // dd($all_data) ;

        // :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

        $tot_revenue_miaki = Miaki_revenue::select(DB::raw('sum(revenue) as tot_rev'),
                                            DB::raw('YEAR(created_at) year, 
                                                    MONTH(created_at) month')) 
                                      ->where('date','>=',$search['start'])
                                      ->where('date','<=',$search['end']) 
                                      ->where('corporate_user','=','Miaki')
                                      ->groupby('year','month')
                                      ->get();

        // dd($tot_revenue_miaki);

        $all_data_miaki = [];
        $ind = 0;

        foreach ($tot_revenue_miaki as $revenue) {

            $btrc_revenue = ($revenue->tot_rev * 6.5)/100; 
            $miaki_robi_rev = $revenue->tot_rev - $btrc_revenue; 
            $miaki_rev = $miaki_robi_rev/2;    
            $vat = ($miaki_rev * 5)/105;
            $final_revenue = $miaki_rev - $vat;                    
                    
            $all_data_miaki[$ind] = array(
                'tot_revenue_miaki' => $revenue->tot_rev,
                'btrc_revenue' => $btrc_revenue,
                'miaki_robi_rev' => $miaki_robi_rev,
                'miaki_rev' => $miaki_rev,
                'vat' => $vat,
                'final_revenue' => $final_revenue,
                'month' => $revenue->month,
                'year' => $revenue->year
            );  

            $ind++;      
        }

        // dd($all_data_miaki) ;

        // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

        $tot_revenue_mmlbd = Miaki_revenue::select(DB::raw('sum(revenue) as tot_rev'),
                                            DB::raw('YEAR(created_at) year, 
                                                    MONTH(created_at) month')) 
                                      ->where('date','>=',$search['start'])
                                      ->where('date','<=',$search['end']) 
                                      ->where('corporate_user','=','MMLBD')
                                      ->groupby('year','month')
                                      ->get();

        $all_data_mmlbd = [];
        $ind = 0;

        foreach ($tot_revenue_miaki as $revenue) {

            $btrc_revenue = ($revenue->tot_rev * 6.5)/100; 
            $miaki_robi_rev = $revenue->tot_rev - $btrc_revenue; 
            $miaki_rev = $miaki_robi_rev/2;    
            $vat = ($miaki_rev * 5)/105;
            $final_revenue = $miaki_rev - $vat;                    
                    
            $all_data_mmlbd[$ind] = array(
                'tot_revenue_mmlbd' => $revenue->tot_rev,
                'btrc_revenue' => $btrc_revenue,
                'miaki_robi_rev' => $miaki_robi_rev,
                'miaki_rev' => $miaki_rev,
                'vat' => $vat,
                'final_revenue' => $final_revenue,
                'month' => $revenue->month,
                'year' => $revenue->year
            );  

            $ind++;      
        }

        // dd($all_data_mmlbd) ;

        return view('miaki_apps_rev.financial_review',compact('search','all_data','all_data_miaki','all_data_mmlbd')); 
    }
}
