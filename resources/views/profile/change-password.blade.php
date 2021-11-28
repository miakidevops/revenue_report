@extends('master')
    
        @section('title')
          All Member
        @endsection


        @section('content')
                                     
           <div class="col-md-6 col-md-offset-3">
                      
                   
                   <h3 class="text-center"><b> Change Your Password </b></h3>     
                                                              
                             @if ($errors->any())
                                  <div class="alert alert-danger">
                                      <ul>
                                          @foreach ($errors->all() as $error)
                                              <li>{{ $error }}</li>
                                          @endforeach
                                      </ul>
                                   </div>
                              @endif


                              <div class="alert alert-{{session('classs')}}" role="alert">
                                <h4 class="messsage text-center"><b> {{ session('message') }} </b></h4>
                              </div>        


                             {!! Form::open(['route' => ['password.update', $data->id],'method' => 'put']) !!}
                                     <div class="w3-card login-card">
                                           <div class="form-group row">
                                                   <div class="col-md-4 col-sm-4 col-xs-4">
                                                       <label class="contrl-label" for="old_pass"> Old Password:</label>
                                                   </div>
                                                   <div class="col-md-7 col-sm-7 col-xs-7">
                                                       <input type="password" class="form-control" name="old_pass" required>
                                                   </div>
                                           </div>

                                            <div class="form-group row">
                                                   <div class="col-md-4 col-sm-4 col-xs-4">
                                                       <label class="control-label" for="new_pass1">New Password: </label>
                                                   </div>
                                                   <div class="col-md-7 col-sm-7 col-xs-7">
                                                        <input type="password" class="form-control" name="new_pass1" required> 
                                                   </div>
                                            </div>

                                            <div class="form-group row">
                                                   <div class="col-md-4 col-sm-4 col-xs-4">
                                                       <label class="control-label" for="password">Confirm Password: </label>
                                                   </div>
                                                   <div class="col-md-7 col-sm-7 col-xs-7">
                                                        <input type="password" class="form-control" name="password" required> 
                                                   </div>
                                            </div>

                                            <input class="btn btn-primary" type="submit" value="Submit">

                                            <a href="{{route('home.index')}}"><button type="button" class="btn btn-primary"> back </button></a>
                                      </div>      
                             {!! Form::close() !!} 


           </div>    
            
        @endsection

             



             