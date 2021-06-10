<!--Add Modal -->
<div id="add_asset_modal{{$token_id}}" class="modal fade" role="dialog">
    <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Add Asset</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
        </div>
        <div class="modal-body">
       
            <form action="{{route('add_asset_data')}}" method="POST">
                @csrf
                <div class="form-group row">
                    <label for="add_asset_type" class="col-sm-4 col-form-label">Asset Type</label>
                    <div class="col-sm-8">
                        <select class="form-control" id="add_asset_type" name="add_asset_type" required>
                            <option value="">Select asset type</option>
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
                    <label for="add_asset_no" class="col-sm-4 col-form-label">Asset No</label>
                    <div class="col-sm-8">
                      <input type="number" class="form-control" id="add_asset_no" name="add_asset_no" required>
                      <input type="hidden" class="form-control" id="add_asset_token_id" name="add_asset_token_id" value="{{$token_id}}" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="add_serialno" class="col-sm-4 col-form-label">Serial No</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="add_serialno" name="add_serialno" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="add_asset_modal" class="col-sm-4 col-form-label">Asset Modal</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="add_asset_modal" name="add_asset_modal" required>
                    </div>
                  </div>

                    <button class="btn btn-danger pull-right" style="background-color: red" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning pull-right mr-2" style="background-color: orange">Add Asset</button>

            </form>

        </div>
      
    </div>

    </div>
</div>



   <!--add dongle Modal -->
   <div id="add_dongle_modal{{$token_id}}" class="modal fade" role="dialog">
    <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Add Dongle Details</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
        </div>
        <div class="modal-body">

            <form action="{{route('add_dongle_user_data')}}" method="POST">
                @csrf
                <div class="form-group row">
                    <label for="add_dongle_type" class="col-sm-4 col-form-label">Dongle Type</label>
                    <div class="col-sm-8">
                        <select class="form-control" id="add_dongle_type" name="add_dongle_type" required>
                            <option value="">Select dongle type</option>
                            <option value="Dongle">Dongle</option>
                            <option value="Wingle">Wingle</option>
                            <option value="Pocket WIFI">Pocket WIFI</option>
                            <option value="Router">Router</option>
                            <option value="TAB">TAB</option>
                          </select>
                    </div>
                  </div>
                
                  <div class="form-group row">
                    <label for="add_connection_type" class="col-sm-4 col-form-label">Connection Type</label>
                    <div class="col-sm-8">
                        <select class="form-control" id="add_connection_type" name="add_connection_type" required>
                            <option value="">Select connection type</option>
                            <option value="Dialog">Dialog</option>
                            <option value="Mobitel">Mobitel</option>
                          </select>
                      <input type="hidden" class="form-control" id="user_dongle_veri_token_id" name="user_dongle_veri_token_id" value="{{$token_id}}" required>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="add_connection_number" class="col-sm-4 col-form-label">Connection No</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="add_connection_number" name="add_connection_number" required>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="add_sim_number" class="col-sm-4 col-form-label">Dongle SIM Number</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="add_sim_number" name="add_sim_number" required>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="add_ip_address" class="col-sm-4 col-form-label">Dongle IP Address</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="add_ip_address" name="add_ip_address" required>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="add_dongle_modal" class="col-sm-4 col-form-label">Dongle Modal</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="add_dongle_modal" name="add_dongle_modal" required>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="add_dongle_imei_no" class="col-sm-4 col-form-label">Dongle IMEI Number</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="add_dongle_imei_no" name="add_dongle_imei_no" required>
                    </div>
                  </div>

                    <button class="btn btn-danger pull-right" style="background-color: red" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success pull-right mr-2" style="background-color: green">Add Dongle</button>

            </form>
        
        </div>
        
    </div>

    </div>
</div>



 <!--Add other asset Modal -->
 <div id="add_other_asset_modal{{$token_id}}" class="modal fade" role="dialog">
    <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Add Other Asset</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
        </div>
        <div class="modal-body">
       
            <form action="{{route('add_other_asset_data')}}" method="POST">
                @csrf
                <div class="form-group row">
                    <label for="add_other_asset_type" class="col-sm-4 col-form-label">Asset Type</label>
                    <div class="col-sm-8">
                        <select class="form-control" id="add_other_asset_type" name="add_other_asset_type" required>
                            <option value="">Select asset type</option>
                            <option value="Pen Drive">Pen Drive</option>
                            <option value="External Hard Drive">External Hard Drive</option>
                          </select>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="add_other_asset_modal" class="col-sm-4 col-form-label">Asset Modal</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="add_other_asset_modal" name="add_other_asset_modal"  required>
                      <input type="hidden" class="form-control" id="add_other_asset_id" name="add_other_asset_id" value="{{$token_id}}" required>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="add_other_asset_capacity" class="col-sm-4 col-form-label">Capacity</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="add_other_asset_capacity" name="add_other_asset_capacity" required>
                    </div>
                  </div>

                    <button class="btn btn-danger pull-right" style="background-color: red" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning pull-right mr-2" style="background-color: orange">Add Other Asset</button>

            </form>

        </div>
      
    </div>

    </div>
</div>



 <!--Deactivate account Modal -->
 <div id="deactivate_account_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Deactivate Account</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
        </div>
        <div class="modal-body">

            <form action="{{route('deactivate_user_account')}}" method="POST">
                @csrf
                <div class="form-group row">
                    <label for="deactivate_reason" class="col-sm-4 col-form-label">Deactivate reason</label>
                    <div class="col-sm-8">
                        <select class="form-control" id="deactivate_reason" name="deactivate_reason" required>
                            <option value="">Select Reason</option>
                            <option value="Employee resign">Employee resign</option>
                            <option value="Other">Other</option>
                          </select>
                    </div>
                  </div>
                <div class="form-group row" id="deactivate_remark_div">
                    <label for="deactivate_remark" class="col-sm-4 col-form-label">Remark</label>
                    <div class="col-sm-8">
                      <textarea type="number" class="form-control" id="deactivate_remark" name="deactivate_remark"></textarea>
                      <input type="hidden" class="form-control" id="deactivate_id" name="deactivate_id" value="{{$token_id}}" required>
                    </div>
                  </div>       

                    <button class="btn btn-danger pull-right" style="background-color: red" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success pull-right mr-2" style="background-color: green">Deactivate</button>

            </form>
        
        </div>
        
    </div>

    </div>
</div>



<!-- Modal -->
<div id="activate_account_modal{{$token_id}}" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Activate account</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form action="{{route('activate_account')}}" method="POST">
          @csrf
          <p>Are you sure do you want to activate this account ?</p>
        
        <input type="hidden" name="activate_token_id" id="activate_token_id" value="{{$token_id}}">

        <button class="btn btn-danger pull-right" style="background-color: red">No, Don't Activate</button>
        <button type="submit" class="btn btn-success pull-right mr-2" style="background-color: green">Yes, Activate</button>
        </form>
      </div>

    </div>

  </div>
</div>



 <!--edit user account Modal -->
 <div id="edit_account_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

  <!-- Modal content-->
  <div class="modal-content">
      <div class="modal-header">
          <h4 class="modal-title">Edit User Details</h4>
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      
      </div>
      <div class="modal-body">

          <form action="{{route('deactivate_user_account')}}" method="POST">
              @csrf
              <div class="form-group row">
                  <label for="deactivate_reason" class="col-sm-4 col-form-label">Deactivate reason</label>
                  <div class="col-sm-8">
                      <select class="form-control" id="deactivate_reason" name="deactivate_reason" required>
                          <option value="">Select Reason</option>
                          <option value="Employee resign">Employee resign</option>
                          <option value="Other">Other</option>
                        </select>
                  </div>
                </div>
              <div class="form-group row" id="deactivate_remark_div">
                  <label for="deactivate_remark" class="col-sm-4 col-form-label">Remark</label>
                  <div class="col-sm-8">
                    <textarea type="number" class="form-control" id="deactivate_remark" name="deactivate_remark"></textarea>
                    <input type="hidden" class="form-control" id="deactivate_id" name="deactivate_id" value="{{$token_id}}" required>
                  </div>
                </div>       

                  <button class="btn btn-danger pull-right" style="background-color: red" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-success pull-right mr-2" style="background-color: green">Deactivate</button>

          </form>
      
      </div>
      
  </div>

  </div>
</div>