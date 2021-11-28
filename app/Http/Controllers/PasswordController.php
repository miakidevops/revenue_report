<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Users_profile;

class PasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Users_profile::where('id',session()->get('user_id'))->first();
        return view('profile/change-password',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
       $this->validate($request, [
                                'new_pass1' => 'required|min:2',
                                'password' => 'required|min:2',
                            ]);

                      $input['old_pass']= md5($request->input('old_pass'));
                      $input['new_pass1']= md5($request->input('new_pass1'));
                      $input['password']= md5($request->input('password'));

                       $data=Users_profile::findOrFail($id);
                      
                      if($data['password']!==$input['old_pass'])
                       {
                           $message='wrong old password !!!';
                           return redirect()->back()->with('message',$message)->with('classs','danger'); 
                       }
                      

                      else if($input['new_pass1']!==$input['password'])
                      {
                       $message="new password did not match!!";
                       return redirect()->back()->with('message',$message)->with('classs','danger'); 
                      }
                     
                      else 
                      {
                       
                       // return $input=$request->all();
                        $inputs['password']= $input['password'];
                        $data=Users_profile::findOrFail($id);
                        $data->update($inputs);

                        $message="new password updated successfully!!";
                        return redirect()->back()->with('message',$message)->with('classs','success'); 
                      }
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
