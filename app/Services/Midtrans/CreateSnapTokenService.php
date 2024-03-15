<?php
 
namespace App\Services\Midtrans;
 
use Midtrans\Snap;
 
class CreateSnapTokenService extends Midtrans
{
    protected $order;
 
    public function __construct($order)
    {
        parent::__construct();
 
        $this->order = $order;
    }
 
    public function getSnapToken()
    {
        $stringAwal = 'abc';
        $stringHasil = $stringAwal . substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 3);
        
        $item_details = array();
        foreach($this->order->orderdetails as $d){
            array_push($item_details, array(
                'id' => $d->id,
                'price' => $d->product_price,
                'quantity' => $d->amount,
                'name' => $d->product->name,
            ));
        }
        array_push($item_details, array(
            'id' => "SHP-" . $this->order->shipment->id,
            'price' => $this->order->shipment->price,
            'quantity' => 1,
            'name' => $this->order->shipment->courier . "-" . $this->order->shipment->service,
        ));
        $params = [
            'transaction_details' => [
                'order_id' => $this->order->id,
                'gross_amount' => intval($this->order->total) + intval($this->order->shipment->price),
            ],
            'item_details' => $item_details,
            'customer_details' => [
                'first_name' => $this->order->user->name,
                'email' => $this->order->user->email,
                'phone' => $this->order->user->detail->phone,
            ]
        ];
        // return $params;
 
        $snapToken = Snap::getSnapToken($params);
 
        return $snapToken;
    }
}