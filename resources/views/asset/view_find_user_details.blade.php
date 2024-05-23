@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Find User Asset Details') }}
                    @if ($asset_user_tbls->status == 0)
                    <button class="btn btn-success btn-sm pull-right" style="background-color: green" id="activate_btn" data-toggle="modal" data-target="#activate_account_modal{{$token_id}}"><i class="fa fa-check-circle"></i>&nbsp;Activate account</button>
                    @else
                    <button class="btn btn-danger btn-sm pull-right" style="background-color: red" id="deactivate_btn"><i class="fa fa-times-circle"></i>&nbsp;Deactivate account</button>
                    @endif
                    <button class="btn btn-warnning btn-sm mr-3 pull-right" style="background-color: orange" id="activate_btn" data-toggle="modal" data-target="#followup_modal{{$token_id}}"><i class="fa fa-info"></i>&nbsp;Followup user</button>
                    <button class="btn btn-success btn-sm mr-3 pull-right" style="background-color: green" id="edit_account_btn" data-toggle="modal" data-target="#edit_account_modal{{$token_id}}"><i class="fa fa-edit"></i>&nbsp;Edit user details</button>
                </div>

                <div class="card-body">
                    
                    <form class="form-inline col-36" id="findform">
                     
                        <p style="color: red"><i class="fa fa-list-alt" aria-hidden="true"></i> &nbsp; Employee Details</p>

                        <div class="form-row">
            
                    <div class="form-group row col-6" id="epf_no_div">
                        <label for="epfno_val" class="col-sm-4 col-form-label"><b>EPF No</b></label>
                        <div class="col-sm-8">
                            <input type="text" readonly class="form-control-plaintext" id="epfno_val" name="epfno_val" value="{{$asset_user_tbls->epf_no}}">
                        </div>
                    </div>
            
            
                <div class="form-group row col-6">
                    <label for="fname" class="col-sm-4 col-form-label"><b>User Name</b></label>
                    <div class="col-sm-8">
                        <input type="text" readonly class="form-control-plaintext" id="fname" name="fname" value="{{$asset_user_tbls->full_name}}">
                    </div>
                </div>
            
                <div class="form-group row col-6">
                    <label for="emp_type" class="col-sm-4 col-form-label"><b>Employee Type</b></label>
                    <div class="col-sm-8">
                        <input type="text" readonly class="form-control-plaintext" id="emp_type" name="emp_type" value="{{$asset_user_tbls->emplyee_type}}">
                    </div>
                </div>

                <div class="form-group row col-6">
                    <label for="NIC" class="col-sm-4 col-form-label"><b>NIC No</b></label>
                    <div class="col-sm-8">
                        <input type="text" readonly class="form-control-plaintext" id="NIC" name="NIC" value="{{$asset_user_tbls->nic_no}}">
                    </div>
                </div>
            
            
                <div class="form-group row col-6">
                    <label for="designation" class="col-sm-4 col-form-label"><b>Designation</b></label>
                    <div class="col-sm-8">
                        <input type="text" readonly class="form-control-plaintext" id="designation" name="designation" value="{{$asset_user_tbls->designation}}">
                    </div>
                </div>

            
                <div class="form-group row col-6">
                    <label for="location" class="col-sm-4 col-form-label"><b>Location</b></label>
                    <div class="col-sm-8">
                        <input type="text" readonly class="form-control-plaintext" id="location" name="location" value="{{$asset_user_tbls->location}}">
                    </div>
                </div>

                <div class="form-group row col-6">
                    <label for="email" class="col-sm-4 col-form-label"><b>Email Address</b></label>
                    <div class="col-sm-8">
                        <input type="text" readonly class="form-control-plaintext" id="email" name="email" value="{{$asset_user_tbls->email}}">
                    </div>
                </div>

                <div class="form-group row col-6">
                    <label for="contact_no" class="col-sm-4 col-form-label"><b>Contact No</b></label>
                    <div class="col-sm-8">
                        <input type="text" readonly class="form-control-plaintext" id="contact_no" name="contact_no" value="{{$asset_user_tbls->contact_no}}">
                    </div>
                </div>
            
            </div>
            
                    
                    </form>

                </div>
            </div>

            @if (count($find_asset_details) == 0)
                @if ($asset_user_tbls->status == 0)
                <button class="btn btn-warning btn-sm mt-3 mb-2" style="background-color: orange" disabled><i class="fa fa-plus-circle"></i>&nbsp;Insert main asset</button>
                @else
                <button class="btn btn-warning btn-sm mt-3 mb-2" style="background-color: orange" data-toggle="modal" data-target="#add_asset_modal{{$token_id}}"><i class="fa fa-plus-circle"></i>&nbsp;Insert main asset</button>
                @endif
            
            @endif
            @if (count($find_asset_other_details) == 0)
                @if ($asset_user_tbls->status == 0)
                <button class="btn btn-warning btn-sm mt-3 mb-2" style="background-color: orange" disabled><i class="fa fa-plus-circle"></i>&nbsp;Insert other asset</button>
                @else
                <button class="btn btn-warning btn-sm mt-3 mb-2" style="background-color: orange" data-toggle="modal" data-target="#add_other_asset_modal{{$token_id}}"><i class="fa fa-plus-circle"></i>&nbsp;Insert other asset</button>
                @endif
            
            @endif
            @if (count($find_dongle_details) == 0)
                @if ($asset_user_tbls->status == 0)
                <button class="btn btn-warning btn-sm mt-3 mb-2" style="background-color: orange" disabled><i class="fa fa-plus-circle"></i>&nbsp;Insert dongle</button>
                @else
                <button class="btn btn-warning btn-sm mt-3 mb-2" style="background-color: orange" data-toggle="modal" data-target="#add_dongle_modal{{$token_id}}"><i class="fa fa-plus-circle"></i>&nbsp;Insert dongle</button>
                @endif

            @endif

            
            @if (count($find_asset_details) == 0)
                    
            @else
                
            <div class="card mt-4">
                <div class="card-body">
                    <p style="color: red"><i class="fa fa-list-alt" aria-hidden="true"></i> &nbsp; Asset Details</p>

                    
                    <center>
                        <p>
                            
                            <b>
                                Main Asset
                            </b>
                        </p>
                    </center>
                   
                    <button class="btn btn-warning btn-sm pull-right mb-2" style="background-color: orange" data-toggle="modal" data-target="#add_asset_modal{{$token_id}}"><i class="fa fa-plus-circle"></i></button>


                    <table id="asset_data_table" class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="text-align: center">Asset Type</th>
                                <th style="text-align: center">Asset Model</th>
                                <th style="text-align: center">Serial Number</th>
                                <th style="text-align: center">Device Modal</th>
                                <th style="text-align: center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tbody>
                                @foreach ($find_asset_details as $asset)
                                <tr>
                                    <td>{{$asset->asset_type}}</td>
                                    <td>{{$asset->asset_no}}</td>
                                    <td>{{$asset->asset_serial_no}}</td>
                                    <td>{{$asset->asset_model}}</td>
                                    <td>
                                        <center>
                                            <button class="btn btn-success" style="background-color: green" data-toggle="modal" data-target="#edit_asset_modal{{$asset->id}}">Edit</button>
                                            <button class="btn btn-danger" style="background-color: red" data-toggle="modal" data-target="#return_asset_modal{{$asset->id}}">Return</button>
                                            
                                        </center>
                                    </td>
                                </tr>



                                    <!--Edit Modal -->
                                <div id="edit_asset_modal{{$asset->id}}" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Asset Details - {{$asset->asset_no}}</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        
                                        </div>
                                        <div class="modal-body">

                                            <form action="{{route('update_asset_user_data')}}" method="POST">
                                                @csrf
                                                <div class="form-group row">
                                                    <label for="update_asset_type" class="col-sm-4 col-form-label">Asset Type</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="update_asset_type" name="update_asset_type" required>
                                                            <option value="{{$asset->asset_type}}">{{$asset->asset_type}}</option>
                                                            <option value="Laptop">Laptop</option>
                                                            <option value="Desktop">Desktop</option>
                                                            <option value="Monitor">Monitor</option>
                                                            <option value="Projector">Multimedia Projector</option>
                                                            <option value="Scanner">Scanner</option>
                                                            <option value="TAB">TAB</option>
                                                          </select>
                                                    </div>
                                                  </div>
                                                <div class="form-group row">
                                                    <label for="update_asset_no" class="col-sm-4 col-form-label">Asset No</label>
                                                    <div class="col-sm-8">
                                                      <input type="number" class="form-control" id="update_asset_no" name="update_asset_no" value="{{$asset->asset_no}}" required>
                                                      <input type="hidden" class="form-control" id="asset_id" name="asset_id" value="{{$asset->id}}" required>
                                                    </div>
                                                  </div>
                                                  <div class="form-group row">
                                                    <label for="update_serialno" class="col-sm-4 col-form-label">Serial No</label>
                                                    <div class="col-sm-8">
                                                      <input type="text" class="form-control" id="update_serialno" name="update_serialno" value="{{$asset->asset_serial_no}}" required>
                                                    </div>
                                                  </div>
                                                  <div class="form-group row">
                                                    <label for="update_asset_modal" class="col-sm-4 col-form-label">Asset Modal</label>
                                                    <div class="col-sm-8">
                                                      <input type="text" class="form-control" id="update_asset_modal" name="update_asset_modal" value="{{$asset->asset_model}}" required>
                                                    </div>
                                                  </div>

                                                    <button class="btn btn-danger pull-right" style="background-color: red" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-success pull-right mr-2" style="background-color: green">Update Asset</button>

                                            </form>
                                        
                                        </div>
                                        
                                    </div>
                                
                                    </div>
                                </div>



                                
                                    <!--Return asset Modal -->
                                    <div id="return_asset_modal{{$asset->id}}" class="modal fade" role="dialog">
                                        <div class="modal-dialog">
                                    
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Asset Return - {{$asset->asset_no}}</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            
                                            </div>
                                            <div class="modal-body">
    
                                                <form action="{{route('return_asset')}}" method="POST">
                                                    @csrf
                                                    <div class="form-group row">
                                                        <label for="retun_reason" class="col-sm-4 col-form-label">Return reason</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control" id="retun_reason" name="retun_reason" required>
                                                                <option value="">Select Reason</option>
                                                                <option value="Employee resign">Employee resign</option>
                                                                <option value="Replacement">Replacement</option>
                                                                <option value="Damage">Damage</option>
                                                                <option value="Device loss">Device loss</option>
                                                                <option value="Other">Other</option>
                                                              </select>
                                                        </div>
                                                      </div>
                                                    <div class="form-group row" id="other_remark_div">
                                                        <label for="return_other_remark" class="col-sm-4 col-form-label">Remark</label>
                                                        <div class="col-sm-8">
                                                          <textarea type="number" class="form-control" id="return_other_remark" name="return_other_remark"></textarea>
                                                          <input type="hidden" class="form-control" id="asset_return_id" name="asset_return_id" value="{{$asset->id}}" required>
                                                        </div>
                                                      </div>

                                                      <div class="form-group row">
                                                        <label for="return_asset_condition" class="col-sm-4 col-form-label">Asset condition</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control" id="return_asset_condition" name="return_asset_condition" required>
                                                                <option value="">Select Condition</option>
                                                                <option value="Good">Good</option>
                                                                <option value="Medium">Medium</option>
                                                                <option value="Poor">Poor</option>
                                                                <option value="None">None</option>
                                                              </select>
                                                        </div>
                                                      </div>
                                                     
    
                                                        <button class="btn btn-danger pull-right" style="background-color: red" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-success pull-right mr-2" style="background-color: green">Return Asset</button>
    
                                                </form>
                                            
                                            </div>
                                            
                                        </div>
                                    
                                        </div>
                                    </div>

                                @endforeach
                                
                            </tbody>
                        </tbody>
                    </table>

                    @endif

                    @if (count($find_asset_other_details) == 0)
                    
                    @else
                    <center>
                        <p>
                            <b>
                                Other Asset
                            </b>
                        </p>
                    </center>
                    
                    <button class="btn btn-warning btn-sm pull-right mb-2" style="background-color: orange" data-toggle="modal" data-target="#add_other_asset_modal{{$token_id}}"><i class="fa fa-plus-circle"></i></button>

                    <table id="asset_data_table" class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="text-align: center">Asset Type</th>
                                <th style="text-align: center">Asset Modal</th>
                                <th style="text-align: center">Capacity</th>
                                <th style="text-align: center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tbody>
                                @foreach ($find_asset_other_details as $other_asset)
                                <tr>
                                    <td>{{$other_asset->asset_type}}</td>
                                    <td>{{$other_asset->other_asset_model}}</td>
                                    <td>{{$other_asset->other_asset_capacity}}</td>
                                    <td>
                                        <center>
                                            <button class="btn btn-success" style="background-color: green" data-toggle="modal" data-target="#edit_other_asset_modal{{$other_asset->id}}">Edit</button>
                                            <button class="btn btn-danger" style="background-color: red" data-toggle="modal" data-target="#return_other_asset_modal{{$other_asset->id}}">Return</button>
                                        </center>
                                    </td>
                                </tr>




                                    <!--Edit Modal -->
                                    <div id="edit_other_asset_modal{{$other_asset->id}}" class="modal fade" role="dialog">
                                        <div class="modal-dialog">
                                    
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Other Asset Details</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            
                                            </div>
                                            <div class="modal-body">
    
                                                <form action="{{route('update_other_asset_user_data')}}" method="POST">
                                                    @csrf
                                                    <div class="form-group row">
                                                        <label for="update_other_asset_type" class="col-sm-4 col-form-label">Asset Type</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control" id="update_other_asset_type" name="update_other_asset_type" required>
                                                                <option value="{{$other_asset->asset_type}}">{{$other_asset->asset_type}}</option>
                                                                <option value="Pen Drive">Pen Drive</option>
                                                                <option value="External Hard Drive">External Hard Drive</option>
                                                              </select>
                                                        </div>
                                                      </div>
                                                    
                                                      <div class="form-group row">
                                                        <label for="update_other_asset_modal" class="col-sm-4 col-form-label">Asset Modal</label>
                                                        <div class="col-sm-8">
                                                          <input type="text" class="form-control" id="update_other_asset_modal" name="update_other_asset_modal" value="{{$other_asset->other_asset_model}}" required>
                                                          <input type="hidden" class="form-control" id="other_asset_id" name="other_asset_id" value="{{$other_asset->id}}" required>
                                                        </div>
                                                      </div>

                                                      <div class="form-group row">
                                                        <label for="update_other_asset_capacity" class="col-sm-4 col-form-label">Capacity</label>
                                                        <div class="col-sm-8">
                                                          <input type="text" class="form-control" id="update_other_asset_capacity" name="update_other_asset_capacity" value="{{$other_asset->other_asset_capacity}}" required>
                                                        </div>
                                                      </div>
    
                                                        <button class="btn btn-danger pull-right" style="background-color: red" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-success pull-right mr-2" style="background-color: green">Update Asset</button>
    
                                                </form>
                                            
                                            </div>
                                            
                                        </div>
                                    
                                        </div>
                                    </div>


                                     <!--Return other asset Modal -->
                                     <div id="return_other_asset_modal{{$other_asset->id}}" class="modal fade" role="dialog">
                                        <div class="modal-dialog">
                                    
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Other asset return</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            
                                            </div>
                                            <div class="modal-body">
    
                                                <form action="{{route('return_other_asset')}}" method="POST">
                                                    @csrf
                                                      <div class="form-group row">
                                                        <label for="other_asset_retun_reason" class="col-sm-4 col-form-label">Return reason</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control" id="other_asset_retun_reason" name="other_asset_retun_reason" required>
                                                                <option value="">Select Reason</option>
                                                                <option value="Employee resign">Employee resign</option>
                                                                <option value="Replacement">Replacement</option>
                                                                <option value="Damage">Damage</option>
                                                                <option value="Device loss">Device loss</option>
                                                                <option value="Other">Other</option>
                                                              </select>
                                                        </div>
                                                      </div>

                                                      <div class="form-group row" id="other_asset_remark_div">
                                                        <label for="other_asset_return_other_remark" class="col-sm-4 col-form-label">Remark</label>
                                                        <div class="col-sm-8">
                                                          <textarea type="number" class="form-control" id="other_asset_return_other_remark" name="other_asset_return_other_remark"></textarea>
                                                          <input type="hidden" class="form-control" id="other_asset_return_id" name="other_asset_return_id" value="{{$other_asset->id}}" required>
                                                        </div>
                                                      </div>

                                                      <div class="form-group row">
                                                        <label for="other_asset_return_condition" class="col-sm-4 col-form-label">Asset condition</label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control" id="other_asset_return_condition" name="other_asset_return_condition" required>
                                                                <option value="">Select Condition</option>
                                                                <option value="Good">Good</option>
                                                                <option value="Medium">Medium</option>
                                                                <option value="Poor">Poor</option>
                                                                <option value="None">None</option>
                                                              </select>
                                                        </div>
                                                      </div>
                                                     
    
                                                        <button class="btn btn-danger pull-right" style="background-color: red" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-success pull-right mr-2" style="background-color: green">Return Asset</button>
    
                                                </form>
                                            
                                            </div>
                                            
                                        </div>
                                    
                                        </div>
                                    </div>
    

                                @endforeach
                                
                            </tbody>
                        </tbody>
                    </table>


                    @endif



                </div>
            </div>


            @if (count($find_dongle_details) == 0)
                
            @else
           
            <div class="card mt-4">
                <div class="card-body">
                    <p style="color: red"><i class="fa fa-list-alt" aria-hidden="true"></i> &nbsp; Dongle Details</p>
                    <button class="btn btn-warning btn-sm pull-right mb-2" style="background-color: orange" data-toggle="modal" data-target="#add_dongle_modal{{$token_id}}"><i class="fa fa-plus-circle"></i></button>

                    <table id="asset_data_table" class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="text-align: center">Dongle Type</th>
                                <th style="text-align: center">Connection Type</th>
                                <th style="text-align: center">Connection No</th>
                                <th style="text-align: center">SIM No</th>
                                <th style="text-align: center">IP Address</th>
                                <th style="text-align: center">Dongle Modal</th>
                                <th style="text-align: center">Dongle IMEI</th>
                                <th style="text-align: center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tbody>
                                @foreach ($find_dongle_details as $dongle)
                                <tr>
                                    <td>{{$dongle->dongle_asset_type}}</td>
                                    <td>{{$dongle->dongle_connection_type}}</td>
                                    <td>{{$dongle->dongle_connection_no}}</td>
                                    <td>{{$dongle->dongle_sim_no}}</td>
                                    <td>{{$dongle->dongle_ip_address}}</td>
                                    <td>{{$dongle->dongle_modal}}</td>
                                    <td>{{$dongle->dongle_imei_no}}</td>
                                    <td>
                                        <center>
                                            <button class="btn btn-success" style="background-color: green" data-toggle="modal" data-target="#edit_dongle_modal{{$dongle->id}}">Edit</button>
                                            <button class="btn btn-danger mt-2" style="background-color: red" data-toggle="modal" data-target="#return_dongle_modal{{$dongle->id}}">Return</button>
                                        </center>
                                    </td>
                                </tr>


                                 <!--Edit Modal -->
                                 <div id="edit_dongle_modal{{$dongle->id}}" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Update Dongle Details</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        
                                        </div>
                                        <div class="modal-body">

                                            <form action="{{route('update_dongle_user_data')}}" method="POST">
                                                @csrf
                                                <div class="form-group row">
                                                    <label for="update_dongle_type" class="col-sm-4 col-form-label">Dongle Type</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="update_dongle_type" name="update_dongle_type" required>
                                                            <option value="{{$dongle->dongle_asset_type}}">{{$dongle->dongle_asset_type}}</option>
                                                            <option value="Dongle">Dongle</option>
                                                            <option value="Wingle">Wingle</option>
                                                            <option value="Pocket WIFI">Pocket WIFI</option>
                                                            <option value="Router">Router</option>
                                                            <option value="TAB">TAB</option>
                                                          </select>
                                                    </div>
                                                  </div>
                                                
                                                  <div class="form-group row">
                                                    <label for="update_connection_type" class="col-sm-4 col-form-label">Connection Type</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="update_connection_type" name="update_connection_type" required>
                                                            <option value="{{$dongle->dongle_connection_type}}">{{$dongle->dongle_connection_type}}</option>
                                                            <option value="Dialog">Dialog</option>
                                                            <option value="Mobitel">Mobitel</option>
                                                          </select>
                                                      <input type="hidden" class="form-control" id="dongle_id" name="dongle_id" value="{{$dongle->id}}" required>
                                                    </div>
                                                  </div>

                                                  <div class="form-group row">
                                                    <label for="update_connection_number" class="col-sm-4 col-form-label">Connection No</label>
                                                    <div class="col-sm-8">
                                                      <input type="text" class="form-control" id="update_connection_number" name="update_connection_number" value="{{$dongle->dongle_connection_no}}" required>
                                                    </div>
                                                  </div>

                                                  <div class="form-group row">
                                                    <label for="update_sim_number" class="col-sm-4 col-form-label">Dongle SIM Number</label>
                                                    <div class="col-sm-8">
                                                      <input type="text" class="form-control" id="update_sim_number" name="update_sim_number" value="{{$dongle->dongle_sim_no}}" required>
                                                    </div>
                                                  </div>

                                                  <div class="form-group row">
                                                    <label for="update_ip_address" class="col-sm-4 col-form-label">Dongle IP Address</label>
                                                    <div class="col-sm-8">
                                                      <input type="text" class="form-control" id="update_ip_address" name="update_ip_address" value="{{$dongle->dongle_ip_address}}" required>
                                                    </div>
                                                  </div>

                                                  <div class="form-group row">
                                                    <label for="update_dongle_modal" class="col-sm-4 col-form-label">Dongle Modal</label>
                                                    <div class="col-sm-8">
                                                      <input type="text" class="form-control" id="update_dongle_modal" name="update_dongle_modal" value="{{$dongle->dongle_modal}}" required>
                                                    </div>
                                                  </div>

                                                  <div class="form-group row">
                                                    <label for="update_dongle_imei_no" class="col-sm-4 col-form-label">Dongle IMEI Number</label>
                                                    <div class="col-sm-8">
                                                      <input type="text" class="form-control" id="update_dongle_imei_no" name="update_dongle_imei_no" value="{{$dongle->dongle_imei_no}}" required>
                                                    </div>
                                                  </div>

                                                    <button class="btn btn-danger pull-right" style="background-color: red" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-success pull-right mr-2" style="background-color: green">Update Dongle</button>

                                            </form>
                                        
                                        </div>
                                        
                                    </div>
                                
                                    </div>
                                </div>



                                <!--Return dongle Modal -->
                                <div id="return_dongle_modal{{$dongle->id}}" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Other asset return</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        
                                        </div>
                                        <div class="modal-body">

                                            <form action="{{route('return_dongle')}}" method="POST">
                                                @csrf
                                                <div class="form-group row">
                                                    <label for="dongle_retun_reason" class="col-sm-4 col-form-label">Return reason</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="dongle_retun_reason" name="dongle_retun_reason" required>
                                                            <option value="">Select Reason</option>
                                                            <option value="Employee resign">Employee resign</option>
                                                            <option value="Replacement">Dongle Change</option>
                                                            <option value="Damage">Damage</option>
                                                            <option value="Device loss">Device loss</option>
                                                            <option value="Other">Other</option>
                                                          </select>
                                                    </div>
                                                  </div>
                                                <div class="form-group row" id="dongle_remark_div">
                                                    <label for="dongle_return_other_remark" class="col-sm-4 col-form-label">Remark</label>
                                                    <div class="col-sm-8">
                                                      <textarea type="number" class="form-control" id="dongle_return_other_remark" name="dongle_return_other_remark"></textarea>
                                                      <input type="hidden" class="form-control" id="dongle_return_id" name="dongle_return_id" value="{{$dongle->id}}" required>
                                                    </div>
                                                  </div>

                                                  <div class="form-group row">
                                                    <label for="dongle_return_condition" class="col-sm-4 col-form-label">Dongle condition</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="dongle_return_condition" name="dongle_return_condition" required>
                                                            <option value="">Select Condition</option>
                                                            <option value="Good">Good</option>
                                                            <option value="Medium">Medium</option>
                                                            <option value="Poor">Poor</option>
                                                            <option value="None">None</option>
                                                          </select>
                                                    </div>
                                                  </div>
                                                 

                                                    <button class="btn btn-danger pull-right" style="background-color: red" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-success pull-right mr-2" style="background-color: green">Return Dongle</button>

                                            </form>
                                        
                                        </div>
                                        
                                    </div>
                                
                                    </div>
                                </div>


                                @endforeach
                                
                            </tbody>
                        </tbody>
                    </table>






                </div>
            </div>

                 
            @endif



        </div>
    </div>
</div>

<input type="hidden" name="main_asset_count" id="main_asset_count" value="{{count($find_asset_details)}}">
<input type="hidden" name="other_asset_count" id="other_asset_count" value="{{count($find_asset_other_details)}}">
<input type="hidden" name="dongle_count" id="dongle_count" value="{{count($find_dongle_details)}}">

@include('asset.modals.asset_add_modal')
@include('asset.modals.user_modal')

<script>
    $('#deactivate_btn').click(function () 
    {
        var main_asset_count = $('#main_asset_count').val();
        var other_asset_count = $('#other_asset_count').val();
        var dongle_count = $('#dongle_count').val();

        if (main_asset_count > 0 || other_asset_count > 0 || dongle_count > 0) 
        {
            $.bootstrapGrowl('<b><i> <span class = "glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;&nbsp;Warning &nbsp;!&nbsp;Please remove allocated assets..!</i></b>',
                {
                type: 'danger',
                width: 500,
                delay: 10000,
                });
                $(window).scrollTop(0);    
        }
        else
        {
            $('#deactivate_account_modal').modal('show');
        }

    });
</script>


@endsection