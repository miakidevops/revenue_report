<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Users_profile;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $all_data=Users_profile::paginate(10);
         return view('profile/all-members',compact('all_data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //  profile form:::::::::::::::::
                $data=Users_profile::where('id',session()->get('user_id'))->first();
                return view('profile/my-profile',compact('data'));
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
                       'name' => 'required',
                       'email'=>"required|email|unique:users_profile,email,$id",
                       'phone'=>'required',
                   ]);

               $input=$request->all();
               
               $data=Users_profile::findOrFail($id);
               $message="successfully data updated !!!";
               $data->update($input);
               session()->put('user_name',$data['name']);
               return redirect()->back()->with('message',$message);
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
