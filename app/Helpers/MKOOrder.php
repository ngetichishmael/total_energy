<?php

namespace App\Helpers;

use App\Http\Resources\OrderLineResourceCollection;
use App\Models\Orders;
use App\Models\Order_items;
use Illuminate\Support\Facades\Http;

class MKOOrder
{
    public $request;
    public $order_code;
    public function __invoke($request)
    {
        $this->request = $request;
        $this->order_code = $request->get('orderID');
        Http::withBody($this->encodeData(), 'application/json')
            ->post(env('MKO_BASE_URL') . '/order');
        (new STKPush())($request);
    }
    public function getOrderItems()
    {
        $orderItems = Order_items::where('order_code', $this->order_code)->get();
        return new OrderLineResourceCollection($orderItems);
    }
    public function encodeData(): string
    {
        $order = Orders::with('Customer', 'User')->where('order_code', $this->order_code)->first();
        $data = array(
            "name" => $order->Customer->customer_name,
            "session" => $order->checkin_code,
            "date_order" => $order->updated_at,
            "partner" => $order->Customer->contact_person,
            "salesperson" => $order->User->name,
            "orderlines" => $this->getOrderItems(),
            "payment" => array(
                "payment_date" => now(),
                "mode" => $this->pluckLastPart(),
                "amount" => $this->request->get('amount'),
                "reference" => $this->request->get('transactionID'),
            ),
        );
        return json_encode($data);
    }
    function pluckLastPart()
    {
        $string = $this->request->get('paymentMethod');
        $prefix = "PaymentMethods.";
        if (strpos($string, $prefix) === 0) {
            return substr($string, strlen($prefix));
        } else {
            return $string;
        }
    }
}
