<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\peripherals_unallocated_tbl;
use App\Models\peripherals_type_tbl;
use App\Models\peripherals_unallocated_serial_no_tbl;
use Auth;
use DB;

class peripherals_controller extends Controller
{

    public function unallocated_peripherals()
    {
       $peripherals_type = peripherals_type_tbl::where('status', '1')->get();

       $getPeripherals = DB::table('peripherals_unallocated_tbls as u')
                        ->join('peripherals_unallocated_serial_no_tbls as s', 's.unallocated_peripherals_id', '=', 'u.id')
                        ->select('u.*', 's.serial_number', 's.id as serial_id')
                        ->where('u.status', 1)
                        ->where('s.status', 1)
                        ->get();

        return view('asset.unallocated.unallocated_peripherals_view')
        ->with('peripherals_type', $peripherals_type)
        ->with('getPeripherals', $getPeripherals);
    }

    public function allocate_peripheral($id, $serial_id)
    {
        $peripherals_type = peripherals_type_tbl::where('status', '1')->get();

        $getPeripherals = peripherals_unallocated_tbl::find($id);
        $getPeripheralsSerials = peripherals_unallocated_serial_no_tbl::find($serial_id);
          
        return view('asset.unallocated.allocate_pheripheral_view')
        ->with('peripherals_type', $peripherals_type)
        ->with('unallocated_Peripheral', $getPeripherals)
        ->with('unallocated_Peripheral_Serials', $getPeripheralsSerials);
    }

    public function add_peripherals_type(Request $request)
    {
        $errors = [
            'peri_type.required' => 'Peripheral Type is Required.',
          ];

          $this->validate($request, [
            'peri_type' => 'required'
        ],$errors);


        $add_type = new peripherals_type_tbl();
        $add_type->peripheral_type = trim(ucwords($request->peri_type));
        $add_type->create_user_id = Auth::user()->id;
        $add_type->save();

        return redirect()->back()->with('success', 'Peripherals type added successfully..!');
    }

    public function add_peripherals(Request $request)
    {
        $this->validate($request, [
            'add_peripherals_type_val' => 'required|numeric',
            'add_unallocate_unit_price' => 'required|numeric',
            'add_unallocate_supplier' => 'required',
            'add_unallocate_ponumber' => 'required',
            'add_unallocate_received_date' => 'required',
            'add_unallocate_quantity' => 'required',
            'unallocated_peripherals_condition' => 'required',
            'seriallist' => 'required',
        ]);

        $peripheral_type = $request->add_peripherals_type_val;
        $peripherals_unitprice = $request->add_unallocate_unit_price;
        $peripherals_supplier = $request->add_unallocate_supplier;
        $peripherals_ponumber = $request->add_unallocate_ponumber;
        $peripherals_received_date = $request->add_unallocate_received_date;
        $peripherals_quantity = $request->add_unallocate_quantity;
        $peripherals_condition = $request->unallocated_peripherals_condition;
        $peripherals_seriallist = $request->seriallist;
        $added_user = Auth::user()->name;
        $added_user_epf_no = Auth::user()->epf_no;
        $added_user_id = Auth::user()->id;

        $peripheral_name = peripherals_type_tbl::find($peripheral_type);
        $peripheral_name = $peripheral_name->peripheral_type;
        
        $add_peripherals = new peripherals_unallocated_tbl();
        $add_peripherals->peripheral_type_id = $peripheral_type;
        $add_peripherals->peripheral_type = $peripheral_name;
        $add_peripherals->unit_price = $peripherals_unitprice;
        $add_peripherals->supplier_name = $peripherals_supplier;
        $add_peripherals->po_number = $peripherals_ponumber;
        $add_peripherals->received_date = $peripherals_received_date;
        $add_peripherals->quntity = $peripherals_quantity;
        $add_peripherals->pheripherals_condition = $peripherals_condition;
        $add_peripherals->create_user_id = $added_user_id;
        $add_peripherals->create_user_epf = $added_user_epf_no;
        $add_peripherals->create_user_name = $added_user;
        $add_peripherals->save();

        $get_last_peripheral_id = peripherals_unallocated_tbl::max('id');
        

        foreach ($peripherals_seriallist as $key => $value) {
            $add_peripherals_serial = new peripherals_unallocated_serial_no_tbl();
            $add_peripherals_serial->unallocated_peripherals_id = $get_last_peripheral_id;
            $add_peripherals_serial->serial_number = trim($peripherals_seriallist[$key]);
            $add_peripherals_serial->create_user_id = $added_user_id;
            $add_peripherals_serial->save();
        }

        return redirect()->back()->with('success', 'Peripheral details added successfully..!');
    }

    

    public function allcate_Peripheral_user(Request $request)
    {
        $user_id = $request->user_id;
        $Peripheral_id = $request->Peripheral_id;
        $serialnumber_id = $request->serialnumber_id;
        $Peripheral_type = $request->Peripheral_type;
        $serial_number = $request->serial_number;
        $unit_price = $request->unit_price;
        $Supplier = $request->Supplier;
        $ponumber = $request->ponumber;
        $received_date = $request->received_date;
        $peripherals_condition = $request->peripherals_condition;

        $added_user = Auth::user()->name;
        $added_user_epf_no = Auth::user()->epf_no;
        $added_user_id = Auth::user()->id;
        $date_data = date('dmYhis');

        // serial number check

        $find_contact_no = asset_dongle_data_tbls::where('dongle_connection_no', $connection_number)->where('status', '1')->count();

        if ($find_contact_no > 0) 
        {
            return response()->json(['error' => 'Connection Number has already been taken.']);
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
