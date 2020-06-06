<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Notifications\BuktiPembayaran;
use App\Notifications\ReviewProducts;
use Illuminate\Http\Request;
use DB;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;

class ProfilController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;

        $transaksi = DB::table('transactions')
                    ->where('user_id','=',$user_id)
                    ->get();


        $transaksi = json_decode($transaksi,true)  ;

        if ($transaksi) {

          foreach ($transaksi as $key) {
          $transaksi_id = $key['id'];
          $transaksi_detail[]=DB::select("SELECT `products`.`id`,`transaction_id`,`selling_price`,`product_name`,qty,`transaction_details`.created_at FROM `transaction_details`
          JOIN `products`
          ON `transaction_details`.`product_id`=`products`.`id`
          WHERE `transaction_id`=$transaksi_id") ;
          }



        }
        else{
          echo "tidak ada data transaksi";
        }



        // echo "<pre>";
        // print_r($transaksi);
        // echo "</pre>";
        // echo "<pre>";
        // print_r($transaksi_detail);
        // echo "</pre>";
        return view('profil/lihat', ['transaksi' => $transaksi,'transaksi_detail' => $transaksi_detail]); //memanggil file edit.blade.php pada folder products dan passing value
    }
    public function cancel(Request $request,$id)
    {
      // echo $id;
      DB::table('transactions')
          ->where('id', $id)
          ->update(['status' => 'canceled']);
      return redirect('profil')->with(['success' => 'Kategori Diperbaharui!']);
    }
    public function buktibayar(Request $request)
    {
      // echo $id;
      //                 ]);
      $file = $request->file('gambarbuktibayar');
      $transaksi_id = $request->transaksi_id;

      $filename = time() .'.' . $file->getClientOriginalExtension();

      $file->storeAs('public/buktibayar/', $filename);
      DB::table('transactions')
          ->where('id', $transaksi_id)
          ->update(['proof_of_payment' => $filename]);

        Notification::send(Admin::whereId(1)->first(), new BuktiPembayaran());

      return redirect('profil')->with(['success' => 'Kategori Diperbaharui!']);
    }
    public function review(Request $request)
    {
      $user_id = Auth::user()->id;
      DB::table('product_reviews')->insert([

          'product_id' => $request->product_id,
          'user_id' => $user_id,
          'rate' => $request->rate,
          'content' => $request->review

      ]);

      Notification::send(Admin::whereId(1)->first(), new ReviewProducts());

        return redirect('produkdetail/'.$request->product_id)->with(['success' => 'Kategori Diperbaharui!']);
    }





}
