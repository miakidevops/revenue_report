@extends('master')
    
        @section('title')
          All Content 
        @endsection



        @section('content')
            <div class="col-md-12 result2">
              <!-- <div class="row"> 
                <div class="col-md-1 col-xs-3 col-sm-2">
                   <a href="{{route('home.index')}}"><button type="button" class="btn btn-success nav-button"> Summary <span class="fa fa-bar-chart"></span></button></a>
                </div>
                <div class="col-md-1 col-xs-3 col-sm-2">
                    <a href="{{route('report.create')}}"><button type="button" class="btn btn-success nav-button left-bar"> Batch <span class="fa fa-upload"></span></button></a>
                </div> 
                <div class="col-md-8 col-xs-3  col-sm-6">
                  <abbr title="click to see all content (home)"><a class="first-heading_link" href="{{route('report.index')}}"><h4 class="first-heading text-center"><b>ROBI VAS REVENUE REPORT</b></h4></a></abbr>
               </div>
               <div class="col-md-1 col-xs-3 col-sm-2">
                  <a href="{{route('shortcode.index')}}"><button type="button" class="btn btn-success nav-button right-bar"> Settings <span class="fa fa-cog"></span></button></a>
               </div>
               <div class="col-md-1 col-xs-3 col-sm-2">
                  <a href="{{route('excelreport.create')}}"><button type="button" class="btn btn-success nav-button right-bar"> Export <span class="fa fa-download"></span></button></a>
               </div>
               
              </div> -->

                        


              <div class="search">            
                 <div class="row">  
                                                  
                                           
                        {!! Form::open(['route'=>'report.index','method'=>'GET','class'=>'search-form']) !!}
                          <div class="form-group">
                             <div class="col-md-2">
              
                                   <select name="shortcode"  class="form-control search_grp">
                                     <?php if($search['shortcode']){?>
                                          <option value="{{$search['shortcode']}}">{{$search['shortcode']}}</option>
                                     <?php }
                                      else ?> 
                                        <option value="">All Shortcode</option>
                                      @foreach($short_code as $short)  
                                        <option value="{{$short->shortcode}}">{{$short->shortcode}}</option>
                                      @endforeach
                                  </select>
                             </div>             
                           </div>
                           

                           <div class="form-group">
                              <div class="col-md-2">
                           
                                    <select name="service_type"  class="form-control search_grp">
                                       <?php if($search['service']){?>
                                            <option value="{{$search['service']}}">{{$search['service']}}</option>
                                       <?php }
                                        else ?>
                                         <option value="">All Service Type</option>
                                       @foreach($service_type as $service)  
                                         <option value="{{$service->service_type}}">{{$service->service_type}}</option>
                                       @endforeach
                                   </select>
                              </div>             
                            </div>


                            <div class="form-group">
                               <div class="col-md-2">
                            
                                     <select name="keyword"  class="form-control search_grp">
                                        <?php if($search['keyword']){?>
                                             <option value="{{$search['keyword']}}">{{$search['keyword']}}</option>
                                        <?php }
                                         else ?>
                                          <option value="">All Keyword</option>
                                        @foreach($keywords as $key)  
                                          <option value="{{$key->keyword}}">{{$key->keyword}}</option>
                                        @endforeach
                                    </select>
                               </div>             
                             </div>

                           
                          

                           <div class="form-group">
                               <div class="col-md-2">
                                 
                                 <?php if($search['start']){ ?> 
                                     <input type="date" name="start" value="{{$search['start']}}" class="form-control col-md-12 search_grp">
                                 <?php } else {?>       
                                     <input type="date" name="start"  class="form-control col-md-12 search_grp">
                                 <?php } ?>    
                                   
                                </div>
                               </div> 
                          


                            <div class="form-group">
                                  <div class="col-md-2">
                                    
                                     <?php if($search['end']){ ?> 
                                         <input type="date" name="end" value="{{$search['end']}}" class="form-control col-md-12 search_grp">
                                     <?php } else {?> 
                                        <input type="date" name="end"  class="form-control col-md-12 search_grp">
                                     <?php } ?>   
                                     
                                  </div> 
                              </div>     
                               
                          

                           <div class="col-md-1" >
                  {!!Form::submit('Search',array('class'=>'search-button btn btn-info')) !!}
                          </div>
                        
                        {!! Form:: close() !!}

                         <div class="col-md-1 col-xs-3 col-sm-2">
                            <a href="{{route('excelreport.create')}}"><button type="button" class="btn btn-success right-bar"> Export <span class="fa fa-download"></span></button></a>
                         </div>

                    </div>
                    </div> 


                          


                <p class="messsage text-center"> {{ session('message') }} </p>
                 
                  
                   <div class="table-responsive">        
                     <table id="example" class="display table">
                          <thead>
                               <tr>
                                <th class="serial"> Serial </th>
                                <th class="time"> Time </th>
                                <th class="shortcode text-center"> Shortcode </th>
                                <th class="keyword text-center"> Keyword </th>
                                <th class="service_type"> Service Type </th>
                                <th class="service_name"> Service Name </th>
                                <th class="total_revenue"> Total Revenue </th>
                                <th class="vat">After Vat </th>
                                <th class="miaki_revenue"> Miaki Revenue </th>
                                </tr>
                           </thead>
                        
             
                          <tbody>
                       <?php $serial=1; 
                             $sum_total_revenue=0;
                             $sum_vat=0;
                             $sum_miaki_revenue=0;
                       ?> 
                       @foreach($all_data as $data)
                          <tr>
                             <td class="serial"> {{$serial}} </td>  
                             <td class="time"> {{$data->time}} </td>
                             <td class="shortcode text-center"> {{$data->shortcode}} </td>
                             <td class="keyword text-center"> {{$data->keyword}} </td>
                             <td class="service_type"> {{$data->service_type}} </td>
                             <td class="service_name"> {{$data->service_name}} </td>
                             <td class="total_revenue text-right">{{number_format($data->total_revenue, 2, '.', ',')}}</td>
                             <td class="vat text-right">{{number_format($data->vat, 2, '.', ',')}}</td>
                             <td class="miaki_revenue text-right">{{number_format($data->miaki_revenue, 2, '.', ',')}}</td>
                           <?php $serial++; 
                                 $sum_total_revenue+=$data->total_revenue;
                                 $sum_vat+=$data->vat;
                                 $sum_miaki_revenue+=$data->miaki_revenue;
                           ?>  
                           </tr> 
                       @endforeach
                         
                        </tbody>
                

         <?php
             $sum_total_revenue = number_format($sum_total_revenue, 2, '.', ',');
             $sum_vat = number_format($sum_vat, 2, '.', ',');
             $sum_miaki_revenue = number_format($sum_miaki_revenue, 2, '.', ',');
         ?>

            
                    <tfoot>
                         <tr>
                          <th class="serial"> {{$serial-1}} </th>
                          <th class="time"> (Row) </th>
                          <th class="shortcode"> {{$search['shortcode']}} </th>
                          <th class="keyword"> {{$search['keyword']}} </th>
                          <th class="service_type"> {{$search['service']}} </th>
                          <th class="service_name"> Total:  </th>
                          <th class="total_revenue text-right"> {{$sum_total_revenue}} </th>
                          <th class="vat text-right"> {{$sum_vat}} </th>
                          <th class="miaki_revenue text-right"> {{$sum_miaki_revenue}} </th>
                          
                         </tr>
                    </tfoot>
                  </table>
                </div>
                 
                 
            </div>
                            
           @endsection

             