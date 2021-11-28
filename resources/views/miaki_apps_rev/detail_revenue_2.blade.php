@extends('master')

    @section('title')
        Detail Revenue
    @endsection

    @section('content_fluid')
    <div class="col-md-12">
      <div class="miaki_apps_detail_revenue" style="margin-top: 20px;">

        <div class="panel panel-default">
          <div class="panel-body">
            <div class="row">
              <div class="col-md-2">
                <p class="panel-span">Start Date:</p>
              </div>
              <div class="col-md-2">
                <p class="panel-span">End Date:</p>
              </div>
            </div>
            <form method="get" action="{{url('detail_miaki_revenue')}}" class="search-form">
              <div class="row">
                <div class="col-md-2">
                  <input type="hidden" value="{{csrf_token()}}" name="_token" />
                  <input type="date" name="start"  class="form-control search_grp" value="{{$first_day}}">
                </div>
                <div class="col-md-2">
                  <input type="date" name="end"  class="form-control search_grp" value="{{$last_day}}">
                </div>
                <div class="col-md-1">
                  <button type="submit" class="btn btn-success">Search</button> 
                </div>
              </div>
            </form>
          </div>  
        </div>

        <!-- <div class="table-responsive"> -->
          <table class="miaki_apps_revenue table table-hover table-bordered table-striped">
            <thead >
              <tr>
                <th class="text-center sl">Sl</th> 
                <th class="text-center app_name">App Name</th>
                <th class="text-center">Account</th>
                @foreach($all_days as $day)
                  <th class="text-center">{{date("d-M", strtotime($day))}}</th>
                @endforeach
                <th>Apps Revenue</th>
              </tr> 
            </thead>
            <tbody>
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
                <th class="text-right">{{number_format($total_rev_of_a_date_range,2)}}</th>
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
                <th class="text-right" style="color:#a52626; background: #dedeff; font-size: 14px">
                    @if(array_key_exists($app->app_name,$revenue_by_apps_array))
                      {{number_format($revenue_by_apps_array[$app->app_name],2)}}
                    @endif
                </th>
              </tr>
              @endforeach
            </tbody>
          </table>
        <!-- </div> -->
      </div>
    </div>
    @endsection