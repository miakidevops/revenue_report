@extends('master')
    
    @section('title')
       Targeted Revenue 
    @endsection

    @section('content')
    <div class="col-md-12">
        @if (session('message2')) 
        <div class="alert alert-success" style="margin-top:10px">
            <ul><li class="text-center"><a class="close" data-dismiss="alert" aria-label="close">&times;</a>{{ session('message2') }}</li></ul>
        </div>    
        @endif

        <div class="table-responsive" style="margin-top:40px">
            <table class="table table-hover table-bordered table-condensed bdapps_table">
                <thead>
                    <tr>
                        <th class="text-center light">SL</th>
                        <th class="text-center dark">YEAR</th>
                        <th class="text-center light">MONTH</th> 
                        <th class="text-center dark">TARGET</th>   
                        <th class="text-center light">ACHIEVED</th>   
                        <th class="text-center dark">SHORT/MORE</th>   
                    </tr> 
                </thead>
                <tbody>
                    @php $ind = 0 @endphp
                    @foreach($all_data as $data)
                    <tr>
                        <th class="text-center">{{$loop->iteration}}</th>
                        <th class="text-center">{{$data->year}}</th>
                        <th class="text-center">{{$month_name[$data->month]}}</th>
                        <th class="text-right">{{  number_format( $data->revenue ,2,'.',',') }}</th>
                        <th class="text-right">
                            {{  number_format( $month_wise_revenue[$ind] ,2,'.',',') }}
                            @if ( $month_wise_revenue[$ind]-$data->revenue > 0 ) 
                                <i class="fa fa-arrow-up" aria-hidden="true" style="color:green; font-size:16px; padding-left:3px"></i>
                            @else
                                <i class="fa fa-arrow-down" aria-hidden="true" style="color:red; font-size:16px; padding-left:3px"></i>
                            @endif
                        </th>
                        <th class="text-right">
                            {{  number_format( $month_wise_revenue[$ind]-$data->revenue ,2,'.',',') }}
                            @if ( $month_wise_revenue[$ind]-$data->revenue > 0 ) 
                                <i class="fa fa-plus" aria-hidden="true" style="color:green; font-size:16px; padding-left:3px"></i>
                            @else
                                <i class="fa fa-minus" aria-hidden="true" style="color:red; font-size:16px; padding-left:3px"></i>
                            @endif    
                        </th>
                    </tr>
                    @php $ind++ @endphp
                    @endforeach
                </tbody>
            </table>
          <br><br>
         </div> 
    </div>    
    @endsection

             