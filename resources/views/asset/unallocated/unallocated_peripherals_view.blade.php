@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Add Peripherals Details') }}
                  <button type="button" class="btn btn-primary btn-sm pull-right ml-2" style="background-color: #011842" data-toggle="modal" data-target="#add_peripherals_model">Add peripheral Type</button>
                  <button type="button" class="btn btn-success btn-sm pull-right" style="background-color: green" data-toggle="modal" data-target="#bulk_peripherals_model">Bulk peripherals Upload</button>
                </div>

                <div class="card-body">
                    
                    <form class="form-inline col-36" id="add_peripherals_form" action="{{route('add_peripherals')}}" method="POST">
                        @csrf
                        <div class="form-group mb-2" style="width:100%;">

                            <label for="add_peripherals_type_val" class="col-2 form-label">peripherals Type</label>
                            <select class="form-control col-sm-3" name="add_peripherals_type_val" id="add_peripherals_type_val">
                                     <option value="">Select peripherals Type</option>
                                      @foreach ($peripherals_type as $peripherals)
                                     <option value="{{$peripherals->id}}">{{$peripherals->peripheral_type}}</option> 
                                       @endforeach                     
                            </select>

                            <label for="add_serial_no" class="col-2 form-label">Serial Number</label>
                            <input type="text" id="add_serial_no" class="form-control col-sm-3" aria-describedby="add_serial_no" name="add_serial_no" disabled>
                            <button type="button" class="btn btn-primary ml-2" style="background-color: #011842" data-toggle="modal" data-target="#serial_no_model"><i class="fa fa-plus-circle"></i></button>
                        </div>

                        <div class="form-group mt-2" style="width:100%;">
                          <label for="add_unallocate_unit_price" class="col-2 form-label">Unit Price </label>
                          <input type="number" id="add_unallocate_unit_price" class="form-control col-sm-3" aria-describedby="add_unallocate_unit_price" name="add_unallocate_unit_price">

                            <label for="add_unallocate_supplier" class="col-2 form-label">Supplier</label>
                            <input type="text" id="add_unallocate_supplier" class="form-control col-sm-3" aria-describedby="add_unallocate_supplier" name="add_unallocate_supplier">

                          <div class="form-group mt-3" style="width:100%;">
                            
                            
                          <label for="add_unallocate_ponumber" class="col-2 form-label">PO Number </label>
                          <input type="text" id="add_unallocate_ponumber" class="form-control col-sm-3" aria-describedby="add_unallocate_ponumber" name="add_unallocate_ponumber">
                   
                          <label for="add_unallocate_received_date" class="col-2 form-label">Received date</label>
                          <input type="date" id="add_unallocate_received_date" class="form-control col-sm-3" aria-describedby="add_unallocate_received_date" name="add_unallocate_received_date">

                        </div>

                        <div class="form-group mt-3" style="width:100%;">

                          <label for="add_unallocate_quantity" class="col-2 form-label">Quantity</label>
                          <input type="number" id="add_unallocate_quantity" class="form-control col-sm-3" aria-describedby="add_unallocate_quantity" name="add_unallocate_quantity">
  

                        <label for="unallocated_peripherals_condition" class="col-2 form-label">peripherals Condition</label>
                        <select class="form-control col-sm-3" id="unallocated_peripherals_condition" name="unallocated_peripherals_condition" required>
                            <option value="">Select Condition</option>
                            <option value="Good">New</option>
                            <option value="Medium">Used</option>
                          </select>

                        </div>
                         
                          <button type="submit" class="btn btn-primary mt-3 col-2" id="find_btn" style="margin-left: 550px;background-color: #011842;color: white"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Add</button>
                          <button type="reset" class="btn btn-warning mt-3 ml-3 col-2" style="background-color: orange"><i class="fa fa-eraser"></i>&nbsp;&nbsp;Reset</button>
                        
                      
                        </div>

                       
                        <!--add serial number list modal -->
                        <div id="serial_no_model" class="modal fade" role="dialog">
                            <div class="modal-dialog modal-lg">
                        
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Add Serial Number List</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                               
                                    <div class="form-group row">
                                        <label for="peri_type" class="col-sm-4 col-form-label">Serial Number</label>
                                        <div class="col-sm-8">
                                        <input type="text" class="form-control" id="phrip_serial_no" name="phrip_serial_no">
                                        <button type="button" class="btn btn-primary btn-sm" id="add_peripherals_serials" style="background-color: #011842"> Add</button>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                      <label class="col-sm-4 col-form-label"></label>
                                      <div class="col-sm-8" id="serialclone"></div>
                                    </div>
                        
                                    <button type="button" id="save_seriallist_btn" class="btn btn-warning pull-right mt-3" style="background-color: orange"><i class="fa fa-save"></i>&nbsp;    Save Serial Number List</button>
                               
                                </div>
                            </div>
                            </div>
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
                            <th width="5%">Id</th>
                            <th width="15%">Peripheral Type</th>
                            <th width="15%">Serial No</th>
                            <th width="15%">Supplier</th>
                            <th width="15%">Unit Price</th>
                            <th width="15%">Received Date</th>
                            <th width="10%">Condition</th>
                            <th width="20%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($getPeripherals as $peripherals)
                          <tr>
                              <td>{{$peripherals->id}}</td>
                              <td>{{$peripherals->peripheral_type}}</td>
                              <td>{{$peripherals->serial_number}}</td>
                              <td>{{$peripherals->supplier_name}}</td>
                              <td>{{$peripherals->unit_price}}</td>
                              <td>{{$peripherals->received_date}}</td>
                              <td>{{$peripherals->pheripherals_condition}}</td>
                              <td>
                                <center><a href='{{url('allocate_peripheral')}}/{{$peripherals->id}}/{{$peripherals->serial_id}}'><button class='btn btn-primary btn-sm btn_style' style='background-color:#011842;'><i class='fa fa-paper-plane'></i>&nbsp;&nbsp;Allocate</button></a></center>
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



<!--Bulk peripherals Upload Modal -->
<div id="bulk_peripherals_model" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
          <h4 class="modal-title">peripherals Bulk Upload</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
      </div>
      <div class="modal-body">
       
        {{-- <form action="{{route('bulk_peripherals_upload')}}" method="POST" enctype="multipart/form-data">
          @csrf

          <div class="form-group row">
              <label for="upload_file" class="col-sm-4 col-form-label">Upload File</label>
              <div class="col-sm-6">
                <input type="file" class="form-control" id="upload_file" name="upload_file" accept=".csv, text/csv">
              </div>
              <div class="col-sm-2">
                <a href="{{route('download_peripherals_csv_demo')}}">
                  <button type="button" id="csv_download" class="btn btn-success btn-sm mt-2" title="Download CSV file"><i class="fa fa-download"></i></button>
                </a>
              </div>
          </div>

          <button type="submit" class="btn btn-warning pull-right" style="background-color: orange"><i class="fa fa-upload"></i>&nbsp;    Upload Bulk List</button>
      </form> --}}


      </div>

    </div>

  </div>
</div>



<!--add peripherals Modal -->
<div id="add_peripherals_model" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
  
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Add Peripheral Type</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body">
         
          <form action="{{route('add_peripherals_type')}}" method="POST">
            @csrf
  
            <div class="form-group row">
                <label for="peri_type" class="col-sm-4 col-form-label">Peripheral Type</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="peri_type" name="peri_type">
                </div>
            </div>
  
            <button type="submit" class="btn btn-warning pull-right" style="background-color: orange"><i class="fa fa-paper-plane"></i>&nbsp;    Add Peripheral Type</button>
        </form>
  
  
        </div>
  
      </div>
  
    </div>
  </div>

  @include('asset.unallocated.peripherals_js_script')

@endsection