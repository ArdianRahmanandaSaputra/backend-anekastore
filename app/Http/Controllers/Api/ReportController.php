<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class ReportController extends Controller
{
    public function generate(Request $request){
        // Ambil data pesanan berdasarkan rentang tanggal dan sertakan relasi orderdetails dan shipment
        $orders = Order::whereBetween('created_at', [$request->start, $request->end . ' 23:59:59'])
                ->with(['orderdetails', 'shipment'])
                ->where('status_pembayaran', 'SUCCESS')
                ->get();

        // Hitung total penjualan
        $totalSales = $orders->sum('total');

        // Hitung total ongkos kirim menggunakan kolom 'price' dari tabel shipments
        $totalShippingCost = $orders->sum(function($order) {
            return $order->shipment ? $order->shipment->price : 0;
        });

        // Kurangi total penjualan dengan total ongkos kirim
        $netSales = $totalSales - $totalShippingCost;

        // Hitung jumlah pesanan
        $totalOrders = $orders->count();

        // Kembalikan data dalam respons
    return response()->json([
        'total_sales' => $netSales,
        'total_orders' => $totalOrders,
        'orders' => $orders,
    ]);

    }

}
