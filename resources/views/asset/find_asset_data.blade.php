@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Find Asset Details') }}</div>

                <div class="card-body">
                    
                    <form class="form-inline col-36" id="find_asset_form">
       
                        <div class="form-group mb-2" style="width:100%;">
                          <label for="findasset_no" class="col-2 form-label">Asset No </label>
                          <input type="text" id="findasset_no" class="form-control col-sm-3" aria-describedby="findasset_no" name="findasset_no">
                          
                          
                         <label for="find_serial_no" class="col-2 form-label">Serial No</label>
                         <input type="text" id="find_serial_no" class="form-control col-sm-3" aria-describedby="find_serial_no" name="find_serial_no">
                        
                        </div>

                          
                        <div class="form-group mt-2" style="width:100%;">
                        
                          <label for="find_asset_type" class="col-2 form-label">Asset Type</label>
                          <select class="form-control col-sm-3" name="find_asset_type" id="find_asset_type">
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
                          
                          <label for="find_asset_status" class="col-2 form-label">Status</label>
                          <select class="form-control col-sm-3" name="find_asset_status" id="find_asset_status">
                                   <option value="">Select Status</option>
                                   <option value="1">Active</option>
                                   <option value="0">Deactive</option>
                          </select>

                          <div class="form-group mt-2" style="width:100%;">
                            <label for="findasset_model" class="col-2 form-label">Asset Model </label>
                            <input type="text" id="findasset_model" class="form-control col-sm-3" aria-describedby="findasset_model" name="findasset_model">

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
            
            
            <table id="find_asset_details_table" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th width="15%">Asset Type</th>
                            <th width="20%">Asset No</th>
                            <th width="15%">User Name</th>
                            <th width="10%">Comapny</th>
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
           url:'{{url("/find_asset_data_details")}}',
           data:findform,
           success:function(jsonData){
                console.log(jsonData.data)

                $("#find_asset_details_table").dataTable().fnDestroy();
            var myDataTable =  $('#find_asset_details_table').DataTable({
                data  :  jsonData.data,
                columns : 
                [
                { data : "asset_type" },  
                { data : "AssetNo" },
                { data : "user_name" },
                { data : "company" },
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