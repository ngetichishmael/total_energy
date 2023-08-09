<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SaleReport;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SaleReportController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'customer_id' => ['required', Rule::exists('customers', 'id')],
        ]);
        $result = SaleReport::create([
            'user_id' => $request->user()->id,
            'customer_id' => $validatedData['customer_id'],
            'customer_ordered' => $request->customer_ordered,
            'outlet_has_stock' => $request->outlet_has_stock,
            'competitor_supplier' => $request->competitor_supplier,
            'likely_ordered_products' => $request->likely_ordered_products,
            'highest_sale_products' => $request->highest_sale_products,
        ]);
        return response()->json([
            'Data' => $result,
        ]);

    }
}
