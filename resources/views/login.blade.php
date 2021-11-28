@extends('master2')
    
    @section('title')
        Login
    @endsection



    @section('content')


    <video autoplay muted loop id="myVideo">
        <source src="test.mp4" type="video/mp4">
        Your browser does not support HTML5 video.
    </video>

    <div class="col-sm-6 col-md-4 col-md-offset-4" style="margin-top: 25px">

      {!! Form::open(array('route'=>'login.store')) !!}
      <div class="cnt-wrap" >
          <div class="row">
              <div class="text-center pro-img">


                  <img class="img-responsive"
                      src="image/image-login.png" alt="" style="width:100%">

              </div>
          </div>
          <div class="row form-cnt">
              <div class="col-sm-8 col-md-8  col-md-offset-2 col-sm-offset-2">
                  @if ($errors->any())
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li><a  class="close" data-dismiss="alert" aria-label="close">&times;</a>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
                  @endif
                  @if (session('message'))  
                  <div class="alert alert-{{session('classs')}}" role="alert">
                      <ul><li><a  class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('message') }}</li></ul>
                  </div>
                  @endif
                  <div class="form-group">
                      <div class="input-group">
                          <span class="input-group-addon">
                              <img src="image/user_icon.png" style="width:22px">
                          </span> 
                          <input class="form-control" placeholder="User Mail" name="email" type="email" required autofocus>
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="input-group">
                          <span class="input-group-addon">
                              <img src="image/lock_icon.png" style="width:22px">
                          </span>
                          <input class="form-control" placeholder="Password" name="password" type="password" value="" required>
                      </div>
                  </div>
                  <div class="form-group">
                      <input type="submit" class="btn btn-primary btn-block" value="Sign In">
                  </div>

                  <div class="text-center" style="color:#999966; font-size: 12px">
                       Copyright © <a href="http://www.miaki.co/" target="_blank">Miaki</a> Group. All rights reserved
                   </div>
              </div>
              
          </div>
      </div>
      {!! Form::close() !!}

    </div>


     
                 
  @endsection

             