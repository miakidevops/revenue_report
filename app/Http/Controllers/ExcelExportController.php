<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Content;
use App\Shortcode;
use Excel;
class ExcelExportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
                     echo "->" ,$shortcode = session()->get('shortcode');
                     echo "->" ,$service = session()->get('service');
                     echo "->" ,$keyword = session()->get('keyword');
                     echo "->" ,$start = session()->get('start');
                     echo "->" ,$end = session()->get('end');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $all_data="";
                      $shortcode = session()->get('shortcode');
                      $service = session()->get('service');
                      $keyword = session()->get('keyword');
                      $start = session()->get('start');
                      $end = session()->get('end');

                      $search['shortcode']=$shortcode;
                      $search['service']=$service;
                      $search['keyword']=$keyword;
                      $search['start']=$start;
                      $search['end']=$end;

                      //dd('a');
                     
                     if( (!empty($shortcode))&&(!empty($service))&&(!empty($keyword))&&(!empty($start))&&(!empty($end)) ){
                       
                           $all_data=Content::where('shortcode','LIKE',$shortcode)->
                                              where('service_type','LIKE',$service)->
                                              where('keyword','LIKE',$keyword)->
                                              where('time','>=',$start)->
                                              where('time','<=',$end)->
                                              orderBy('id', 'desc')->get();
                                                    

                       }elseif( (!empty($shortcode))&&(!empty($service))&&(!empty($keyword))) {
                       
                           $all_data=Content::where('shortcode','LIKE',$shortcode)->
                                              where('service_type','LIKE',$service)->
                                              where('keyword','LIKE',$keyword)->
                                              orderBy('id', 'desc')->get();
                                                    

                       }elseif( (!empty($shortcode))&&(!empty($service))&&(!empty($start))&&(!empty($end)) ){
                       
                           $all_data=Content::where('shortcode','LIKE',$shortcode)->
                                              where('service_type','LIKE',$service)->
                                              where('time','>=',$start)->
                                              where('time','<=',$end)->
                                              orderBy('id', 'desc')->get();
                                                    

                       }elseif( (!empty($shortcode))&&(!empty($service))&&(!empty($start))&&(!empty($end)) ){
                       
                           $all_data=Content::where('shortcode','LIKE',$shortcode)->
                                              where('service_type','LIKE',$service)->
                                              where('time','>=',$start)->
                                              where('time','<=',$end)->
                                              orderBy('id', 'desc')->get();
                                                    

                       }elseif( (!empty($keyword))&&(!empty($service))&&(!empty($start))&&(!empty($end)) ){
                       
                           $all_data=Content::where('keyword','LIKE',$keyword)->
                                              where('service_type','LIKE',$service)->
                                              where('time','>=',$start)->
                                              where('time','<=',$end)->
                                              orderBy('id', 'desc')->get();
                                                    

                       }elseif( (!empty($shortcode))&&(!empty($service)) ){
                       
                           $all_data=Content::where('shortcode','LIKE',$shortcode)->
                                              where('service_type','LIKE',$service)->
                                              orderBy('id', 'desc')->get();
                                                    

                       }elseif( (!empty($shortcode))&&(!empty($keyword)) ){
                       
                           $all_data=Content::where('shortcode','LIKE',$shortcode)->
                                              where('keyword','LIKE',$keyword)->
                                              orderBy('id', 'desc')->get();
                                                    

                       }elseif( (!empty($shortcode))&&(!empty($start))&&(!empty($end)) ){
                       
                           $all_data=Content::where('shortcode','LIKE',$shortcode)->
                                              where('time','>=',$start)->
                                              where('time','<=',$end)->
                                              orderBy('id', 'desc')->get();
                                                    

                       }elseif( (!empty($service))&&(!empty($keyword)) ){
                       
                           $all_data=Content::where('keyword','LIKE',$keyword)->
                                              where('service_type','LIKE',$service)->
                                              orderBy('id', 'desc')->get();
                                                    

                       }elseif( (!empty($service))&&(!empty($start))&&(!empty($end)) ){
                       
                           $all_data=Content::where('service_type','LIKE',$service)->
                                              where('time','>=',$start)->
                                              where('time','<=',$end)->
                                              orderBy('id', 'desc')->get();
                                                    

                       } elseif( (!empty($keyword))&&(!empty($start))&&(!empty($end)) ){
                      
                          $all_data=Content::where('keyword','LIKE',$keyword)->
                                             where('time','>=',$start)->
                                             where('time','<=',$end)->
                                             orderBy('id', 'desc')->get();
                                                   

                      }elseif( (!empty($shortcode)) ){
                      
                          $all_data=Content::where('shortcode','LIKE',$shortcode)->
                                             orderBy('id', 'desc')->get();
                                                   

                      }elseif( (!empty($service)) ){
                      
                          $all_data=Content::where('service_type','LIKE',$service)->
                                             orderBy('id', 'desc')->get();
                                                   

                      }elseif( (!empty($keyword))){
                      
                          $all_data=Content::where('keyword','LIKE',$keyword)->
                                             orderBy('id', 'desc')->get();
                                                   

                      }elseif( (!empty($start))&&(!empty($end)) ){
                      
                          $all_data=Content::where('time','>=',$start)->
                                             where('time','<=',$end)->
                                             orderBy('id', 'desc')->get();
                                                   

                      }else{

                        $end=strtotime("today");
                        $end= date("Y-m-d", $end);

                        $start=strtotime("-30 days");
                        $start= date("Y-m-d", $start);
                       
                       $all_data=Content::where('time','>=',$start)->
                                          where('time','<=',$end)->
                                          orderBy('id', 'desc')->get();
                              
                           } 
                      $download=date("d-m-Y H:i:sa");
                      Excel::create($download, function($excel) use($all_data,$search) {

                          $excel->sheet('result', function($sheet) use($all_data,$search) {
               $searchs=$search;               

              $sheet->row(1,array('shortcode',$searchs['shortcode']));
              $sheet->row(2,array('service',$searchs['service']));
              $sheet->row(3,array('keyword',$searchs['keyword']));
              $sheet->row(4,array('start',$searchs['start']));
              $sheet->row(5,array('end',$searchs['end']));



              $sheet->row(10, array('Time','Shortcode','Keyword','Service_id','Service_name','Company_name','Product_id','Type','Total_revenue','Share','Vat','Miaki_revenue'));
                              // $all_infos=session()->get('all_info');
                              $all_infos=$all_data;
                              // echo count($all_infos);
                              // dd("aa");
                    $total_miaki_rev =0;
                    $total_rev =0;
                    $total_vat =0;          
                                for($i=1;$i<=count($all_infos);$i++){

              

              $total_miaki_rev +=$all_infos["$i"-1]->miaki_revenue;
              $total_rev +=$all_infos["$i"-1]->total_revenue;
              $total_vat +=$all_infos["$i"-1]->vat;

              $data3 = array($all_infos["$i"-1]->time,
                             $all_infos["$i"-1]->shortcode,
                             $all_infos["$i"-1]->keyword,
                             $all_infos["$i"-1]->service_id,
                             $all_infos["$i"-1]->service_name,
                             $all_infos["$i"-1]->company_name,
                             $all_infos["$i"-1]->product_id,
                             $all_infos["$i"-1]->type,
                             $all_infos["$i"-1]->total_revenue,
                             $all_infos["$i"-1]->share,
                             $all_infos["$i"-1]->vat,
                             $all_infos["$i"-1]->miaki_revenue);
              $sheet->row($i+10, $data3);
                                }
                                 // $sheet->fromArray($data3,null,"A$i",false,false);   

                $sheet->row(6,array('total revenue:',$total_rev));
                $sheet->row(7,array('total vat:',$total_vat));
                $sheet->row(8,array('total miaki revenue:',$total_miaki_rev));
                          });

                      })->download('xls');
                      // store('xls', storage_path('storage/export/'));
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
