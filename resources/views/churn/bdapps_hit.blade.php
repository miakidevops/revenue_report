@extends('master')
    @section('title')
          BDApps Hit
    @endsection

    @section('content')
        <div class="col-md-12">
          <div class="regular_vas_churn">
            <ul class="nav nav-tabs">
                <li class="inactive"><a href="{{url('churn')}}">Regular VAS</a></li>
                <li class="active"><a href="{{url('bdapps_ussd_hit')}}">BDApps <span style="font-size:8px">USSD Session</span></a></li>
            </ul>

            <form method="get" action="{{url('bdapps_ussd_hit')}}">
                <input type="hidden" value="{{csrf_token()}}" name="_token" />
                <div class="form-group row">
                  <div class="col-md-2">
                    <select name="ussd" class="form-control">
                      <option value="">All USSD</option>
                      @foreach($all_ussd_code as $ussd_code)
                        <option value="{{$ussd_code->ussd_code}}" {{ ($search['ussd'] == $ussd_code->ussd_code) ? "selected=selected" : "" }}>{{$ussd_code->ussd_code}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-md-3">
                    <div class="row">
                      <div class="col-md-2">
                        <div class="date_picker_title">
                          <span>Start:</span>
                        </div>
                      </div>
                      <div class="col-md-10">
                        <div class="form-group">
                          <div class='input-group'>
                              <input type='text' class="form-control picker" name="start" value="{{$search['start']}}">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="row">
                      <div class="col-md-2">
                        <div class="date_picker_title">
                          <span>End:</span>
                        </div>
                      </div>
                      <div class="col-md-10">
                        <div class="form-group">
                          <div class='input-group'>
                              <input type='text' class="form-control picker" name="end" value="{{$search['end']}}">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- <div class="col-md-2">
                    <input type="date" class="form-control" name="start" value="{{-- $search['start'] --}}"> 
                  </div>
                  <div class="col-md-2">
                    <input type="date" class="form-control" name="end" value="{{-- $search['end'] --}}"> 
                  </div> -->
                  <div class="col-md-2">
                    <button type="submit" class="btn btn-primary submit_btn">Submit</button>
                  </div>
                </div>
            </form> 

            <table id="data_table_1" class="table table-striped">
                <thead>
                  <tr>
                    <th class="text-center">SL</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Message</th>
                    <th class="text-center">Service Desc.</th>
                    <th class="text-center">Hit</th>
                  </tr>
                </thead>
                <tbody>
                  @php $ind = 1; $total_hit = 0 @endphp
                  @foreach( $all_data as $data)
                  <tr>
                    <td class="text-center">{{$ind}}</td>
                    <td class="text-center">{{$data->date}}</td>
                    <td class="text-center">{{$data->message}}</td>
                    <td class="text-center">
                      @if (array_key_exists($data->message,$ussd_wise_service))
                        {{$ussd_wise_service[$data->message]}}
                      @else
                        --no service desc--
                      @endif
                    </td>
                    <td class="text-center">{{$data->hit}}</td>
                  </tr>
                  @php $ind++; $total_hit += $data->hit @endphp
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th class="text-center">{{$ind-1}}</th>
                    <th class="text-center">(Rows)</th>
                    <th class="text-center">Total Hits:</th>
                    <th class="text-center">Total Hits:</th>
                    <th class="text-center">{{$total_hit}}</th>
                  </tr>
                </tfoot>
              </table>

          </div>
        </div>
    @endsection
