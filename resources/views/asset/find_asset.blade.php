@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Find User Asset Details') }}</div>

                <div class="card-body">
                    
                    <form class="form-inline col-36" id="findform">
       
                        <div class="form-group mb-2" style="width:100%;">
                          <label for="findepf_no" class="col-2 form-label">EPF No </label>
                          <input type="text" id="findepf_no" class="form-control col-sm-3" aria-describedby="findepf_no" name="findepf_no">
                          
                          
                         <label for="find_name" class="col-2 form-label">User Name</label>
                         <input type="text" id="find_name" class="form-control col-sm-3" aria-describedby="find_name" name="find_name">
                        
                        </div>
                      
                          
                        <div class="form-group mt-2" style="width:100%;">
                        
                          <label for="find_company" class="col-2 form-label">Company</label>
                          <select class="form-control col-sm-3" name="find_company" id="find_company">
                                   <option value="">Select Company</option>
                                   <option value="HNBA">HNB Assurance PLC</option>
                                   <option value="HNBGI">HNB General Insurance Ltd.</option>
                              
                         
                          </select>
                          
                          <label for="find_status" class="col-2 form-label">Status</label>
                          <select class="form-control col-sm-3" name="find_status" id="find_status">
                                   <option value="">Select Status</option>
                                   <option value="1">Active</option>
                                   <option value="0">Deactive</option>
                              
                         
                          </select>
                         
                          <button type="button" class="btn btn-primary mt-3 col-2" id="find_btn" style="margin-left: 550px;background-color: #011842;color: white"><i class="fa fa-search"></i>&nbsp;&nbsp;Search</button>
                          <button type="reset" class="btn btn-warning mt-3 ml-3 col-2" style="background-color: orange"><i class="fa fa-eraser"></i>&nbsp;&nbsp;Reset</button>
                        
                      
                        </div>
                      
                      </form>



                </div>
            </div>



            <div class="card mt-3" id="find_details_card">
                <div class="card-body">
            <p>Find Details</p>
            
            
            <table id="find_asset_user_details_table" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th width="10%">EPF No</th>
                            <th width="20%">Full Name</th>
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
        let findform = $('#findform').serialize();

        $.ajax({
           type:'GET',
           headers: {
            'X-CSRF-Token': '{{ csrf_token() }}',
        },
           url:'{{url("/find_asset_details")}}',
           data:findform,
           success:function(jsonData){
              
                $("#find_asset_user_details_table").dataTable().fnDestroy();
            var myDataTable =  $('#find_asset_user_details_table').DataTable({
                data  :  jsonData.data,
                columns : 
                [
                { data : "user_epf_no" },
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
                { data : "id" , render : function (data, type, row, meta, rowData) 
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