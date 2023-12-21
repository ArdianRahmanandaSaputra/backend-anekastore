<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Toko;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Shipment;
use Illuminate\Support\Facades\Auth;
use App\Services\Midtrans\CreateSnapTokenService;
use App\Services\Midtrans\CallbackService;

class CartController extends Controller
{
    private $apiKey = '36878ac22f61b56062bd8beae3e310ac';

    public function getCart(){
        $cart = Cart::where('user_id', Auth::user()->id)->get();
        foreach($cart as $c){
            $c->item = $c->product;
        }

        return response()->json(['cart' => $cart]);
    }

    public function addCart(Request $req){
        $user = Auth::user()->id;

        $cart = new Cart;
        $cart->user_id = $user;
        $cart->product_id = $req->product_id;
        $cart->amount = $req->amount;

        $cart->save();

        return response()->json(['message' => 'cart successfully created']);
    }

    public function addItemCart(Request $req){
        $id = $req->cart_id;
        $cart = Cart::findOrFail($id);

        $cart->amount = (intval($cart->amount) + 1);
        $cart->save();

        return response()->json(['message' => 'cart successfully added by one']);
    }

    public function deleteCart(Request $req){
        $id = $req->cart_id;
        Cart::destroy($id);

        return response()->json(['message' => 'cart successfully deleted']);
    }

    public function deleteItemCart(Request $req){
        $id = $req->cart_id;
        $cart = Cart::findOrFail($id);

        $cart->amount = (intval($cart->amount) - 1);
        $cart->save();

        return response()->json(['message' => 'cart successfully deleted by one']);
    }

    public function updateCart(Request $req){
        $cart = Cart::findOrFail($req->id);

        $cart->amount = $req->amount;
        $cart->save();

        return response()->json(['message' => 'cart successfully updated']);
    }

    public function getCost(Request $req){
        $toko = Toko::first();
        $courier = $req->courier;
        $origin = $toko->city_code;
        $dest = $req->dest;
        $weight = $req->weight;
        $apiKey = $this->apiKey; 

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=" . $origin . "&destination=" . $dest . "&weight=" . $weight . "&courier=" . $courier,
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: " . $apiKey
            ),
        ));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
        $response = curl_exec($curl);
        curl_close($curl);
        $cost = json_decode($response);

        return response()->json(['cost' => $cost->rajaongkir->results]);
    }

    public function makeOrder(Request $req){
        $kurir = $array = explode(" | ", $req->service);
        $order = new Order;
        $order->user_id = $req->user_id;
        $order->status = 'Dalam Proses';
        $order->total = 0;

        foreach($req->order as $o){
            $cart = Cart::findOrFail($o);
            $order->total += (intval($cart->product->price) * intval($cart->amount));
        }
        // return $order->total;
        $order->status_pembayaran = 'PENDING';
        $snapToken = $order->snap_token;
        $order->save();

        $shipment = new Shipment;
        $shipment->price = intval($kurir[2]);
        $shipment->courier = $req->courier;
        $shipment->estimate = $kurir[1];
        $shipment->service = $kurir[0];
        $shipment->order_id = $order->id;
        $shipment->save();

        foreach($req->order as $o){
            $cart = Cart::findOrFail($o);
            $detail = new OrderDetail;
            $detail->order_id = $order->id;
            $detail->product_id = $cart->product_id;
            $detail->amount = $cart->amount;
            $detail->subtotal = (intval($cart->product->price) * intval($cart->amount));
            $detail->save();
        }
        if (is_null($snapToken)) {
            // Jika snap token masih NULL, buat token snap dan simpan ke database

            $midtrans = new CreateSnapTokenService($order);
            $snapToken = $midtrans->getSnapToken();
            // return $snapToken;
            $order->snap_token = $snapToken;
            $order->save();
        }
        return response()->json(['snapToken' => $snapToken, 'order' => $order, 'client_key' => config('midtrans.client_key'), 'server_key' => config('midtrans.server_key')]);
    }

    public function receive(){
        $callback = new CallbackService;
 
        if ($callback->isSignatureKeyVerified()) {
            $notification = $callback->getNotification();
            $order = $callback->getOrder();
 
            if ($callback->isSuccess()) {
                $ord = Order::findOrFail($order->id);
                $ord->status_pembayaran = "SUCCESS"; 
                $ord->save();
            }
 
            if ($callback->isExpire()) {
                Order::where('id', $order->id)->update([
                    'status_pembayaran' => 'EXPIRED',
                ]);
            }
 
            if ($callback->isCancelled()) {
                Invoice::where('id', $order->id)->update([
                    'status_pembayaran' => 'CANCEL',
                ]);
            }
 
            return response()
                ->json([
                    'success' => true,
                    'message' => 'Notifikasi berhasil diproses',
                ]);
        } else {
            return response()
                ->json([
                    'error' => true,
                    'message' => 'Signature key tidak terverifikasi',
                ], 403);
        }
    }
}
