<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Content;
use App\Shortcode;
use App\Achieved;
use Excel;
class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
         $shortcode= $request->input('shortcode');
         $service= $request->input('service_type');
         $keyword= $request->input('keyword');

         if( $request->has('start') ) {
          $start= $request->input('start');
         } else {
          $start_day=strtotime("-30 days");
          $start= date("Y-m-d", $start_day);
         }
         
         if( $request->has('end') ) {
          $end= $request->input('end');
         } else {
          $end_day=strtotime("today");
          $end= date("Y-m-d", $end_day);
         }
        

         $search['shortcode']=$shortcode;
         $search['service']=$service;
         $search['keyword']=$keyword;
         $search['start']=$start;
         $search['end']=$end;
         
        
         $all_data="";
        session()->put('shortcode',$shortcode);
        session()->put('service',$service);
        session()->put('keyword',$keyword);
        session()->put('start',$start);
        session()->put('end',$end);

         $short_code = Shortcode::orderBy('shortcode')->distinct()->get(['shortcode']);
         $service_type = Content::orderBy('service_type')->distinct()->get(['service_type']);
         $keywords = Shortcode::orderBy('keyword')->distinct()->get(['keyword']);

         $all_data = Content::where('id', '>', 0);

         if( !empty($shortcode) ) {
          $all_data = $all_data->where('shortcode','LIKE',$shortcode);
         }

         if( !empty($service) ) {
          $all_data = $all_data->where('service_type','LIKE',$service);          
         }

         if( !empty($keyword) ) {
          $all_data = $all_data->where('keyword','LIKE',$keyword);
         }

         if( !empty($start) ) {
          $all_data = $all_data->where('time','>=',$start);
         }

         if( !empty($end) ) {
          $all_data = $all_data->where('time','<=',$end);
         }

         $all_data = $all_data->orderBy('id', 'desc')->get();
         
         // if( (!empty($shortcode))&&(!empty($service))&&(!empty($keyword))&&(!empty($start))&&(!empty($end)) ){
           
         //       $all_data=Content::where('shortcode','LIKE',$shortcode)->
         //                          where('service_type','LIKE',$service)->
         //                          where('keyword','LIKE',$keyword)->
         //                          where('time','>=',$start)->
         //                          where('time','<=',$end)->
         //                          orderBy('id', 'desc')->get();
                                        

         //   }elseif( (!empty($shortcode))&&(!empty($service))&&(!empty($keyword))) {
           
         //       $all_data=Content::where('shortcode','LIKE',$shortcode)->
         //                          where('service_type','LIKE',$service)->
         //                          where('keyword','LIKE',$keyword)->
         //                          orderBy('id', 'desc')->get();
                                        

         //   }elseif( (!empty($shortcode))&&(!empty($service))&&(!empty($start))&&(!empty($end)) ){
           
         //       $all_data=Content::where('shortcode','LIKE',$shortcode)->
         //                          where('service_type','LIKE',$service)->
         //                          where('time','>=',$start)->
         //                          where('time','<=',$end)->
         //                          orderBy('id', 'desc')->get();
                                        

         //   }elseif( (!empty($shortcode))&&(!empty($keyword))&&(!empty($start))&&(!empty($end)) ){
           
         //       $all_data=Content::where('shortcode','LIKE',$shortcode)->
         //                          where('keyword','LIKE',$keyword)->
         //                          where('time','>=',$start)->
         //                          where('time','<=',$end)->
         //                          orderBy('id', 'desc')->get();
                                        

         //   }elseif( (!empty($keyword))&&(!empty($service))&&(!empty($start))&&(!empty($end)) ){
           
         //       $all_data=Content::where('keyword','LIKE',$keyword)->
         //                          where('service_type','LIKE',$service)->
         //                          where('time','>=',$start)->
         //                          where('time','<=',$end)->
         //                          orderBy('id', 'desc')->get();
                                        

         //   }elseif( (!empty($shortcode))&&(!empty($service)) ){
           
         //       $all_data=Content::where('shortcode','LIKE',$shortcode)->
         //                          where('service_type','LIKE',$service)->
         //                          orderBy('id', 'desc')->get();
                                        

         //   }elseif( (!empty($shortcode))&&(!empty($keyword)) ){
           
         //       $all_data=Content::where('shortcode','LIKE',$shortcode)->
         //                          where('keyword','LIKE',$keyword)->
         //                          orderBy('id', 'desc')->get();
                                        

         //   }elseif( (!empty($shortcode))&&(!empty($start))&&(!empty($end)) ){
           
         //       $all_data=Content::where('shortcode','LIKE',$shortcode)->
         //                          where('time','>=',$start)->
         //                          where('time','<=',$end)->
         //                          orderBy('id', 'desc')->get();
                                        

         //   }elseif( (!empty($service))&&(!empty($keyword)) ){
           
         //       $all_data=Content::where('keyword','LIKE',$keyword)->
         //                          where('service_type','LIKE',$service)->
         //                          orderBy('id', 'desc')->get();
                                        

         //   }elseif( (!empty($service))&&(!empty($start))&&(!empty($end)) ){
           
         //       $all_data=Content::where('service_type','LIKE',$service)->
         //                          where('time','>=',$start)->
         //                          where('time','<=',$end)->
         //                          orderBy('id', 'desc')->get();
                                        

         //   } elseif( (!empty($keyword))&&(!empty($start))&&(!empty($end)) ){
          
         //      $all_data=Content::where('keyword','LIKE',$keyword)->
         //                         where('time','>=',$start)->
         //                         where('time','<=',$end)->
         //                         orderBy('id', 'desc')->get();
                                       

         //  }elseif( (!empty($shortcode)) ){
          
         //      $all_data=Content::where('shortcode','LIKE',$shortcode)->
         //                         orderBy('id', 'desc')->get();
                                       

         //  }elseif( (!empty($service)) ){
          
         //      $all_data=Content::where('service_type','LIKE',$service)->
         //                         orderBy('id', 'desc')->get();
                                       

         //  }elseif( (!empty($keyword))){
          
         //      $all_data=Content::where('keyword','LIKE',$keyword)->
         //                         orderBy('id', 'desc')->get();
                                       

         //  }elseif( (!empty($start))&&(!empty($end)) ){
          
         //      $all_data=Content::where('time','>=',$start)->
         //                         where('time','<=',$end)->
         //                         orderBy('id', 'desc')->get();
                                       

         //  }else{

         //        $end_day=strtotime("today");
         //        $end_day= date("Y-m-d", $end_day);

         //        $start_day=strtotime("-30 days");
         //        $start_day= date("Y-m-d", $start_day);
           
         //         $all_data=Content::where('time','>=',$start_day)
         //                           ->where('time','<=',$end_day)
         //                           ->orderBy('id', 'desc')->get();
                  
         //       } 


        return view('revenue',compact('all_data','short_code','service_type','keywords','search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('batch');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
            $request->excell->move('content',$filename);
         }

        $data = Excel::load('content/'.$filename, function($reader) {
           })->get();

        $total_row = count($data);

        $condition=0;

     
        Excel::load('content/'.$filename, function($reader) use ($request, &$condition){
           $firstrow = $reader->first()->toArray();
           if(isset($firstrow['time']) && isset($firstrow['service_id']) && isset($firstrow['service_name']) && isset($firstrow['total_revenue'])) {
                       $condition=1;
                   
              }else{
                        $condition=0;
                        
                    }
          });



                 
    if($condition){
        $dates = array();

        for($i=0;$i<$total_row;$i++) {
           if($data[$i]->time!=="" && $data[$i]->service_id!=="" && $data[$i]->service_name!=="") {
                           

              $times=$data[$i]->time;
              $times=explode(" ",$times);

              $input['time']= $times[0];
              $input['service_id']=$data[$i]->service_id;
              $input['service_name']=$data[$i]->service_name;
              $input['total_revenue']=$data[$i]->total_revenue;
              $input['order_number']=$data[$i]->order_number;
              $input['order_revenue']=$data[$i]->order_revenue;
              $input['reorder_number']=$data[$i]->reorder_number;
              $input['reorder_revenue']=$data[$i]->reorder_revenue;
              $input['on_demanded_number']=$data[$i]->on_demanded_number;
              $input['on_demanded_revenue']=$data[$i]->on_demanded_revenue;
              $input['third_party_revenue']=$data[$i]->third_party_revenue;
              $one_shortcode=$this->get_shortcode($input['service_id']);

              $input['shortcode']=(empty($one_shortcode['shortcode'])) ? "empth" : $one_shortcode['shortcode'];
              $input['keyword']=(empty($one_shortcode['keyword'])) ? "empth" : $one_shortcode['keyword'];
              $input['product_id']=(empty($one_shortcode['product_id'])) ? "empth" : $one_shortcode['product_id'];
              $input['service_type']=(empty($one_shortcode['service_type'])) ? "empth" : $one_shortcode['service_type'];
              $input['type']=(empty($one_shortcode['type'])) ? "empth" : $one_shortcode['type'];
              $input['company_name']=(empty($one_shortcode['company_name'])) ? "empth" : $one_shortcode['company_name'];
              $input['share']=(empty($one_shortcode['share'])) ? 30 : $one_shortcode['share'];

              $vat=$input['total_revenue']-($input['total_revenue']*.22);
              $miaki_rev=$vat*.935*($input['share']/100);

              $input['vat']=$vat;
              $input['miaki_revenue']=$miaki_rev;
         
              //dd( $one_shortcode);
              Content::create($input);
              // Sum revenue for dates to insert into aws_revenue_dashboard
              if( !array_key_exists($input['time'], $dates) ) {
                $dates[$input['time']] = 0;
              }
              $dates[$input['time']] += $input['miaki_revenue'];
          }else{
                              
                   foreach( $dates AS $date => $revenue ) {
                       $achieved = Achieved::where('category_id', '=', 1)
                                   ->where('date', '=', $date)
                                   ->first();
                       if( !$achieved ) {
                           $achieved = new Achieved();
                       }
                       $achieved->category_id = 1;
                       $achieved->date = $date;
                       $achieved->achieved = $revenue;
                       $achieved->save();
                   }
                   $message="Successfully $i content added. But there are some invalid/null rows!!! Please check. ";
                   return redirect('report')->with('message',$message);

                }     
            }
            // dd($dates);
            foreach( $dates AS $date => $revenue ) {
                $achieved = Achieved::where('category_id', '=', 1)
                            ->where('date', '=', $date)
                            ->first();
                if( !$achieved ) {
                    $achieved = new Achieved();
                }
                $achieved->category_id = 1;
                $achieved->date = $date;
                $achieved->achieved = $revenue;
                $achieved->save();
            }
            $message="Successfully content added";
             return redirect('report')->with('message',$message);
                                                    
          }else{
            $message="Excel column format is worng"; 
            return redirect()->back()->with('message',$message);
          }

                    
                   
   }


    public function get_shortcode($service_iid)
    {
          $data=Shortcode::where('service_id', $service_iid)->first();
          return $data;
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
