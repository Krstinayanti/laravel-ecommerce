<?php

namespace App\Http\Controllers;

use DB;
use App\Admin;
use App\Notifications\AdminNotification;
use App\Quotation;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AdminController extends Controller
{
    public function chart()
      {
        $tahun = CARBON::NOW()->format('Y');
        $result = \DB::table('transactions')
                    ->select(DB::raw('DATE_FORMAT(created_at, "%M") as bulan'), DB::raw('COALESCE(SUM(total),0) as pendapatan'))
                    ->groupBy(DB::raw('DATE_FORMAT(created_at, "%M")'))
                    ->where(DB::raw('YEAR(created_at)'),'=', $tahun)
                    ->where('status','success')
                    ->get();
        return response()->json($result);
      }
}
