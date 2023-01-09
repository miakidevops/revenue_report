@extends('master')

    @section('title')
        Upload Apps Revenue
    @endsection

    @section('content')
    <div class="col-md-12">
        @if ($errors->any())
          <div class="alert alert-danger">
            <ul class="text-center" style="list-style-type: none"><a  class="close" data-dismiss="alert" aria-label="close">&times;</a>
             @foreach ($errors->all() as $error)
                <li> {{ $error }}</li>
             @endforeach
            </ul>
          </div>
        @endif
    </div>
    <div class="col-md-5 col-xs-12 ">
      <div class="card" style="margin-top: 80px">
        <div class="card-body" style="background:white; padding:30px; border-radius: 10px">
          @if (session('message')) 
          <div class="alert alert-success">
              <ul><li class="text-center"><a class="close" data-dismiss="alert" aria-label="close">&times;</a>{{ session('message') }}</li></ul>
          </div>    
          @endif

          <h4 style="padding-bottom: 20px"><b>MIAKI APPS REVENUE:</b></h4>

         <!--  @if (session('message')) 
          <div class="alert alert-success">
               <ul><li><a  class="close" data-dismiss="alert" aria-label="close">&times;</a>{{ session('message') }}</li></ul>
          </div>    
          @endif

          @if (session('message1')) 
          <div class="alert alert-danger">
               <ul><li><a  class="close" data-dismiss="alert" aria-label="close">&times;</a>{{ session('message1') }}</li></ul>
          </div>    
          @endif -->


          <form method="post" action="{{url('/save_apps_revenue')}}" enctype="multipart/form-data">
              <input type="hidden" value="{{csrf_token()}}" name="_token" />
                  <div class="form-group row" style="padding-bottom: 10px">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <label class="control-label" for="excell">Upload Excel File: </label>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <input type="file" class="form-control" name="excell" id="excell" required> 
                    </div>
                  </div>
              
                  <button type="submit" class="btn btn-success ctn_submit_btn">Upload</button>
                  
          </form> 
        </div>
      </div>

      <div class="dwn_sample_file">

          <p style="font-size:12px; padding-top: 10px"> Download sample file </p>
             
          <a href=" {{ URL::to( 'miaki_apps_file/sample/sample.xlsx') }}" download="sample.xlsx">
             <button type="button" class="btn sample_file">
                <i class="fa fa-download">
                </i><span> download </span>
             </button>
          </a>
      </div>
    </div>


    <div class="col-md-5 col-md-offset-2 col-xs-12 ">
      <div class="card" style="margin-top: 80px">
        <div class="card-body" style="background:white; padding:30px; border-radius: 10px">

          @if (session('message2')) 
          <div class="alert alert-success">
              <ul><li class="text-center"><a class="close" data-dismiss="alert" aria-label="close">&times;</a>{{ session('message2') }}</li></ul>
          </div>    
          @endif

          <h4 style="padding-bottom: 20px"><b>MONTHLY REVENUE TARGET:</b></h4>

          <form method="post" action="{{url('save_target_revenue')}}">
               
                  <input type="hidden" value="{{csrf_token()}}" name="_token" />
                  <div class="form-group row">
                      <div class="col-md-12 col-sm-12 col-xs-12">
                          <label class="control-label" for="target_date">Date:</label>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12">
                          <input type="month" class="form-control" name="target_date" id="target_date" min="2019-01" max="2042-12" value="{{date('Y-m')}}" required> 
                      </div>
                  </div>

                  <div class="form-group row" style="padding-top:10px; padding-bottom: 10px">
                      <div class="col-md-12 col-sm-12 col-xs-12">
                          <label class="control-label" for="revenue">Revenue Target:</label>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12">
                          <input type="number" class="form-control" name="revenue" id="revenue" required> 
                      </div>
                  </div>
                     
                  <button type="submit" class="btn btn-success ctn_submit_btn">Save</button>
              
          </form> 
        </div>
      </div>

    </div>
    @endsection