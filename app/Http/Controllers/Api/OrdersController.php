<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Shipment;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    public function index(){
        $orders = Order::where('status_pembayaran', 'SUCCESS')->get();

        foreach($orders as $o){
            $orders->customer = $o->user;
        }

        return response()->json(['orders' => $orders]);
    }

    public function view($id){
        $order = Order::with('shipment')->findOrFail($id);

        $order->customer = $order->user;
        $order->user_detail = $order->user->detail;

        $productArr = array();
        foreach($order->orderdetails as $d){
            array_push($productArr, array('amount' => $d->amount, 'item' => $d->product));
        }
        $order->product = $productArr;

        $order->pengiriman = $order->shipment;

        return response()->json(['order' => $order]);
    }

    public function update(Request $req){
        $order_id = $req->id;
        $status = $req->status;
        $resi = $req->resi;

        $order = Order::findOrFail($order_id);

        $order->status = $status;
        $order->save();

        $shipment = Shipment::where('order_id', $order_id)->first();
        $shipment->resi = $resi;
        $shipment->save();

        return response()->json(['message' => 'order successfully updated']);
    }

    public function orderByCustomer(){
        $user = Auth::user()->id;

        $order = Order::where('user_id', $user)->get();
        $orderDetail = [];
        foreach($order as $d){
            foreach($d->orderdetails as $od){
                $od->product_detail = $od->product;
                array_push($orderDetail, $od);
            }
        }
        $order->detail = $orderDetail;

        return response()->json(['order' => $order]);
    }
}
