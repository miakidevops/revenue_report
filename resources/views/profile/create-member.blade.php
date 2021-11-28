@extends('master')
    
        @section('title')
          All Member
        @endsection


        @section('content')
                                     
           <div class="col-md-6 col-md-offset-3">
                      
                   
                    <h3 class="first-heading text-center"><b>Welcome to Registration Here </b></h3>

                           

                                      @if ($errors->any())
                                           <div class="alert alert-danger">
                                               <ul>
                                                   @foreach ($errors->all() as $error)
                                                       <li>{{ $error }}</li>
                                                   @endforeach
                                               </ul>
                                           </div>
                                       @endif
                                   
                       <p class="messsage text-center" style="color:red"> {{ session('message') }} </p>

                                
                       {!! Form::open(array('route'=>'member.store')) !!}
                        <div class="w3-card login-card">
                               <div class="form-group row">
                                       <div class="col-md-3 col-sm-3 col-xs-3">
                                           <label class="contrl-label" for="name">Name:</label>
                                       </div>
                                       <div class="col-md-9 col-sm-9 col-xs-9">
                                            <input type="text" class="form-control" name="name"   value="{{ old('name') }}" required>
                                        </div>
                               </div>

                              

                               <div class="form-group row">
                                        <div class="col-md-3 col-sm-3 col-xs-3">
                                             <label class="control-label" for="email">Email: </label>
                                         </div>
                                         <div class="col-md-9 col-sm-9 col-xs-9">
                                              <input type="email" class="form-control" name="email" value="{{ old('email') }}" required> 
                                         </div>
                               </div>


                              <div class="form-group row">
                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                        <label class="contrl-label" for="type">Type:</label>
                                    </div>
                                    <div class="col-md-9 col-sm-9 col-xs-9">
                                         <input type="radio" name="type" value="general" checked="checked"> General
                                         <input type="radio" name="type" value="admin"> Admin
                                         
                                     </div>
                              </div>

                                

                               <div class="form-group row">
                                       <div class="col-md-3 col-sm-3 col-xs-3">
                                            <label class="control-label" for="phone">Phone: </label>
                                        </div>
                                        <div class="col-md-9 col-sm-9 col-xs-9">
                                             <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" required> 
                                        </div>
                               </div>




                               <div class="form-group row">
                                        <div class="col-md-3 col-sm-3 col-xs-3">
                                             <label class="control-label" for="password">Password: </label>
                                         </div>
                                         <div class="col-md-9 col-sm-9 col-xs-9">
                                              <input type="password" class="form-control" name="password"  value="{{ old('password') }}" required> 
                                         </div>
                               </div>


                               <div class="form-group row">
                                        <div class="col-md-3 col-sm-3 col-xs-3">
                                             <label class="control-label" for="password_confirm">Confirm Password: </label>
                                         </div>
                                         <div class="col-md-9 col-sm-9 col-xs-9">
                                              <input type="password" class="form-control" name="password_confirm"  value="{{ old('password_confirm') }}" required> 
                                         </div>
                               </div>


                               

                               <!--  ,'onclick'=>'return myFunction1()' -->
                                 {!!Form::submit('submit',array('class'=>'btn btn-primary'))!!}

                                 <a href="{{route('user.index')}}"><button type="button" class="btn btn-primary"> back </button></a>
                       </div>
                        {!! Form::close() !!}


            </div>    
            
        @endsection

             



             