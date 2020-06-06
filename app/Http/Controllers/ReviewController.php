<?php

namespace App\Http\Controllers;

use App\Notifications\ReviewProductUser;
use App\ProductReviews;
use App\User;
use Illuminate\Http\Request;
use DB;
// use Auth;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;

class ReviewController extends Controller
{
    public function index()
    {


        $product_reviews= DB::select("SELECT `product_reviews`.`id`,`product_reviews`.`product_id`,`products`.`product_name`,`product_reviews`.`created_at`,users.`name`,`product_reviews`.`rate`, `product_reviews`.`content` FROM `product_reviews`
            JOIN `products`
            ON `product_reviews`.`product_id`=`products`.`id`
            JOIN users
            ON `product_reviews`.`user_id`=users.`id`"
            );
            $product_response= DB::table('response')->get();

        // $product_reviews = json_decode($product_reviews,true)  ;


        // echo "<pre>";
        // print_r($product_reviews);
        // echo "</pre>";
        // echo "<pre>";
        // print_r($transaksi_detail);
        // echo "</pre>";
        // return view('transaksi.index', ['transaksi' => $transaksi,'transaksi_detail' => $transaksi_detail]);
        return view('review.index', ['product_reviews' => $product_reviews,'product_response' => $product_response]); //memanggil file edit.blade.php pada folder products dan passing value
    }

    public function input(Request $request,$id)
    {
      // echo $id;
      // echo $request->status_update;

      DB::table('response')->insert([

          'review_id' => $id,
          'admin_id' => 1,
          'content' => $request->response

      ]);

      $data = ProductReviews::whereId($id)->first();

      Notification::send(User::whereId($data->user_id)->first(), new ReviewProductUser());

      return redirect('review')->with(['success' => 'Kategori Diperbaharui!']);
    }





}
