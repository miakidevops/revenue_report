<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shortcode;
use Excel;
class ShortcodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_data=Shortcode::all();
        return view('shortcode',compact('all_data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('batch_scode');
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
                    $request->excell->move('revenue',$filename);
           }

        $data = Excel::load('revenue/'.$filename, function($reader) {
           })->get();

         $total_row = count($data);

         
         $condition=0;
          
         Excel::load('revenue/'.$filename, function($reader) use ($request, &$condition){
                $firstrow = $reader->first()->toArray();
                if(isset($firstrow['service_id']) && isset($firstrow['product_id']) && isset($firstrow['shortcode']) && isset($firstrow['keyword']) && isset($firstrow['service_type'])) {
                            $condition=1;
                        
                         }
                         else{
                             $condition=0;
                             
                         }
                                  });
        
           if($condition){
       
          for($i=0;$i<$total_row;$i++)
        {
           if($data[$i]->service_id!=="" && $data[$i]->product_id!=="" && $data[$i]->shortcode!=="" && $data[$i]->keyword!=="" && $data[$i]->service_name!=="" && $data[$i]->service_type!=="" && $data[$i]->share!=="") {

            $input['service_id']= $data[$i]->service_id;
            $input['product_id']= $data[$i]->product_id;
            $input['shortcode']= $data[$i]->shortcode;
            $input['keyword']= $data[$i]->keyword;
            $input['service_name']= $data[$i]->service_name;
            $input['service_type']= $data[$i]->service_type;
            $input['type']= $data[$i]->type;
            $input['share']= $data[$i]->share;
            $input['company_name']= $data[$i]->company_name;
            
            Shortcode::create($input);  
            }     
        }

        $message="Successfully content added";
        return redirect('shortcode')->with('message',$message);
          }else{
         $message="Excel column format is worng"; 
         return redirect()->back()->with('message',$message);   
          }
        
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
              Shortcode::truncate();
              $message="successfully content deletet";
              return redirect()->back()->with('message',$message);
    }
}
