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
            <!-- :::::::::::::::::::::::::::::::::::::::::::::::::::::::  TOTAL  ::::::::::::::::::::::::::::::::::::::::::::::::::::::: -->
            <div class="panel-body">
              <h1 class="text-center"><b>Total Revenue</b></h1>
              @php $ind = 0; @endphp
              @foreach($all_data as $data)
                <table class="table table-bordered table-hover">
                    <tbody>
                      <tr>
                        <td> <b>(SL: {{++$ind}} )</b> Date :</td>
                        <th class="text-right">{{$data['year']}}-{{$data['month']}}</th>
                      </tr>
                      <tr>
                        <td>Total Revenue :</td>
                        <th class="text-right">{{number_format($data['tot_revenue'],2)}} Tk</th>
                      </tr>
                      <tr>
                        <td>Less:6.5% BTRC Revenue :</td>
                        <th class="text-right">{{number_format($data['btrc_revenue'],2)}} Tk</th>
                      </tr>
                      <tr>
                        <td>Miaki + Robi :</td>
                        <th class="text-right">{{number_format($data['miaki_robi_rev'],2)}} Tk</th>
                      </tr>
                      <tr>
                        <td>Miaki :</td>
                        <th class="text-right">{{number_format($data['miaki_rev'],2)}} Tk</th>
                      </tr>
                      <tr>
                        <td>Less: Vat5% :</td>
                        <th class="text-right">{{number_format($data['vat'],2)}} Tk</th>
                      </tr>
                      <tr>
                        <td>Final Revenue :</td>
                        <th class="text-right">{{number_format($data['final_revenue'],2)}} Tk</th>
                      </tr>
                    </tbody>
                </table>
              @endforeach

            </div>
            <!-- :::::::::::::::::::::::::::::::::::::::::::::::::::::::  MIAKI  ::::::::::::::::::::::::::::::::::::::::::::::::::::::: -->
            <div class="panel-body">
                <h1 class="text-center"><b>Total Miaki Revenue</b></h1>
                @php $ind = 0; @endphp
                @foreach($all_data_miaki as $data_miaki)
                  <table class="table table-bordered table-hover">
                      <tbody>
                        <tr>
                          <td> <b>(SL: {{++$ind}} )</b> Date :</td>
                          <th class="text-right">{{$data_miaki['year']}}-{{$data_miaki['month']}}</th>
                        </tr>
                        <tr>
                          <td>Total Revenue (Miaki):</td>
                          <th class="text-right">{{number_format($data_miaki['tot_revenue_miaki'],2)}} Tk</th>
                        </tr>
                        <tr>
                          <td>Less:6.5% BTRC Revenue :</td>
                          <th class="text-right">{{number_format($data_miaki['btrc_revenue'],2)}} Tk</th>
                        </tr>
                        <tr>
                          <td>Miaki + Robi :</td>
                          <th class="text-right">{{number_format($data_miaki['miaki_robi_rev'],2)}} Tk</th>
                        </tr>
                        <tr>
                          <td>Miaki :</td>
                          <th class="text-right">{{number_format($data_miaki['miaki_rev'],2)}} Tk</th>
                        </tr>
                        <tr>
                          <td>Less: Vat5% :</td>
                          <th class="text-right">{{number_format($data_miaki['vat'],2)}} Tk</th>
                        </tr>
                        <tr>
                          <td>Final Revenue :</td>
                          <th class="text-right">{{number_format($data_miaki['final_revenue'],2)}} Tk</th>
                        </tr>
                      </tbody>
                  </table>
                @endforeach
            </div>
            <!-- :::::::::::::::::::::::::::::::::::::::::::::::::::::::  MMLBD  ::::::::::::::::::::::::::::::::::::::::::::::::::::::: -->
            <div class="panel-body">
                <h1 class="text-center"><b>Total MMLBD Revenue</b></h1>
                @php $ind = 0; @endphp
                @foreach($all_data_mmlbd as $data_mmlbd)

                  <table class="table table-bordered table-hover">
                      <tbody>
                        <tr>
                          <td> <b>(SL: {{++$ind}} )</b> Date :</td>
                          <th class="text-right">{{$data_mmlbd['year']}}-{{$data_mmlbd['month']}}</th>
                        </tr>
                        <tr>
                          <td>Total Revenue (MMLBD):</td>
                          <th class="text-right">{{number_format($data_mmlbd['tot_revenue_mmlbd'],2)}} Tk</th>
                        </tr>
                        <tr>
                          <td>Less:6.5% BTRC Revenue :</td>
                          <th class="text-right">{{number_format($data_mmlbd['btrc_revenue'],2)}} Tk</th>
                        </tr>
                        <tr>
                          <td>Miaki + Robi :</td>
                          <th class="text-right">{{number_format($data_mmlbd['miaki_robi_rev'],2)}} Tk</th>
                        </tr>
                        <tr>
                          <td>Miaki :</td>
                          <th class="text-right">{{number_format($data_mmlbd['miaki_rev'],2)}} Tk</th>
                        </tr>
                        <tr>
                          <td>Less: Vat5% :</td>
                          <th class="text-right">{{number_format($data_mmlbd['vat'],2)}} Tk</th>
                        </tr>
                        <tr>
                          <td>Final Revenue :</td>
                          <th class="text-right">{{number_format($data_mmlbd['final_revenue'],2)}} Tk</th>
                        </tr>
                      </tbody>
                  </table>

                @endforeach
            </div>
        </div>
    </div>
    @endsection