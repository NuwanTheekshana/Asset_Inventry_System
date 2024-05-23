@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form id="find_asset_form">
            <div class="card">
                <div class="card-header">{{ __('Asset Details') }}
                    <button type="button" class="btn btn-success btn-sm pull-right" style="background-color: green" data-toggle="modal" data-target="#dongle_followup_modal">Dongle Follow-up</button>
                </div>

                <div class="card-body">
                        <div class="form-inline col-36">
                       
                            <div class="form-group mb-2" style="width:100%;">

                                <label for="add_dongle_type_val" class="col-2 form-label">Dongle Type</label>
                                <select class="form-control col-sm-3" name="add_dongle_type_val" id="add_dongle_type_val">
                                         <option value="{{$unallocated_dongle->asset_type}}">{{$unallocated_dongle->asset_type}}</option>
                                         <option value="Dongle">Dongle</option>
                                         <option value="Wingle">Wingle</option>
                                         <option value="Pocket WIFI">Pocket WIFI</option>
                                         <option value="Router">Router</option>
                                         <option value="TAB">TAB</option>                          
                                </select>

                                <label for="add_connection_type_val" class="col-2 form-label">Connection Type</label>
                                <select class="form-control col-sm-3" name="add_connection_type_val" id="add_connection_type_val">
                                         <option value="{{$unallocated_dongle->connection_type}}">{{$unallocated_dongle->connection_type}}</option>
                                         <option value="Dialog">Dialog</option>
                                         <option value="Mobitel">Mobitel</option>                        
                                </select>
                         
                            </div>
    
                              
                            <div class="form-group mt-2" style="width:100%;">
                                
                                
                                <label for="add_unallocate_connection_no" class="col-2 form-label">Connection No </label>
                                <input type="text" id="add_unallocate_connection_no" class="form-control col-sm-3" aria-describedby="add_unallocate_connection_no" name="add_unallocate_connection_no" value="{{$unallocated_dongle->connection_number}}">
                                <input type="hidden" id="add_unallocate_dongle_id" class="form-control col-sm-3" aria-describedby="add_unallocate_dongle_id" name="add_unallocate_dongle_id" value="{{$unallocated_dongle->id}}">
                                  
                                <label for="add_unallocate_sim_no" class="col-2 form-label">SIM No</label>
                                <input type="text" id="add_unallocate_sim_no" class="form-control col-sm-3" aria-describedby="add_unallocate_sim_no" name="add_unallocate_sim_no" value="{{$unallocated_dongle->sim_no}}">
                               
                              <div class="form-group mt-3" style="width:100%;">
                                        
                              <label for="add_unallocate_ipaddress" class="col-2 form-label">IP Address </label>
                              <input type="text" id="add_unallocate_ipaddress" class="form-control col-sm-3" aria-describedby="add_unallocate_ipaddress" name="add_unallocate_ipaddress" value="{{$unallocated_dongle->ipaddress}}">
      
                                <label for="add_unallocate_dongle_modal" class="col-2 form-label">Dongle Modal</label>
                                <input type="text" id="add_unallocate_dongle_modal" class="form-control col-sm-3" aria-describedby="add_unallocate_dongle_modal" name="add_unallocate_dongle_modal" value="{{$unallocated_dongle->dongle_modal}}">

                            </div>

                            <div class="form-group mt-2" style="width:100%;">
                                <label for="add_unallocate_dongle_imei" class="col-2 form-label">Dongle IMEI No</label>
                                <input type="text" id="add_unallocate_dongle_imei" class="form-control col-sm-3" aria-describedby="add_unallocate_dongle_imei" name="add_unallocate_dongle_imei" value="{{$unallocated_dongle->dongle_imei}}">
        
                            </div>
                        
                        </div>

                    </div>    

                </div>


                <div class="card mt-4">
                    <div class="card-header">{{ __('User Details') }}</div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-2">
                              </div>
                            <div class="col">
                                <select class="form-control" name="user_company" id="user_company">
                                    <option value="">Select Comapny</option>
                                    <option value="HNBA">HNB Assurance PLC</option>
                                    <option value="HNBGI">HNB General Insurance Ltd.</option>
                                </select>
                            </div>

                            <div class="col">
                                <input type="text" class="form-control" name="user_name" id="user_name" placeholder="User Name">
                              </div>

                            <div class="col">
                              <input type="text" class="form-control" name="user_epf" id="user_epf" placeholder="EPF No">
                            </div>

                            <div class="col">
                               <button type="button" id="find_user"  class="btn btn-warning" style="background-color: orange;"><i class="fa fa-search"></i> Find</button>
                              </div>
                        </div>


                        <div class="card mt-3" id="find_user_details_card">
                            <div class="card-body">
                                <table id="find_user_details_card_table" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th width="20%">EPF No</th>
                                                <th width="40%">Full Name</th>
                                                <th width="20%">Comapny</th>
                                                <th width="20%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                
                                </table>
                        
                    
                            </div>
                        </div>



                    </div>
                </div>




            </form>


        </div>


        </div>
    </div>

<!--followup Modal -->
<div id="dongle_followup_modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
  
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Dongle Follow-up</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body">
         
            <div class="card mt-3" id="find_details_card">
                <div class="card-body">
                    <table id="find_asset_details_table" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th width="15%">Dongle Type</th>
                                    <th width="20%">Connection No</th>
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
  </div>






    <script>
        $("#find_user").click(function () 
        {
             var company = $('#user_company').val();
             var epf = $('#user_epf').val();
             var user_name = $('#user_name').val();

             if (company == "") 
             {$.bootstrapGrowl('<b><i> <span class = "glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;&nbsp;Warning &nbsp;!&nbsp;Company name is required..!</i></b>',
                {type: 'danger',width: 500,delay: 10000,});$(window).scrollTop(0);return false;  
             }

             $.ajax({
                headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
           type:'POST',
           url:'{{url("/find_emp_details")}}',
           data:{company:company, epf:epf, user_name:user_name},
           success:function(jsonData)
           {
            $("#find_user_details_card_table").dataTable().fnDestroy();
            var myDataTable =  $('#find_user_details_card_table').DataTable({
                data  :  jsonData.data,
                columns : 
                [
                { data : "epf_no" },
                { data : "full_name" },
                { data : "company" },
                { data : "id" , render : function (data, type, row, meta, rowData) 
                {
                        return "<center><button type='button' onclick=add_modal('"+row.id+"'); class='btn btn-primary btn-sm btn_style' style='background-color:#011842;'><i class='fa fa-plus'></i>&nbsp;&nbsp;Add</button></center>"
                }},

                ],
           
            });
                    
            }
       
        });


        });

        function add_modal(user_id) 
        {
           var status = confirm("Do you want to allocate this dongle ?");
           var dongle_id = $('#add_unallocate_dongle_id').val();
           var dongle_type = $('#add_dongle_type_val').val();
           var connection_type = $('#add_connection_type_val').val();
           var connection_number = $('#add_unallocate_connection_no').val();
           var sim_number = $('#add_unallocate_sim_no').val();
           var ipaddress = $('#add_unallocate_ipaddress').val();
           var dongle_modal = $('#add_unallocate_dongle_modal').val();
           var dongle_imei = $('#add_unallocate_dongle_imei').val();

            if (connection_number == "") 
            {
                $.bootstrapGrowl('<b><i> <span class = "glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;&nbsp;Warning &nbsp;!&nbsp;Connection number is required..!</i></b>',
                {type: 'danger',width: 500,delay: 10000,});$(window).scrollTop(0);  
            }
            if (connection_type == "") 
            {
                $.bootstrapGrowl('<b><i> <span class = "glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;&nbsp;Warning &nbsp;!&nbsp;Connection type is required..!</i></b>',
                {type: 'danger',width: 500,delay: 10000,});$(window).scrollTop(0);  
            }
            if (dongle_type == "") 
            {
                $.bootstrapGrowl('<b><i> <span class = "glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;&nbsp;Warning &nbsp;!&nbsp;Dongle type is required..!</i></b>',
                {type: 'danger',width: 500,delay: 10000,});$(window).scrollTop(0); 
            }
            if (sim_number == "") 
            {
                $.bootstrapGrowl('<b><i> <span class = "glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;&nbsp;Warning &nbsp;!&nbsp;SIM number is required..!</i></b>',
                {type: 'danger',width: 500,delay: 10000,});$(window).scrollTop(0); 
            }
            if (ipaddress == "") 
            {
                $.bootstrapGrowl('<b><i> <span class = "glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;&nbsp;Warning &nbsp;!&nbsp;IP address is required..!</i></b>',
                {type: 'danger',width: 500,delay: 10000,});$(window).scrollTop(0); 
            }
            if (dongle_modal == "") 
            {
                $.bootstrapGrowl('<b><i> <span class = "glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;&nbsp;Warning &nbsp;!&nbsp;Dongle modal is required..!</i></b>',
                {type: 'danger',width: 500,delay: 10000,});$(window).scrollTop(0); 
            }
            if (dongle_imei == "") 
            {
                $.bootstrapGrowl('<b><i> <span class = "glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;&nbsp;Warning &nbsp;!&nbsp;Dongle IMEI number is required..!</i></b>',
                {type: 'danger',width: 500,delay: 10000,});$(window).scrollTop(0); 
            }
            
            if (connection_number == "" || dongle_type == "" || sim_number == "" || ipaddress == "" || dongle_modal == "" || dongle_imei == "" || connection_type == "") 
            {
                return false;
            }

            if (status) 
            {
                $.ajax({
                headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
                type:'POST',
                url:'{{url("/allcate_dongle_user")}}',
                data:{user_id:user_id, dongle_id:dongle_id, dongle_type:dongle_type, connection_number:connection_number, sim_number:sim_number, ipaddress:ipaddress, dongle_modal:dongle_modal, dongle_imei:dongle_imei, connection_type:connection_type},
                success:function(data)
                {
                    if (data.success) {
                        $.bootstrapGrowl('<b><i> <span class = "glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;&nbsp;Warning &nbsp;!&nbsp;'+data.success+'</i></b>',
                        {type: 'success',width: 500,delay: 10000,});$(window).scrollTop(0); 

                        location.href = '{{url("/unallocated_dongle")}}';
                    }
                    else
                    {
                        $.bootstrapGrowl('<b><i> <span class = "glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;&nbsp;Warning &nbsp;!&nbsp;'+data.error+'</i></b>',
                        {type: 'danger',width: 500,delay: 10000,});$(window).scrollTop(0);
                    }

                }
       
            });
            }
        }
    </script>

    

@endsection