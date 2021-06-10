@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Find Dongle Details') }}</div>

                <div class="card-body">
                    
                    <form class="form-inline col-36" id="find_asset_form">
       
                        <div class="form-group mb-2" style="width:100%;">
                          <label for="findcon_no" class="col-2 form-label">Connection No </label>
                          <input type="text" id="findcon_no" class="form-control col-sm-3" aria-describedby="findcon_no" name="findcon_no">
                          
                          
                         <label for="find_sim_no" class="col-2 form-label">SIM No</label>
                         <input type="text" id="find_sim_no" class="form-control col-sm-3" aria-describedby="find_sim_no" name="find_sim_no">
                        
                        </div>

                          
                        <div class="form-group mt-2" style="width:100%;">
                        
                            <label for="find_ip_address" class="col-2 form-label">IP Address</label>
                            <input type="text" id="find_ip_address" class="form-control col-sm-3" aria-describedby="find_ip_address" name="find_ip_address">   
                          
                            <label for="find_imei" class="col-2 form-label">IMEI No</label>
                            <input type="text" id="find_imei" class="form-control col-sm-3" aria-describedby="find_imei" name="find_imei">   
                          

                          <div class="form-group mt-3" style="width:100%;">

                            <label for="find_user" class="col-2 form-label">User Name</label>
                            <input type="text" id="find_user" class="form-control col-sm-3" aria-describedby="find_user" name="find_user">   
                          

                            <label for="find_asset_type" class="col-2 form-label">Dongle Type</label>
                                <select class="form-control col-sm-3" name="find_asset_type" id="find_asset_type">
                                    <option value="">Select dongle type</option>
                                    <option value="Dongle">Dongle</option>
                                    <option value="Wingle">Wingle</option>
                                    <option value="Pocket WIFI">Pocket WIFI</option>
                                    <option value="Router">Router</option>
                                    <option value="TAB">TAB</option>
                                </select>

                            

                            <div class="form-group mt-3" style="width:100%;">
                                <label for="find_asset_status" class="col-2 form-label">Status</label>
                                <select class="form-control col-sm-3" name="find_asset_status" id="find_asset_status">
                                   <option value="">Select Status</option>
                                   <option value="1">Active</option>
                                   <option value="0">Deactive</option>
                                </select>

                            </div>
                            </div>
                         
                          <button type="button" class="btn btn-primary mt-3 col-2" id="find_btn" style="margin-left: 550px;background-color: #011842;color: white"><i class="fa fa-search"></i>&nbsp;&nbsp;Search</button>
                          <button type="reset" class="btn btn-warning mt-3 ml-3 col-2" style="background-color: orange"><i class="fa fa-eraser"></i>&nbsp;&nbsp;Reset</button>
                        
                      
                        </div>

                        
                      
                      </form>



                </div>
            </div>



            <div class="card mt-3" id="find_details_card">
                <div class="card-body">
            <p>Find Details</p>
            
            
            <table id="find_dongle_details_table" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th width="15%">Dongle Type</th>
                            <th width="15%">User Name</th>
                            <th width="15%">Connection No</th>
                            <th width="20%">SIM No</th>
                            <th width="15%">IP Address</th>
                            <th width="10%">Status</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      
            
                    </tbody>
            
            </table>
            
        
                </div>
            </div>


        </div>
    </div>
</div>



<script>
    $('#find_btn').click(function () 
    {
        let findform = $('#find_asset_form').serialize();

        $.ajax({
           type:'POST',
           headers: {
            'X-CSRF-Token': '{{ csrf_token() }}',
        },
           url:'{{url("/find_dongle_data_details")}}',
           data:findform,
           success:function(jsonData){
                console.log(jsonData.data)

                $("#find_dongle_details_table").dataTable().fnDestroy();
            var myDataTable =  $('#find_dongle_details_table').DataTable({
                data  :  jsonData.data,
                columns : 
                [
                { data : "dongle_asset_type" },  
                { data : "user_name" },  
                { data : "dongle_connection_no" },
                { data : "dongle_sim_no" },
                { data : "dongle_ip_address" },
                { data : "status", render : function (data, type, row, meta, rowData)
                {
                    if (row.status == "0") 
                      {
                        return "Deactive";
                      } 
                      else 
                      {
                        return "Active";
                      }
                }},
                { data : "AssetID" , render : function (data, type, row, meta, rowData) 
                {
                        return "<center><a href='{{url('view_user')}}/"+row.id+"'><button onclick=view('"+row.id+"'); class='btn btn-primary btn-sm btn_style' style='background-color:#011842;'><i class='fa fa-file'></i>&nbsp;&nbsp;View</button></a></center>"

                }},

                ],
           
    });

          }
          
        });  
    });

    
</script>

@endsection