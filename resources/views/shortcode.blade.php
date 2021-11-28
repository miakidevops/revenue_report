@extends('master')
    
        @section('title')
          All Shortcode 
        @endsection



        @section('content')
            <div class="col-md-12  result2 colorr">
                


                        <div class="search">            
                           <div class="row">  
                                                            
                                

                           
                           

                            
                               <h4 class=" text-center"><ins><b>All Shortcode List</b></ins></h4>
                              
                              <ul class="short-ul">
                                 <li>
                                    <a href="{{route('shortcode.create')}}"><button class="w3-button w3-white w3-border w3-round w3-tiny"> Add New <span class="fa fa-plus"></span></button></a>
                                 </li>
                                 <li>
                                    {!! Form::open(['route' => ['shortcode.destroy',500],'method' => 'delete']) !!}
                                    {!!Form::hidden('id',500)!!}
                                    {!!Form::submit('Delete All',array('class'=>'w3-button w3-white w3-border w3-round w3-tiny','onclick'=>'return myFunction()'))!!}
                                    {!! Form::close() !!}
                                 </li>
                              </ul>
                            
                            

                                                 
                                                
                          </div>
                        </div>   <!-- search -->


                <p class="messsage text-center"> {{ session('message') }} </p>
                      <div class="table-responsive">          
                         <table id="example" class="display table table-hover">
                            <thead>
                                 <tr>
                                  <th>Sl</th>
                                  <th>Service Id</th>
                                  <th>Product Id</th> 
                                  <th>Shortcode</th>
                                  <th>Keyword</th>
                                  <th>Service Name</th>
                                  <th>Service Type</th>
                                  <th>Type</th>
                                  <th>Share</th>
                                  <th>Company Name</th>
                                 </tr>
                             </thead>
                             

                       
                            <tbody>
                               <?php $serial=1; ?> 
                               @foreach($all_data as $data)
                                  <tr>
                                     <td>{{$serial}}</td>  
                                     <td>{{$data->service_id}}</td>
                                     <td>{{$data->product_id}}</td>
                                     <td>{{$data->shortcode}}</td>
                                     <td>{{$data->keyword}}</td>
                                     <td>{{$data->service_name}}</td>
                                     <td>{{$data->service_type}}</td>
                                     <td>{{$data->type}}</td>
                                     <td>{{$data->share}}</td>
                                     <td>{{$data->company_name}}</td>
                                   <?php $serial++; ?>  
                                   </tr> 
                               @endforeach 
                              </tbody>
                           </table>

                       </div>
                   
           </div>
                    
                            
                         
                           
           @endsection

              