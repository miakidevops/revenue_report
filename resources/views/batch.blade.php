  @extends('master')
      
          @section('title')
            Create Content 
          @endsection



          @section('content')
                	  <div class="col-md-6 col-md-offset-3">
                   
               <h4 class="first-heading text-center"><b>Welcome to Upload Content: </b></h4>


				  @if ($errors->any())
				      <div class="alert alert-danger">
				          <ul>
				              @foreach ($errors->all() as $error)
				                  <li>{{ $error }}</li>
				              @endforeach
				          </ul>
				      </div>
				  @endif 

                 <p class="messsage text-center"> {{ session('message') }} </p>
				 
				    {!! Form::open(array('route'=>'report.store','files' => true)) !!}
				                   <div class="w3-card login-card"> 

				                     <div class="form-group row">
				                              <div class="col-md-12 col-sm-12 col-xs-12">
				                                   <label class="control-label" for="excell">Upload Excel File: </label>
				                               </div>
				                               <div class="col-md-12 col-sm-12 col-xs-12">
				                                    <input type="file" class="form-control" name="excell" id="excell"> 
				                               </div>
				                     </div>
				                           

				                         <!--  ,'onclick'=>'return myFunction1()' -->
				                           {!!Form::submit('submit',array('class'=>'btn btn-success'))!!}

				                           <a href="{{url()->previous()}}"><button type="button" class="btn btn-success"><span class="fa fa-arrow-circle-left"></span> Back </button></a>
				                     </div>
				    {!! Form::close() !!}  

				
	       				  <p class="note"> download sample file </p>
	                     
	                        <a href=" {{ URL::to( '/sample/type-1/every_day.xlsx') }}" download="every_day.xlsx">
	                           <button type="button" class="btn btn-primary edit">
	                              <i class="fa fa-download">
	                                
	                              </i><span> download </span>
	                           </button>
	                        </a>
                </div>
		 @endsection		 

