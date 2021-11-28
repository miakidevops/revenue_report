@extends('master')
    
        @section('title')
          All Member
        @endsection


        @section('content')
                                     
            <div class="col-md-12">
                
                            <p class="messsage text-center" style="color:green"> {{ session('message') }} </p>
                            <h3 class="text-left"><b><i class="fa fa-user" aria-hidden="true"></i> Users List</b></h3>
                            <hr>
                            <div class="row">
                               <div class="col-md-12">
                              <?php if(session()->get('user_type')=="admin") {?>
                               <div class="col-md-1 btnns-grp">
                                 <a href="{{route('member.index')}}"><button type="button" class="btn btn-primary"><i class="fa fa-plus"></i> New</button></a>
                               </div>
                               <?php } ?>
                                </div>
                            </div>
                                    
                              
                                             
                                 <div class="table-responsive profile-table">          
                                    <table class="table table-bordered">
                                     <tr>
                                         <th> Name </th>
                                         <th> Email </th>
                                         <th> Contact </th>
                                         <th> Group </th>
                                         <th> Status </th>
                                         <th> Action </th>
                                         <th> Edit </th>
                                     </tr>
                                
                                       @foreach($all_data as $data)
                                     <tr>
                                         <td> {{$data->name}} </td>
                                         <td> {{$data->email}} </td>
                                         <td> {{$data->phone}} </td>
                                         <td> {{$data->type}} </td>

                                         <?php
                                          if($data->status){ ?>  
                                            <td class="actives" style="color:green"> active </td>
                                         <?php }else{ ?>
                                            <td class="deactive" style="color:red"> deactive </td>
                                          <?php } ?>


                                          <td><b> <?php if($data->status){ ?>
                                            <a href="{{route('member.show',$data->id)}}" class="member-active">  
                                               click for deactive
                                            </a>
                                            <?php }else{ ?> 
                                               <a href="{{route('member.show',$data->id)}} " class="member-deactive">  
                                               click for active
                                            </a>
                                                <?php } ?>
                                            </b> </td>
                                            

                                           <td> <a href="{{route('member.edit',$data->id)}}" class="member-active">  
                                              click </a> </td>                                     
                                     </tr>
                                       @endforeach 
                                    

                                     </table>
                                  </div>  
                                         
                             
                                     {!!$all_data->render() !!}
                                     <br>
                                </div>    
            
        @endsection

             



             