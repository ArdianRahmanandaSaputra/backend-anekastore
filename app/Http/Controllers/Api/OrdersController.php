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

        $orders = Order::with(['orderdetails', 'shipment'])
                       ->where('user_id', $user)
                       ->orderBy('created_at', 'desc')  // Menambahkan pengurutan descending berdasarkan tanggal pembuatan
                       ->get();

        $formattedOrders = $orders->map(function ($order) {
            $order->detail = $order->orderdetails->map(function ($orderdetail) {
                $orderdetail->product_detail = $orderdetail->product;
                return $orderdetail;
            });
            // Jika ada shipment, tambahkan informasi price ke dalam hasil
            if ($order->shipment) {
                $order->price = $order->shipment->price;
            }
            return $order;
        });

        return response()->json(['order' => $orders]);
    }



    //Tambahan
    public function getOrderCountByCurrentMonth() {
    $currentMonth = date('m');
    $currentYear = date('Y');

    $orderCount = Order::where('status_pembayaran', 'SUCCESS')
        ->whereYear('created_at', $currentYear)
        ->whereMonth('created_at', $currentMonth)
        ->count();

    return response()->json(['order_count' => $orderCount]);
    }

    public function getTotalRevenueByCurrentMonth() {
        $currentMonth = date('m');
        $currentYear = date('Y');

        $totalRevenue = Order::where('status_pembayaran', 'SUCCESS')
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->sum('total');

        $totalShippingCost = Shipment::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->sum('price');

        $netRevenue = $totalRevenue - $totalShippingCost;

        return response()->json([
            'total_revenue' => $totalRevenue,
            'total_shipping_cost' => $totalShippingCost,
            'net_revenue' => $netRevenue
        ]);
    }

    public function getOrderCountByCurrentYear() {
    $currentYear = date('Y');

    $orderCount = Order::where('status_pembayaran', 'SUCCESS')
        ->whereYear('created_at', $currentYear)
        ->count();

    return response()->json(['order_count' => $orderCount]);
    }

    public function getTotalRevenueByCurrentYear() {
        $currentYear = date('Y');

        $totalRevenue = Order::where('status_pembayaran', 'SUCCESS')
            ->whereYear('created_at', $currentYear)
            ->sum('total');

        $totalShippingCost = Shipment::whereYear('created_at', $currentYear)
            ->sum('price');

        $netRevenue = $totalRevenue - $totalShippingCost;

        return response()->json([
            'total_revenue' => $totalRevenue,
            'total_shipping_cost' => $totalShippingCost,
            'net_revenue' => $netRevenue
        ]);
    }
}
