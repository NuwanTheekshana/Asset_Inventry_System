@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form id="find_asset_form">
            <div class="card">
                <div class="card-header">{{ __('Asset Details') }}
                    <button type="button" class="btn btn-success btn-sm pull-right" style="background-color: green" data-toggle="modal" data-target="#Peripheral_followup_modal">Peripheral Follow-up</button>
                </div>

                <div class="card-body">
                        <div class="form-inline col-36">
                       
                            <div class="form-group mb-2" style="width:100%;">

                                <label for="add_Peripheral_type_val" class="col-2 form-label">Peripheral Type</label>
                                <select class="form-control col-sm-3" name="add_Peripheral_type_val" id="add_Peripheral_type_val">
                                         <option value="{{$unallocated_Peripheral->peripheral_type_id}}">{{$unallocated_Peripheral->peripheral_type}}</option>
                                         @foreach ($peripherals_type as $peripherals)
                                            <option value="{{$peripherals->id}}">{{$peripherals->peripheral_type}}</option> 
                                            @endforeach                            
                                </select>

                                <label for="add_serial_no" class="col-2 form-label">Serial Number</label>
                            <input type="text" id="add_serial_no" class="form-control col-sm-3" aria-describedby="add_serial_no" name="add_serial_no" value="{{$unallocated_Peripheral_Serials->serial_number}}" readonly>
                            <input type="text" id="add_serial_no_id" class="form-control col-sm-3" aria-describedby="add_serial_no_id" name="add_serial_no_id" value="{{$unallocated_Peripheral_Serials->id}}" readonly>
                         
                            </div>
    
                              
                            <div class="form-group mt-2" style="width:100%;">
                                
                                <label for="add_unallocate_unit_price" class="col-2 form-label">Unit Price </label>
                                 <input type="number" id="add_unallocate_unit_price" class="form-control col-sm-3" aria-describedby="add_unallocate_unit_price" name="add_unallocate_unit_price" value="{{$unallocated_Peripheral->unit_price}}">

                                <label for="add_unallocate_supplier" class="col-2 form-label">Supplier</label>
                                <input type="text" id="add_unallocate_supplier" class="form-control col-sm-3" aria-describedby="add_unallocate_supplier" name="add_unallocate_supplier" value="{{$unallocated_Peripheral->supplier_name}}">
                                <input type="hidden" id="add_unallocate_Peripheral_id" class="form-control col-sm-3" aria-describedby="add_unallocate_Peripheral_id" name="add_unallocate_Peripheral_id" value="{{$unallocated_Peripheral->id}}">
                                    
                            </div>

                            <div class="form-group mt-3" style="width:100%;">
                                        
                                <label for="add_unallocate_ponumber" class="col-2 form-label">PO Number </label>
                                <input type="text" id="add_unallocate_ponumber" class="form-control col-sm-3" aria-describedby="add_unallocate_ponumber" name="add_unallocate_ponumber" value="{{$unallocated_Peripheral->po_number}}">
                         
                                <label for="add_unallocate_received_date" class="col-2 form-label">Received date</label>
                                <input type="date" id="add_unallocate_received_date" class="form-control col-sm-3" aria-describedby="add_unallocate_received_date" name="add_unallocate_received_date" value="{{$unallocated_Peripheral->received_date}}">

                            </div>

                            <div class="form-group mt-2" style="width:100%;">
                                
                                <label for="unallocated_peripherals_condition" class="col-2 form-label">peripherals Condition</label>
                                <select class="form-control col-sm-3" id="unallocated_peripherals_condition" name="unallocated_peripherals_condition" value="{{$unallocated_Peripheral->pheripherals_condition}}">
                                    <option value="{{$unallocated_Peripheral->pheripherals_condition}}">{{$unallocated_Peripheral->pheripherals_condition}}</option>
                                    <option value="Good">New</option>
                                    <option value="Medium">Used</option>
                                </select>

        
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
<div id="Peripheral_followup_modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
  
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Peripheral Follow-up</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body">
         
            <div class="card mt-3" id="find_details_card">
                <div class="card-body">
                    <table id="find_asset_details_table" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th width="15%">Peripheral Type</th>
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
           var status = confirm("Do you want to allocate this Peripheral ?");
           var Peripheral_id = $('#add_unallocate_Peripheral_id').val();
           var serialnumber_id = $('#add_serial_no_id').val();
           var Peripheral_type = $('#add_Peripheral_type_val').val();
           var serial_number = $('#add_serial_no').val();
           var unit_price = $('#add_unallocate_unit_price').val();
           var Supplier = $('#add_unallocate_supplier').val();
           var ponumber = $('#add_unallocate_ponumber').val();
           var received_date = $('#add_unallocate_received_date').val();
           var peripherals_condition = $('#unallocated_peripherals_condition').val();

            if (Peripheral_type == "") 
            {
                $.bootstrapGrowl('<b><i> <span class = "glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;&nbsp;Warning &nbsp;!&nbsp;Peripheral type is required..!</i></b>',
                {type: 'danger',width: 500,delay: 10000,});$(window).scrollTop(0);  
            }
            if (serial_number == "") 
            {
                $.bootstrapGrowl('<b><i> <span class = "glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;&nbsp;Warning &nbsp;!&nbsp;Serial number is required..!</i></b>',
                {type: 'danger',width: 500,delay: 10000,});$(window).scrollTop(0);  
            }
            if (unit_price == "") 
            {
                $.bootstrapGrowl('<b><i> <span class = "glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;&nbsp;Warning &nbsp;!&nbsp;Unit price is required..!</i></b>',
                {type: 'danger',width: 500,delay: 10000,});$(window).scrollTop(0); 
            }
            if (Supplier == "") 
            {
                $.bootstrapGrowl('<b><i> <span class = "glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;&nbsp;Warning &nbsp;!&nbsp;Supplier is required..!</i></b>',
                {type: 'danger',width: 500,delay: 10000,});$(window).scrollTop(0); 
            }
            if (ponumber == "") 
            {
                $.bootstrapGrowl('<b><i> <span class = "glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;&nbsp;Warning &nbsp;!&nbsp;PO number is required..!</i></b>',
                {type: 'danger',width: 500,delay: 10000,});$(window).scrollTop(0); 
            }
            if (received_date == "") 
            {
                $.bootstrapGrowl('<b><i> <span class = "glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;&nbsp;Warning &nbsp;!&nbsp;Received date is required..!</i></b>',
                {type: 'danger',width: 500,delay: 10000,});$(window).scrollTop(0); 
            }
            if (peripherals_condition == "") 
            {
                $.bootstrapGrowl('<b><i> <span class = "glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;&nbsp;Warning &nbsp;!&nbsp;Peripheral condition is required..!</i></b>',
                {type: 'danger',width: 500,delay: 10000,});$(window).scrollTop(0); 
            }
            
            if (Peripheral_type == "" || serial_number == "" || unit_price == "" || Supplier == "" || ponumber == "" || received_date == "" || peripherals_condition == "") 
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
                url:'{{url("/allcate_Peripheral_user")}}',
                data:{user_id:user_id, Peripheral_id:Peripheral_id, Peripheral_type:Peripheral_type, connection_number:connection_number, sim_number:sim_number, ipaddress:ipaddress, Peripheral_modal:Peripheral_modal, Peripheral_imei:Peripheral_imei, connection_type:connection_type},
                success:function(data)
                {
                    if (data.success) {
                        $.bootstrapGrowl('<b><i> <span class = "glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;&nbsp;Warning &nbsp;!&nbsp;'+data.success+'</i></b>',
                        {type: 'success',width: 500,delay: 10000,});$(window).scrollTop(0); 

                        location.href = '{{url("/unallocated_peripherals")}}';
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