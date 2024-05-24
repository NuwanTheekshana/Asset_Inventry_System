@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Add Asset Details') }}
                    <button type="button" class="btn btn-success btn-sm pull-right" style="background-color: green" data-toggle="modal" data-target="#bulk_asset_model">Bulk Asset Upload</button>
                </div>

                <div class="card-body">
                    
                    <form class="form-inline col-36" id="add_asset_form" action="{{route('add_unallocated_data')}}" method="POST">
                        @csrf
                        <div class="form-group mb-2" style="width:100%;">

                            <label for="add_asset_type" class="col-2 form-label">Asset Type</label>
                            <select class="form-control col-sm-3" name="add_asset_type_val" id="add_asset_type_val">
                                     <option value="">Select Asset Type</option>
                                     <option value="Laptop">Laptop</option>
                                     <option value="Desktop">Desktop</option>
                                     <option value="Monitor">Monitor</option>
                                     <option value="Projector">Multimedia Projector</option>
                                     <option value="Scanner">Scanner</option>
                                     <option value="TAB">TAB</option>                                 
                                     <option value="Pen Drive">Pen Drive</option>
                                     <option value="External Hard Drive">External Hard Drive</option>
                            </select>

                                <label for="add_unallocate_asset_no" class="col-2 form-label">Asset No </label>
                                <input type="text" id="add_unallocate_asset_no" class="form-control col-sm-3" aria-describedby="add_unallocate_asset_no" name="add_unallocate_asset_no">
                            
                         
                     
                        </div>

                          
                        <div class="form-group mt-3" style="width:100%;">
                        
                              
                            <label for="add_unallocate_serial_no" class="col-2 form-label">Serial No</label>
                            <input type="text" id="add_unallocate_serial_no" class="form-control col-sm-3" aria-describedby="add_unallocate_serial_no" name="add_unallocate_serial_no">
                           

                          <label for="add_unallocate_asset_model" class="col-2 form-label">Asset Model </label>
                          <input type="text" id="add_unallocate_asset_model" class="form-control col-sm-3" aria-describedby="add_unallocate_asset_model" name="add_unallocate_asset_model">



                          <div class="form-group mt-3" style="width:100%;">
                        
                              
                            <label for="add_unallocate_other_asset_modal" class="col-2 form-label">Other Asset Modal</label>
                            <input type="text" id="add_unallocate_other_asset_modal" class="form-control col-sm-3" aria-describedby="add_unallocate_other_asset_modal" name="add_unallocate_other_asset_modal">
                           

                          <label for="add_unallocate_other_asset_modal_capacity" class="col-2 form-label">Other Asset Capacity </label>
                          <input type="text" id="add_unallocate_other_asset_modal_capacity" class="form-control col-sm-3" aria-describedby="add_unallocate_other_asset_modal_capacity" name="add_unallocate_other_asset_modal_capacity">
  
                      
                        </div>

                        <div class="form-group mt-3" style="width:100%;">

                        <label for="unallocated_asset_condition" class="col-2 form-label">Asset Condition</label>
                        <select class="form-control col-sm-3" id="unallocated_asset_condition" name="unallocated_asset_condition" required>
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
                            <th width="15%">Asset Type</th>
                            <th width="15%">Asset No</th>
                            <th width="15%">Asset Modal</th>
                            <th width="15%">Other Asset Modal</th>
                            <th width="15%">Other Asset Capacity</th>
                            <th width="15%">Asset Condition</th>
                            <th width="15%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach ($get_asset as $asset)
                          <tr>
                              <td>{{$asset->asset_type}}</td>
                              <td>{{$asset->asset_no}}</td>
                              <td>{{$asset->asset_model}}</td>
                              <td>{{$asset->other_asset_model}}</td>
                              <td>{{$asset->other_asset_model}}</td>
                              <td>{{$asset->asset_condition}}</td>
                              <td>
                                <center><a href="{{url('allocate_asset')}}/{{$asset->id}}"><button class='btn btn-primary btn-sm btn_style' style='background-color:#011842;' ><i class='fa fa-paper-plane'></i>&nbsp;&nbsp;Allocate</button></a></center>
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




    <!--Allocated asset Modal -->
    <div id="allocated_asset_modal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Asset Allocation</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            
            </div>
            <div class="modal-body">
                <form class="form-inline col-36" id="allocated_asset_form" action="" method="POST">
                    @csrf
                    
                    <div id="asset_details_div">

                    
                    <p style="color: red"><i class="fa fa-address-book"></i> Asset Details</p>
                    <div class="form-group row">
                        <label for="allocate_user_asset_type" class="col-sm-2 col-form-label">Asset Type</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="allocate_user_asset_type" name="allocate_user_asset_type" value="{{$asset->asset_type}}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="allocate_user_asset_no" class="col-sm-2 col-form-label">Asset No</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="allocate_user_asset_no" name="allocate_user_asset_no" value="{{$asset->asset_no}}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="allocate_user_serial_no" class="col-sm-2 col-form-label">Serial No</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="allocate_user_serial_no" name="allocate_user_serial_no" value="{{$asset->serial_no}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="allocate_user_asset_modal" class="col-sm-2 col-form-label">Asset Modal</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="allocate_user_asset_modal" name="allocate_user_asset_modal" value="{{$asset->asset_model}}">
                        </div>
                    </div>

                    <button type="button" id="next_btn" class="btn btn-primary pull-right">Next</button>
                </div>


                    <div id="emp_details_div" style="display: none">

                        <div class="form-group col-md-12">
                            <label for="allocate_user_compy_type">Company</label>
                            <select id="compy_type" class="form-control @error('compy_type') is-invalid @enderror" value="{{ old('compy_type') }}" name="allocate_user_compy_type">
                                <option value="">Select Company</option>
                                <option value="HNBA">HNB Assurance PLC</option>
                                <option value="HNBGI">HNB General Insurance Ltd.</option>
                            </select>
                        </div>
            
            
                        <div class="form-group col-md-5" id="epf_no_div" style="display: none">
                            <label for="allocate_user_epfno">EPF No</label>
                            <input type="text" class="form-control text-center" id="allocate_user_epfno" name="allocate_user_epfno" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;">
                        </div>


                    </div>
                  





                      
                      <div class="form-group row">
                        <div class="col-sm-10">
                          <button type="submit" class="btn btn-primary pull-right" style="display: none">Allocate Asset</button>
                        </div>
                      </div>




               
                </form>
            </div>
    
        </div>
    </div>

    </div>




    <!--Bulk Dongle Upload Modal -->
<div id="bulk_asset_model" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
  
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Asset Bulk Upload</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body">
         
          <form action="{{route('bulk_asset_upload')}}" method="POST" enctype="multipart/form-data">
            @csrf
  
            <div class="form-group row">
                <label for="upload_file" class="col-sm-4 col-form-label">Upload File</label>
                <div class="col-sm-6">
                  <input type="file" class="form-control" id="upload_file" name="upload_file" accept=".csv, text/csv">
                </div>
                <div class="col-sm-2">
                  <a href="{{route('download_asset_csv_demo')}}">
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


<script>
    $('#add_asset_type_val').change(function () 
    {
        var add_asset_type = $('#add_asset_type_val').val();
        
        if (add_asset_type == "Pen Drive" || add_asset_type == "External Hard Drive") 
        {
            $('#add_unallocate_asset_no').prop('readonly', true);
            $('#add_unallocate_serial_no').prop('readonly', true);
            $('#add_unallocate_asset_model').prop('readonly', true);

            $('#add_unallocate_other_asset_modal').prop('readonly', false);
            $('#add_unallocate_other_asset_modal_capacity').prop('readonly', false);
        }
        else
        {
            $('#add_unallocate_asset_no').prop('readonly', false);
            $('#add_unallocate_serial_no').prop('readonly', false);
            $('#add_unallocate_asset_model').prop('readonly', false);

            $('#add_unallocate_other_asset_modal').prop('readonly', true);
            $('#add_unallocate_other_asset_modal_capacity').prop('readonly', true);
        }
    });
</script>

<script>
    $('#next_btn').click(function () 
    {

            alert("nuwan");
        //  var allocate_asset_type = $('#allocate_asset_type').val();
        //  var allocate_asset_no = $('#allocate_asset_no').val();
        //  var allocate_serial_no = $('#allocate_serial_no').val();
        //  var allocate_asset_modal = $('#allocate_asset_modal').val();

        //  if (allocate_asset_type == "" || allocate_asset_no == "" || allocate_serial_no == "" || allocate_asset_modal == "") 
        //  {
        //     $.bootstrapGrowl('<b><i> <span class = "glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;&nbsp;Warning &nbsp;!&nbsp;All fields are required..!</i></b>',
        //         {
        //         type: 'danger',
        //         width: 500,
        //         delay: 10000,
        //         });
        //         $(window).scrollTop(0);
        //         return false;
        //  }
        
        //  $('#asset_details_div').hide(1000);
        //  $('#emp_details_div').show(1000);
         


    });
</script>

@endsection