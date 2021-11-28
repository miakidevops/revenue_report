<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ussd_session;
use App\Bdapps_service_list;
use DB;

class Bdapps_hit_count_controller extends Controller
{
    public function index(Request $request)
    {
        // dd($request->start1,'--',$request->start);
        $start = $request->start;
        $end = $request->end;
        $ussd = $request->ussd;

        if(!$start) $start = date('Y-m-d',strtotime("-1 days")) . " 00:00";
        if(!$end) $end = date('Y-m-d',strtotime("-1 days")) . " 23:59";

        $search['start'] = $start;
        $search['end'] = $end;
        $search['ussd'] = $ussd;

        $sql = "select message,COUNT(id) as hit,CAST(created_at as DATE) as date
              FROM [info_BDapps].[dbo].[tbl_ussd_session_new]
              where created_at>='".$start."'
              and created_at<='".$end."'
              and message like '%".$ussd."%'
              group by message,CAST(created_at as DATE)
              order by message,CAST(created_at as DATE) desc";
        $all_data = DB::connection('sqlsrv2')->select(DB::raw($sql));
        // dd($all_data);
        $all_ussd_code = Bdapps_service_list::distinct()->get(['ussd_code']);
        // dd($all_ussd_code);
        $all_ussd_service = Bdapps_service_list::select('ussd_code','service_desc')->get();
        $ussd_wise_service = array();
        foreach ($all_ussd_service as $value) {
          $ussd_wise_service[$value->ussd_code] = $value->service_desc;
        }
        // dd($ussd_wise_service);
        return view('churn.bdapps_hit',compact('all_data','search','all_ussd_code','ussd_wise_service'));
    }
}
