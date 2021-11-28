@extends('master')

    @section('title')
        Detail Revenue
    @endsection

    @section('content_fluid')
    <div class="col-md-12">
      <div class="miaki_apps_detail_revenue" style="margin-top: 20px; /*height: 80vh;*/ overflow-x: auto">
        <!-- <div class="table-responsive"> -->
          <table class="table table-hover table-bordered table-striped">
            <thead style="display: block;">
              <tr>
                <th class="text-center sl">Sl</th> 
                <th class="text-center app_name">App Name</th>
                <th class="text-center">Account</th>
                @foreach($all_days as $day)
                  <th class="text-center">{{date("d-M", strtotime($day))}}</th>
                @endforeach
              </tr> 
            </thead>
            <tbody style="display: block; overflow-y: scroll; height: 70vh">
              <tr style="background:#cffae6">
                <th class="text-center sl">-</th>
                <th class="text-center app_name">Total</th>
                <th class="text-center">-</th>
                @foreach($all_days as $day)
                  @if(array_key_exists($day,$revenue_by_date_array))
                    <th class="text-right">{{number_format($revenue_by_date_array[$day]['rev'],2)}}
                    @if( $revenue_by_date_array[$day]["ind"] == 1 )
                        <i class="fa fa-arrow-up" style="color:green"></i>
                    @elseif( $revenue_by_date_array[$day]["ind"] == -1 )
                        <i class="fa fa-arrow-down" style="color:red"></i>
                    @else
                        <i class="fa fa-arrows-h" style="color:orange"></i>
                    @endif
                    </th>
                  @else
                  <th class="text-right">-</th>
                  @endif
                @endforeach
              </tr>
              @foreach($distinct_app_name as $app)
              <tr class="app_wise_rev">
                <td class="text-center sl">{{$loop->iteration}}</td>
                <td class="text-center app_name"><b>{{$app->app_name}}</b></td>
                <td class="text-center">
                  @if(array_key_exists($app->app_name,$app_wise_account))
                    {{ucwords($app_wise_account[$app->app_name])}}
                  @endif
                </td>
                @foreach($all_days as $day)
                  @if( array_key_exists($app->app_name, $all_data) && array_key_exists($day, $all_data[$app->app_name]) && array_key_exists('revenue', $all_data[$app->app_name][$day]) )
                    <td class="text-right code{{$all_data[$app->app_name][$day]['ind']}}"><b>{{number_format($all_data[$app->app_name][$day]['revenue'],2)}}</b></td>
                  @else
                    <td class="text-right">-</td>
                  @endif
                @endforeach
              </tr>
              @endforeach
            </tbody>
          </table>
        <!-- </div> -->
      </div>
    </div>
    @endsection