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

class ListExport2 implements FromCollection, WithHeadings
{
  public function collection()
  {
    $Request = DB::table('asset_dongle_data_tbls')
      ->select('asset_verify_user_tokens.user_epf_no', 'asset_verify_user_tokens.user_name', 'asset_verify_user_tokens.company', 'asset_dongle_data_tbls.dongle_asset_type', 'asset_dongle_data_tbls.dongle_connection_type', 'asset_dongle_data_tbls.dongle_connection_no', 'asset_dongle_data_tbls.dongle_sim_no', 'asset_dongle_data_tbls.dongle_ip_address', 'asset_dongle_data_tbls.dongle_modal', 'asset_dongle_data_tbls.dongle_imei_no', 'asset_dongle_data_tbls.status')
      ->join('asset_verify_user_tokens', 'asset_verify_user_tokens.dongle_token', '=', 'asset_dongle_data_tbls.dongle_token')
      ->where('asset_verify_user_tokens.status', '1')
      ->where('asset_dongle_data_tbls.status', '1')
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
        'Dongle Asset Type',
        'Dongle Connection Type',
        'Connection No',
        'SIM No',
        'IP Address',
        'Dongle Modal',
        'Dongle IMEI No',
        'Status',
      ];

    }

}