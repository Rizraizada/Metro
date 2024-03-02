<?php

namespace App\Http\Controllers;
 use Illuminate\Http\Request;
  use Mpdf\Mpdf;
 use App\Models\Voucher;
  use App\Models\FlatVoucher;
  use App\Models\Bank;
  use Illuminate\Support\Facades\Log;
   class BankController extends Controller
{
    public function index()
    {
        $banks = Bank::all();


        return view('admin.bank', compact('banks'));
    }

    public function store(Request $request)
    {
        try {
            Bank::create([
                'bank_name' => $request->input('bank_name'),
                'branch_no' => $request->input('branch_no'),
                'owner' => $request->input('owner'),
                'opening_balance' => $request->input('opening_balance'),
                'deposit' => $request->input('deposit'),
                'withdraw' => $request->input('withdraw'),
                'details' => $request->input('details'),
            ]);

            return redirect()->back()->with('success', 'Bank created successfully.');
        } catch (\Exception $e) {
             \Log::error($e);

            return redirect()->back()->with('error', 'An error occurred while processing the Bank.');
        }
    }


    public function generatePdf(Request $request)
    {
        $bankIds = $request->input('bank_ids');

        if (in_array('all', $bankIds)) {
            $voucherData = Voucher::whereBetween('month_date', [$request->input('start_date'), $request->input('end_date')])
                ->with('bank')
                ->get();

            $flatVoucherData = FlatVoucher::whereBetween('month', [$request->input('start_date'), $request->input('end_date')])
                ->with('bank')
                ->get();

            $bankData = Bank::all(); // Fetch data from the banks table
        } else {
            $voucherData = Voucher::whereIn('bank_id', $bankIds)
                ->whereBetween('month_date', [$request->input('start_date'), $request->input('end_date')])
                ->with('bank')
                ->get();

            $flatVoucherData = FlatVoucher::whereIn('bank_id', $bankIds)
                ->whereBetween('month', [$request->input('start_date'), $request->input('end_date')])
                ->with('bank')
                ->get();

            $bankData = Bank::whereIn('id', $bankIds)->get(); // Fetch data from the selected banks
        }

        $mpdf = new Mpdf();
        $this->generateCombinedTable($mpdf, $voucherData, $flatVoucherData, $bankData, $bankIds);

        $mpdf->Output();
    }



    private function generateCombinedTable($mpdf, $voucherResults, $flatVoucherResults, $bankData)
    {
        $html = '<html lang="en">';
        $html .= '<head>';
        $html .= '<meta charset="UTF-8">';
        $html .= '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        $html .= '<style>';
        $html .= '.bangla, .bangla td { font-family: SolaimanLipi; }';
        $html .= '.txt-eng { font-family: Helvetica; font-size: 15px; }';
        $html .= '.tbl-border { border-collapse: collapse; width: 100%; margin-top: 10px; }';
        $html .= 'th, td { border: 1px solid #000; padding: 8px; text-align: left; }';
        $html .= '.page-header { font-size: 18px; font-weight: bold; text-align: center; }';
        $html .= '.bangla-header { font-size: 15px; font-weight: bold; }';
        $html .= '.border-bottom { border-bottom: 1px dotted #000; width: 100%; margin-top: 20px; }';
        $html .= '</style>';
        $html .= '</head>';
        $html .= '<body>';

        $html .= '<div style="text-align: center;">';
        $html .= '<h2 class="bangla page-header" style="margin-bottom: -3.4;">Metro Homes Limited</h2>';
        $html .= '<p class="bangla-header">Metro Shopping Mall, (4th floor), House #1, Road #12/A (New), Mirpur Road, Dhanmondi Dhaka</p>';
        $html .= '<hr style="border-top: 2px solid #000; margin: 5px 0;">';

        $bankName = '';
        $openingBalance = 0;

        if ($voucherResults->isNotEmpty()) {
            $firstVoucher = $voucherResults->first();
            $bankName = $firstVoucher->bank->bank_name;
            $openingBalance = $firstVoucher->bank->opening_balance;
        }

        $html .= '<h3 class="bangla page-header">' . $bankName . '</h3>';
        $html .= '<p class="bangla-header">Date Range:';

        if ($voucherResults->isNotEmpty()) {
            $firstDate = $voucherResults->min('month_date');
            $lastDate = $voucherResults->max('month_date');
            $html .= $firstDate . ' - ' . $lastDate;
        }

        $html .= '</p>';
        $html .= '</div>';

        // Main Combined Table
        $html .= '<table class="txt-eng tbl-border">';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th colspan="3" class="bangla page-header">Receipts</th>';
        $html .= '<th colspan="2" class="bangla page-header">Payments</th>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<th width="20%" class="bangla">Project Name</th>';
        $html .= '<th width="20%" class="bangla">Description</th>';
        $html .= '<th width="15%" class="bangla">Taka</th>';
        $html .= '<th width="25%" class="bangla">Project Name</th>';
        $html .= '<th width="10%" class="bangla">Taka</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody class="bangla">';

        $projectTotals = []; // To store total credit amount for each project

        // Loop through voucher results to calculate project totals for credit amount
        foreach ($voucherResults as $voucher) {
            $projectName = $voucher->project->name;
            if (!isset($projectTotals[$projectName])) {
                $projectTotals[$projectName] = 0;
            }
            $projectTotals[$projectName] += $voucher->amount;
        }

        $countFlatVouchers = count($flatVoucherResults);
        $debitTotal = 0;

        // Loop through flat voucher results
        for ($i = 0; $i < $countFlatVouchers; $i++) {
            $flatVoucher = $flatVoucherResults[$i];
            $amountFields = [
                'amount',
                'delay_charge',
                'utility_charge',
                'special_discount',
                'car_money',
                'tiles_work',
                'refund_money',
                'miscellaneous_cost'
            ];

            $html .= '<tr>';
            $html .= '<td>';
            $html .= "<div>{$flatVoucher->flat->flat_number}</div>";
            $html .= '</td>';
            $html .= '<td>';
            $html .= "<div>{$flatVoucher->description}</div>";
            $html .= '</td>';
            $html .= '<td>';
            foreach ($amountFields as $field) {
                if ($flatVoucher->$field > 0) {
                    $html .= "<div>{$flatVoucher->$field}</div>";
                    if ($field === 'refund_money' || $field === 'special_discount') {
                        $debitTotal -= $flatVoucher->$field;
                    } else {
                        $debitTotal += $flatVoucher->$field;
                    }
                }
            }
            $html .= '<td colspan="2"></td>'; // Empty cells for credit amount columns
            $html .= '</tr>';
        }

        // Loop through project totals for credit amount
        foreach ($projectTotals as $projectName => $creditAmount) {
            $html .= '<tr>';
            $html .= '<td colspan="3"></td>'; // Empty cells for debit amount columns and Description
            $html .= '<td>';
            $html .= "<div>{$projectName}</div>"; // Display project name once
            $html .= '</td>';
            $html .= "<td>{$creditAmount}</td>"; // Display total credit amount for the project
            $html .= '</tr>';
        }

        $html .= '<tr>';
        $html .= '<td colspan="3" class="bangla page-header">TOTAL</td>';
        $html .= "<td class='bangla'>{$debitTotal}</td>";
        $html .= '<td class="bangla">' . array_sum($projectTotals) . '</td>'; // Total credit amount
        $html .= '</tr>';

        $html .= '<tr>';
        $html .= '<td colspan="3" class="bangla page-header">Opening Balance</td>';
        $html .= "<td class='bangla'>{$openingBalance}</td>";
        $html .= "<td class='bangla'>" . ($openingBalance - $debitTotal + array_sum($projectTotals)) . "</td>";
        $html .= '</tr>';

        $html .= '<tr>';
        $html .= '<td colspan="3" class="bangla page-header">Total</td>';
        $html .= "<td class='bangla'>" . ($openingBalance - $debitTotal) . "</td>";
        $html .= "<td class='bangla'>" . ($openingBalance - $debitTotal) . "</td>";
        $html .= '</tr>';

        $html .= '</tbody>';
        $html .= '</table>';


        // Bank Details Table
        $html .= '<h3 class="bangla page-header" style="margin-top: 10px;">Bank Details:----------</h3>';
        $html .= '<table class="txt-eng tbl-border">';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th class="bangla" style="width: 30px;">Bank Name</th>';
        $html .= '<th class="bangla">Details</th>';
        $html .= '<th class="bangla">Opening Balance</th>';
        $html .= '<th class="bangla">Deposit</th>';
        $html .= '<th class="bangla">Withdraw</th>';
        $html .= '<th class="bangla">Total</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody class="bangla">';

        $grandOpeningBalance = 0;
        $grandDepositTotal = 0;
        $grandWithdrawTotal = 0;

        foreach ($bankData as $bank) {
            $html .= '<tr>';
            $html .= "<td>{$bank->bank_name}</td>";
            $html .= "<td>{$bank->details}</td>";
            $html .= "<td>{$bank->opening_balance}</td>";

            $individualDebitTotal = 0;
            $individualCreditTotal = 0;

            foreach ($voucherResults as $voucher) {
                if ($voucher->bank_id == $bank->id) {
                    $individualCreditTotal += $voucher->amount;
                }
            }

            foreach ($flatVoucherResults as $flatVoucher) {
                if ($flatVoucher->bank_id == $bank->id) {
                    $amountFields = ['amount', 'delay_charge', 'utility_charge', 'special_discount', 'car_money', 'tiles_work', 'refund_money', 'miscellaneous_cost'];
                    foreach ($amountFields as $field) {
                        $individualDebitTotal += ($field === 'refund_money' || $field === 'special_discount') ? -$flatVoucher->$field : $flatVoucher->$field;
                    }
                }
            }

            $html .= "<td>{$individualDebitTotal}</td>";
            $html .= "<td>{$individualCreditTotal}</td>";

            // Calculate individual closing balance
            $closingBalance = $bank->opening_balance + $individualCreditTotal - $individualDebitTotal;
            $html .= "<td>{$closingBalance}</td>";

            // Update grand totals
            $grandOpeningBalance += $bank->opening_balance;
            $grandDepositTotal += $individualCreditTotal;
            $grandWithdrawTotal += $individualDebitTotal;

            $html .= '</tr>';
        }

        $html .= '<tr>';
        $html .= '<td colspan="2" class="bangla page-header" style="text-align: center;">TOTAL</td>';
        $html .= "<td class='bangla'>{$grandOpeningBalance}</td>";
        $html .= "<td class='bangla'>{$grandWithdrawTotal}</td>";
        $html .= "<td class='bangla'>{$grandDepositTotal}</td>";
        $html .= "<td class='bangla'>" . ($grandOpeningBalance + $grandDepositTotal - $grandWithdrawTotal) . "</td>";
        $html .= '</tr>';

        $html .= '</tbody>';
        $html .= '</table>';

        $html .= '</body>';
        $html .= '</html>';

        $mpdf->WriteHTML($html);
    }




    }


