<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\asset_data_tbls;
use App\Models\asset_dongle_data_tbls;
use App\Models\asset_user_tbls;
use App\Models\asset_verify_user_token;
use App\Models\asset_followup_tbl;
use App\Models\asset_unallocated_tbl;
use App\Models\asset_dongle_followup_tbl;
use App\Models\asset_dongle_unallocated_tbl;
use App\Models\common_connection_details_tbl;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ListExport2;
use Auth;
use DB;

class dongle_controller extends Controller
{
    public function find_dongle_data()
    {
        return view('asset.find_dongle_data');
    }

    public function unallocated_dongle(Request $request)
    {
        $get_dongle_asset = asset_dongle_unallocated_tbl::where('status', '1')->get();
        return view('asset..unallocated.unallocated_dongle')->with('get_dongle_asset', $get_dongle_asset);
    }

    public function find_dongle_data_details(Request $request)
    {
        $findcon_no = $request->findcon_no;
        $find_sim_no = $request->find_sim_no;
        $find_ip_address = $request->find_ip_address;
        $find_imei = $request->find_imei;
        $find_asset_type = $request->find_asset_type;
        $find_asset_status = $request->find_asset_status;
        $find_user = $request->find_user;

        $query = DB::table('asset_dongle_data_tbls')
        ->select('asset_dongle_data_tbls.*', 'asset_verify_user_tokens.asset_token', 'asset_verify_user_tokens.id', 'asset_verify_user_tokens.user_name', 'asset_verify_user_tokens.company')
        ->join('asset_verify_user_tokens','asset_verify_user_tokens.dongle_token','=','asset_dongle_data_tbls.dongle_token');
        $query2 = common_connection_details_tbl::where('status', '1');

        if ($findcon_no != null)
        {
            $query->where('asset_dongle_data_tbls.dongle_connection_no', $findcon_no);
            $query2->where('dongle_connection_no', $findcon_no);
        }
        if ($find_sim_no != null)
        {
            $query->where('asset_dongle_data_tbls.dongle_sim_no', 'rlike',$find_sim_no);
            $query2->where('dongle_sim_no', 'rlike', $find_sim_no);
        }
        if ($find_ip_address != null)
        {
            $query->where('asset_dongle_data_tbls.dongle_ip_address', $find_ip_address);
            $query2->where('dongle_ip_address', $find_ip_address);
        }
        if ($find_imei != null)
        {
            $query->where('asset_dongle_data_tbls.dongle_imei_no', $find_imei);
        }
        if ($find_asset_type != null)
        {
            $query->where('asset_dongle_data_tbls.dongle_asset_type', $find_asset_type);
        }
        if ($find_user != null)
        {
            $query->where('asset_verify_user_tokens.user_name', 'rlike',$find_user);
        }
        if ($find_asset_status != null)
        {
            $query->where('asset_dongle_data_tbls.status', $find_asset_status);
        }

        $data = $query->orderBy('asset_dongle_data_tbls.id','desc')->get();
        $data2 = $query2->orderBy('id','desc')->get();

        return response()->json(['data' => $data, 'data2'=> $data2]);
    }

    public function update_dongle_user_data(Request $request)
    {
        $id = $request->dongle_id;
        $update_dongle_type = $request->update_dongle_type;
        $update_connection_type = $request->update_connection_type;
        $update_connection_number = $request->update_connection_number;
        $update_sim_number = $request->update_sim_number;
        $update_ip_address = $request->update_ip_address;
        $update_dongle_modal = $request->update_dongle_modal;
        $update_dongle_imei_no = $request->update_dongle_imei_no;

        $added_user = Auth::user()->name;
        $added_user_epf_no = Auth::user()->epf_no;
        $added_user_id = Auth::user()->id;

        $errors = [
            'update_dongle_type.required' => 'Dongle Type is Required.',
            'update_connection_type.required' => 'Connection Type is Required.',
            'update_connection_number.required' => 'Connection Number is Required.',
            'update_sim_number.required' => 'SIM Number is Required.',
            'ipaddress.required' => 'IP Address is Required.',
            'dongle_modal.required' => 'Dongle Modal is Required.',
            'imei_no.required' => 'IMEI Number is Required.',
    
            'update_connection_number.max' => 'The Connection Number may not be greater than 10 characters.',
            'update_connection_number.min' => 'The Connection Number must be at least 9 characters.',
            'update_sim_number.max' => 'The SIM Number may not be greater than 22 characters.',
            'update_sim_number.min' => 'The SIM Number must be at least 15 characters.',
            'ipaddress.min' => 'The IP Address must be a valid IPv4 address.',
            'imei_no.max' => 'The IMEI Number may not be greater than 25 characters.',
            'imei_no.min' => 'The IMEI Number must be at least 12 characters.',

            'update_connection_number.unique' => 'Connection Number has already been taken.',
            'update_sim_number.unique' => 'SIM Number has already been taken.',
            'ipaddress.unique' => 'IP Address has already been taken.',
            'imei_no.unique' => 'IMEI Number has already been taken.',
          ];

          $this->validate($request, [
            'update_dongle_type' => 'required',
            'update_connection_type' => 'required',
            'update_connection_number' => 'required|min:8|numeric',
            'update_sim_number' => 'required|max:23|min:14',
            'update_ip_address' => 'required|ipv4',
            'update_dongle_modal' => 'required',
            'update_dongle_imei_no' => 'required|max:25|min:12',
        ],$errors);

        $update_dongle = asset_dongle_data_tbls::find($id);
        $update_dongle_connection_no = $update_dongle->dongle_connection_no;
        $update_dongle_sim_no= $update_dongle->dongle_sim_no;
        $update_dongle_ipaddress= $update_dongle->dongle_ip_address;
        $update_dongle_imei= $update_dongle->dongle_imei_no;

        // dongle connection number check
        if ($update_dongle_connection_no != $update_connection_number) 
        {
            $find_contact_no = asset_dongle_data_tbls::where('dongle_connection_no', $update_connection_number)->where('status', '1')->count();

            if ($find_contact_no > 0) 
            {
                return redirect()->back()->with('error', 'Connection Number has already been taken.');
            }
        }

        // dongle sim number check
        if ($update_dongle_sim_no != $update_sim_number) 
        {
            $find_sim_no = asset_dongle_data_tbls::where('dongle_sim_no', $update_sim_number)->where('status', '1')->count();

            if ($find_sim_no > 0) 
            {
                return redirect()->back()->with('error', 'SIM Number has already been taken.');
            }
        }
     

        // dongle ip address check
        if ($update_dongle_ipaddress != $update_ip_address) 
        {
            $find_ip_address = asset_dongle_data_tbls::where('dongle_ip_address', $update_ip_address)->where('status', '1')->count();

            if ($find_ip_address > 0) 
            {
                return redirect()->back()->with('error', 'IP Address has already been taken.');
            }
        }

        // dongle IMEI number check
        if ($update_dongle_imei_no != $update_dongle_imei) 
        {
            $find_imei = asset_dongle_data_tbls::where('dongle_ip_address', $update_dongle_imei_no)->where('status', '1')->count();

            if ($find_imei > 0) 
            {
                return redirect()->back()->with('error', 'IMEI number has already been taken.');
            }
        }

        $find_dongle_token = $update_dongle->dongle_token;
        $user_token = asset_verify_user_token::where('dongle_token', $find_dongle_token)->value('user_token');
        $user_token_company = asset_verify_user_token::where('dongle_token', $find_dongle_token)->value('company');
        $find_user =  asset_user_tbls::where('user_token', $user_token)->get()->first();
        $current_username = $find_user->full_name;
        $current_epf = $find_user->epf_no;


        $update_dongle->dongle_asset_type = $update_dongle_type;
        $update_dongle->dongle_connection_type = $update_connection_type;
        $update_dongle->dongle_connection_no = $update_connection_number;
        $update_dongle->dongle_sim_no = $update_sim_number;
        $update_dongle->dongle_ip_address = $update_ip_address;
        $update_dongle->dongle_modal = $update_dongle_modal;
        $update_dongle->dongle_imei_no = $update_dongle_imei_no;
        $update_dongle->update();

        $add_followup = new asset_dongle_followup_tbl();
        $add_followup->current_user_token = $user_token;
        $add_followup->current_user_epf = $current_epf;
        $add_followup->current_user_name = $current_username;
        $add_followup->current_user_company = $user_token_company;
        $add_followup->connection_number = $update_connection_number;
        $add_followup->sim_number = $update_sim_number;
        $add_followup->ip_address = $update_ip_address;
        $add_followup->dongle_imei_no = $update_dongle_imei_no;
        $add_followup->reason = "";
        $add_followup->reason_remark = "";
        $add_followup->followup_update_user_id = $added_user_id;
        $add_followup->followup_update_user_name = $added_user;
        $add_followup->status = "Update";
        $add_followup->save();

        return redirect()->back()->with('success', 'Dongle details update successfully..!');
    }

    public function return_dongle(Request $request)
    {
        $id = $request->dongle_return_id;
        $retun_reason = $request->dongle_retun_reason;
        $return_other_remark = $request->dongle_return_other_remark;
        $return_asset_condition = $request->dongle_return_condition;

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
        else
        {
            $return_other_remark = "";
        }


        $return_dongle = asset_dongle_data_tbls::find($id);
        $return_dongle_asset_type = $return_dongle->dongle_asset_type;
        $return_dongle_connection_no = $return_dongle->dongle_connection_no;
        $return_dongle_sim_no= $return_dongle->dongle_sim_no;
        $return_dongle_ipaddress= $return_dongle->dongle_ip_address;
        $return_dongle_connection_type= $return_dongle->dongle_connection_type;
        $return_dongle_imei= $return_dongle->dongle_imei_no;
        $return_dongle_modal= $return_dongle->dongle_modal;

        $find_dongle_token = $return_dongle->dongle_token;
        $user_token = asset_verify_user_token::where('dongle_token', $find_dongle_token)->value('user_token');
        $user_token_company = asset_verify_user_token::where('dongle_token', $find_dongle_token)->value('company');
        $find_user =  asset_user_tbls::where('user_token', $user_token)->get()->first();
        $current_username = $find_user->full_name;
        $current_epf = $find_user->epf_no;

        $return_dongle->status = 0;
        $return_dongle->update();



        $add_unallocated_list = new asset_dongle_unallocated_tbl();
        $add_unallocated_list->asset_type = $return_dongle_asset_type;
        $add_unallocated_list->connection_number = $return_dongle_connection_no;
        $add_unallocated_list->sim_no = $return_dongle_sim_no;
        $add_unallocated_list->ipaddress = $return_dongle_ipaddress;
        $add_unallocated_list->connection_type = $return_dongle_connection_type;
        $add_unallocated_list->dongle_modal = $return_dongle_modal;
        $add_unallocated_list->dongle_imei = $return_dongle_imei;
        $add_unallocated_list->dongle_condition = $return_asset_condition;
        $add_unallocated_list->resposible_user_id = $added_user_id;
        $add_unallocated_list->resposible_user_epf = $added_user_epf_no;
        $add_unallocated_list->resposible_user_name = $added_user;
        $add_unallocated_list->save();

        $add_followup = new asset_dongle_followup_tbl();
        $add_followup->current_user_token = $user_token;
        $add_followup->current_user_epf = $current_epf;
        $add_followup->current_user_name = $current_username;
        $add_followup->current_user_company = $user_token_company;
        $add_followup->connection_number = $return_dongle_connection_no;
        $add_followup->sim_number = $return_dongle_sim_no;
        $add_followup->ip_address = $return_dongle_ipaddress;
        $add_followup->dongle_imei_no = $return_dongle_imei;
        $add_followup->reason = $retun_reason;
        $add_followup->reason_remark = $return_other_remark;
        $add_followup->followup_update_user_id = $added_user_id;
        $add_followup->followup_update_user_name = $added_user;
        $add_followup->status = "Return";
        $add_followup->save();

        return redirect()->back()->with('success', 'Allocated dongle return successfully..!');
 
    }

    public function add_dongle_user_data(Request $request)
    {
        $id = $request->user_dongle_veri_token_id;
        $add_dongle_type = $request->add_dongle_type;
        $add_connection_type = $request->add_connection_type;
        $add_connection_number = $request->add_connection_number;
        $add_sim_number = $request->add_sim_number;
        $add_ip_address = $request->add_ip_address;
        $add_dongle_modal = $request->add_dongle_modal;
        $add_dongle_imei_no = $request->add_dongle_imei_no;

        $added_user = Auth::user()->name;
        $added_user_epf_no = Auth::user()->epf_no;
        $added_user_id = Auth::user()->id;
        $date_data = date('dmYhis');


        $errors = [
            'add_dongle_type.required' => 'Dongle Type is Required.',
            'add_connection_type.required' => 'Connection Type is Required.',
            'add_connection_number.required' => 'Connection Number is Required.',
            'add_sim_number.required' => 'SIM Number is Required.',
            'add_ip_address.required' => 'IP Address is Required.',
            'add_dongle_modal.required' => 'Dongle Modal is Required.',
            'add_dongle_imei_no.required' => 'IMEI Number is Required.',
    
            'add_connection_number.max' => 'The Connection Number may not be greater than 10 characters.',
            'add_connection_number.min' => 'The Connection Number must be at least 9 characters.',
            'add_sim_number.max' => 'The SIM Number may not be greater than 22 characters.',
            'add_sim_number.min' => 'The SIM Number must be at least 15 characters.',
            'add_ip_address.min' => 'The IP Address must be a valid IPv4 address.',
            'add_dongle_imei_no.max' => 'The IMEI Number may not be greater than 25 characters.',
            'add_dongle_imei_no.min' => 'The IMEI Number must be at least 12 characters.',

            'add_connection_number.unique' => 'Connection Number has already been taken.',
            'add_sim_number.unique' => 'SIM Number has already been taken.',
            'add_ip_address.unique' => 'IP Address has already been taken.',
            'add_dongle_imei_no.unique' => 'IMEI Number has already been taken.',
          ];

          $this->validate($request, [
            'add_dongle_type' => 'required',
            'add_connection_type' => 'required',
            'add_connection_number' => 'required|min:8|numeric',
            'add_sim_number' => 'required|max:23|min:14',
            'add_ip_address' => 'required|ipv4',
            'add_dongle_modal' => 'required',
            'add_dongle_imei_no' => 'required|max:25|min:12',
        ],$errors);


        // dongle connection number check

            $find_contact_no = asset_dongle_data_tbls::where('dongle_connection_no', $add_connection_number)->where('status', '1')->count();

            if ($find_contact_no > 0) 
            {
                return redirect()->back()->with('error', 'Connection Number has already been taken.');
            }


        // dongle sim number check
            $find_sim_no = asset_dongle_data_tbls::where('dongle_sim_no', $add_sim_number)->where('status', '1')->count();

            if ($find_sim_no > 0) 
            {
                return redirect()->back()->with('error', 'SIM Number has already been taken.');
            }

        // dongle ip address check
            $find_ip_address = asset_dongle_data_tbls::where('dongle_ip_address', $add_ip_address)->where('status', '1')->count();

            if ($find_ip_address > 0) 
            {
                return redirect()->back()->with('error', 'IP Address has already been taken.');
            }

        // dongle IMEI number check
            $find_imei = asset_dongle_data_tbls::where('dongle_ip_address', $add_dongle_imei_no)->where('status', '1')->count();

            if ($find_imei > 0) 
            {
                return redirect()->back()->with('error', 'IMEI number has already been taken.');
            }


        $find_dongle_token = asset_verify_user_token::find($id);
        $dongle_token = $find_dongle_token->dongle_token;
        $user_token = $find_dongle_token->user_token;
        $user_epf_no = $find_dongle_token->user_epf_no;
        $user_name = $find_dongle_token->user_name;
        $company = $find_dongle_token->company;
        
        if ($dongle_token == "") 
        {
            $dongle_token = "DONGLE/".rand(123445678, $date_data);
            $find_dongle_token->dongle_status = 1;
            $find_dongle_token->dongle_token = $dongle_token;
            $find_dongle_token->update();
        }

        $add_dongle= new asset_dongle_data_tbls();
        $add_dongle->dongle_token = $dongle_token;
        $add_dongle->dongle_asset_type = $add_dongle_type;
        $add_dongle->dongle_connection_type = $add_connection_type;
        $add_dongle->dongle_connection_no = $add_connection_number;
        $add_dongle->dongle_sim_no = $add_sim_number;
        $add_dongle->dongle_ip_address = $add_ip_address;
        $add_dongle->dongle_modal = $add_dongle_modal;
        $add_dongle->dongle_imei_no = $add_dongle_imei_no;
        $add_dongle->save();


        $add_followup = new asset_dongle_followup_tbl();
        $add_followup->current_user_token = $user_token;
        $add_followup->current_user_epf = $user_epf_no;
        $add_followup->current_user_name = $user_name;
        $add_followup->current_user_company = $company;
        $add_followup->connection_number = $add_connection_number;
        $add_followup->sim_number = $add_sim_number;
        $add_followup->ip_address = $add_ip_address;
        $add_followup->dongle_imei_no = $add_dongle_imei_no;
        $add_followup->reason = "";
        $add_followup->reason_remark = "";
        $add_followup->followup_update_user_id = $added_user_id;
        $add_followup->followup_update_user_name = $added_user;
        $add_followup->status = "Add";
        $add_followup->save();


        return redirect()->back()->with('success', 'Dongle allocation successfully..!');

    }

    public function add_unallocated_dongle_data(Request $request)
    {
        $add_dongle_type_val = $request->add_dongle_type_val;
        $add_unallocate_connection_no = $request->add_unallocate_connection_no;
        $add_unallocate_sim_no = $request->add_unallocate_sim_no;
        $add_unallocate_ipaddress = $request->add_unallocate_ipaddress;
        $add_unallocate_connection_type = $request->add_unallocate_connection_type;
        $add_unallocate_dongle_modal = $request->add_unallocate_dongle_modal;
        $add_unallocate_dongle_imei = $request->add_unallocate_dongle_imei;
        $unallocated_dongle_condition = $request->unallocated_dongle_condition;

        $added_user = Auth::user()->name;
        $added_user_epf_no = Auth::user()->epf_no;
        $added_user_id = Auth::user()->id;

        $errors = [
            'add_dongle_type_val.required' => 'Dongle Type is Required.',
            'add_unallocate_connection_no.required' => 'Connection Number is Required.',
            'add_unallocate_sim_no.required' => 'SIM Number is Required.',
            'add_unallocate_ipaddress.required' => 'IP Address is Required.',
            'add_unallocate_dongle_modal.required' => 'Dongle Modal is Required.',
            'add_unallocate_dongle_imei.required' => 'IMEI Number is Required.',
            'add_unallocate_connection_type.required' => 'Connection type is Required.',
            
            'add_unallocate_connection_no.max' => 'The Connection Number may not be greater than 10 characters.',
            'add_unallocate_connection_no.min' => 'The Connection Number must be at least 9 characters.',
            'add_unallocate_sim_no.max' => 'The SIM Number may not be greater than 22 characters.',
            'add_unallocate_sim_no.min' => 'The SIM Number must be at least 15 characters.',
            'add_unallocate_ipaddress.min' => 'The IP Address must be a valid IPv4 address.',
            'add_unallocate_dongle_imei.max' => 'The IMEI Number may not be greater than 25 characters.',
            'add_unallocate_dongle_imei.min' => 'The IMEI Number must be at least 12 characters.',

            'add_unallocate_connection_no.unique' => 'Connection Number has already been taken.',
            'add_unallocate_sim_no.unique' => 'SIM Number has already been taken.',
            'add_unallocate_ipaddress.unique' => 'IP Address has already been taken.',
            'add_unallocate_dongle_imei.unique' => 'IMEI Number has already been taken.',
          ];

          $this->validate($request, [
            'add_dongle_type_val' => 'required',
            'add_unallocate_connection_no' => 'required|min:8|numeric',
            'add_unallocate_sim_no' => 'required|max:23|min:14',
            'add_unallocate_ipaddress' => 'required|ipv4',
            'add_unallocate_connection_type' => 'required',
            'add_unallocate_dongle_modal' => 'required',
            'unallocated_dongle_condition' => 'required',
            'add_unallocate_dongle_imei' => 'required|max:25|min:12',
        ],$errors);
        
        $add_unallocated_list = new asset_dongle_unallocated_tbl();
        $add_unallocated_list->asset_type = $add_dongle_type_val;
        $add_unallocated_list->connection_number = $add_unallocate_connection_no;
        $add_unallocated_list->sim_no = $add_unallocate_sim_no;
        $add_unallocated_list->ipaddress = $add_unallocate_ipaddress;
        $add_unallocated_list->connection_type = $add_unallocate_connection_type;
        $add_unallocated_list->dongle_modal = $add_unallocate_dongle_modal;
        $add_unallocated_list->dongle_imei = $add_unallocate_dongle_imei;
        $add_unallocated_list->dongle_condition = $unallocated_dongle_condition;
        $add_unallocated_list->resposible_user_id = $added_user_id;
        $add_unallocated_list->resposible_user_epf = $added_user_epf_no;
        $add_unallocated_list->resposible_user_name = $added_user;
        $add_unallocated_list->save();

        return redirect()->back()->with('success', 'Insert dongle details successfully..!');
    }

    public function bulk_dongle_upload(Request $request)
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
            $dongle_data = array(
                'asset_type' => ucwords(trim($datalineSplit[0])),
                'connection_number' => trim($datalineSplit[1]),
                'sim_no' => trim($datalineSplit[2]),
                'ipaddress' => trim($datalineSplit[3]),
                'connection_type' => trim($datalineSplit[4]),
                'dongle_modal' => trim($datalineSplit[5]),
                'dongle_imei' => trim($datalineSplit[6]),
                'dongle_condition' => ucwords(trim($datalineSplit[7])),
                'resposible_user_id' => $added_user_id,
                'resposible_user_epf' => $added_user_epf_no,
                'resposible_user_name' => $added_user,
                'created_at' => $datetime,
                'updated_at' => $datetime
            );
            // print '<pre>';
            // print_r($datalineSplit);
            // print '</pre>';
            asset_dongle_unallocated_tbl::insert($dongle_data);
            }
            $count++;
        }
        
    }

    return redirect()->back()->with('success', 'Dongle details upload successfully..!');
    }

    public function download_dongle_csv_demo()
    {
        $filepath= public_path()."/bulk_csv/Dongle_bulk_upload.zip";
        return response()->download($filepath, 'Dongle_bulk_upload_demo.zip');
    }

    public function dongle_report()
    {
        return Excel::download(new ListExport2, 'dongle_report.xlsx');
    }

    public function allocate_dongle($id)
    {
        $find_unallocated_dongle = asset_dongle_unallocated_tbl::find($id);

        return view('asset.unallocated.allocate_dongle_view')
        ->with('unallocated_dongle', $find_unallocated_dongle);
    }

    public function allcate_dongle_user(Request $request)
    {
        $id = $request->user_id;
        $dongle_type = $request->dongle_type;
        $connection_number = $request->connection_number;
        $connection_type = $request->connection_type;
        $sim_number = $request->sim_number;
        $ipaddress = $request->ipaddress;
        $dongle_modal = $request->dongle_modal;
        $dongle_imei = $request->dongle_imei;

        $added_user = Auth::user()->name;
        $added_user_epf_no = Auth::user()->epf_no;
        $added_user_id = Auth::user()->id;
        $date_data = date('dmYhis');

        // dongle connection number check

        $find_contact_no = asset_dongle_data_tbls::where('dongle_connection_no', $connection_number)->where('status', '1')->count();

        if ($find_contact_no > 0) 
        {
            return response()->json(['error' => 'Connection Number has already been taken.']);
        }


    // dongle sim number check
        $find_sim_no = asset_dongle_data_tbls::where('dongle_sim_no', $sim_number)->where('status', '1')->count();

        if ($find_sim_no > 0) 
        {
            return response()->json(['error' => 'SIM Number has already been taken.']);
        }

    // dongle ip address check
        $find_ip_address = asset_dongle_data_tbls::where('dongle_ip_address', $ipaddress)->where('status', '1')->count();

        if ($find_ip_address > 0) 
        {
            return response()->json(['error' => 'IP Address has already been taken.']);
        }

    // dongle IMEI number check
        $find_imei = asset_dongle_data_tbls::where('dongle_ip_address', $dongle_imei)->where('status', '1')->count();

        if ($find_imei > 0) 
        {
            return response()->json(['error' => 'IMEI number has already been taken.']);
        }

        $find_user = asset_user_tbls::find($id);
        $user_token = $find_user->user_token;
        $id = asset_verify_user_token::where('user_token', $user_token)->where('status', '1')->value('id');

        $find_dongle_token = asset_verify_user_token::find($id);
        $dongle_token = $find_dongle_token->dongle_token;
        $user_token = $find_dongle_token->user_token;
        $user_epf_no = $find_dongle_token->user_epf_no;
        $user_name = $find_dongle_token->user_name;
        $company = $find_dongle_token->company;
        
        if ($dongle_token == "") 
        {
            $dongle_token = "DONGLE/".rand(123445678, $date_data);
            $find_dongle_token->dongle_status = 1;
            $find_dongle_token->dongle_token = $dongle_token;
            $find_dongle_token->update();
        }

        $add_dongle= new asset_dongle_data_tbls();
        $add_dongle->dongle_token = $dongle_token;
        $add_dongle->dongle_asset_type = $dongle_type;
        $add_dongle->dongle_connection_type = $connection_type;
        $add_dongle->dongle_connection_no = $connection_number;
        $add_dongle->dongle_sim_no = $sim_number;
        $add_dongle->dongle_ip_address = $ipaddress;
        $add_dongle->dongle_modal = $dongle_modal;
        $add_dongle->dongle_imei_no = $dongle_imei;
        $add_dongle->save();

        $id = $request->dongle_id;
        $update_unallocated_list = asset_dongle_unallocated_tbl::find($id);
        $update_unallocated_list->status = '0';
        $update_unallocated_list->update();

        $add_followup = new asset_dongle_followup_tbl();
        $add_followup->current_user_token = $user_token;
        $add_followup->current_user_epf = $user_epf_no;
        $add_followup->current_user_name = $user_name;
        $add_followup->current_user_company = $company;
        $add_followup->connection_number = $connection_number;
        $add_followup->sim_number = $sim_number;
        $add_followup->ip_address = $ipaddress;
        $add_followup->dongle_imei_no = $dongle_imei;
        $add_followup->reason = "";
        $add_followup->reason_remark = "";
        $add_followup->followup_update_user_id = $added_user_id;
        $add_followup->followup_update_user_name = $added_user;
        $add_followup->status = "Add";
        $add_followup->save();

        return response()->json(['success' => 'Dongle allocation succeefully..!']);
    }
}
