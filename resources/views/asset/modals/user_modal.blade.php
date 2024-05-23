<!-- Modal -->
<div id="edit_account_modal{{$token_id}}" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
  
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Update User Details</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body">

                        <form action="{{url('emp_update_details')}}" method="POST">
                            @csrf
                            <div class="form-group row">
                              <label for="epfno_val" class="col-sm-4 col-form-label">EPF No</label>
                              <div class="col-sm-8">
                                <input type="text" class="form-control" id="epfno_val" name="epfno_val" placeholder="" value="{{$asset_user_tbls->epf_no}}" required>
                                <input type="hidden" class="form-control" id="emp_id" name="emp_id" placeholder="" value="{{$asset_user_tbls->id}}" required>
                              </div>
                            </div>
                            <div class="form-group row">
                                <label for="fname" class="col-sm-4 col-form-label">Full Name</label>
                                <div class="col-sm-8">
                                  <input type="text" class="form-control" id="fname" name="fname" value="{{$asset_user_tbls->full_name}}" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="emp_type" class="col-sm-4 col-form-label">Employee Type</label>
                                <div class="col-sm-8">
                                  <select id="emp_type" class="form-control" name="emp_type" required>
                                    <option value="{{$asset_user_tbls->emplyee_type}}">{{$asset_user_tbls->emplyee_type}} Employee</option>
                                    <option value="">Select Employee Type</option>
                                    <option value="Permanent">Permanent Employee</option>
                                    <option value="Casual">Outsourced Employee</option>
                                    <option value="Other">Other Employee</option>
                            </select>
                                
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="company" class="col-sm-4 col-form-label">Company</label>
                                <div class="col-sm-8">
                                  <select id="company" class="form-control" name="company" required>
                                    <option value="{{$company}}">{{$company}}</option>
                                    <option value="">Select Company</option>
                                    <option value="HNBA">HNBA</option>
                                    <option value="HNBGI">HNBGI</option>
                                </select>
                                
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="NIC" class="col-sm-4 col-form-label">NIC No</label>
                                <div class="col-sm-8">
                                  <input type="text" class="form-control" id="NIC" name="NIC" value="{{$asset_user_tbls->nic_no}}" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="designation" class="col-sm-4 col-form-label">Designation</label>
                                <div class="col-sm-8">
                                  <input type="text" class="form-control" id="designation" name="designation" value="{{$asset_user_tbls->designation}}" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="location" class="col-sm-4 col-form-label">Location</label>
                                <div class="col-sm-8">
                                  <input type="text" class="form-control" id="location" name="location" value="{{$asset_user_tbls->location}}" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-sm-4 col-form-label">Email</label>
                                <div class="col-sm-8">
                                  <input type="email" class="form-control" id="email" name="email" value="{{$asset_user_tbls->email}}" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="contact_no" class="col-sm-4 col-form-label">Contact No</label>
                                <div class="col-sm-8">
                                  <input type="number" class="form-control" id="contact_no" name="contact_no" value="{{$asset_user_tbls->contact_no}}" required>
                                </div>
                            </div>
                            
                           <center>
                            <button type="submit" class="btn btn-success" style="background-color: green;">Update User</button>
                           </center>
                          </form>


        </div>
       
      </div>
  
    </div>
  </div>





  <!-- Modal -->
<div id="followup_modal{{$token_id}}" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl">
  
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Followup Details</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body">


        <b><p class="text-danger">Main Asset Details</p></b>
 
        <table id="user_followup_asset_data_table" class="table table-bordered">
            <thead>
                <tr>
                  <th style="text-align: center">Date</th>
                  <th style="text-align: center">Asset Type</th>
                  <th style="text-align: center">Asset Model</th>
                  <th style="text-align: center">Serial Number</th>
                  <th style="text-align: center">Other Asset Modal</th>
                  <th style="text-align: center">Reason</th>
                  <th style="text-align: center">Status</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($user_followup as $user_follow)
              <tr>
              
                  <td>{{$user_follow->updated_at}}</td>
                  <td>{{$user_follow->asset_type}}</td>
                  <td>{{$user_follow->asset_no}}</td>
                  <td>{{$user_follow->serial_no}}</td>
                  <td>{{$user_follow->other_asset_model}}</td>
                  <td>{{$user_follow->reason}}</td>
                  <td>{{$user_follow->status}}</td>
                
              </tr>
              @endforeach
            </tbody>
        </table>
      <br>

            <b><p class="text-danger">Dongle Details</p></b>
      
        <table id="dongle_followup_asset_data_table" class="table table-bordered">
            <thead>
                <tr>
                  <th style="text-align: center">Date</th>
                  <th style="text-align: center">Connection Number</th>
                  <th style="text-align: center">SIM Number</th>
                  <th style="text-align: center">IP Address</th>
                  <th style="text-align: center">IMEI No</th>
                  <th style="text-align: center">Reason</th>
                  <th style="text-align: center">Status</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($dongle_followup as $dongle_follow)
              <tr>
              
                  <td>{{$dongle_follow->updated_at}}</td>
                  <td>{{$dongle_follow->connection_number}}</td>
                  <td>{{$dongle_follow->sim_number}}</td>
                  <td>{{$dongle_follow->ip_address}}</td>
                  <td>{{$dongle_follow->dongle_imei_no}}</td>
                  <td>{{$dongle_follow->reason}}</td>
                  <td>{{$dongle_follow->status}}</td>
                
              </tr>
              @endforeach
            </tbody>
        </table>

        </div>
       
      </div>
  
    </div>
  </div>