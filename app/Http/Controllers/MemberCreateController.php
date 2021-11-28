<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Users_profile;
class MemberCreateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('profile/create-member');
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
        //  create new user by storing data:::::::::::::::::
                 $this->validate($request, [
                       'name' => 'required',
                       'email'=>'required|email|unique:profile,email',
                       'phone'=>'required',
                       'password' => 'required|min:2',
                       'password_confirm' => 'required|min:2',
                   ]);

               $input=$request->all();
               $input['status']=1;
               $input['password']=md5($input['password']);
               $input['password_confirm']=md5($input['password_confirm']);

               if( $input['password']== $input['password_confirm']){
                      Users_profile::create($input);
                      $message="you successfully add a new user!!!";
                      return redirect('user')->with('message',$message);
               }else{
                      $message="your password did not match!";
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
        // change user status
          $data=Users_profile::findOrFail($id);
          
          
            if($data['status'])
                $input['status']=0;
            else $input['status']=1;

             $data->update($input);
             $message="user's status successfully changed!";
             return redirect()->back()->with('message',$message);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
          $data=Users_profile::where('id',$id)->first();
          return view('profile/profile-edit-admin',compact('data'));
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
                        'email'=>"required|email|unique:profile,email,$id",
                        'phone'=>'required',
                    ]);

        $input['name']=$request->input('name');
        $input['email']=$request->input('email');
        $input['phone']=$request->input('phone');
        $input['type']=$request->input('type');


        //dd($input);
        $pass=$request->input('password');
        if($pass==null||$pass==''){
          
        }
        else{
          $input['password']=md5($pass);
        }
        
        $data=Users_profile::findOrFail($id);
        $message="successfully data updated !!!";
        $data->update($input);
        return redirect('user')->with('message',$message);
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
