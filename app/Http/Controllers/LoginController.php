<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Users_profile;
class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        // $this->middleware('auth', ['only' => ['create', 'store', 'edit', 'delete']]);
        // // Alternativly
        $this->middleware('CheckLogin', ['only' => ['index']]);
        $this->middleware('CheckLogout', ['except' => ['index','store']]);
       
    }
    
    public function index()
    {
        return view('login');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //this function is for logout
         session()->flush();
         $message="Successfully Logout!";
         return redirect('login')->with('message',$message)->with('classs','success');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd('dddd');
        $this->validate($request,[
                   'email'=>'required|email|exists:profile,email',
                   'password'=>'required',
                ]);

        $input['email']=$request->input('email');
        $input['password']=md5($request->input('password'));

        $output=Users_profile::where('email',$input['email'])->where('password',$input['password'])->first();  


        if (!$output) {
            $message="Wrong Password!!!";
            return redirect()->back()->with('message',$message)->with('classs','danger');
        }elseif ($output['status']==0) {
            $message="You Are Deactive!";
            return redirect()->back()->with('message',$message)->with('classs','danger');
        }else{

            session()->put('user_email',$output['email']);
            session()->put('user_type',$output['type']);
            session()->put('user_id',$output['id']);
            session()->put('user_name',$output['name']);
                                       
            if (session()->has('rev_rep_prev_url')) {
                $rev_rep_prev_url = session()->get('rev_rep_prev_url');
                session()->forget('rev_rep_prev_url');
                return redirect($rev_rep_prev_url);
            }

                                                
            // return redirect('/homePage');
            return redirect('/bdapps');
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
        //
    }
}
