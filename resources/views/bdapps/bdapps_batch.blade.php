@extends('master')
    @section('title')
          BDApps Upload Batch
    @endsection

    @section('content')

    <div class="col-md-12">
        @if ($errors->any())
        <div class="alert alert-danger">
           <ul>
               @foreach ($errors->all() as $error)
                   <li>{{ $error }}</li>
               @endforeach
           </ul>
        </div>
        @endif

        @if (session('message')) 
        <div class="alert alert-danger">
            <ul><li><a  class="close" data-dismiss="alert" aria-label="close">&times;</a>{{ session('message') }}</li></ul>
        </div>    
        @endif
    </div>

    <div class="col-md-4 col-md-offset-1">
    	<h4 class="text-center bdapps_heading"><b>BDAPPS BATCH</b></h4>
				 
		<form method="post" action="{{url('bdapps_batch_submit')}}" enctype="multipart/form-data">
			<div class="w3-card login-card"> 
            	<input type="hidden" value="{{csrf_token()}}" name="_token" />
				<div class="form-group row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<label class="control-label" for="excell">Upload BDApps Revenue File: </label>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12">
						<input type="file" class="form-control" name="excell" id="excell" required> 
					</div>
				</div>
			       

	       		<button type="submit" class="btn btn-success ctn_submit_btn">Submit</button>

	       		<a href="{{url()->previous()}}"><button type="button" class="btn btn-success"><span class="fa fa-arrow-circle-left"></span> Back </button></a>
			</div>
		</form> 

        				
		<p class="note"> download sample file </p>

		<a href=" {{ URL::to( '/sample/type-3/sample.xlsx') }}" download="sample.xlsx">
			<button type="button" class="btn btn-primary edit">
			    <i class="fa fa-download"></i><span> download </span>
			</button>
		</a>

    </div>    

    <div class="col-md-4 col-md-offset-2 media_query_div">
    	<h4 class="text-center bdapps_heading"><b>Input BDApps Revenue(Day Wise)</b></h4>
        		<form method="post" action="{{url('bdapps_data_submit')}}">
        			<div class="w3-card login-card"> 
                    	<input type="hidden" value="{{csrf_token()}}" name="_token" />
        				<div class="form-group row">
        					<div class="col-md-12 col-sm-12 col-xs-12">
        						<label class="control-label" for="date">Date:</label>
        					</div>
        					<div class="col-md-12 col-sm-12 col-xs-12">
        						<input type="date" class="form-control" name="rev_date" id="rev_date" value="<?php echo date("Y-m-d", strtotime("-1 day")) ?>" required> 
        					</div>
        				</div>

        				<div class="form-group row">
        					<div class="col-md-12 col-sm-12 col-xs-12">
        						<label class="control-label" for="date">Miaki Rev:</label>
        					</div>
        					<div class="col-md-12 col-sm-12 col-xs-12">
        						<input type="text" class="form-control" name="miaki_rev" id="miaki_rev" required style="background: #d9d9ff"> 
        					</div>
        				</div>


        				<div class="form-group row">
        					<div class="col-md-12 col-sm-12 col-xs-12">
        						<label class="control-label" for="date">Mmlbd Rev:</label>
        					</div>
        					<div class="col-md-12 col-sm-12 col-xs-12">
        						<input type="text" class="form-control" name="mmlbd_rev" id="mmlbd_rev" required > 
        					</div>
        				</div>


                        <div class="form-group row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <label class="control-label" for="date">Other Rev:</label>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <input type="text" class="form-control" name="other_rev" id="other_rev" required  style="background: #c2d292"> 
                            </div>
                        </div>
        			       

        	       		<button type="submit" class="btn btn-success ctn_submit_btn">Submit</button>

        	       		<a href="{{url()->previous()}}"><button type="button" class="btn btn-success"><span class="fa fa-arrow-circle-left"></span> Back </button></a>
        			</div>
        		</form>
    </div>                    
    @endsection

              