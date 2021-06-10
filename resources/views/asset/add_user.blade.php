@extends('layouts.app')

@section('title')
    IT Asset Verification
@endsection

<style>
    
.project-tab {
    padding: 10%;
    margin-top: -8%;
}
.project-tab #tabs{
    background: #007b5e;
    color: #eee;
}
.project-tab #tabs h6.section-title{
    color: #eee;
}
.project-tab #tabs .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
    color: #0062cc;
    background-color: transparent;
    border-color: transparent transparent #f3f3f3;
    border-bottom: 3px solid !important;
    font-size: 16px;
    font-weight: bold;
}
.project-tab .nav-link {
    border: 1px solid transparent;
    border-top-left-radius: .25rem;
    border-top-right-radius: .25rem;
    color: #0062cc;
    font-size: 16px;
    font-weight: 600;
}
.project-tab .nav-link:hover {
    border: none;
}
.project-tab thead{
    background: #f3f3f3;
    color: #333;
}
.project-tab a{
    text-decoration: none;
    color: #333;
    font-weight: 600;
}
.btn_style
{
  width: 100%;
}


</style>

@section('content')

<div class="container">

<form id="form">
    @csrf
    <center>
<div class="card mt-5 col-8" id="user_maintype_data_card">

    <div class="card-body">
        <center>

            <div class="form-group col-md-12">
                <label for="compy_type">Company</label>
                <select id="compy_type" class="form-control @error('compy_type') is-invalid @enderror" value="{{ old('compy_type') }}" name="compy_type">
                    <option value="">Select Company</option>
                    <option value="HNBA">HNB Assurance PLC</option>
                    <option value="HNBGI">HNB General Insurance Ltd.</option>
                </select>
            </div>

        <div class="form-group col-md-12">
            <label for="emp_type">Employee Type</label>
            <select id="emp_type" class="form-control @error('emp_type') is-invalid @enderror" value="{{ old('emp_type') }}" name="emp_type">
                    <option value="">Select Employee Type</option>
                    <option value="Permanent">Permanent Employee</option>
                    <option value="Casual">Outsourced Employee</option>
                    <option value="Other">Other Employee</option>
            </select>
        </div>

        {{-- <div class="form-group col-md-5" id="emp_no_div" style="display: none">
            <label for="empNo" class="text-center">Employee No</label>
            <input type="text" class="form-control" id="empNo" name="empNo" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;">
        </div> --}}

        <div class="form-group col-md-5" id="epf_no_div" style="display: none">
            <label for="epfno">EPF No</label>
            <input type="text" class="form-control text-center" id="epfno" name="epfno" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;">
        </div>
    
    <button type="button" id="nexttype_btn" class="btn btn-success" style="background-color: #011842;"><i class="fa fa-paper-plane"></i> Next</button>
    </center>


    </div>
</div>

</center>

{{-- user details --}}
    <div class="card mt-5"  id="user_data_card" style="display: none;width: 105%">

        <div class="card-body">
                
            <p style="color: red"><i class="fa fa-list-alt" aria-hidden="true"></i> &nbsp; Employee Details</p>

            <div class="form-row">


        <div class="form-group row col-6" id="epf_no_div">
            <label for="epfno_val" class="col-sm-3 col-form-label">EPF No :</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="epfno_val" name="epfno_val">
            </div>
        </div>


    <div class="form-group row col-6">
        <label for="fullname" class="col-sm-3 col-form-label">First Name :</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="fullname" name="fullname">
        </div>
    </div>


    <div class="form-group row col-6">
        <label for="NIC" class="col-sm-3 col-form-label">NIC No :</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="NIC" name="NIC">
        </div>
    </div>

    <div class="form-group row col-6">
        <label for="designation" class="col-sm-3 col-form-label">Designation :</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="designation" name="designation">
        </div>
    </div>

    <div class="form-group row col-6">
        <label for="location" class="col-sm-3 col-form-label">Location :</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="location" name="location">
        </div>
    </div>

</div>

  <div class="form-row">

    <div class="form-group row col-6">
        <label for="email" class="col-sm-3 col-form-label">Email :</label>
        <div class="col-sm-9">
            <input type="email" class="form-control" id="email" name="email">
        </div>
    </div>

    <div class="form-group row col-6">
        <label for="contact_no" class="col-sm-3 col-form-label">Contact No :</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="contact_no" name="contact_no" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;">
        </div>
    </div>
   
  </div>

<center>
    <div id="user_div_btn">
        <button type="button" id="next1" class="btn btn-success" style="background-color: #011842;"><i class="fa fa-paper-plane"></i> Next</button>
    </div>
    
</center>


        </div>
    </div>


{{-- asset details --}}

    <div class="card mt-3" id="asset_data_card" style="display: none;width: 105%">
        <div class="card-body">

            <p style="color: red"><i class="fa fa-list-alt" aria-hidden="true"></i> &nbsp; Asset Items Details</p>

<div id="asset_group">

   <div class="form-group row">
    <div class="col-sm-1"></div>
    <div class="col-sm-2">
        <select class="form-control" id="asset_type" name="asset_type">
            <option value="">Asset Type</option>
            <option value="Laptop">Laptop</option>
            <option value="Desktop">Desktop</option>
            <option value="Monitor">Monitor</option>
            <option value="Projector">Multimedia Projector</option>
			<option value="Scanner">Scanner</option>
            <option value="TAB">TAB</option>
            <option value="Pen Drive">Pen Drive</option>
            <option value="External Hard Drive">External Hard Drive</option>
          </select>
    </div>

        <div class="col-sm-2" id="asset_no_div">
            <input type="text" class="form-control" id="asset_no" aria-describedby="asset_no" placeholder="Asset No" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;">
        </div>
    
        <div class="col-sm-2" id="serial_no_div">
            <input type="text" class="form-control" id="serialno" aria-describedby="serialno" placeholder="Serial No">
        </div>

        <div class="col-sm-2" id="dev_modal_div">
            <input type="text" class="form-control" id="dev_modal" aria-describedby="dev_modal" placeholder="Device Modal">
        </div>




        <div class="col-sm-2" id="pen_model_div" style="display: none">
            <input type="text" class="form-control" id="pen_model" aria-describedby="pen_model" placeholder="Model" >
        </div>
    
        <div class="col-sm-3" id="pen_storage_div" style="display: none">
            <input type="text" class="form-control" id="pen_storage" aria-describedby="pen_storage" placeholder="Capacity">
        </div>

   

    <div class="form-check col-2" id="not_mention_div">
        <input class="form-check-input" type="checkbox" id="notmention">
        <label class="form-check-label" for="notmention">
          Cannot Found
        </label>
    </div>

        <button type="button" class="btn btn-danger mb-4" id="add_item" style="background-color: red"><i class="fa fa-plus-circle"></i> </button>
        <button type="button" class="btn btn-danger mb-4" id="add_item_other" style="background-color: red;display: none"><i class="fa fa-plus-circle"></i> </button>

    </div>
</div>

    <center>
           
   {{-- table values --}}
   <div id="table_div" style="display: none;width: 75%">

    <table id="asset_data_table" class="table table-bordered">
        <thead>
            <tr>
                <th style="text-align: center">Asset Type</th>
                <th style="text-align: center">Asset Number</th>
                <th style="text-align: center">Serial Number</th>
                <th style="text-align: center">Device Modal</th>
                <th style="text-align: center">Action</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>



   </div>
    </center>

    <center>
           
        {{-- table values --}}
        <div id="table_other_div" style="display: none;width: 75%">
     
         <table id="other_asset_data_table" class="table table-bordered">
             <thead>
                 <tr>
                     <th style="text-align: center">Asset Type</th>
                     <th style="text-align: center">Asset Number</th>
                     <th style="text-align: center">Serial Number</th>
                     <th style="text-align: center">Action</th>
                 </tr>
             </thead>
             <tbody>
                 
             </tbody>
         </table>
     
     
     
        </div>
         </center>

    <center>
        <div id="asset_div_btn">
            <input type="hidden" name="asset_status" id="asset_status" value="1">
            <button type="button" id="skip_asset" class="btn btn-warning pull-right ml-2" style="background-color: orange;"><i class="fa fa-fast-forward" aria-hidden="true"></i> Skip</button>
            <button type="button" id="next_asset_btn" class="btn btn-success pull-right" style="background-color: #011842;"><i class="fa fa-paper-plane"></i> Next</button>
        
        </div>
       
    </center>


        </div>
   </div>




   {{-- dongle details --}}

   <div class="card mt-3"  id="dongle_connection_div" style="display: none;width: 105%">
    
    <div class="card-body">
        <p style="color: red"><i class="fa fa-list-alt" aria-hidden="true"></i> &nbsp; Dongle Connection Details</p>


       <div id="dongle_group">

        <div class="form-row">
            <div class="form-group row col-6">
                <label for="don_asset_type" class="col-sm-4 col-form-label">Asset type</label>
                <div class="col-sm-8">
                    <select id="don_asset_type" class="form-control @error('don_asset_type') is-invalid @enderror" value="{{ old('don_asset_type') }}" name="don_asset_type">
                        <option value="">Select Asset Type</option>
                        <option value="Dongle">Dongle</option>
                        <option value="Wingle">Wingle</option>
                        <option value="Pocket WIFI">Pocket WIFI</option>
                        <option value="Router">Router</option>
                        <option value="TAB">TAB</option>
                    </select>
                </div>
            </div>

            <div class="form-group row col-6">
                <label for="don_con_type" class="col-sm-4 col-form-label">Connection type</label>
                <div class="col-sm-8">
                    <select id="don_con_type" class="form-control @error('don_con_type') is-invalid @enderror" value="{{ old('don_con_type') }}" name="don_con_type">
                        <option value="">Select Connection Type</option>
                        <option value="Dialog">Dialog</option>
                        <option value="Mobitel">Mobitel</option>
                    </select>
                </div>
            </div>

            <div class="form-group row col-6">
                <label for="don_con_number" class="col-sm-4 col-form-label">Dongle Mobile Number</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="don_con_number" name="don_con_number" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;">
                    <i style="color:red;">(07X XXXXXXXX)</i>
                </div>
            </div>

            <div class="form-group row col-6">
                <label for="don_sim_number" class="col-sm-4 col-form-label">Dongle SIM Number</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="don_sim_number" name="don_sim_number" onkeypress="if ( isNaN( String.fromCharCode(event.keyCode) )) return false;">
                </div>
            </div>

           
        </div>


        <div class="form-row">

            <div class="form-group row col-6">
                <label for="don_ip" class="col-sm-4 col-form-label">Dongle IP Address</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="don_ip" name="don_ip">
                </div>
            </div>

            <div class="form-group row col-6">
                <label for="don_modal" class="col-sm-4 col-form-label">Dongle Modal</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="don_modal" name="don_modal" >
                    <i style="color:red;">(Ex: Huawei XXXX)</i>
                </div>
            </div>
         
           
        </div>

        <div class="form-row">

            

            <div class="form-group row col-6">
                <label for="don_imei" class="col-sm-4 col-form-label">Dongle IMEI Number</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="don_imei" name="don_imei">
                </div>
            </div>

         
           
        </div>

        <div id="dongle_div_btn">

            <center>
                <input type="hidden" name="dongle_status" id="dongle_status" value="1">
                <button type="button" id="skip_dongle" class="btn btn-warning ml-2" style="background-color: orange;"><i class="fa fa-fast-forward" aria-hidden="true"></i> Skip</button>
                <button type="button" id="insert_don_data" class="btn btn-success" style="background-color: #011842;"><i class="fa fa-plus-circle"></i> Insert</button>
            </center>


        </div>
   





       </div>
    
    <center>
           
        {{-- table values --}}
        <div id="dongle_table_div" style="width: 90%;display: none" class="mt-3">
     
         <table id="dongle_data_table" class="table table-bordered">
             <thead>
                 <tr>
                     <th style="text-align: center">Asset Type</th>
                     <th style="text-align: center">Connection Type</th>
                     <th style="text-align: center">Connection Number</th>
                     <th style="text-align: center">SIM Number</th>
                     <th style="text-align: center">IP Address</th>
                     <th style="text-align: center">Dongle Modal</th>
                     <th style="text-align: center">Dongle IMEI Number</th>
                     <th style="text-align: center">Action</th>
                 </tr>
             </thead>
             <tbody>
                 
             </tbody>
         </table>
     
     
     
        </div>

         </center>
         <button type="button" id="next_dongle" class="btn btn-success pull-right" style="background-color: #011842;display: none"><i class="fa fa-paper-plane"></i> Next</button>
    
    </div>
</div>


    <center>
        <button type="button" id="submit_btn" class="btn btn-warning mt-2 mb-5" style="background-color: orange;display: none"><i class="fa fa-paper-plane"></i> Submit</button>
    </center>

</form>


<br><br><br><br><br>
        <div class="card mt-5" id="imgdiv" style="background-color: transparent;border: none;display: none">
            <div class="card-body">
                    <center>
                        {{-- <img class="mb-4" src="{{ asset('img/loading.gif') }}" alt=""> --}}
                        <h1 style="color: orange "><b><i>Thank for your support</i></b></h1>
                    </center>
            </div>
        </div>




</div>


@include('asset.js_script')

@endsection