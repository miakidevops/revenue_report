<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Intake_churn_model;
use App\shortcode_and_keyword;
use App\Active_subscriber;
use DB;

class Intake_churn_controller extends Controller
{
    public function index(Request $request)
    {
        $start = $request->start;
        $end = $request->end;
        $shortcode = $request->shortcode;
        $keyword = $request->keyword;

        if(!$start) $start = date('Y-m-d',strtotime("-1 days"));
        if(!$end) $end = date('Y-m-d',strtotime("-1 days"));

        $search['start'] = $start;
        $search['end'] = $end;
        $search['shortcode'] = $shortcode;
        $search['keyword'] = $keyword;

        $sql = "SELECT shortcode,keyword,operator,intake,churn,CAST(creation_time as date) as date
              FROM [info].[dbo].[tbl_intake_churn]
              where CAST(creation_time as date)>='".$start."'
              and CAST(creation_time as date)<='".$end."'
              and shortcode like '%".$shortcode."%'
              and keyword like '%".$keyword."%'
              order by shortcode, creation_time asc";
        $all_data = DB::connection('sqlsrv')->select(DB::raw($sql));
        // dd($all_data);
        $result = $this->all_shortcode_and_keyword($start, $end, $search);
        $subscriber_base = $this->get_all_active_users_number($start, $end, $shortcode, $keyword);
        // dd($subscriber_base);

        foreach ($all_data as $value) {
            if(
                array_key_exists($value->shortcode, $result)
                && array_key_exists($value->keyword, $result[$value->shortcode])){

                    if(array_key_exists($value->date, $result[$value->shortcode][$value->keyword]) && array_key_exists($value->operator, $result[$value->shortcode][$value->keyword][$value->date])){

                            $result[$value->shortcode][$value->keyword][$value->date][$value->operator] = array(
                                    'intake' => $value->intake,
                                    'churn' => $value->churn,
                                    'total_sub' => 0
                                    );
                        
                    }
            }
        }


        foreach ($result as $shortcode_key => $value) {
            foreach ($value as $keyword_key => $value2) {
                foreach ($value2 as $date_key => $value3) {
                    foreach ($value3 as $operator_key => $value4) {
                        $total_sub = 0;
                        if(
                            array_key_exists($shortcode_key, $subscriber_base) && 
                            array_key_exists($keyword_key, $subscriber_base[$shortcode_key]) &&
                            array_key_exists($date_key, $subscriber_base[$shortcode_key][$keyword_key]) && 
                            array_key_exists($operator_key, $subscriber_base[$shortcode_key][$keyword_key][$date_key]) &&
                            array_key_exists('total_sub', $subscriber_base[$shortcode_key][$keyword_key][$date_key][$operator_key])

                        ){
                            $total_sub = $subscriber_base[$shortcode_key][$keyword_key][$date_key][$operator_key]['total_sub'];
                            $result[$shortcode_key][$keyword_key][$date_key][$operator_key]['total_sub'] = $total_sub;
                        }
                    }
                }
            }
        }
        // dd($result);
        $distinct_shortcode = shortcode_and_keyword::distinct()->get(['shortcode']);
        $distinct_keyword = shortcode_and_keyword::distinct()->get(['keyword']);
        // dd($distinct_keyword);

        // dd($result);

        return view('churn.churn',compact('result','search','distinct_shortcode','distinct_keyword'));
    }


    public function all_shortcode_and_keyword($start, $end, $search)
    {

        $days = $this->get_all_days_between_two_date($start, $end);
        $result = array();
        // $data = shortcode_and_keyword::all();
        $data = shortcode_and_keyword::where('id', '>', 0);
        if( !empty($search['shortcode']) ) {
         $data = $data->where('shortcode','=',$search['shortcode']);
        }

        if( !empty($search['keyword']) ) {
            $data = $data->where('keyword','LIKE','%'.$search['keyword'].'%');
        }

        $data = $data->orderBy('id', 'desc')->get();
        // dd($data);
        foreach ($data as $value) {
            if(!array_key_exists(trim($value->shortcode), $result)){
                $result[trim($value->shortcode)] = array();
            }

            if(!array_key_exists(trim($value->keyword),$result[trim($value->shortcode)])){
                $result[trim($value->shortcode)][trim($value->keyword)] = array();

                foreach($days as $day){
                    // $result[$value->shortcode][$value->keyword][$day] = array();
                    $result[trim($value->shortcode)][trim($value->keyword)][$day]['88018'] = array(
                        'intake' => 0,
                        'churn' => 0,
                        'total_sub' => 0
                    );
                    $result[trim($value->shortcode)][trim($value->keyword)][$day]['88016'] = array(
                        'intake' => 0,
                        'churn' => 0,
                        'total_sub' => 0
                    );
                }
            }
        }
        // dd($result);
        return $result;
    }


    public function get_all_active_users_number($start, $end, $shortcode, $keyword)
    {
        $sql = "SELECT shortcode,keyword,operator_prefix,CAST(creation_time as date) as date       ,active_subscriber
              FROM [info].[dbo].[tbl_active_subscriber]
              where CAST(creation_time as date)>='".$start."'
              and CAST(creation_time as date)<='".$end."'
              and shortcode like '%".$shortcode."%'
              and keyword like '%".$keyword."%'
              ";
        $subscriber_data = DB::connection('sqlsrv')->select(DB::raw($sql));
        // dd($subscriber_data);
        $result = array();
        foreach ($subscriber_data as $value) {
            if(!array_key_exists(trim($value->shortcode), $result)){
                $result[trim($value->shortcode)] = array();
            }

            if(!array_key_exists(trim($value->keyword),$result[trim($value->shortcode)])){
                $result[trim($value->shortcode)][trim($value->keyword)] = array();
            }

            if(!array_key_exists(trim($value->date),$result[trim($value->shortcode)][trim($value->keyword)])){
                $result[trim($value->shortcode)][trim($value->keyword)][trim($value->date)] = array();
            }

            $result[trim($value->shortcode)][trim($value->keyword)][trim($value->date)][trim($value->operator_prefix)] = array(
                'total_sub' => $value->active_subscriber
            );
        
        }
        // dd($result);
        return $result;
    }

    public function get_all_days_between_two_date($first_date,$last_date)
    {
        $days = array();
        $datediff = round((strtotime($last_date)-strtotime($first_date))/(24*60*60));
        for($i=0; $i <= $datediff; $i++) {
          $days[] = date('Y-m-d', strtotime($first_date ." +$i day"));
        }

        return $days;
    }
}
