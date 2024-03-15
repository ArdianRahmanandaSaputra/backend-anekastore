<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class ReportController extends Controller
{
    public function generate(Request $request){
        //Ambil data pesanan berdasarkan rentang tanggal
        $orders = Order::whereBetween('created_at', [$request->start, $request->end])
                        ->with('orderdetails')
                        ->get();

        // Hitung total penjualan
        $totalSales = $orders->sum('total');

        // Hitung jumlah pesanan
        $totalOrders = $orders->count();

        // Kembalikan data dalam respons
        return response()->json([
            'total_sales' => $totalSales,
            'total_orders' => $totalOrders,
            'orders' => $orders,
        ]);
    }
}
