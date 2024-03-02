<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\FlatVoucher;
class ChartController extends Controller
{


    public function getFlatVoucherChart()
    {
        try {
            $flatVouchers = FlatVoucher::all();

            $chartData = [
                'categories' => ['Booking Money', 'Miscellaneous Cost', 'Received', 'Delay Charge', 'Utility Charge', 'Special Discount', 'Car Money', 'Tiles Work', 'Refund Money'],
                'data' => [
                    $flatVouchers->sum('amount'),
                    $flatVouchers->sum('miscellaneous_cost'),
                    // Add other data points as needed
                ],
            ];

            return response()->json($chartData);
        } catch (\Exception $e) {
            \Log::error('Error in getFlatVoucherChart: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
