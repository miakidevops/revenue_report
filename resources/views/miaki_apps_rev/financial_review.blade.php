@extends('master')

    @section('title')
        Financial Review
    @endsection

    @section('content')
    <div class="col-md-12 financial_review_div">
        <div class="panel panel-default" style="margin-top: 50px">
            <div class="panel-heading">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-3 col-xs-6">
                                Start Date
                            </div>
                            <div class="col-md-3 col-xs-6">
                                End Date
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form method="get" action="{{url('financial_review')}}">
                            <input type="hidden" value="{{csrf_token()}}" name="_token" />
                            <div class="form-group row">
                              <div class="col-md-3 col-xs-6">
                                <input type="date" class="form-control" name="start" value="{{$search['start']}}"> 
                              </div>
                              <div class="col-md-3 col-xs-6">
                                <input type="date" class="form-control" name="end" value="{{$search['end']}}"> 
                              </div>
                              <div class="col-md-2 col-xs-12">
                                <button type="submit" class="btn btn-primary submit_btn">Submit</button>
                              </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- :::::::::::::::::::::::::::::::::::::::::::::::::::::::   ::::::::::::::::::::::::::::::::::::::::::::::::::::::: -->
           <div class="panel-body">

            <ul class="nav nav-pills" style="padding: 30px 0px">
                <li style="border: 2px solid #d4d4eb; border-radius: 5px;" class="active"><a data-toggle="pill" href="#duration">Duration Wise</a></li>
                <li style="border: 2px solid #d4d4eb; border-radius: 5px;"><a data-toggle="pill" href="#month">Month Wise</a></li>
              </ul>
              
              <div class="tab-content">
                <div id="duration" class="tab-pane fade in active">
                    <h3>Duration Wise Revenue:</h3>

                    <h5 style="padding-top: 25px">Miaki</h5>
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Title (Miaki)</th>
                          <th>Total Amount</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Total Reveneu:</td>
                          <td class="text-right">{{ number_format($duration_wise['miaki']['tot_rev']) }}</td>
                        </tr>
                        <tr>
                          <td>(-)BTRC Reveneu Share(6.5%)</td>
                          <td class="text-right">{{ number_format($duration_wise['miaki']['btrc']) }}</td>
                        </tr>
                        <tr>
                          <td>Subtotal</td>
                          <td class="text-right">{{ number_format($duration_wise['miaki']['subtotal']) }}</td>
                        </tr>
                        <tr>
                          <td>Our Gross Revenue (.5)</td>
                          <td class="text-right">{{ number_format($duration_wise['miaki']['gross']) }}</td>
                        </tr>
                        <tr>
                          <td>(-)VAT (5%)</td>
                          <td class="text-right">{{ number_format($duration_wise['miaki']['vat']) }}</td>
                        </tr>
                        <tr>
                          <td>(-)AIT (0%)</td>
                          <td class="text-right">{{ number_format($duration_wise['miaki']['ait']) }}</td>
                        </tr>
                        <tr>
                          <td>(-)Rebate (0)</td>
                          <td class="text-right">{{ number_format($duration_wise['miaki']['rebate']) }}</td>
                        </tr>
                        <tr>
                          <td>Net Payable to Our Bank Account</td>
                          <td class="text-right">{{ number_format($duration_wise['miaki']['net']) }}</td>
                        </tr>
                      </tbody>
                    </table>
                    <!-- ------------------------------------------------------ -->

                    <h5 style="padding-top: 25px">MMLBD</h5>
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Title (MMLBD)</th>
                          <th>Total Amount</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Total Reveneu:</td>
                          <td class="text-right">{{ number_format($duration_wise['mmlbd']['tot_rev']) }}</td>
                        </tr>
                        <tr>
                          <td>(-)BTRC Reveneu Share(6.5%)</td>
                          <td class="text-right">{{ number_format($duration_wise['mmlbd']['btrc']) }}</td>
                        </tr>
                        <tr>
                          <td>Subtotal</td>
                          <td class="text-right">{{ number_format($duration_wise['mmlbd']['subtotal']) }}</td>
                        </tr>
                        <tr>
                          <td>Our Gross Revenue (.5)</td>
                          <td class="text-right">{{ number_format($duration_wise['mmlbd']['gross']) }}</td>
                        </tr>
                        <tr>
                          <td>(-)VAT (5%)</td>
                          <td class="text-right">{{ number_format($duration_wise['mmlbd']['vat']) }}</td>
                        </tr>
                        <tr>
                          <td>(-)AIT (0%)</td>
                          <td class="text-right">{{ number_format($duration_wise['mmlbd']['ait']) }}</td>
                        </tr>
                        <tr>
                          <td>(-)Rebate (0)</td>
                          <td class="text-right">{{ number_format($duration_wise['mmlbd']['rebate']) }}</td>
                        </tr>
                        <tr>
                          <td>Net Payable to Our Bank Account</td>
                          <td class="text-right">{{ number_format($duration_wise['mmlbd']['net']) }}</td>
                        </tr>
                      </tbody>
                    </table>
                    <!-- ------------------------------------------------------ -->

                    <h5 style="padding-top: 25px">Other</h5>
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Title (Other)</th>
                          <th>Total Amount</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Total Reveneu:</td>
                          <td class="text-right">{{ number_format($duration_wise['other']['tot_rev']) }}</td>
                        </tr>
                        <tr>
                          <td>(-)BTRC Reveneu Share(6.5%)</td>
                          <td class="text-right">{{ number_format($duration_wise['other']['btrc']) }}</td>
                        </tr>
                        <tr>
                          <td>Subtotal</td>
                          <td class="text-right">{{ number_format($duration_wise['other']['subtotal']) }}</td>
                        </tr>
                        <tr>
                          <td>Our Gross Revenue (.5)</td>
                          <td class="text-right">{{ number_format($duration_wise['other']['gross']) }}</td>
                        </tr>
                        <tr>
                          <td>(-)VAT (5%)</td>
                          <td class="text-right">{{ number_format($duration_wise['other']['vat']) }}</td>
                        </tr>
                        <tr>
                          <td>(-)AIT (0%)</td>
                          <td class="text-right">{{ number_format($duration_wise['other']['ait']) }}</td>
                        </tr>
                        <tr>
                          <td>(-)Rebate (0)</td>
                          <td class="text-right">{{ number_format($duration_wise['other']['rebate']) }}</td>
                        </tr>
                        <tr>
                          <td>Net Payable to Our Bank Account</td>
                          <td class="text-right">{{ number_format($duration_wise['other']['net']) }}</td>
                        </tr>
                      </tbody>
                    </table>
                    <!-- ------------------------------------------------------ -->

                </div>

                <div id="month" class="tab-pane fade">
                    <h3>Month Wise Revenue:</h3>
                    <table class="table table-hover table-bordered">
                      <thead>
                        <tr>
                          <th class="text-right">Year</th>
                          <th class="text-right">Month</th>
                          <th class="text-right">Miaki</th>
                          <th class="text-right">MMLBD</th>
                          <th class="text-right">Other</th>
                          <th class="text-right">Total</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($month_wise_all_revenue as $rev_arr)                       
                        <tr>
                          <td >{{ $rev_arr['year'] }}</td>
                          <td class="text-right">{{ $month_name[$rev_arr['month']] }}</td>
                          <td class="text-right">{{ number_format($rev_arr['miaki_rev']) }}</td>
                          <td class="text-right">{{ number_format($rev_arr['mmlbd_rev']) }}</td>
                          <td class="text-right">{{ number_format($rev_arr['other_rev']) }}</td>
                          <td class="text-right">{{ number_format($rev_arr['miaki_rev'] + $rev_arr['mmlbd_rev'] + $rev_arr['other_rev']) }}</td>
                        </tr>
                        @endforeach

                        <tr>
                          <th class="text-right">-</th>
                          <th class="text-right">Total Sum:</th>
                          <th class="text-right">{{ number_format($month_wise_3_type_rev['miaki_rev']) }}</th>
                          <th class="text-right">{{ number_format($month_wise_3_type_rev['mmlbd_rev']) }}</th>
                          <th class="text-right">{{ number_format($month_wise_3_type_rev['other_rev']) }}</th>
                          <th class="text-right">{{ number_format( $month_wise_3_type_rev['miaki_rev'] + $month_wise_3_type_rev['mmlbd_rev'] + $month_wise_3_type_rev['other_rev'] ) }}</th>
                        </tr>
                      </tbody>
                    </table>
                </div>
              </div>

            </div>
           
        </div>
    </div>
    @endsection