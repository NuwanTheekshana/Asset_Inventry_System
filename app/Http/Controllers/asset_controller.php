<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\asset_data_tbls;
use App\Models\asset_dongle_data_tbls;
use App\Models\asset_dongle_followup_tbl;
use App\Models\asset_user_tbls;
use App\Models\asset_verify_user_token;
use App\Models\asset_followup_tbl;
use App\Models\asset_unallocated_tbl;
use App\Models\user_followup_tbls;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ListExport;
use Auth;
use DB;

class asset_controller extends Controller
{
    

    public function find()
    {
        return view('asset.find_asset');
    }

    public function view_user($id)
    {
        $find_user_token_data = asset_verify_user_token::find($id);
        $find_user_token = $find_user_token_data->user_token;
        $find_asset_token = $find_user_token_data->asset_token;
        $find_dongle_token = $find_user_token_data->dongle_token;
        $company = $find_user_token_data->company;

        $asset_user_tbls = asset_user_tbls::where('user_token', $find_user_token)->get()->first();
        $find_asset_details = asset_data_tbls::where('asset_token', $find_asset_token)->whereNotIn('asset_type', ['Pen Drive', 'External Hard Drive'])->where('status', '1')->get();
        $find_asset_other_details = asset_data_tbls::where('asset_token', $find_asset_token)->whereIn('asset_type', ['Pen Drive', 'External Hard Drive'])->where('status', '1')->get();
        $find_dongle_details = asset_dongle_data_tbls::where('dongle_token', $find_dongle_token)->where('status', '1')->get();

        $user_followup = asset_followup_tbl::where('current_user_token', $find_user_token)->get();
        $dongle_followup = asset_dongle_followup_tbl::where('current_user_token', $find_user_token)->get();

        
        return view('asset.view_find_user_details')
        ->with('token_id', $id)
        ->with('company', $company)
        ->with('asset_user_tbls', $asset_user_tbls)
        ->with('find_asset_details', $find_asset_details)
        ->with('find_dongle_details', $find_dongle_details)
        ->with('find_asset_other_details', $find_asset_other_details)
        ->with('user_followup', $user_followup)
        ->with('dongle_followup', $dongle_followup);
    }

    public function find_asset()
    {
        return view('asset.find_asset_data');
    }

    public function unallocated_asset()
    {

        $get_asset = asset_unallocated_tbl::where('status', '1')->get();
        return view('asset.unallocated.unallocated_asset')->with('get_asset', $get_asset);
    }

    public function find_asset_details(Request $request)
    {
        $epf = $request->findepf_no;
        $find_name = $request->find_name;
        $find_company = $request->find_company;
        $find_status = $request->find_status;

        $query = DB::table('asset_verify_user_tokens');

        if ($epf != null)
        {
            $query->where('user_epf_no', $epf);
        }
        if ($find_name != null)
        {
            $query->where('user_name', 'rlike',$find_name);
        }
        if ($find_company != null)
        {
            $query->where('company', $find_company);
        }
        if ($find_status != null)
        {
            $query->where('status', $find_status);
        }

        $data = $query->orderBy('id','desc')->get();

        return response()->json(['data' => $data]);
    }

    public function update_asset_user_data(Request $request)
    {
        $id = $request->asset_id;
        $update_asset_type = $request->update_asset_type;
        $update_asset_no = $request->update_asset_no;
        $update_serialno = $request->update_serialno;
        $update_asset_modal = $request->update_asset_modal;
        $added_user = Auth::user()->name;
        $added_user_epf_no = Auth::user()->epf_no;
        $added_user_id = Auth::user()->id;

        $errors = [
            'update_asset_type.required' => 'Asset type is Required.',
            'update_asset_type.max' => 'Asset type may not be greater than 50 characters.',
            'update_asset_no.required' => 'Asset number is Required.',
            'update_serialno.required' => 'Serial number is Required.',
            'update_serialno.max' => 'Serial number may not be greater than 100 characters.',
            'update_asset_modal.required' => 'Asset modal is Required.',
            'update_asset_modal.max' => 'Asset modal may not be greater than 100 characters.',
            ];
    
            $this->validate($request, [
            'update_asset_type' => 'required|max:50',
            'update_asset_no' => 'required|numeric',
            'update_serialno' => 'required|max:100',
            'update_asset_modal' => 'required|string|max:100',
              ], $errors);

        $update_asset_data = asset_data_tbls::find($id);
        $find_token = $update_asset_data->asset_token;
        $user_token = asset_verify_user_token::where('asset_token', $find_token)->value('user_token');
        $user_token_company = asset_verify_user_token::where('asset_token', $find_token)->value('company');
        $find_user =  asset_user_tbls::where('user_token', $user_token)->get()->first();
        $current_username = $find_user->full_name;
        $current_epf = $find_user->epf_no;

        $update_asset_data->asset_type = $update_asset_type;
        $update_asset_data->asset_no = $update_asset_no;
        $update_asset_data->asset_serial_no = $update_serialno;
        $update_asset_data->asset_model = $update_asset_modal;
        $update_asset_data->update();

        $add_followup = new asset_followup_tbl();
        $add_followup->current_user_token = $user_token;
        $add_followup->current_user_epf = $current_epf;
        $add_followup->current_user_name = $current_username;
        $add_followup->current_user_company = $user_token_company;
        $add_followup->asset_type = $update_asset_type;
        $add_followup->asset_no = $update_asset_no;
        $add_followup->serial_no = $update_serialno;
        $add_followup->other_asset_model = "";
        $add_followup->other_asset_capacity = "";
        $add_followup->reason = "";
        $add_followup->reason_remark = "";
        $add_followup->followup_update_user_id = $added_user_id;
        $add_followup->followup_update_user_epf = $added_user_epf_no;
        $add_followup->followup_update_user_name = $added_user;
        $add_followup->status = "Update";
        $add_followup->save();

        return redirect()->back()->with('success', 'Asset details update successfully..!');
        
    }

    public function update_other_asset_user_data(Request $request)
    {
        $id = $request->other_asset_id;
        $update_other_asset_type = $request->update_other_asset_type;
        $update_other_asset_modal = $request->update_other_asset_modal;
        $update_other_asset_capacity = $request->update_other_asset_capacity;
        $added_user = Auth::user()->name;
        $added_user_epf_no = Auth::user()->epf_no;
        $added_user_id = Auth::user()->id;

        $errors = [
            'update_other_asset_type.required' => 'Asset type is Required.',
            'update_other_asset_type.max' => 'Asset type may not be greater than 50 characters.',
            'update_other_asset_modal.required' => 'Asset modal is Required.',
            'update_other_asset_modal.max' => 'Asset modal may not be greater than 100 characters.',

            'update_other_asset_capacity.required' => 'Capacity is Required.',
            'update_other_asset_capacity.max' => 'Capacity may not be greater than 20 characters.',
            ];
    
            $this->validate($request, [
            'update_other_asset_type' => 'required|max:50',
            'update_other_asset_modal' => 'required|string|max:100',
            'update_other_asset_capacity' => 'required|max:20',
              ], $errors);

        $update_other_asset_data = asset_data_tbls::find($id);
        $find_token = $update_other_asset_data->asset_token;
        $user_token = asset_verify_user_token::where('asset_token', $find_token)->value('user_token');
        $user_token_company = asset_verify_user_token::where('asset_token', $find_token)->value('company');
        $find_user =  asset_user_tbls::where('user_token', $user_token)->get()->first();
        $current_username = $find_user->full_name;
        $current_epf = $find_user->epf_no;



        $update_other_asset_data->asset_type = $update_other_asset_type;
        $update_other_asset_data->other_asset_model = $update_other_asset_modal;
        $update_other_asset_data->other_asset_capacity = $update_other_asset_capacity;
        $update_other_asset_data->update();

        $add_followup = new asset_followup_tbl();
        $add_followup->current_user_token = $user_token;
        $add_followup->current_user_epf = $current_epf;
        $add_followup->current_user_name = $current_username;
        $add_followup->current_user_company = $user_token_company;
        $add_followup->asset_type = $update_other_asset_type;
        $add_followup->asset_no = "";
        $add_followup->serial_no = "";
        $add_followup->other_asset_model = $update_other_asset_modal;
        $add_followup->other_asset_capacity = $update_other_asset_capacity;
        $add_followup->reason = "";
        $add_followup->reason_remark = "";
        $add_followup->followup_update_user_id = $added_user_id;
        $add_followup->followup_update_user_epf = $added_user_epf_no;
        $add_followup->followup_update_user_name = $added_user;
        $add_followup->status = "Update";
        $add_followup->save();

        return redirect()->back()->with('success', 'Other asset details update successfully..!');
    }


    public function return_asset(Request $request)
    {
        $id = $request->asset_return_id;
        $retun_reason = $request->retun_reason;
        $return_other_remark = $request->return_other_remark;
        $return_asset_condition = $request->return_asset_condition;

        $added_user = Auth::user()->name;
        $added_user_epf_no = Auth::user()->epf_no;
        $added_user_id = Auth::user()->id;

        if ($retun_reason == "Other") 
        {
            if ($return_other_remark == null || $return_other_remark == "") 
            {
                return redirect()->back()->with('error', 'Return reason required..!');
            }
        }
        if ($return_other_remark == null) 
        {
            $return_other_remark = "";
        }
 

        $return_asset_data = asset_data_tbls::find($id);
        $asset_type = $return_asset_data->asset_type;
        $asset_no = $return_asset_data->asset_no;
        $asset_serial_no = $return_asset_data->asset_serial_no;
        $asset_model = $return_asset_data->asset_model;

        $find_token = $return_asset_data->asset_token;
        $user_token = asset_verify_user_token::where('asset_token', $find_token)->value('user_token');
        $user_token_company = asset_verify_user_token::where('asset_token', $find_token)->value('company');
        $find_user =  asset_user_tbls::where('user_token', $user_token)->get()->first();
        $current_username = $find_user->full_name;
        $current_epf = $find_user->epf_no;

        $return_asset_data->status = 0;
        $return_asset_data->update();



        $add_unallocated_list = new asset_unallocated_tbl();
        $add_unallocated_list->asset_type = $asset_type;
        $add_unallocated_list->asset_no = $asset_no;
        $add_unallocated_list->serial_no = $asset_serial_no;
        $add_unallocated_list->asset_model = $asset_model;
        $add_unallocated_list->other_asset_model = "";
        $add_unallocated_list->other_asset_capacity = "";
        $add_unallocated_list->resposible_user_id = $added_user_id;
        $add_unallocated_list->resposible_user_epf = $added_user_epf_no;
        $add_unallocated_list->resposible_user_name = $added_user;
        $add_unallocated_list->asset_condition = $return_asset_condition;
        $add_unallocated_list->save();

        $add_followup = new asset_followup_tbl();
        $add_followup->current_user_token = $user_token;
        $add_followup->current_user_epf = $current_epf;
        $add_followup->current_user_name = $current_username;
        $add_followup->current_user_company = $user_token_company;
        $add_followup->asset_type = $asset_type;
        $add_followup->asset_no = $asset_no;
        $add_followup->serial_no = $asset_serial_no;
        $add_followup->other_asset_model = "";
        $add_followup->other_asset_capacity = "";
        $add_followup->reason = $retun_reason;
        $add_followup->reason_remark = $return_other_remark;
        $add_followup->followup_update_user_id = $added_user_id;
        $add_followup->followup_update_user_epf = $added_user_epf_no;
        $add_followup->followup_update_user_name = $added_user;
        $add_followup->status = "Return";
        $add_followup->save();

        return redirect()->back()->with('success', 'Allocated asset return successfully..!');
    }

    public function return_other_asset(Request $request)
    {
        $id = $request->other_asset_return_id;
        $retun_reason = $request->other_asset_retun_reason;
        $return_other_remark = $request->other_asset_return_other_remark;
        $return_asset_condition = $request->other_asset_return_condition;

        $added_user = Auth::user()->name;
        $added_user_epf_no = Auth::user()->epf_no;
        $added_user_id = Auth::user()->id;

        if ($retun_reason == "Other") 
        {
            if ($return_other_remark == null || $return_other_remark == "") 
            {
                return redirect()->back()->with('error', 'Return reason required..!');
            }
        }

        $return_asset_data = asset_data_tbls::find($id);
        $asset_type = $return_asset_data->asset_type;
        $other_asset_model = $return_asset_data->other_asset_model;
        $other_asset_capacity = $return_asset_data->other_asset_capacity;

        $find_token = $return_asset_data->asset_token;
        $user_token = asset_verify_user_token::where('asset_token', $find_token)->value('user_token');
        $user_token_company = asset_verify_user_token::where('asset_token', $find_token)->value('company');
        $find_user =  asset_user_tbls::where('user_token', $user_token)->get()->first();
        $current_username = $find_user->full_name;
        $current_epf = $find_user->epf_no;

        $return_asset_data->status = 0;
        $return_asset_data->update();



        $add_unallocated_list = new asset_unallocated_tbl();
        $add_unallocated_list->asset_type = $asset_type;
        $add_unallocated_list->asset_no = "";
        $add_unallocated_list->serial_no = "";
        $add_unallocated_list->asset_model = "";
        $add_unallocated_list->other_asset_model = $other_asset_model;
        $add_unallocated_list->other_asset_capacity = $other_asset_capacity;
        $add_unallocated_list->resposible_user_id = $added_user_id;
        $add_unallocated_list->resposible_user_epf = $added_user_epf_no;
        $add_unallocated_list->resposible_user_name = $added_user;
        $add_unallocated_list->asset_condition = $return_asset_condition;
        $add_unallocated_list->save();

        $add_followup = new asset_followup_tbl();
        $add_followup->current_user_token = $user_token;
        $add_followup->current_user_epf = $current_epf;
        $add_followup->current_user_name = $current_username;
        $add_followup->current_user_company = $user_token_company;
        $add_followup->asset_type = $asset_type;
        $add_followup->asset_no = "";
        $add_followup->serial_no = "";
        $add_followup->other_asset_model = $other_asset_model;
        $add_followup->other_asset_capacity = $other_asset_capacity;
        $add_followup->reason = $retun_reason;
        $add_followup->reason_remark = $return_other_remark;
        $add_followup->followup_update_user_id = $added_user_id;
        $add_followup->followup_update_user_epf = $added_user_epf_no;
        $add_followup->followup_update_user_name = $added_user;
        $add_followup->status = "Return";
        $add_followup->save();

        return redirect()->back()->with('success', 'Allocated other asset return successfully..!');
    }

    public function add_asset_data(Request $request)
    {
        $id = $request->add_asset_token_id;
        $add_asset_type = $request->add_asset_type;
        $add_asset_no = $request->add_asset_no;
        $add_serialno = $request->add_serialno;
        $add_asset_modal = $request->add_asset_modal;

        $added_user = Auth::user()->name;
        $added_user_epf_no = Auth::user()->epf_no;
        $added_user_id = Auth::user()->id;
        $date_data = date('dmYhis');

        $errors = [
            'add_asset_type.required' => 'Asset type is Required.',
            'add_asset_type.max' => 'Asset type may not be greater than 50 characters.',
            'add_asset_modal.required' => 'Asset modal is Required.',
            'add_asset_modal.max' => 'Asset modal may not be greater than 50 characters.',
            'add_asset_no.required' => 'Asset type is Required.',
            'add_asset_no.max' => 'Asset type may not be greater than 50 characters.',
            'add_serialno.required' => 'Asset type is Required.',
            'add_serialno.max' => 'Asset type may not be greater than 50 characters.',
            ];
    
            $this->validate($request, [
            'add_asset_type' => 'required|max:50',
            'add_asset_no' => 'required|string|max:100',
            'add_serialno' => 'required|max:100',
            'add_asset_modal' => 'required|max:50',
              ], $errors);

        $find_asset_token = asset_verify_user_token::find($id);
        $asset_token = $find_asset_token->asset_token;
        $user_token = $find_asset_token->user_token;
        $user_epf_no = $find_asset_token->user_epf_no;
        $user_name = $find_asset_token->user_name;
        $company = $find_asset_token->company;

        if ($asset_token == "") 
        {
            $asset_token = "ASSET/".rand(123445678, $date_data);
            $find_asset_token->asset_status = 1;
            $find_asset_token->asset_token = $asset_token;
            $find_asset_token->update();
        }

        $add_asset = new asset_data_tbls();
        $add_asset->asset_token = $asset_token;
        $add_asset->asset_type = $add_asset_type;
        $add_asset->asset_no = $add_asset_no;
        $add_asset->asset_serial_no = $add_serialno;
        $add_asset->asset_model = $add_asset_modal;
        $add_asset->other_asset_model = "";
        $add_asset->other_asset_capacity = "";
        $add_asset->save();


        $add_followup = new asset_followup_tbl();
        $add_followup->current_user_token = $user_token;
        $add_followup->current_user_epf = $user_epf_no;
        $add_followup->current_user_name = $user_name;
        $add_followup->current_user_company = $company;
        $add_followup->asset_type = $add_asset_type;
        $add_followup->asset_no = $add_asset_no;
        $add_followup->serial_no = $add_serialno;
        $add_followup->other_asset_model = "";
        $add_followup->other_asset_capacity = "";
        $add_followup->reason = "";
        $add_followup->reason_remark = "";
        $add_followup->followup_update_user_id = $added_user_id;
        $add_followup->followup_update_user_epf = $added_user_epf_no;
        $add_followup->followup_update_user_name = $added_user;
        $add_followup->status = "Add";
        $add_followup->save();

        return redirect()->back()->with('success', 'Asset allocation successfully..!');

    }

    public function add_other_asset_data(Request $request)
    {
        $id = $request->add_other_asset_id;
        $add_asset_type = $request->add_other_asset_type;
        $add_other_asset_modal = $request->add_other_asset_modal;
        $add_other_asset_capacity = $request->add_other_asset_capacity;

        $added_user = Auth::user()->name;
        $added_user_epf_no = Auth::user()->epf_no;
        $added_user_id = Auth::user()->id;
        $date_data = date('dmYhis');


        $errors = [
            'add_other_asset_type.required' => 'Asset type is Required.',
            'add_other_asset_type.max' => 'Asset type may not be greater than 50 characters.',
            'add_other_asset_modal.required' => 'Asset modal is Required.',
            'add_other_asset_modal.max' => 'Asset modal may not be greater than 100 characters.',

            'add_other_asset_capacity.required' => 'Capacity is Required.',
            'add_other_asset_capacity.max' => 'Capacity may not be greater than 20 characters.',
            ];
    
            $this->validate($request, [
            'add_other_asset_type' => 'required|max:50',
            'add_other_asset_modal' => 'required|string|max:100',
            'add_other_asset_capacity' => 'required|max:20',
              ], $errors);


        $find_asset_token = asset_verify_user_token::find($id);
        $asset_token = $find_asset_token->asset_token;
        $user_token = $find_asset_token->user_token;
        $user_epf_no = $find_asset_token->user_epf_no;
        $user_name = $find_asset_token->user_name;
        $company = $find_asset_token->company;

        if ($asset_token == "") 
        {
            $asset_token = "ASSET/".rand(123445678, $date_data);
            $find_asset_token->asset_status = 1;
            $find_asset_token->asset_token = $asset_token;
            $find_asset_token->update();
        }

        $add_asset = new asset_data_tbls();
        $add_asset->asset_token = $asset_token;
        $add_asset->asset_type = $add_asset_type;
        $add_asset->asset_no = "";
        $add_asset->asset_serial_no = "";
        $add_asset->asset_model = "";
        $add_asset->other_asset_model = $add_other_asset_modal;
        $add_asset->other_asset_capacity = $add_other_asset_capacity;
        $add_asset->save();


        $add_followup = new asset_followup_tbl();
        $add_followup->current_user_token = $user_token;
        $add_followup->current_user_epf = $user_epf_no;
        $add_followup->current_user_name = $user_name;
        $add_followup->current_user_company = $company;
        $add_followup->asset_type = $add_asset_type;
        $add_followup->asset_no = "";
        $add_followup->serial_no = "";
        $add_followup->other_asset_model = $add_other_asset_modal;
        $add_followup->other_asset_capacity = $add_other_asset_capacity;
        $add_followup->reason = "";
        $add_followup->reason_remark = "";
        $add_followup->followup_update_user_id = $added_user_id;
        $add_followup->followup_update_user_epf = $added_user_epf_no;
        $add_followup->followup_update_user_name = $added_user;
        $add_followup->status = "Add";
        $add_followup->save();


        return redirect()->back()->with('success', 'Other asset allocation successfully..!');

    }

    public function insert_new_asset_data(Request $request)
    {
        $all = $request->all();
        $date_data = date('dmYhis');
        // user details
        // dd($all);
        $company = $request->compy_type;
        $epfno_val = $request->epfno_val;
        $emp_type = $request->emp_type;
        $fullname = $request->fullname;
        $NIC = $request->NIC;
        $designation = $request->designation;
        $location = $request->location;
        $email = $request->email;
        $contact_no = $request->contact_no;
        $user_token = "USER/".rand(123445678, $date_data);

        $added_user = Auth::user()->name;
        $added_user_epf_no = Auth::user()->epf_no;
        $added_user_id = Auth::user()->id;

        if ($NIC == null) 
        {
            $NIC = "";
        }


        // asset details
        $asset_status = $request->asset_status;

        if ($asset_status == 1) 
        {
            $asset_type_val = $request->asset_type_val;
            $asset_no_val = $request->asset_no_val;
            $serial_no_val = $request->serial_no_val;
            $dev_modal_val = $request->dev_modal_val;
            $asset_token = "ASSET/".rand(123445678, $date_data);


            foreach ($serial_no_val as $key => $value) {
                if (is_null($value)) {
                     $serial_no_val[$key] = "";
                }
            }

            if ($asset_no_val == null) 
            {
                $asset_no_val = "";
            }

            foreach ($asset_no_val as $key2 => $value2) {
                if (is_null($value2)) {
                     $asset_no_val[$key2] = "";
                }
            }

            foreach ($dev_modal_val as $key3 => $value3) {
                if (is_null($value3)) {
                     $dev_modal_val[$key3] = "";
                }
            }

            foreach ($asset_type_val as $i => $value) 
            {
                // $asset[] = array(
                //     'asset_token' => $asset_token,
                //     'asset_type' => $asset_type_val[$i],
                //     'asset_no' => $asset_no_val[$i],
                //     'asset_serial_no' => $serial_no_val[$i],
                //     'asset_model' => $dev_modal_val[$i],
                //     'other_asset_model' => "",
                //     'other_asset_capacity' => "",
                //     'asset_validate_status' => $asset_status,
                // );

                $add_asset = new asset_data_tbls();
                $add_asset->asset_token = $asset_token;
                $add_asset->asset_type = $asset_type_val[$i];
                $add_asset->asset_no = $asset_no_val[$i];
                $add_asset->asset_serial_no = $serial_no_val[$i];
                $add_asset->asset_model = $dev_modal_val[$i];
                $add_asset->other_asset_model = "";
                $add_asset->other_asset_capacity = "";
                $add_asset->asset_validate_status = $asset_status;
                $add_asset->save();

                $add_followup = new asset_followup_tbl();
                $add_followup->current_user_token = $user_token;
                $add_followup->current_user_epf = $epfno_val;
                $add_followup->current_user_name = $fullname;
                $add_followup->current_user_company = $company;
                $add_followup->asset_type = $asset_type_val[$i];
                $add_followup->asset_no = $asset_no_val[$i];
                $add_followup->serial_no = $serial_no_val[$i];
                $add_followup->other_asset_model = "";
                $add_followup->other_asset_capacity = "";
                $add_followup->reason = "";
                $add_followup->reason_remark = "";
                $add_followup->followup_update_user_id = $added_user_id;
                $add_followup->followup_update_user_epf = $added_user_epf_no;
                $add_followup->followup_update_user_name = $added_user;
                $add_followup->status = "New";
                $add_followup->save();
            }
            
            // asset_data_tbls::insert($asset);
            
            // other assets
            $asset_type_other_val = $request->asset_type_other_val;
            $pen_asset_no_val = $request->pen_asset_no_val;
            $storange_val = $request->storange_val;

            if ($asset_type_other_val != null) 
            {

            $other_asset_count = count($asset_type_other_val);

            if ($other_asset_count > 0) 
            {
                    foreach ($asset_type_other_val as $i3 => $otherasset) 
                {
                    // $other_asset[] = array(
                    //     'asset_token' => $asset_token,
                    //     'asset_type' => $asset_type_other_val[$i3],
                    //     'asset_no' => "",
                    //     'asset_serial_no' => "",
                    //     'asset_model' => "",
                    //     'other_asset_model' => $pen_asset_no_val[$i3],
                    //     'other_asset_capacity' => $storange_val[$i3],
                    //     'asset_validate_status' => $asset_status,
                    // );

                    $add_asset = new asset_data_tbls();
                    $add_asset->asset_token = $asset_token;
                    $add_asset->asset_type = $asset_type_other_val[$i3];
                    $add_asset->asset_no = "";
                    $add_asset->asset_serial_no = "";
                    $add_asset->asset_model = "";
                    $add_asset->other_asset_model = $pen_asset_no_val[$i3];
                    $add_asset->other_asset_capacity = $storange_val[$i3];
                    $add_asset->asset_validate_status = $asset_status;
                    $add_asset->save();

                    $add_followup = new asset_followup_tbl();
                    $add_followup->current_user_token = $user_token;
                    $add_followup->current_user_epf = $epfno_val;
                    $add_followup->current_user_name = $fullname;
                    $add_followup->current_user_company = $company;
                    $add_followup->asset_type = $asset_type_other_val[$i3];
                    $add_followup->asset_no = "";
                    $add_followup->serial_no = "";
                    $add_followup->other_asset_model = $pen_asset_no_val[$i3];
                    $add_followup->other_asset_capacity = $storange_val[$i3];
                    $add_followup->reason = "";
                    $add_followup->reason_remark = "";
                    $add_followup->followup_update_user_id = $added_user_id;
                    $add_followup->followup_update_user_epf = $added_user_epf_no;
                    $add_followup->followup_update_user_name = $added_user;
                    $add_followup->status = "New";
                    $add_followup->save();
                }

                // asset_data_tbls::insert($other_asset);
                }
            }

           
        }
        elseif ($asset_status == 0) 
        {
            $asset_type_val = "";
            $asset_no_val = "";
            $serial_no_val = "";
            $asset_token = "";
        }

        // dongle details
        $dongle_status = $request->dongle_status;

        if ($dongle_status == "1") 
        {
            $don_asset_type_val = $request->don_asset_type_val;
            $don_con_type_val = $request->don_con_type_val;
            $don_con_number_val = $request->don_con_number_val;
            $don_sim_number_val = $request->don_sim_number_val;
            $don_ip_val = $request->don_ip_val;
            $don_modal_val = $request->don_modal_val;
            $don_imei_val = $request->don_imei_val;
            $dongle_token = "DONGLE/".rand(123445678, $date_data);

            foreach ($don_asset_type_val as $i2 => $a_type) 
            {
                // $dongle[] = array(
                //     'dongle_token' => $dongle_token,
                //     'dongle_asset_type' => $don_asset_type_val[$i2],
                //     'dongle_connection_type' => $don_con_type_val[$i2],
                //     'dongle_connection_no' => $don_con_number_val[$i2],
                //     'dongle_sim_no' => $don_sim_number_val[$i2],
                //     'dongle_ip_address' => $don_ip_val[$i2],
                //     'dongle_modal' => $don_modal_val[$i2],
                //     'dongle_imei_no' => $don_imei_val[$i2],
                // );

                $add_dongle = new asset_dongle_data_tbls();
                $add_dongle->dongle_token = $dongle_token;
                $add_dongle->dongle_asset_type = $don_asset_type_val[$i2];
                $add_dongle->dongle_connection_type = $don_con_type_val[$i2];
                $add_dongle->dongle_connection_no = $don_con_number_val[$i2];
                $add_dongle->dongle_sim_no = $don_sim_number_val[$i2];
                $add_dongle->dongle_ip_address = $don_ip_val[$i2];
                $add_dongle->dongle_modal = $don_modal_val[$i2];
                $add_dongle->dongle_imei_no = $don_imei_val[$i2];
                $add_dongle->save();


                $add_followup = new asset_dongle_followup_tbl();
                $add_followup->current_user_token = $user_token;
                $add_followup->current_user_epf = $epfno_val;
                $add_followup->current_user_name = $fullname;
                $add_followup->current_user_company = $company;
                $add_followup->connection_number = $don_con_type_val[$i2];
                $add_followup->sim_number = $don_sim_number_val[$i2];
                $add_followup->ip_address = $don_ip_val[$i2];
                $add_followup->dongle_imei_no = $don_imei_val[$i2];
                $add_followup->reason = "";
                $add_followup->reason_remark = "";
                $add_followup->followup_update_user_id = $added_user_id;
                $add_followup->followup_update_user_name = $added_user;
                $add_followup->status = "New";
                $add_followup->save();
            }
            
            // asset_dongle_data_tbls::insert($dongle);
            
        }
        elseif ($dongle_status == "0") 
        {
            $don_asset_type_val = "";
            $don_con_type_val = "";
            $don_con_number_val = "";
            $don_sim_number_val = "";
            $don_ip_val = "";
            $don_modal_val = "";
            $don_imei_val = "";
            $dongle_token = "";
        }

        $user_data = new asset_user_tbls();
        $user_data->user_token = $user_token;
        $user_data->epf_no = $epfno_val;
        $user_data->emplyee_type = $emp_type;
        $user_data->nic_no = $NIC;
        $user_data->full_name = $fullname;
        $user_data->designation = $designation;
        $user_data->location = $location;
        $user_data->email = $email;
        $user_data->contact_no = $contact_no;
        $user_data->save();

        $user_data = new user_followup_tbls();
        $user_data->current_user_token = $user_token;
        $user_data->current_user_epf = $epfno_val;
        $user_data->current_user_name = $fullname;
        $user_data->current_user_company = $company;
        $user_data->reason = "";
        $user_data->reason_remark = "";
        $user_data->followup_update_user_id = $added_user_id;
        $user_data->followup_update_user_name = $added_user;
        $user_data->status = "Add";
        $user_data->save();

        $ref_no = asset_verify_user_token::count('id');
        $ref_no = $ref_no+1;
        $ref_no = "UVA/".$ref_no;
        
        $verify_user_data = new asset_verify_user_token();
        $verify_user_data->ref_no = $ref_no;
        $verify_user_data->user_epf_no = $epfno_val;
        $verify_user_data->user_name = $fullname;
        $verify_user_data->nic_no = $NIC;
        $verify_user_data->company = $company;
        $verify_user_data->user_token = $user_token;
        $verify_user_data->asset_status = $asset_status;
        $verify_user_data->asset_token = $asset_token;
        $verify_user_data->dongle_status = $dongle_status;
        $verify_user_data->dongle_token = $dongle_token;
        $verify_user_data->save();

        return response()->json(['success'=>'Database update successfully..!', 'all'=>$all]);

    }

    public function find_asset_data_details(Request $request)
    {
        $findasset_no = $request->findasset_no;
        $find_serial_no = $request->find_serial_no;
        $find_asset_type = $request->find_asset_type;
        $find_status = $request->find_status;
        $findasset_model = $request->findasset_model;
        $find_asset_company = $request->find_asset_company;

        $query = DB::table('asset_data_tbls')
        ->select('asset_data_tbls.id as AssetID', 'asset_data_tbls.asset_no as AssetNo', 'asset_data_tbls.status as Status', 'asset_data_tbls.*', 'asset_verify_user_tokens.asset_token', 'asset_verify_user_tokens.id', 'asset_verify_user_tokens.user_name', 'asset_verify_user_tokens.company')
        ->join('asset_verify_user_tokens','asset_verify_user_tokens.asset_token','=','asset_data_tbls.asset_token');

        if ($findasset_no != null)
        {
            $query->where('asset_data_tbls.asset_no', $findasset_no);
        }
        if ($find_serial_no != null)
        {
            $query->where('asset_data_tbls.asset_serial_no', 'rlike',$find_serial_no);
        }
        if ($find_asset_type != null)
        {
            $query->where('asset_data_tbls.asset_type', $find_asset_type);
        }
        if ($find_status != null)
        {
            $query->where('asset_data_tbls.status', $find_status);
        }
        if ($findasset_model != null)
        {
            $query->where('asset_data_tbls.asset_model', $findasset_model);
        }
        if ($find_asset_company != null)
        {
            $query->where('asset_verify_user_tokens.company', $find_asset_company);
        }

        $data = $query->orderBy('asset_data_tbls.id','desc')->get();

        return response()->json(['data' => $data]);
    }
    
    public function add_unallocated_data(Request $request)
    {
        $add_asset_type_val = $request->add_asset_type_val;
        $add_unallocate_asset_no = $request->add_unallocate_asset_no;
        $add_unallocate_serial_no = $request->add_unallocate_serial_no;
        $add_unallocate_asset_model = $request->add_unallocate_asset_model;
        $add_unallocate_other_asset_modal = $request->add_unallocate_other_asset_modal;
        $add_unallocate_other_asset_modal_capacity = $request->add_unallocate_other_asset_modal_capacity;
        $unallocated_asset_condition = $request->unallocated_asset_condition;
        
        $added_user = Auth::user()->name;
        $added_user_epf_no = Auth::user()->epf_no;
        $added_user_id = Auth::user()->id;
        
        if ($add_asset_type_val != "Pen Drive" || $add_asset_type_val != "External Hard Drive") 
        {
            $add_unallocated_list = new asset_unallocated_tbl();
            $add_unallocated_list->asset_type = $add_asset_type_val;
            $add_unallocated_list->asset_no = $add_unallocate_asset_no;
            $add_unallocated_list->serial_no = $add_unallocate_serial_no;
            $add_unallocated_list->asset_model = $add_unallocate_asset_model;
            $add_unallocated_list->other_asset_model = "";
            $add_unallocated_list->other_asset_capacity = "";
            $add_unallocated_list->resposible_user_id = $added_user_id;
            $add_unallocated_list->resposible_user_epf = $added_user_epf_no;
            $add_unallocated_list->resposible_user_name = $added_user;
            $add_unallocated_list->asset_condition = $unallocated_asset_condition;
            $add_unallocated_list->save();
        }
        else
        {
            $add_unallocated_list = new asset_unallocated_tbl();
            $add_unallocated_list->asset_type = $add_asset_type_val;
            $add_unallocated_list->asset_no = "";
            $add_unallocated_list->serial_no = "";
            $add_unallocated_list->asset_model = "";
            $add_unallocated_list->other_asset_model = $add_unallocate_other_asset_modal;
            $add_unallocated_list->other_asset_capacity = $add_unallocate_other_asset_modal_capacity;
            $add_unallocated_list->resposible_user_id = $added_user_id;
            $add_unallocated_list->resposible_user_epf = $added_user_epf_no;
            $add_unallocated_list->resposible_user_name = $added_user;
            $add_unallocated_list->asset_condition = $unallocated_asset_condition;
            $add_unallocated_list->save();
        }

        return redirect()->back()->with('success', 'Insert asset details successfully..!');

    }
    
    public function bulk_asset_upload(Request $request)
    {
        $path = $request->file('upload_file');
        $added_user = Auth::user()->name;
        $added_user_epf_no = Auth::user()->epf_no;
        $added_user_id = Auth::user()->id;
        $datetime = date('Y-m-d H:i:s');

        $this->validate($request, [
            'upload_file'  => 'required|mimes:csv,txt',
           ]);

        $path = $path->getRealPath();

        $maindb = fopen($path, 'r');
        $count = 0;
        if ($maindb) {
        while (($dataline = fgets($maindb)) != false) {
        
            if ($count>0) {
                   //process the dataline read.
            $datalineSplit = explode(",", $dataline);
            $asset_data = array(
                'asset_type' => ucwords(trim($datalineSplit[0])),
                'asset_no' => trim($datalineSplit[1]),
                'serial_no' => trim($datalineSplit[2]),
                'asset_model' => trim($datalineSplit[3]),
                'other_asset_model' => trim($datalineSplit[4]),
                'other_asset_capacity' => trim($datalineSplit[5]),
                'resposible_user_id' => $added_user_id,
                'resposible_user_epf' => $added_user_epf_no,
                'resposible_user_name' => $added_user,
                'asset_condition' => ucwords(trim($datalineSplit[6])),
                'created_at' => $datetime,
                'updated_at' => $datetime
            );
            // print '<pre>';
            // print_r($datalineSplit);
            // print '</pre>';
            asset_unallocated_tbl::insert($asset_data);
            }
            $count++;
        }
        
    }

    return redirect()->back()->with('success', 'Asset details upload successfully..!');
    }

    public function download_asset_csv_demo()
    {
        $filepath= public_path()."/bulk_csv/Asset_bulk_upload.zip";
        return response()->download($filepath, 'Asset_bulk_upload_demo.zip');
    }

    public function asset_report()
    {
        return Excel::download(new ListExport, 'asset_report.xlsx');
    }

    public function allocate_asset($id)
    {
        $find_unallocated_asset = asset_unallocated_tbl::find($id);

        return view('asset.unallocated.allocate_asset_view')
        ->with('unallocated_asset', $find_unallocated_asset);
    }

    public function find_emp_details(Request $request)
    {
        $epf = $request->epf;
        $company = $request->company;
        $user_name = $request->user_name;

        $query = DB::table('asset_user_tbls')
                    ->select('asset_user_tbls.*', 'asset_verify_user_tokens.user_token', 'asset_verify_user_tokens.company')
                    ->join('asset_verify_user_tokens', 'asset_verify_user_tokens.user_token', '=', 'asset_user_tbls.user_token')
                    ->where('asset_user_tbls.status', '1');

        if ($epf != null)
        {
            $query->where('asset_user_tbls.epf_no', $epf);
        }
        if ($user_name != null)
        {
            $query->where('asset_user_tbls.full_name', 'rlike', $user_name);
        }
        if ($company != null)
        {
            $query->where('asset_verify_user_tokens.company', $company);
        }
      
        $data = $query->orderBy('asset_user_tbls.id','desc')->get();

        return response()->json(['data' => $data]);
    }

    public function allcate_asset_user(Request $request)
    {
        $id = $request->user_id;
        $findasset_no = $request->findasset_no;
        $find_asset_type = $request->find_asset_type;
        $find_serial_no = $request->find_serial_no;
        $findasset_model = $request->findasset_model;

        $added_user = Auth::user()->name;
        $added_user_epf_no = Auth::user()->epf_no;
        $added_user_id = Auth::user()->id;
        $date_data = date('dmYhis');

        if ($find_serial_no == null) {$find_serial_no = "";}

        $find_user = asset_user_tbls::find($id);
        $user_token = $find_user->user_token;
        $id = asset_verify_user_token::where('user_token', $user_token)->where('status', '1')->value('id');

        $find_asset_token = asset_verify_user_token::find($id);
        $asset_token = $find_asset_token->asset_token;
        $user_token = $find_asset_token->user_token;
        $user_epf_no = $find_asset_token->user_epf_no;
        $user_name = $find_asset_token->user_name;
        $company = $find_asset_token->company;

        if ($asset_token == "") 
        {
            $asset_token = "ASSET/".rand(123445678, $date_data);
            $find_asset_token->asset_status = 1;
            $find_asset_token->asset_token = $asset_token;
            $find_asset_token->update();
        }

        $add_asset = new asset_data_tbls();
        $add_asset->asset_token = $asset_token;
        $add_asset->asset_type = $find_asset_type;
        $add_asset->asset_no = $findasset_no;
        $add_asset->asset_serial_no = $find_serial_no;
        $add_asset->asset_model = $findasset_model;
        $add_asset->other_asset_model = "";
        $add_asset->other_asset_capacity = "";
        $add_asset->save();

        $id = $request->asset_id;
        $update_unallocated_asset = asset_unallocated_tbl::find($id);
        $update_unallocated_asset->status = '0';
        $update_unallocated_asset->update();

        $add_followup = new asset_followup_tbl();
        $add_followup->current_user_token = $user_token;
        $add_followup->current_user_epf = $user_epf_no;
        $add_followup->current_user_name = $user_name;
        $add_followup->current_user_company = $company;
        $add_followup->asset_type = $find_asset_type;
        $add_followup->asset_no = $findasset_no;
        $add_followup->serial_no = $find_serial_no;
        $add_followup->other_asset_model = "";
        $add_followup->other_asset_capacity = "";
        $add_followup->reason = "";
        $add_followup->reason_remark = "";
        $add_followup->followup_update_user_id = $added_user_id;
        $add_followup->followup_update_user_epf = $added_user_epf_no;
        $add_followup->followup_update_user_name = $added_user;
        $add_followup->status = "Add";
        $add_followup->save();

        return response()->json(['success' => 'Asset allocation succeefully..!']);
    }
   
}
