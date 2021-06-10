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
use Auth;
use DB;

class ListExport implements FromCollection, WithHeadings
{
  public function collection()
  {
    //   $Request = asset_data_tbls::select('asset_type', 'asset_no', 'asset_serial_no', 'asset_model', 'other_asset_model', 'other_asset_capacity', 'status')->where('Status', '1')->get();
    //   return $Request;

      $Request = DB::table('asset_data_tbls')
      ->select('asset_verify_user_tokens.user_epf_no', 'asset_verify_user_tokens.user_name', 'asset_verify_user_tokens.company', 'asset_data_tbls.asset_type', 'asset_data_tbls.asset_no', 'asset_data_tbls.asset_serial_no', 'asset_data_tbls.asset_model', 'asset_data_tbls.other_asset_model', 'asset_data_tbls.other_asset_capacity', 'asset_data_tbls.status')
      ->join('asset_verify_user_tokens', 'asset_verify_user_tokens.asset_token', '=', 'asset_data_tbls.asset_token')
      ->where('asset_verify_user_tokens.status', '1')
      ->where('asset_data_tbls.status', '1')
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
            'Asset Type',
            'Asset No',
            'Serial No',
            'Asset Model',
            'other_asset_model',
            'other_asset_capacity',
            'status',
        ];
    }
    
}

