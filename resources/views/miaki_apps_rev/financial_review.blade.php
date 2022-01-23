@extends('master')

    @section('title')
        Financial Review
    @endsection

    @section('content')
    <div class="col-md-12 financial_review_div">
        <div class="panel panel-default" style="margin-top: 50px">
            <div class="panel-heading">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-3 col-xs-6">
                                Start Date
                            </div>
                            <div class="col-md-3 col-xs-6">
                                End Date
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form method="get" action="{{url('financial_review')}}">
                            <input type="hidden" value="{{csrf_token()}}" name="_token" />
                            <div class="form-group row">
                              <div class="col-md-3 col-xs-6">
                                <input type="date" class="form-control" name="start" value="{{$search['start']}}"> 
                              </div>
                              <div class="col-md-3 col-xs-6">
                                <input type="date" class="form-control" name="end" value="{{$search['end']}}"> 
                              </div>
                              <div class="col-md-2 col-xs-12">
                                <button type="submit" class="btn btn-primary submit_btn">Submit</button>
                              </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- :::::::::::::::::::::::::::::::::::::::::::::::::::::::   ::::::::::::::::::::::::::::::::::::::::::::::::::::::: -->
           
            <ul class="nav nav-pills">
                <li class="active"><a data-toggle="pill" href="#duration">Duration Wise</a></li>
                <li><a data-toggle="pill" href="#month">Month Wise</a></li>
              </ul>
              
              <div class="tab-content">
                <div id="duration" class="tab-pane fade in active">
                  <h3>HOME</h3>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                </div>
                <div id="month" class="tab-pane fade">
                  <h3>Menu 1</h3>
                  <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                </div>
              </div>
           
        </div>
    </div>
    @endsection