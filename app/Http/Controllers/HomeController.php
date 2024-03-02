<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
 use Illuminate\Support\Facades\Auth;
use App\Models\FlatVoucher;
use App\Models\Voucher;
use App\Models\Item;
use App\Models\Bank;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use App\Models\Project;
use ConsoleTVs\Charts\Facades\Charts;

use Illuminate\Validation\ValidationException;

class HomeController extends Controller {



    public function addsell()
    {
        $vouchers = Voucher::latest()->paginate(15);
        $projects = Project::all();
        $items = Item::all();
        $banks = Bank::all();



        return view('admin.home', [
            'vouchers' => $vouchers,
            'projects' => $projects,
            'items' => $items,
            'banks' => $banks,

        ]);
    }


    public function saveVouchers(Request $request)
    {
        try {


            $action = $request->input('action', 'save');
            $totalAmount = 0;

            foreach ($request->input('project_ids') as $key => $projectId) {
                $dataToStore = [
                    'month_date' => $request->input('months')[$key],
                    'voucher_no' => $request->input('voucher_nos')[$key],
                    'description' => $request->input('descriptions')[$key],
                    'amount' => $request->input('amounts')[$key],
                    'payee' => $request->input('payees')[$key],
                    'category' => $request->input('categories')[$key],
                    'project_id' => $projectId,
                    'item_id' => $request->input('item_ids')[$key],
                    'note' => $request->input('notes')[$key],
                    'paid_to' => $request->input('paid_to')[$key],
                    'bank_id' => $request->input('bank_ids')[$key],
                ];

                Voucher::create($dataToStore);
                $totalAmount += $request->input('amounts')[$key];
            }

            if ($action == 'save_and_print') {
                return redirect()->route('print.vouchers', [
                    'totalAmount' => $totalAmount,
                    'months' => $request->input('months'),
                    'voucher_nos' => $request->input('voucher_nos'),
                    'descriptions' => $request->input('descriptions'),
                    'amounts' => $request->input('amounts'),
                    'payees' => $request->input('payees'),
                    'categories' => $request->input('categories'),
                    'project_ids' => $request->input('project_ids'),
                    'item_ids' => $request->input('item_ids'),
                    'notes' => $request->input('notes'),
                    'paid_to' => $request->input('paid_to'),
                    'bank_ids' => $request->input('bank_ids'),
                ]);
            }


            return redirect()->route('admin.addsell')->with('success', 'Vouchers saved successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.addsell')->with('error', 'An error occurred while saving vouchers.');
        }
    }


    public function showVouchers(Request $request)
    {
        try {
            $vouchers = Voucher::latest()->paginate(25);

            $recentProjects = Project::latest()->limit(3)->get();
            $dailyVisitorsItems = Item::latest()->limit(3)->get();

             $todayProfitLoss = 0;

            return view('admin.accounts', compact('vouchers', 'recentProjects', 'dailyVisitorsItems', 'todayProfitLoss'));
        } catch (ValidationException $e) {
            return redirect()->route('admin.accounts')->withErrors($e->errors());
        } catch (\Exception $e) {
            return redirect()->route('admin.accounts')->with('error', 'An error occurred while fetching voucher data.');
        }
    }


    public function searchVouchers(Request $request)
    {
        $keyword = $request->input('keyword');

        $vouchers = Voucher::where('month_date', 'LIKE', "%$keyword%")
            ->orWhere('voucher_no', 'LIKE', "%$keyword%")
            ->orWhere('description', 'LIKE', "%$keyword%")
            ->orWhere('amount', 'LIKE', "%$keyword%")
            ->orWhere('payee', 'LIKE', "%$keyword%")
            ->orWhere('category', 'LIKE', "%$keyword%")
            ->orWhere('paid_to', 'LIKE', "%$keyword%")
            ->orWhere('note', 'LIKE', "%$keyword%")
            ->paginate(5);

         $projects = Project::all();
        $items = Item::all();

        return view('admin.home', [
            'vouchers' => $vouchers,
            'projects' => $projects,
            'items' => $items,
        ]);
    }

     public function calculateProfit(Request $request)
       {
           $startDate = Carbon::parse($request->input('start_date'))->startOfDay();
           $endDate = Carbon::parse($request->input('end_date'))->endOfDay();
           $profit = FlatVoucher::whereBetween('created_at', [$startDate, $endDate])
               ->sum('amount') - FlatVoucher::whereBetween('created_at', [$startDate, $endDate])
               ->sum('miscellaneous_cost');
           return response()->json(['profit' => number_format($profit, 2) . 'Tk']);
       }

      public function getChartData()
          {
              $data = FlatVoucher::select(
                      DB::raw('SUM(amount) as total_amount'),
                      'delay_charge',
                      'utility_charge',
                      'special_discount',
                      'car_money',
                      'tiles_work',
                      'refund_money',
                      'miscellaneous_cost'
                  )
                  ->groupBy('delay_charge', 'utility_charge', 'special_discount', 'car_money', 'tiles_work', 'refund_money', 'miscellaneous_cost')
                  ->get();
              return response()->json($data);
          }
}


