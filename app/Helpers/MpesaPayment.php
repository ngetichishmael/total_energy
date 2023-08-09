<?php

namespace App\Helpers;

use App\Helpers\Mpesa;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MpesaPayment
{
    /**
     * @param $phone
     * @param $amount
     * @param $callback
     * @param $account_number
     * @param $remarks
     * @return array
     */
    public function stkPush(
        $phone,
        $amount,
        $callback,
        $account_number,
        $remarks
    ) {
        $url = Mpesa::oxerus_mpesaGetStkPushUrl();
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer ' . Mpesa::oxerus_mpesaGenerateAccessToken()));
        $curl_post_data = [
            'BusinessShortCode' => config('services.mpesa.business_shortcode'),
            'Password' => Mpesa::oxerus_mpesaLipaNaMpesaPassword(),
            'Timestamp' => Carbon::now()->format('YmdHis'),
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $amount,
            'PartyA' => $phone,
            'PartyB' => config('services.mpesa.business_shortcode'),
            'PhoneNumber' => $phone,
            'CallBackURL' => $callback,
            'AccountReference' => $account_number,
            'TransactionDesc' => $remarks,
        ];
        info("MPESA PAYMENT Helper Phone Number");
        info($phone);
        $data_string = json_encode($curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        $curl_response = curl_exec($curl);
        $responseObj = json_decode($curl_response);
        info("MPESA PAYMENT Helper");
        info(json_encode($responseObj));
        $response_details = [
            "merchant_request_id" => $responseObj->MerchantRequestID ?? null,
            "checkout_request_id" => $responseObj->CheckoutRequestID ?? null,
            "response_code" => $responseObj->ResponseCode ?? null,
            "response_desc" => $responseObj->ResponseDescription ?? null,
            "customer_msg" => $responseObj->CustomerMessage ?? null,
            "phone" => $phone,
            "amount" => $amount,
            "remarks" => $remarks,
        ];

        return $response_details;
    }

    /**
     * @param Request $request
     */
    public function stkPushCallback(Request $request)
    {
        $callbackJSONData = file_get_contents('php://input');
        $callbackData = json_decode($callbackJSONData);

        info($callbackJSONData);

        $result_code = $callbackData->Body->stkCallback->ResultCode;
        // $result_desc = $callbackData->Body->stkCallback->ResultDesc;
        $merchant_request_id = $callbackData->Body->stkCallback->MerchantRequestID;
        $checkout_request_id = $callbackData->Body->stkCallback->CheckoutRequestID;
        $amount = $callbackData->Body->stkCallback->CallbackMetadata->Item[0]->Value;
        $mpesa_receipt_number = $callbackData->Body->stkCallback->CallbackMetadata->Item[1]->Value;
        // $transaction_date = $callbackData->Body->stkCallback->CallbackMetadata->Item[3]->Value;
        // $phone_number = $callbackData->Body->stkCallback->CallbackMetadata->Item[4]->Value;

        $result = [
            // "result_desc" => $result_desc,
            "result_code" => $result_code,
            "merchant_request_id" => $merchant_request_id,
            "checkout_request_id" => $checkout_request_id,
            "amount" => $amount,
            "mpesa_receipt_number" => $mpesa_receipt_number,
            // "phone" => $phone_number,
            // "transaction_date" => Carbon::parse($transaction_date)->toDateTimeString()
        ];

        if ($result['result_code'] == 0) {

            //  SendSms::dispatchAfterResponse($order->service->vendor->company_phone_number, 'The client completed the payment for the order '.$order->order_id);
        }
    }

    public function confirmationCallback(Request $request)
    {
        $callbackJSONData = file_get_contents('php://input');
        $callbackData = json_decode($callbackJSONData);

        $result = [
            'transaction_id' => $callbackData->data->TransID,
            'payment_ref' => $callbackData->data->BillRefNumber,
            'amount' => $callbackData->data->TransAmount,
        ];
    }

    public function validationUrl(Request $request)
    {
        info($request);
    }

    public function registerUrl()
    {
        $url = 'https://api.safaricom.co.ke/mpesa/c2b/v1/registerurl';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Authorization:Bearer ' . Mpesa::oxerus_mpesaGenerateAccessToken(),
            'Content-Type: application/json',
        ]);

        $curl_post_data = [
            "ShortCode" => "884350",
            "ResponseType" => "Completed",
            "ConfirmationURL" => route('confirmation.callback'),
            "ValidationURL" => route('validation.callback'),
        ];

        $data_string = json_encode($curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        $curl_response = curl_exec($curl);
        $responseObj = json_decode($curl_response);

        return response()->json($responseObj, 200);
    }
}
