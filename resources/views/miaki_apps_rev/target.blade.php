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
                        <th class="text-center">{{ $loop->iteration }}</th>
                        <th class="text-center">{{ $data->year }}</th>
                       
                        
                    </tr>
                    @php $ind++ @endphp
                    @endforeach
                </tbody>
            </table>
          <br><br>
         </div> 
    </div>    
    @endsection

             