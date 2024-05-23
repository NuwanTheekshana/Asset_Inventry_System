@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Add Dongle Details') }}
                  <button type="button" class="btn btn-success btn-sm pull-right" style="background-color: green" data-toggle="modal" data-target="#bulk_dongle_model">Bulk Dongle Upload</button>
                </div>

                <div class="card-body">
                    
                    <form class="form-inline col-36" id="add_dongle_form" action="{{route('add_unallocated_dongle_data')}}" method="POST">
                        @csrf
                        <div class="form-group mb-2" style="width:100%;">

                            <label for="add_dongle_type_val" class="col-2 form-label">Dongle Type</label>
                            <select class="form-control col-sm-3" name="add_dongle_type_val" id="add_dongle_type_val">
                                     <option value="">Select Dongle Type</option>
                                     <option value="Dongle">Dongle</option>
                                     <option value="Wingle">Wingle</option>
                                     <option value="Pocket WIFI">Pocket WIFI</option>
                                     <option value="Router">Router</option>
                                     <option value="TAB">TAB</option>                          
                            </select>

                            <label for="add_unallocate_connection_type" class="col-2 form-label">Connection Type</label>
                            <select class="form-control col-sm-3" name="add_unallocate_connection_type" id="add_unallocate_connection_type">
                                     <option value="">Select connection type</option>
                                     <option value="Dialog">Dialog</option>
                                     <option value="Mobitel">Mobitel</option>                       
                            </select>

                        </div>

                          
                        <div class="form-group mt-2" style="width:100%;">
                          <label for="add_unallocate_connection_no" class="col-2 form-label">Connection No </label>
                          <input type="text" id="add_unallocate_connection_no" class="form-control col-sm-3" aria-describedby="add_unallocate_connection_no" name="add_unallocate_connection_no">

                            <label for="add_unallocate_sim_no" class="col-2 form-label">SIM No</label>
                            <input type="text" id="add_unallocate_sim_no" class="form-control col-sm-3" aria-describedby="add_unallocate_sim_no" name="add_unallocate_sim_no">

                          <div class="form-group mt-3" style="width:100%;">
                            
                            
                          <label for="add_unallocate_ipaddress" class="col-2 form-label">IP Address </label>
                          <input type="text" id="add_unallocate_ipaddress" class="form-control col-sm-3" aria-describedby="add_unallocate_ipaddress" name="add_unallocate_ipaddress">
                   
                          <label for="add_unallocate_dongle_modal" class="col-2 form-label">Dongle Modal</label>
                          <input type="text" id="add_unallocate_dongle_modal" class="form-control col-sm-3" aria-describedby="add_unallocate_dongle_modal" name="add_unallocate_dongle_modal">

                        </div>

                        <div class="form-group mt-3" style="width:100%;">

                          <label for="add_unallocate_dongle_imei" class="col-2 form-label">Dongle IMEI No</label>
                          <input type="text" id="add_unallocate_dongle_imei" class="form-control col-sm-3" aria-describedby="add_unallocate_dongle_imei" name="add_unallocate_dongle_imei">
  

                        <label for="unallocated_dongle_condition" class="col-2 form-label">Dongle Condition</label>
                        <select class="form-control col-sm-3" id="unallocated_dongle_condition" name="unallocated_dongle_condition" required>
                            <option value="">Select Condition</option>
                            <option value="Good">Good</option>
                            <option value="Medium">Medium</option>
                            <option value="Poor">Poor</option>
                            <option value="None">None</option>
                          </select>

                        </div>
                         
                          <button type="submit" class="btn btn-primary mt-3 col-2" id="find_btn" style="margin-left: 550px;background-color: #011842;color: white"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Add</button>
                          <button type="reset" class="btn btn-warning mt-3 ml-3 col-2" style="background-color: orange"><i class="fa fa-eraser"></i>&nbsp;&nbsp;Reset</button>
                        
                      
                        </div>

                       

                        
                      
                      </form>



                </div>
            </div>



            <div class="card mt-3" id="find_details_card">
                <div class="card-body">
            <p>All Unallocated Details</p>
            
            
            <table id="find_asset_details_table" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th width="15%">Dongle Type</th>
                            <th width="15%">Connection No</th>
                            <th width="15%">SIM No</th>
                            <th width="15%">IP Address</th>
                            <th width="15%">Dongle Modal</th>
                            <th width="15%">Dongle Condition</th>
                            <th width="15%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach ($get_dongle_asset as $dongle)
                          <tr>
                              <td>{{$dongle->asset_type}}</td>
                              <td>{{$dongle->connection_number}}</td>
                              <td>{{$dongle->sim_no}}</td>
                              <td>{{$dongle->ipaddress}}</td>
                              <td>{{$dongle->dongle_modal}}</td>
                              <td>{{$dongle->dongle_condition}}</td>
                              <td>
                                <center><a href='{{url('allocate_dongle')}}/{{$dongle->id}}'><button class='btn btn-primary btn-sm btn_style' style='background-color:#011842;'><i class='fa fa-paper-plane'></i>&nbsp;&nbsp;Allocate</button></a></center>
                              </td>
                          </tr>
                      @endforeach
            
                    </tbody>
            
            </table>
            
        
                </div>
            </div>


        </div>
    </div>
</div>



<!--Bulk Dongle Upload Modal -->
<div id="bulk_dongle_model" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
          <h4 class="modal-title">Dongle Bulk Upload</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
      </div>
      <div class="modal-body">
       
        <form action="{{route('bulk_dongle_upload')}}" method="POST" enctype="multipart/form-data">
          @csrf

          <div class="form-group row">
              <label for="upload_file" class="col-sm-4 col-form-label">Upload File</label>
              <div class="col-sm-6">
                <input type="file" class="form-control" id="upload_file" name="upload_file" accept=".csv, text/csv">
              </div>
              <div class="col-sm-2">
                <a href="{{route('download_dongle_csv_demo')}}">
                  <button type="button" id="csv_download" class="btn btn-success btn-sm mt-2" title="Download CSV file"><i class="fa fa-download"></i></button>
                </a>
              </div>
          </div>

          <button type="submit" class="btn btn-warning pull-right" style="background-color: orange"><i class="fa fa-upload"></i>&nbsp;    Upload Bulk List</button>
      </form>


      </div>

    </div>

  </div>
</div>


@endsection