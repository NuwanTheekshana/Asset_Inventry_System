@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form id="find_asset_form">
            <div class="card">
                <div class="card-header">{{ __('Asset Details') }}
                    <button type="button" class="btn btn-success btn-sm pull-right" style="background-color: green" data-toggle="modal" data-target="#asset_followup_modal">Asset Follow-up</button>
                </div>

                <div class="card-body">
                        <div class="form-inline col-36">
                       
                        <div class="form-group mb-2" style="width:100%;">
                          <label for="findasset_no" class="col-2 form-label">Asset No </label>
                          <input type="text" id="findasset_no" class="form-control col-sm-3" aria-describedby="findasset_no" name="findasset_no" value="{{$unallocated_asset->asset_no}}">
                          <input type="hidden" id="findasset_id" class="form-control col-sm-3" aria-describedby="findasset_id" name="findasset_id" value="{{$unallocated_asset->id}}">
                          
                          <label for="find_asset_type" class="col-2 form-label">Asset Type</label>
                          <select class="form-control col-sm-3" name="find_asset_type" id="find_asset_type">
                                   <option value="{{$unallocated_asset->asset_type}}">{{$unallocated_asset->asset_type}}</option>
                                   <option value="Laptop">Laptop</option>
                                   <option value="Desktop">Desktop</option>
                                   <option value="Monitor">Monitor</option>
                                   <option value="Projector">Multimedia Projector</option>
                                   <option value="Scanner">Scanner</option>
                                   <option value="TAB">TAB</option>                                 
                          </select>
                       
                        </div>

                          
                        <div class="form-group mt-2" style="width:100%;">
                        
                            <label for="find_serial_no" class="col-2 form-label">Serial No</label>
                            <input type="text" id="find_serial_no" class="form-control col-sm-3" aria-describedby="find_serial_no" name="find_serial_no" value="{{$unallocated_asset->serial_no}}">

                            <label for="findasset_model" class="col-2 form-label">Asset Model </label>
                            <input type="text" id="findasset_model" class="form-control col-sm-3" aria-describedby="findasset_model" name="findasset_model" value="{{$unallocated_asset->asset_model}}">

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
<div id="asset_followup_modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
  
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Asset Follow-up</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body">
         
            <div class="card mt-3" id="find_details_card">
                <div class="card-body">
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
           var status = confirm("Do you want to allocate this asset ?");
           var asset_id = $('#findasset_id').val();
           var findasset_no = $('#findasset_no').val();
           var find_asset_type = $('#find_asset_type').val();
           var find_serial_no = $('#find_serial_no').val();
           var findasset_model = $('#findasset_model').val();

            if (findasset_no == "") 
            {
                $.bootstrapGrowl('<b><i> <span class = "glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;&nbsp;Warning &nbsp;!&nbsp;Asset number is required..!</i></b>',
                {type: 'danger',width: 500,delay: 10000,});$(window).scrollTop(0);  
            }
            if (find_asset_type == "") 
            {
                $.bootstrapGrowl('<b><i> <span class = "glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;&nbsp;Warning &nbsp;!&nbsp;Asset type is required..!</i></b>',
                {type: 'danger',width: 500,delay: 10000,});$(window).scrollTop(0); 
            }
            if (findasset_model == "") 
            {
                $.bootstrapGrowl('<b><i> <span class = "glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;&nbsp;Warning &nbsp;!&nbsp;Asset model is required..!</i></b>',
                {type: 'danger',width: 500,delay: 10000,});$(window).scrollTop(0); 
            }
            
            if (findasset_no == "" || find_asset_type == "" || findasset_model == "") 
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
                url:'{{url("/allcate_asset_user")}}',
                data:{user_id:user_id, asset_id:asset_id, findasset_no:findasset_no, find_asset_type:find_asset_type, find_serial_no:find_serial_no, findasset_model:findasset_model},
                success:function(data)
                {
                    // $.bootstrapGrowl('<b><i> <span class = "glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;&nbsp;Warning &nbsp;!&nbsp;'+data.success+'</i></b>',
                    // {type: 'success',width: 500,delay: 10000,});$(window).scrollTop(0);
                    location.href = '{{url("/unallocated_asset")}}';
                }
       
            });
            }
        }
    </script>

    

@endsection