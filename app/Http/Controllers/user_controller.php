<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\asset_user_tbls;
use App\Models\asset_verify_user_token;
use App\Models\user_followup_tbls;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ListExport3;
use Auth;
use DB;
use Hash;

class user_controller extends Controller
{
    public function add_new()
    {
        return view('asset.add_user');
    }

    public function all_user()
    {
        $all_user_data = User::where('status', '1')->get();
        return view('auth.all_user')->with('all_user_data', $all_user_data);
    }

    public function employee_validation(Request $request)
    {
        $company = $request->compy_type;
        $emp_type = $request->emp_type;
        $epf = $request->epfno;

            $epf = sprintf('%06d', $epf);

            $postData = array
            (
            "EmployeeNo"=> $epf,
            "Company"=> $company,
            "EmailAddress"=> "",
            "Branch"=> ""
            );
      
            $postData = json_encode($postData); 
            $host="http://192.168.10.54:8087/api/ProposalAssign/GetActiveDirectoryDetails";
            $ch = curl_init($host);
            $username = "MOBILE_APP";
            $password = "SRILANKA";
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            //curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            $return = curl_exec($ch);
            curl_close($ch);
      
            $result=json_decode($return,true);
            return response()->json(['success'=>'Get User Data..!', 'emp_details' => $result]);
    }

    public function employee_details_validation(Request $request)
    {
        $company = $request->compy_type;
        $emp_type = $request->emp_type;
        $epf = $request->epfno;

        $find_user_count = asset_verify_user_token::where('user_epf_no', $epf)->where('company', $company)->count();

        if ($find_user_count > 0) 
        {
            $already_added_user = "User details already exists..!";
        }
        else
        {
            $already_added_user = "";
        }

        return response()->json(['success'=>'Get User Data..!', 'already_added_user' => $already_added_user, 'find_user_count' => $find_user_count]);
    }

    public function deactivate_user_account(Request $request)
    {
        $id = $request->deactivate_id;
        $deactivate_reason = $request->deactivate_reason;
        $deactivate_remark = $request->deactivate_remark;

        $added_user = Auth::user()->name;
        $added_user_epf_no = Auth::user()->epf_no;
        $added_user_id = Auth::user()->id;

        if ($deactivate_reason == "Other") 
        {
            if ($deactivate_remark == null || $deactivate_remark == "") 
            {
                return redirect()->back()->with('error', 'Deactivation reason required..!');
            }
        }
        else
        {
            if ($deactivate_remark == null || $deactivate_remark == "") 
            {
                $deactivate_remark = "";
            }
        }

        $find_user = asset_verify_user_token::find($id);
        $find_user->status = 0;
        $find_user->update();

        $user_token = $find_user->user_token;
        $epfno_val = $find_user->user_epf_no;
        $fullname = $find_user->user_name;
        $company = $find_user->company;
        $id = asset_user_tbls::where('user_token', $user_token)->value('id');
        $user_status_update = asset_user_tbls::find($id);
        $user_status_update->status = 0;
        $user_status_update->update();

        $user_data = new user_followup_tbls();
        $user_data->current_user_token = $user_token;
        $user_data->current_user_epf = $epfno_val;
        $user_data->current_user_name = $fullname;
        $user_data->current_user_company = $company;
        $user_data->reason = $deactivate_reason;
        $user_data->reason_remark = $deactivate_remark;
        $user_data->followup_update_user_id = $added_user_id;
        $user_data->followup_update_user_name = $added_user;
        $user_data->status = "Remove";
        $user_data->save();


        return redirect()->back()->with('success', 'User deactivation successfully..!');

    }

    public function activate_account(Request $request)
    {
        $id = $request->activate_token_id;
        $added_user = Auth::user()->name;
        $added_user_epf_no = Auth::user()->epf_no;
        $added_user_id = Auth::user()->id;

        $find_user = asset_verify_user_token::find($id);
        $find_user->status = 1;
        $find_user->update();

        $user_token = $find_user->user_token;
        $epfno_val = $find_user->user_epf_no;
        $fullname = $find_user->user_name;
        $company = $find_user->company;
        $id = asset_user_tbls::where('user_token', $user_token)->value('id');
        $user_status_update = asset_user_tbls::find($id);
        $user_status_update->status = 1;
        $user_status_update->update();

        $user_data = new user_followup_tbls();
        $user_data->current_user_token = $user_token;
        $user_data->current_user_epf = $epfno_val;
        $user_data->current_user_name = $fullname;
        $user_data->current_user_company = $company;
        $user_data->reason = "";
        $user_data->reason_remark = "";
        $user_data->followup_update_user_id = $added_user_id;
        $user_data->followup_update_user_name = $added_user;
        $user_data->status = "Activate";
        $user_data->save();

        return redirect()->back()->with('success', 'User Activation successfully..!');

    }

    public function emp_update_details(Request $request)
    {
        $added_user = Auth::user()->name;
        $added_user_epf_no = Auth::user()->epf_no;
        $added_user_id = Auth::user()->id;

        $id = $request->emp_id;
        $epf = $request->epfno_val;
        $full_name = $request->fname;
        $emp_type = $request->emp_type;
        $NIC = $request->NIC;
        $designation = $request->designation;
        $location = $request->location;
        $email = $request->email;
        $company = $request->company;
        $contact_no = $request->contact_no;

        $update_user = asset_user_tbls::find($id);
        $user_token = $update_user->user_token;
        $get_verify_user_id = asset_verify_user_token::where('user_token', $user_token)->value('id');
        $verify_user = asset_verify_user_token::find($get_verify_user_id);
        $verify_user->company = $company;
        $verify_user->nic_no = $NIC;
        $verify_user->update();

        $update_user->epf_no = $epf;
        $update_user->emplyee_type = $emp_type;
        $update_user->nic_no = $NIC;
        $update_user->full_name = $full_name;
        $update_user->designation = $designation;
        $update_user->location = $location;
        $update_user->email = $email;
        $update_user->contact_no = $contact_no;
        $update_user->update();

        $user_data = new user_followup_tbls();
        $user_data->current_user_token = $user_token;
        $user_data->current_user_epf = $epf;
        $user_data->current_user_name = $full_name;
        $user_data->current_user_company = $company;
        $user_data->reason = "";
        $user_data->reason_remark = "";
        $user_data->followup_update_user_id = $added_user_id;
        $user_data->followup_update_user_name = $added_user;
        $user_data->status = "Update";
        $user_data->save();

        return redirect()->back()->with('success', 'Employee details update successfully..!');

    }

    public function user_update_details(Request $request)
    {
        $id = $request->user_id;
        $update_epf = $request->update_epf;
        $update_name = $request->update_name;
        $update_company = $request->update_company;
        $update_department = $request->update_department;
        $update_email = $request->update_email;
        $update_permission = $request->update_permission;

        $update_user = User::find($id);
        $update_user->epf_no = $update_epf;
        $update_user->name = $update_name;
        $update_user->company = $update_company;
        $update_user->department = $update_department;
        $update_user->email  = $update_email;
        $update_user->permission  = $update_permission;
        $update_user->update();

        return redirect()->back()->with('success', 'User details update successfully..!');
    }

    public function remove_users(Request $request)
    {
        $id = $request->remove_users_ids;

        $remove_user = User::find($id);
        $remove_user->status  = 0;
        $remove_user->update();

        return redirect()->back()->with('success', 'User details remove successfully..!');
    }

    public function change_user_password(Request $request)
    {
        $id = $request->id_pass_id;
        $password = $request->password;
        $new_pass = $request->new_pass;
        $confirm_pass = $request->confirm_pass;

        $errors=[ 
            'password.required'=> 'Current password is Required.',
            'new_pass.required'=> 'New Password is Required.',
            'confirm_pass.required'=> 'Confirm Password is Required.',
            ];

        $this->validate($request, [
        'password' => 'required',
        'new_pass' => 'required',
        'confirm_pass' => 'required',
        ],$errors);

        if (Auth::attempt(['id' => $id, 'password' => $password]))
        {}
        else
        {
            return redirect()->back()->with('errors', 'Current password invalid..!');

        }

        if ($new_pass != $confirm_pass) 
        {
            return redirect()->back()->with('errors', 'Two Password Combination..!');
        }

        $password = Hash::make($new_pass);
        $find_user = User::find($id);
        $find_user->password = $password;
        $find_user->update();
        
        return redirect()->back()->with('success', 'User password change successfully..!');
    }

    public function user_report()
    {
        return Excel::download(new ListExport3, 'user_report.xlsx');
    }
}
