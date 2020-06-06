<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\User;
// use Auth;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use App\Notifications\StatusTransaction;
use App\Transaction;
use Illuminate\Support\Facades\Notification;

class TransaksiController extends Controller
{
    public function index()
    {
        // $user_id = Auth::user()->id;

        $transaksi = DB::table('transactions')

            ->get();

        $transaksi = json_decode($transaksi, true);

        if ($transaksi) {

            foreach ($transaksi as $key) {
                $transaksi_id = $key['id'];
                $transaksi_detail[] = DB::select("SELECT `transaction_id`,`selling_price`,`product_name`,qty,`transaction_details`.created_at,`products`.`id` FROM `transaction_details`
          JOIN `products`
          ON `transaction_details`.`product_id`=`products`.`id`
          WHERE `transaction_id`=$transaksi_id");
            }
        } else {
            echo "tidak ada data transaksi";
        }



        // echo "<pre>";
        // print_r($transaksi);
        // echo "</pre>";
        // echo "<pre>";
        // print_r($transaksi_detail);
        // echo "</pre>";
        return view('transaksi.index', ['transaksi' => $transaksi, 'transaksi_detail' => $transaksi_detail]);
        // return view('transaksi', ['transaksi' => $transaksi,'transaksi_detail' => $transaksi_detail]); //memanggil file edit.blade.php pada folder products dan passing value
    }

    public function updatestatus(Request $request, $id)
    {
        // echo $id;
        // echo $request->status_update;
        DB::table('transactions')
            ->where('id', $id)
            ->update(['status' => $request->status_update]);

        $transaction = Transaction::whereId($id)->first();

        $user = User::whereId($transaction->user_id)->first();

        $notification = Notification::send($user, new StatusTransaction($transaction));

        return redirect('transaksi')->with(['success' => 'Kategori Diperbaharui!']);
    }
}
