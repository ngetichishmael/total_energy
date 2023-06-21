<?php

namespace App\Helpers;

use App\Models\Orders;
use Illuminate\Support\Facades\Http;

class STKPush
{
   public $request;
   public $order_code;
   public function __invoke($request)
   {
      $this->request = $request;
      $this->order_code =  $request->get('orderID');
      Http::withBody($this->encodeData(), 'application/json')
         ->post(env('MKO_BASE_URL') . '/stkpush');
   }
   public function encodeData(): string
   {
      $order = Orders::with('Customer', 'User')->where('order_code', $this->order_code)->first();
      $data = array(
         "Amount" => (float) $this->request->get('amount'),
         "PhoneNumber" =>  $order->Customer->phone_number,
         "CallBackURL" => "https://totalenergies.sokoflow.com/",
         "AccountReference" => $this->request->get('transactionID'),
         "TransactionDesc" => $this->request->get('transactionID'),
         "PartyA" => $order->Customer->contact_person,
      );
      return json_encode($data);
   }
}
