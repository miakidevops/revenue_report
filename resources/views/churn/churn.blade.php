@extends('master')
    @section('title')
          Intake Churn
    @endsection

    @section('content')
        <div class="col-md-12">
          <div class="regular_vas_churn">
            <ul class="nav nav-tabs">
                <li class="active"><a href="{{url('churn')}}">Regular VAS</a></li>
                <li class="inactive"><a href="{{url('bdapps_ussd_hit')}}">BDApps <span style="font-size:8px">USSD Session</span></a></li>
            </ul>

            <form method="get" action="{{url('churn')}}">
                <input type="hidden" value="{{csrf_token()}}" name="_token" />
                <div class="form-group row">
                  <div class="col-md-2">
                    <select name="shortcode" class="form-control">
                      <option value="">All Shortcode</option>
                      @foreach($distinct_shortcode as $short)
                        <option value="{{trim($short->shortcode)}}" {{ ($search['shortcode'] == trim($short->shortcode)) ? "selected=selected" : "" }}>{{trim($short->shortcode)}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-md-2">
                    <select name="keyword" class="form-control">
                      <option value="">All Keyword</option>
                      @foreach($distinct_keyword as $kywrd)
                        <option value="{{trim($kywrd->keyword)}}" {{ ($search['keyword'] == trim($kywrd->keyword)) ? "selected=selected" : "" }}>{{trim($kywrd->keyword)}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-md-2">
                    <input type="date" class="form-control" name="start" value="{{$search['start']}}"> 
                  </div>
                  <div class="col-md-2">
                    <input type="date" class="form-control" name="end" value="{{$search['end']}}"> 
                  </div>
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
                    <th class="text-center">Shortcode</th>
                    <th class="text-center">Keyword</th>
                    <th class="text-center">Ope</th>
                    <th class="text-center">Intake</th>
                    <th class="text-center">Churn</th>
                    <th class="text-center">To. Subs.</th>
                  </tr>
                </thead>
                <tbody>
                @php $ind = 1; $sum_intake = 0; $sum_churn = 0; $sum_tot_subs = 0 @endphp
                @foreach( $result as $key => $val )
                  @foreach( $val as $key2 => $val2 )
                    @foreach( $val2 as $key3 => $val3 )
                      @foreach( $val3 as $key4 => $val4 )
                      <tr>
                        <td class="text-center">{{$ind}}</td>
                        <td class="text-center">{{$key3}}</td>
                        <td class="text-center">{{$key}}</td>
                        <td class="text-center">{{$key2}}</td>
                        <td class="text-center">{{$key4}}</td>
                        <td class="text-right">{{$val4['intake']}}</td>
                        <td class="text-right">{{$val4['churn']}}</td>
                        <td class="text-right">{{$val4['total_sub']}}</td>
                      </tr>
                      @php 
                        $ind++; $sum_intake+=$val4['intake']; $sum_churn+=$val4['churn']; $sum_tot_subs += $val4['total_sub']
                      @endphp
                      @endforeach
                    @endforeach
                  @endforeach
                @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th class="text-center">{{$ind-1}}</th>
                    <th class="text-center">(Rows)</th>
                    <th class="text-center">---</th>
                    <th class="text-center">---</th>
                    <th class="text-center">Total:</th>
                    <th class="text-right">{{$sum_intake}}</th>
                    <th class="text-right">{{$sum_churn}}</th>
                    <th class="text-right">{{$sum_tot_subs}}</th>
                  </tr>
                </tfoot>
              </table>
            </div>
        </div>
    @endsection
