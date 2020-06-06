<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Notifications\NewTransaction;
use Illuminate\Http\Request;
use DB;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Notification;

class CartController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
        // echo "<pre>";
        // print_r($user_id);
        // echo "</pre>";
        $cart = DB::table('carts')
                    ->leftjoin('products', 'products.id','=','carts.product_id')
                    ->leftjoin('discounts','discounts.id_product','=','carts.product_id')
                    ->select('carts.*','product_name', 'price', 'weight','gambar','percentage', 'start', 'end')
                    ->whereRaw(" carts.status IS NULL and carts.user_id ='$user_id' and Date(discounts.start) <= CURDATE() AND Date(discounts.end) >= CURDATE() ")

                    ->get();
        // echo "<pre>";
        // print_r($cart);
        // echo "</pre>";
        // $products_join = DB::table('products')
        //         ->leftjoin('discounts','products.id' ,'=','discounts.id_product')
        //         ->select('products.*', 'discounts.id_product', 'discounts.percentage', 'discounts.start','discounts.end')
        //                   ->whereRaw('Date(discounts.start) <= CURDATE() AND Date(discounts.end) >= CURDATE()')
        //                   ->distinct()
        //         ->get();
        $cart =  DB::select("SELECT
            id,product_name,qty,user_id,product_id,price,weight,percentage
            FROM
            (SELECT c.id,product_name,qty,user_id,product_id,price,weight FROM carts c
            LEFT JOIN products t
            ON c.`product_id`=t.`id`
            WHERE user_id = '$user_id' AND c.status IS NULL) t1

            LEFT JOIN (
            SELECT id_product, percentage,START, END FROM discounts d
            WHERE
            DATE(d.`start`) <= CURDATE() AND DATE(d.`end`) >= CURDATE()) t2
            ON t1.product_id = t2.id_product");
        // echo "<pre>";
        // print_r($products_join);
        // echo "</pre>";

        // $data_products= \App\Products::all();
        $provinsi = $this->get_province();
        return view('cart/lihat', ['cart' => $cart,'provinsi' => $provinsi]); //memanggil file edit.blade.php pada folder products dan passing value
    }
    public function get_kota(Request $request)
    {
        $user_id = Auth::user()->id;
        // echo "<pre>";
        // print_r($user_id);
        // echo "</pre>";
        $cart = DB::table('carts')
                    ->leftjoin('products', 'products.id','=','carts.product_id')
                    ->leftjoin('discounts','discounts.id_product','=','carts.product_id')
                    ->select('carts.*','product_name', 'price', 'weight','gambar','percentage', 'start', 'end')
                    ->whereRaw(" carts.status IS NULL and carts.user_id ='$user_id' and Date(discounts.start) <= CURDATE() AND Date(discounts.end) >= CURDATE() ")

                    ->get();
        // echo "<pre>";
        // print_r($cart);
        // echo "</pre>";
        // $products_join = DB::table('products')
        //         ->leftjoin('discounts','products.id' ,'=','discounts.id_product')
        //         ->select('products.*', 'discounts.id_product', 'discounts.percentage', 'discounts.start','discounts.end')
        //                   ->whereRaw('Date(discounts.start) <= CURDATE() AND Date(discounts.end) >= CURDATE()')
        //                   ->distinct()
        //         ->get();
        $cart =  DB::select("SELECT
            id,product_name,qty,user_id,product_id,price,weight,percentage
            FROM
            (SELECT c.id,product_name,qty,user_id,product_id,price,weight FROM carts c
            LEFT JOIN products t
            ON c.`product_id`=t.`id`
            WHERE user_id = '$user_id' AND c.status IS NULL) t1

            LEFT JOIN (
            SELECT id_product, percentage,START, END FROM discounts d
            WHERE
            DATE(d.`start`) <= CURDATE() AND DATE(d.`end`) >= CURDATE()) t2
            ON t1.product_id = t2.id_product");
        // echo "<pre>";
        // print_r($products_join);
        // echo "</pre>";

        // $data_products= \App\Products::all();
        $idprovinsi = $request->province_id;
        $kota = $this->get_city($idprovinsi);
        // print_r($kota);
        return view('cart/kota', ['cart' => $cart,'kota' => $kota,'idprovinsi'=>$idprovinsi]); //memanggil file edit.blade.php pada folder products dan passing value
    }

    public function ongkir(Request $request)
    {
        $user_id = Auth::user()->id;
        // echo "<pre>";
        // print_r($user_id);
        // echo "</pre>";
        $cart = DB::table('carts')
                    ->leftjoin('products', 'products.id','=','carts.product_id')
                    ->leftjoin('discounts','discounts.id_product','=','carts.product_id')
                    ->select('carts.*','product_name', 'price', 'weight','gambar','percentage', 'start', 'end')
                    ->whereRaw(" carts.status IS NULL and carts.user_id ='$user_id' and Date(discounts.start) <= CURDATE() AND Date(discounts.end) >= CURDATE() ")

                    ->get();
        // echo "<pre>";
        // print_r($cart);
        // echo "</pre>";
        // $products_join = DB::table('products')
        //         ->leftjoin('discounts','products.id' ,'=','discounts.id_product')
        //         ->select('products.*', 'discounts.id_product', 'discounts.percentage', 'discounts.start','discounts.end')
        //                   ->whereRaw('Date(discounts.start) <= CURDATE() AND Date(discounts.end) >= CURDATE()')
        //                   ->distinct()
        //         ->get();
        $cart =  DB::select("SELECT
            id,product_name,qty,user_id,product_id,price,weight,percentage
            FROM
            (SELECT c.id,product_name,qty,user_id,product_id,price,weight FROM carts c
            LEFT JOIN products t
            ON c.`product_id`=t.`id`
            WHERE user_id = '$user_id' AND c.status IS NULL) t1

            LEFT JOIN (
            SELECT id_product, percentage,START, END FROM discounts d
            WHERE
            DATE(d.`start`) <= CURDATE() AND DATE(d.`end`) >= CURDATE()) t2
            ON t1.product_id = t2.id_product");
        // echo "<pre>";
        // print_r($products_join);
        // echo "</pre>";

        // $data_products= \App\Products::all();
        $idprovinsi = $request->province_id;
        $kota = $this->get_city($idprovinsi);
        print_r($kota);
        return view('cart/kota', ['cart' => $cart,'kota' => $kota,'idprovinsi'=>$idprovinsi]); //memanggil file edit.blade.php pada folder products dan passing value
    }
    public function cekongkir(Request $request)
    {
        $user_id = Auth::user()->id;
        // echo "<pre>";
        // print_r($user_id);
        // echo "</pre>";
        $cart = DB::table('carts')
                    ->leftjoin('products', 'products.id','=','carts.product_id')
                    ->leftjoin('discounts','discounts.id_product','=','carts.product_id')
                    ->select('carts.*','product_name', 'price', 'weight','gambar','percentage', 'start', 'end')
                    ->whereRaw(" carts.status IS NULL and carts.user_id ='$user_id' and Date(discounts.start) <= CURDATE() AND Date(discounts.end) >= CURDATE() ")

                    ->get();
        // echo "<pre>";
        // print_r($cart);
        // echo "</pre>";
        // $products_join = DB::table('products')
        //         ->leftjoin('discounts','products.id' ,'=','discounts.id_product')
        //         ->select('products.*', 'discounts.id_product', 'discounts.percentage', 'discounts.start','discounts.end')
        //                   ->whereRaw('Date(discounts.start) <= CURDATE() AND Date(discounts.end) >= CURDATE()')
        //                   ->distinct()
        //         ->get();
        $cart =  DB::select("SELECT
            id,product_name,qty,user_id,product_id,price,weight,percentage
            FROM
            (SELECT c.id,product_name,qty,user_id,product_id,price,weight FROM carts c
            LEFT JOIN products t
            ON c.`product_id`=t.`id`
            WHERE user_id = '$user_id' AND c.status IS NULL) t1

            LEFT JOIN (
            SELECT id_product, percentage,START, END FROM discounts d
            WHERE
            DATE(d.`start`) <= CURDATE() AND DATE(d.`end`) >= CURDATE()) t2
            ON t1.product_id = t2.id_product");
        // echo "<pre>";
        // print_r($products_join);
        // echo "</pre>";

        // $data_products= \App\Products::all();
        // $provinsi = $this->get_province();

        $ongkir= $this->get_ongkir($request->kota_id,$request->weight,$request->kurir_id);
// echo "<pre>";
        // print_r($ongkir);
        // echo "</pre>";
        return view('cart/pilihkurir', ['cart' => $cart,'ongkir' => $ongkir]); //memanggil file edit.blade.php pada folder products dan passing value
    }
    public function detail(Request $request)
    {
        $user_id = Auth::user()->id;
        // echo "<pre>";
        // print_r($user_id);
        // echo "</pre>";
        $cart = DB::table('carts')
                    ->leftjoin('products', 'products.id','=','carts.product_id')
                    ->leftjoin('discounts','discounts.id_product','=','carts.product_id')
                    ->select('carts.*','product_name', 'price', 'weight','gambar','percentage', 'start', 'end')
                    ->whereRaw(" carts.status IS NULL and carts.user_id ='$user_id' and Date(discounts.start) <= CURDATE() AND Date(discounts.end) >= CURDATE() ")

                    ->get();
        // echo "<pre>";
        // print_r($cart);
        // echo "</pre>";
        // $products_join = DB::table('products')
        //         ->leftjoin('discounts','products.id' ,'=','discounts.id_product')
        //         ->select('products.*', 'discounts.id_product', 'discounts.percentage', 'discounts.start','discounts.end')
        //                   ->whereRaw('Date(discounts.start) <= CURDATE() AND Date(discounts.end) >= CURDATE()')
        //                   ->distinct()
        //         ->get();
        $cart =  DB::select("SELECT
            id,product_name,qty,user_id,product_id,price,weight,percentage
            FROM
            (SELECT c.id,product_name,qty,user_id,product_id,price,weight FROM carts c
            LEFT JOIN products t
            ON c.`product_id`=t.`id`
            WHERE user_id = '$user_id' AND c.status IS NULL) t1

            LEFT JOIN (
            SELECT id_product, percentage,START, END FROM discounts d
            WHERE
            DATE(d.`start`) <= CURDATE() AND DATE(d.`end`) >= CURDATE()) t2
            ON t1.product_id = t2.id_product");
        // echo "<pre>";
        // print_r($products_join);
        // echo "</pre>";

        // $data_products= \App\Products::all();
        // $provinsi = $this->get_province();
//
        // $ongkir= $this->get_ongkir($request->kota_id,$request->weight,$request->kurir_id);
// echo "<pre>";
//         print_r($ongkir);
//         echo "</pre>";
        $data['kurir_id'] = $request->kurir_id;
        $data['province'] = $request->province;
        $data['regency']  = $request->regency;
        $data['shipping_cost']  = $request->ongkir;
        $data['total_belanja']  = $request->totalbelanja;
        $data['sub_total']  = $request->ongkir +$request->totalbelanja;
        // print_r($data);
        return view('cart/detail', ['cart' => $cart,'data' => $data]); //memanggil file edit.blade.php pada folder products dan passing value
    }
    public function proses(Request $request)
    {
        $user_id = Auth::user()->id;
        // echo "<pre>";
        // print_r($user_id);
        // echo "</pre>";
        $cart = DB::table('carts')
                    ->leftjoin('products', 'products.id','=','carts.product_id')
                    ->leftjoin('discounts','discounts.id_product','=','carts.product_id')
                    ->select('carts.*','product_name', 'price', 'weight','gambar','percentage', 'start', 'end')
                    ->whereRaw(" carts.status IS NULL and carts.user_id ='$user_id' and Date(discounts.start) <= CURDATE() AND Date(discounts.end) >= CURDATE() ")

                    ->get();
        // echo "<pre>";
        // print_r($cart);
        // echo "</pre>";
        // $products_join = DB::table('products')
        //         ->leftjoin('discounts','products.id' ,'=','discounts.id_product')
        //         ->select('products.*', 'discounts.id_product', 'discounts.percentage', 'discounts.start','discounts.end')
        //                   ->whereRaw('Date(discounts.start) <= CURDATE() AND Date(discounts.end) >= CURDATE()')
        //                   ->distinct()
        //         ->get();
        $cart =  DB::select("SELECT
            id,product_name,qty,user_id,product_id,price,weight,percentage
            FROM
            (SELECT c.id,product_name,qty,user_id,product_id,price,weight FROM carts c
            LEFT JOIN products t
            ON c.`product_id`=t.`id`
            WHERE user_id = '$user_id' AND c.status IS NULL) t1

            LEFT JOIN (
            SELECT id_product, percentage,START, END FROM discounts d
            WHERE
            DATE(d.`start`) <= CURDATE() AND DATE(d.`end`) >= CURDATE()) t2
            ON t1.product_id = t2.id_product");
        // echo "<pre>";
        // print_r($products_join);
        // echo "</pre>";

        // $data_products= \App\Products::all();
        // $provinsi = $this->get_province();
//
        // $ongkir= $this->get_ongkir($request->kota_id,$request->weight,$request->kurir_id);
// echo "<pre>";
//         print_r($ongkir);
//         echo "</pre>";
        // $data['kurir_id'] = $request->kurir_id;
        $data['weight'] = $request->weight;
        $data['timeout'] = date("Y-m-d", ($tomorrow_timestamp = strtotime("+ 1 day")));
        $data['courier_id'] = $request->courier_id;
        $data['address'] = $request->address;
        $data['province'] = $request->province_name;
        $data['regency']  = $request->regency_name;
        $data['shipping_cost']  = $request->ongkir;
        $data['total']  = $request->totalbelanja;
        $data['user_id'] = $user_id;
        $data['status'] = 'unverified';
        $data['sub_total']  = ($request->ongkir + $request->totalbelanja);
        // print_r($data);
        $id_transaction = DB::table('transactions')->insertGetId([
            'timeout' => $data['timeout'],
            'address' => $data['address'],
            'regency' => $data['regency'],
            'province' => $data['province'],
            'total' => $data['total'],
            'shipping_cost' => $data['shipping_cost'],
            'sub_total' => $data['sub_total'],
            'user_id' =>   $data['user_id'],
            'courier_id' => $data['courier_id'],
            'status' => $data['status']
        ]);

        Notification::send(Admin::whereId(1)->first(), new NewTransaction());
        // $id_transaction=5;
        // echo "<pre>";
        // print_r($cart);
        // echo "</pre>";

        foreach ($cart as $key) {
          $percentage=0;
          DB::table('transaction_details')->insert([
              'transaction_id' => $id_transaction,
              'product_id' => $key->product_id,
              'qty' => $key->qty,
              'discount' => $percentage +=$key->percentage,
              'selling_price' => $key->price

          ]);
          }

          $products = DB::table('products')->where('id','=','$key->product_id')->get();
          // $id_transaction=5;
          echo "<pre>";
          print_r($products);
          echo "</pre>";

          foreach ($cart as $key) {
            $products = DB::table('products')->where('id','=',$key->product_id)->get();
            $products = json_decode($products, true);
            // echo $products[0]['id'];
            // echo '<br>';
            // echo $products[0]['stock'];
            // echo '<br>';
            $sisa_stok=$products[0]['stock']-$key->qty;
            DB::table('products')
                ->where('id', $key->product_id)
                ->update(['stock' => $sisa_stok]);
          }
          foreach ($cart as $key) {

            DB::table('carts')
                ->where('id', $key->id)
                ->update(['status' => 'checkedout']);
          }

        return redirect('profil')->with(['success' => 'Kategori Diperbaharui!']);
    }
    public function tambah(Request $request) //Membuat function untuk create data pada tabel products
    {
        // echo "string tambah";
        // print_r($request);


        DB::table('carts')->insert([



            'user_id' => $request->user_id,
            'product_id' => $request->product_id,

            'qty' => $request->qty

        ]);

      return redirect('/cart')->with('sukses','Data berhasil dimasukkan');
        //with ini berarti untuk menambahkan pesan sukses
    }

    // public function lihat($id)
    // {
    //     $products = \App\Products::find($id); //ini berarti mengambil id dan disimpan pada variabel products
    //     $product_detail = DB::table('products')
    //                     ->leftjoin('discounts','products.id' ,'=','discounts.id_product')
    //                     ->leftjoin('product_category_details','products.id' ,'=','product_category_details.product_id')
    //                     ->leftjoin('categories','product_category_details.category_id' ,'=','categories.id')
    //                     ->select('products.*', 'discounts.id_product', 'discounts.percentage', 'discounts.start','discounts.end','categories.category_name')
    //                     ->where('products.id','=',$id)
    //
    //
    //                     ->get();
    //     return view('products/lihat', ['products' => $products,'products_detail' => $product_detail]); //memanggil file edit.blade.php pada folder products dan passing value
    // }

    public function delete($id)
    {
        $cart =DB::select("delete from carts where id = '$id'");

        return redirect('/cart')->with('sukses','Data berhasil dimasukkan');
    }


    public function get_province(){
      $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_SSL_VERIFYHOST => 0,
  CURLOPT_SSL_VERIFYPEER => 0,
  CURLOPT_HTTPHEADER => array(
    "key: 3bb143b5f604f0429540f87d5501e4a7"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
echo "cURL Error #:" . $err;
} else {
//ini kita decode data nya terlebih dahulu
$response=json_decode($response,true);
//ini untuk mengambil data provinsi yang ada di dalam rajaongkir resul
$data_pengirim = $response['rajaongkir']['results'];
return $data_pengirim;
}
    }
    public function get_ongkir($kota_id,$weight,$kurir){
      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_POSTFIELDS => "origin=128&destination=$kota_id&weight=$weight&courier=$kurir",
        CURLOPT_HTTPHEADER => array(
          "content-type: application/x-www-form-urlencoded",
          "key: 3bb143b5f604f0429540f87d5501e4a7"
        ),
      ));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
echo "cURL Error #:" . $err;
} else {
//ini kita decode data nya terlebih dahulu
$response=json_decode($response,true);
//ini untuk mengambil data provinsi yang ada di dalam rajaongkir resul
// $data_pengirim = $response['rajaongkir']['results'];
$data_pengirim = $response['rajaongkir'];
return $data_pengirim;
// return $response;
}
    }
    public function get_city($id){
      $curl = curl_init();
    $getid=$id;
    // $url ="https://api.rajaongkir.com/starter/city?&province=".$getid ;
    // print_r($url);
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.rajaongkir.com/starter/city?&province=$id",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_SSL_VERIFYHOST => 0,
  CURLOPT_SSL_VERIFYPEER => 0,
  CURLOPT_HTTPHEADER => array(
    "key: 3bb143b5f604f0429540f87d5501e4a7"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
echo "cURL Error #:" . $err;
} else {
$response=json_decode($response,true);
// print_r($response);
$data_kota = $response['rajaongkir']['results'];
return $data_kota;
}
    }



}
