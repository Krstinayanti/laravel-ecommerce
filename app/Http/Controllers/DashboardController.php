<?php

namespace App\Http\Controllers;

use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index ()
    {
        $tahun = Carbon::NOW()->format('Y');
        $reportBulanan = Transaction::
        select(DB::raw('DATE_FORMAT(created_at, "%M") as bulan'), DB::raw('COALESCE(SUM(total),0) as pendapatan'))
            ->groupBy(DB::raw('DATE_FORMAT(created_at, "%M")'))
            ->where(DB::raw('YEAR(created_at)'),'=', $tahun)
            ->where('status','success')
            ->get();

        $reportTahunan = Transaction::
        select(DB::raw('YEAR(created_at) as tahun'), DB::raw('COALESCE(SUM(total),0) as pendapatan'))
            ->groupBy(DB::raw('YEAR(created_at)'))
            ->where('status','success')
            ->get();
        return view('dashboards.index',compact("reportBulanan","reportTahunan"));
    }
}
