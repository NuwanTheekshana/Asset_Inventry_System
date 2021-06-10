<?php
namespace App\Exports;
use App\Models\asset_data_tbls;
use App\Models\asset_dongle_data_tbls;
use App\Models\asset_user_tbls;
use App\Models\asset_verify_user_token;
use App\Models\asset_followup_tbl;
use App\Models\asset_unallocated_tbl;
use App\Models\user_followup_tbls;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class ListExport3 implements FromCollection, WithHeadings
{
  public function collection()
  {
    $Request = DB::table('asset_user_tbls')
      ->select('asset_verify_user_tokens.user_epf_no', 'asset_verify_user_tokens.user_name', 'asset_verify_user_tokens.company', 'asset_user_tbls.emplyee_type', 'asset_user_tbls.nic_no', 'asset_user_tbls.designation', 'asset_user_tbls.location', 'asset_user_tbls.email', 'asset_user_tbls.contact_no', 'asset_user_tbls.status')
      ->join('asset_verify_user_tokens', 'asset_verify_user_tokens.user_token', '=', 'asset_user_tbls.user_token')
      ->where('asset_verify_user_tokens.status', '1')
      ->where('asset_user_tbls.status', '1')
      ->orderBy('asset_verify_user_tokens.user_epf_no', 'asc')
      ->get();
      return $Request;
  }

  public function headings(): array
    {
      return [
        'EPF No',
        'User Name',
        'Company',
        'Employee Type',
        'NIC',
        'Designation',
        'Location',
        'Email',
        'Contact No',
        'Status',
      ];

    }

}