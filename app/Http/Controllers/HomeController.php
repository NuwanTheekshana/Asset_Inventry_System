<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\asset_data_tbls;
use App\Models\asset_dongle_data_tbls;
use App\Models\asset_user_tbls;
use App\Models\asset_verify_user_token;
use App\Models\asset_followup_tbl;
use App\Models\asset_unallocated_tbl;
use App\Models\user_followup_tbls;
use App\Models\asset_dongle_followup_tbl;
use App\Models\asset_dongle_unallocated_tbl;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // unallocated asset
        $total_unallocated_asset = asset_unallocated_tbl::where('status', '1')->count();
        $good_unallocated_asset = asset_unallocated_tbl::where('status', '1')->where('asset_condition', 'Good')->count();
        $medium_unallocated_asset = asset_unallocated_tbl::where('status', '1')->where('asset_condition', 'Medium')->count();
        $poor_unallocated_asset = asset_unallocated_tbl::where('status', '1')->where('asset_condition', 'Poor')->count();
        $none_unallocated_asset = asset_unallocated_tbl::where('status', '1')->where('asset_condition', 'None')->count();

        // unallocated dongle
        $total_unallocated_dongle = asset_dongle_unallocated_tbl::where('status', '1')->count();
        $good_unallocated_dongle = asset_dongle_unallocated_tbl::where('status', '1')->where('dongle_condition', 'Good')->count();
        $medium_unallocated_dongle = asset_dongle_unallocated_tbl::where('status', '1')->where('dongle_condition', 'Medium')->count();
        $poor_unallocated_dongle = asset_dongle_unallocated_tbl::where('status', '1')->where('dongle_condition', 'Poor')->count();
        $none_unallocated_dongle = asset_dongle_unallocated_tbl::where('status', '1')->where('dongle_condition', 'None')->count();

        $unallocated_data = [
            'total_unallocated_asset' => $total_unallocated_asset,
            'good_unallocated_asset' => $good_unallocated_asset,
            'medium_unallocated_asset' => $medium_unallocated_asset,
            'poor_unallocated_asset' => $poor_unallocated_asset,
            'none_unallocated_asset' => $none_unallocated_asset,
            'total_unallocated_dongle' => $total_unallocated_dongle,
            'good_unallocated_dongle' => $good_unallocated_dongle,
            'medium_unallocated_dongle' => $medium_unallocated_dongle,
            'poor_unallocated_dongle' => $poor_unallocated_dongle,
            'none_unallocated_dongle' => $none_unallocated_dongle
        ];

        $main_asset_followup =asset_followup_tbl::whereIn('status', ['Add', 'New'])->whereMonth('created_at', '=', date('m'))->whereYear('created_at', '=', date('Y'))->count();
        $other_asset_followup =asset_followup_tbl::whereIn('status', ['Add', 'New'])->whereIn('asset_type', ['Pen Drive', 'External Hard Drive'])->whereMonth('created_at', '=', date('m'))->whereYear('created_at', '=', date('Y'))->count();
        $dongle_asset_followup =asset_dongle_followup_tbl::whereIn('status', ['Add', 'New'])->whereMonth('created_at', '=', date('m'))->whereYear('created_at', '=', date('Y'))->count();
        
        $dongle_week_followup_hnba = asset_dongle_followup_tbl::whereIn('status', ['Add', 'New'])
                                ->where('current_user_company', 'HNBA')
                                ->where('created_at', '>', Carbon::now()->startOfWeek())
                                ->where('created_at', '<', Carbon::now()->endOfWeek())
                                ->count();
        $dongle_week_followup_hnbgi = asset_dongle_followup_tbl::whereIn('status', ['Add', 'New'])
                                ->where('current_user_company', 'HNBGI')
                                ->where('created_at', '>', Carbon::now()->startOfWeek())
                                ->where('created_at', '<', Carbon::now()->endOfWeek())
                                ->count();
        
        //dd($dongle_week_followup_hnbgi);
        $asset_data = [
            'main_asset_followup' => $main_asset_followup,
            'other_asset_followup' => $other_asset_followup,
            'dongle_asset_followup' => $dongle_asset_followup,
            'dongle_week_followup_hnba' => $dongle_week_followup_hnba,
            'dongle_week_followup_hnbgi' => $dongle_week_followup_hnbgi,
        ];

        //dd($asset_data);
        return view('home')
        ->with('asset_data', $asset_data)
        ->with('unallocated_data', $unallocated_data);
    }
}
