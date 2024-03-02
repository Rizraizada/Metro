<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\Project;
use App\Models\FlatVoucher;
use App\Models\Item;
use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Mpdf\Mpdf;
use DB;


class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::latest()->paginate(10);
        $projects = Project::all();
        $items = Item::all();
        $banks = Bank::all();

        return view('admin.voucher.index', compact('vouchers', 'projects', 'items','banks'));
    }

    public function destroy($id)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->delete();

        return back()->with('success', 'Voucher deleted successfully.');
    }


    public function searchWizard(Request $request)
    {
        $projectId = $request->input('project_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $voucherQuery = Voucher::query();

        if ($startDate && $endDate) {
            $voucherQuery->whereBetween('month_date', [$startDate, $endDate]);
        }

        if ($projectId) {
            $voucherQuery->where('project_id', $projectId);
        }

        $searchResults = $voucherQuery->get();

        // Initialize flatVoucherResults array
        $flatVoucherResults = [];

        // Check if 'include_flat_vouchers' exists in the request
        if ($request->has('include_flat_vouchers')) {
            $flatVoucherQuery = FlatVoucher::query();

            if ($startDate && $endDate) {
                $flatVoucherQuery->whereBetween('month', [$startDate, $endDate]);
            }

            if ($projectId) {
                $flatVoucherQuery->where('project_id', $projectId);
            }

            $flatVoucherResults = $flatVoucherQuery->get();
        }

        // Debugging - Check the structure of $searchResults and $flatVoucherResults
        // dd($searchResults, $flatVoucherResults);

        $projects = Project::all();
        $vouchers = Voucher::all();

        $this->exportMultiplePdf($searchResults, $flatVoucherResults);

        return view('admin.voucher.index', [
            'vouchers' => $vouchers,
            'projects' => $projects,
            'searchResults' => $searchResults,
            'flatVoucherResults' => $flatVoucherResults,
            'projectId' => $projectId,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }





    public function exportMultiplePdf($searchResults, $flatVoucherResults)
    {
        $mpdf = new Mpdf();

        if ($searchResults->isNotEmpty() && !empty($flatVoucherResults)) {
            $this->generateCombinedTable($mpdf, $searchResults, $flatVoucherResults, 'Combined Vouchers');
        } else {
            $noDataMessage = 'No data found for the selected criteria.';

            if ($searchResults->isNotEmpty()) {
                $this->generateTable($mpdf, $searchResults, 'Voucher');
            } else {
                $mpdf->WriteHTML($noDataMessage);
            }

            if (!empty($flatVoucherResults)) {
                $this->generateTable($mpdf, $flatVoucherResults, 'Flat Voucher');
            } else {
                $mpdf->WriteHTML($noDataMessage);
            }
        }

        $mpdf->Output('combined_vouchers.pdf', 'I');
    }


    private function generateCombinedTable($mpdf, $voucherResults, $flatVoucherResults, $title)
    {
        $html = '<html lang="en">';
        $html .= '<head>';
        $html .= '<meta charset="UTF-8">';
        $html .= '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        $html .= "<title>{$title}</title>";
        $html .= '<style>';
        $html .= '.bangla, .bangla td { font-family: SolaimanLipi; }';
        $html .= '.txt-eng { font-family: Helvetica; font-size: 12px; }';
        $html .= '.tbl-border { border: 1px solid #000; }';
        $html .= '.page-header { font-size: 18px; font-weight: bold; }';
        $html .= '.flex-container { display: flex; justify-content: space-between; margin-top: 10px; flex-wrap: nowrap; }';
        $html .= 'table { border-collapse: collapse; width: 100%; margin-top: 10px; }';
        $html .= 'th, td { border: 1px solid #000; padding: 8px; text-align: left; }';
        $html .= '.nested-table { width: 100%; border-collapse: collapse; }';
        $html .= '.nested-th, .nested-td { border: 1px solid #000; padding: 5px; text-align: left; }'; // Adjusted padding
        $html .= 'tfoot { font-weight: bold; }';
        $html .= '.border-bottom { border-bottom: 1px dotted #000; width: 100%; margin-top: 15px; }'; // Adjusted margin-top
        $html .= '.signature-container { margin-top: 60px; width: 100%; display: flex; justify-content: space-between; }'; // Adjusted margin-top
        $html .= '.signature-box { width: 20%; float: left; text-align: center; margin-bottom: 5px; line-height: 1.5; }'; // Adjusted margin-bottom
        $html .= '.signature-box span { border-bottom: 1px solid #000; display: inline-block; width: 80%; }';
        $html .= '</style>';
        $html .= '</head>';
        $html .= '<body>';
        $html .= '<div style="margin-top: 10px; margin-bottom: 10px; text-align: center;">';
        $html .= '<h2 class="bangla page-header" style="font-weight: bold; font-size: 26px; margin-bottom: -3.4;">Metro Homes Limited</h2>'; // Adjusted font-size
        $html .= '<br>';
        $html .= '<h3 class="bangla page-header" style="font-size: 14px; font-weight: bold; margin: 0;">Metro Shopping Mall, (4th floor), House #1, Road #12/A (New), Mirpur Road, Dhanmondi Dhaka</h3>'; // Adjusted font-size
        $html .= '<hr style="border-top: 2px solid #000; margin: 3px 0;">'; // Adjusted margin-top
        $html .= '<h3 class="bangla page-header" style="font-size: 14px; font-weight: bold; margin: 0;">Receipts And Payment</h3>'; // Adjusted font-size
        $html .= '</div>';
        $html .= '<div class="flex-container">';
        $html .= '<div style="text-align: right;">';
        $html .= 'Date Range:';

        if ($voucherResults->isNotEmpty()) {
            $firstDate = $voucherResults->min('month_date');
            $lastDate = $voucherResults->max('month_date');
            $html .= $firstDate . ' - ' . $lastDate;
        }

        $html .= '</div>';
        $html .= '</div>';

        $html .= '<table class="txt-eng tbl-border">';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th colspan="3" class="bangla page-header" style="text-align: center;">Receipts</th>';
        $html .= '<th width="10%"></th>';
        $html .= '<th colspan="3" class="bangla page-header" style="text-align: center;">Payments</th>';
        $html .= '</tr>';
        $html .= '<tr>';

        $html .= '<th width="20%" class="bangla">Date/Voucher No</th>';
        $html .= '<th width="25%" class="bangla">Account Head</th>';
        $html .= '<th width="15%" class="bangla">Taka</th>';
        $html .= '<th width="1%"></th>';
        $html .= '<th width="20%" class="bangla">Date/Voucher No</th>';
        $html .= '<th width="25%" class="bangla">Account Head</th>';
        $html .= '<th width="15%" class="bangla">Taka</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody class="bangla">';

        $countVouchers = count($voucherResults);
        $countFlatVouchers = count($flatVoucherResults);
        $maxCount = max($countVouchers, $countFlatVouchers);
        $debitTotal = 0;
        $creditTotal = 0;

        for ($i = 0; $i < $maxCount; $i++) {
            $html .= '<tr>';

            if ($i < $countFlatVouchers) {
                $flatVoucher = $flatVoucherResults[$i];
                $html .= "<td>{$flatVoucher->month}/{$flatVoucher->voucher_no}</td>";
                // Nested table for Flat Voucher starts here
                $html .= '<td style="border: 1px solid #000; padding: 5px;">'; // Adjusted padding
                $html .= '<table class="nested-table">';
                $html .= '<tr>';
                $html .= '<td class="nested-th">Flat Number</td>';
                $html .= '<td class="nested-td">' . $flatVoucher->flat->flat_number . '</td>';
                $html .= '</tr>';
                $html .= '<tr>';
                $html .= '<td class="nested-th">Payee</td>';
                $html .= '<td class="nested-td">' . $flatVoucher->payee . '</td>';
                $html .= '</tr>';
                $html .= '<tr>';
                $html .= '<td class="nested-th">Paid To</td>';
                $html .= '<td class="nested-td">' . $flatVoucher->paid_to . '</td>';
                $html .= '</tr>';
                $html .= '<tr>';
                $html .= '<td class="nested-th">Description</td>';
                $html .= '<td class="nested-td">' . $flatVoucher->description . '</td>';
                $html .= '</tr>';
                $html .= '</table>';
                $html .= '</td>';
                // Nested table for Flat Voucher ends here
                $html .= "<td>{$flatVoucher->amount}</td>";
                $debitTotal += $flatVoucher->amount;
            } else {
                $html .= '<td></td><td></td><td></td>';
            }

            $html .= '<td></td>';

            if ($i < $countVouchers) {
                $voucher = $voucherResults[$i];
                $html .= "<td>{$voucher->month_date}/{$voucher->voucher_no}</td>";
                // Nested table for Voucher starts here
                $html .= '<td style="border: 1px solid #000; padding: 5px;">'; // Adjusted padding
                $html .= '<table class="nested-table">';
                $html .= '<tr>';
                $html .= '<td class="nested-th">Project Name</td>';
                $html .= '<td class="nested-td">' . $voucher->project->name . '</td>';
                $html .= '</tr>';
                $html .= '<tr>';
                $html .= '<td class="nested-th">Payee</td>';
                $html .= '<td class="nested-td">' . $voucher->payee . '</td>';
                $html .= '</tr>';
                $html .= '<tr>';
                $html .= '<td class="nested-th">Paid To</td>';
                $html .= '<td class="nested-td">' . $voucher->paid_to . '</td>';
                $html .= '</tr>';
                $html .= '<tr>';
                $html .= '<td class="nested-th">Description</td>';
                $html .= '<td class="nested-td">' . $voucher->description . '</td>';
                $html .= '</tr>';
                $html .= '</table>';
                $html .= '</td>';
                // Nested table for Voucher ends here
                $html .= "<td>{$voucher->amount}</td>";
                $creditTotal += $voucher->amount;
            } else {
                $html .= '<td></td><td></td><td></td>';
            }

            $html .= '</tr>';
        }

        // Total row
        $html .= '<tr>';
        $html .= '<td colspan="2" class="bangla page-header" style="text-align: center;">TOTAL</td>';
        $html .= "<td class='bangla'>{$debitTotal}</td>";
        $html .= '<td></td>';
        $html .= '<td colspan="2" class="bangla page-header" style="text-align: center;">TOTAL</td>';
        $html .= "<td class='bangla'>{$creditTotal}</td>";
        $html .= '</tr>';

        $html .= '</tbody>';
        $html .= '</table>';

        $html .= '</body>';

        $html .= '</html>';

        $mpdf->WriteHTML($html);
    }




    public function saveAndPrint(Request $request)
    {
         $months = $request->input('months');
        $voucherNos = $request->input('voucher_nos');
        $descriptions = $request->input('descriptions');
        $amounts = $request->input('amounts');
        $payees = $request->input('payees');
        $categories = $request->input('categories');
        $projectIds = $request->input('project_ids');
        $items = $request->input('item_ids');
        $bank_ids = $request->input('bank_ids');

        $notes = $request->input('notes');
        $paidTo = $request->input('paid_to');

         $view = View::make('vouchers.multiplepdf', compact(
            'months', 'voucherNos', 'descriptions', 'amounts',
            'payees', 'categories', 'projectIds', 'items', 'notes', 'paidTo','bank_ids'
        ));

        $htmlContent = $view->render();

        $mpdf = new Mpdf();

        $mpdf->WriteHTML($htmlContent);

         $mpdf->Output('combined_vouchers.pdf', 'D');
    }
    public function fullDetails(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $title = 'Full Details Report';

        $flatVouchers = FlatVoucher::with('project', 'bank')
            ->whereBetween('month', [$start_date, $end_date])
            ->get();

        $vouchers = Voucher::with('project', 'item', 'bank')
            ->whereBetween('month_date', [$start_date, $end_date])
            ->get();

        $mpdf = new Mpdf();
        $mpdf->SetTitle($title);
        $mpdf->SetHeader($title);

        $html = '<html lang="en">';
        $html .= '<head>';
        $html .= '<meta charset="UTF-8">';
        $html .= '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        $html .= '<style>';
        $html .= 'table { border-collapse: collapse; width: 100%; margin-top: 10px; }';
        $html .= 'th, td { border: 1px solid #000; padding: 8px; text-align: left; }';
        $html .= '.project-heading { font-weight: bold; background-color: #f0f0f0; }';
        $html .= '.total-row { font-weight: bold; background-color: #d9edf7; }';
        $html .= '</style>';
        $html .= '</head>';
        $html .= '<body>';
        $html .= '<div style="margin-top: 10px; margin-bottom: 10px; text-align: center;">';
        $html .= '<h2 style="font-weight: bold; font-size: 28px; margin-bottom: -3.4;">Metro Homes Limited</h2>';
        $html .= '<br>';
        $html .= '<h3 style="font-size: 15px; font-weight: bold; margin: 0;">Metro Shopping Mall, (4th floor), House #1, Road #12/A (New), Mirpur Road, Dhanmondi Dhaka</h3>';
        $html .= '<hr style="border-top: 2px solid #000; margin: 5px 0;">';
        $html .= '<p>Date Range: ' . date('m/d/y', strtotime($start_date)) . ' - ' . date('m/d/y', strtotime($end_date)) . '</p>';
        $html .= '<table>';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th>Date/Voucher No</th>';
        $html .= '<th>Type</th>'; // Add a new column for voucher type
        $html .= '<th>Project</th>';
        $html .= '<th>Account Head</th>';
        $html .= '<th>Taka</th>';
        $html .= '<th>Refund</th>';
        $html .= '<th>Discount</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';

        // Merge flat vouchers and vouchers
        $mergedVouchers = $flatVouchers->map(function ($item) {
            $item['type'] = 'Flat Voucher'; // Add a 'type' attribute to flat vouchers
            return $item;
        })->merge($vouchers->map(function ($item) {
            $item['type'] = 'Voucher'; // Add a 'type' attribute to vouchers
            return $item;
        }));

        // Group vouchers by project name
        $groupedVouchers = $mergedVouchers->groupBy('project.name');

        foreach ($groupedVouchers as $projectName => $vouchers) {
            $html .= '<tr class="project-heading">';
            $html .= '<td colspan="7" style="text-align: center;">PROJECT - ' . $projectName . '</td>';
            $html .= '</tr>';

            foreach ($vouchers as $voucher) {
                $html .= '<tr>';
                $html .= '<td>' . $voucher->month_date . '/' . $voucher->voucher_no . '</td>';
                $html .= '<td>' . $voucher->type . '</td>'; // Display voucher type
                $html .= '<td>' . $projectName . '</td>';
                $html .= '<td>' . $voucher->paid_to . ' - ' . $voucher->description . '</td>';
                $html .= '<td>' . $voucher->amount . '</td>';
                $html .= '<td>' . $voucher->refund_money . '</td>'; // Display refund money for the voucher
                $html .= '<td>' . $voucher->special_discount . '</td>'; // Display special discount for the voucher
                $html .= '</tr>';
            }

            $projectTotal = $vouchers->sum('amount'); // Total amount for the project
            $projectRefundMoneyTotal = $vouchers->where('type', 'Flat Voucher')->sum('refund_money');
            $projectSpecialDiscountTotal = $vouchers->where('type', 'Flat Voucher')->sum('special_discount');

            // Calculate the final total for the project
            $finalTotal = $projectTotal - $projectRefundMoneyTotal - $projectSpecialDiscountTotal;

            // Output the final total row
            $html .= '<tr class="total-row">';
            $html .= '<td colspan="4" style="text-align: right;">Final Total</td>';
            $html .= '<td>' . $finalTotal . '</td>'; // Display the final total for the project
            $html .= '<td colspan="2"></td>'; // Leave two empty cells for refund money and special discount
            $html .= '</tr>';
        }


        $html .= '</tbody>';
        $html .= '</table>';
        $html .= '</div>';
        $html .= '</body>';
        $html .= '</html>';

        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }







public function itemSearch(Request $request)
{
    $projects = Project::all();
    $items = Item::all();

    $projectId = $request->input('project_id');
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');
    $itemIds = $request->input('item_ids');

    $voucherQuery = Voucher::query();

    if ($startDate && $endDate) {
        $voucherQuery->whereBetween('month_date', [$startDate, $endDate]);
    }

    if ($projectId) {
        $voucherQuery->where('project_id', $projectId);
    }

    if (!empty($itemIds) && !in_array('all', $itemIds)) {
        $voucherQuery->whereIn('item_id', $itemIds);
    }

    $searchResults = $voucherQuery->get();

    $mpdf = new \Mpdf\Mpdf();  // Assuming you have Mpdf installed

    $html = '<html lang="en">';
    $html .= '<head>';
    $html .= '<meta charset="UTF-8">';
    $html .= '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    $html .= '<title>Payments</title>';
    $html .= '<style>';
    $html .= '.bangla, .bangla td { font-family: SolaimanLipi; }';
    $html .= '.txt-eng { font-family: Helvetica; font-size: 12px; }';
    $html .= '.tbl-border { border: 1px solid #000; }';
    $html .= '.page-header { font-size: 18px; font-weight: bold; }';
    $html .= '.flex-container { display: flex; justify-content: space-between; margin-top: 10px; flex-wrap: nowrap; }';
    $html .= 'table { border-collapse: collapse; width: 100%; margin-top: 10px; }';
    $html .= 'th, td { border: 1px solid #000; padding: 8px; text-align: left; }';
    $html .= 'tfoot { font-weight: bold; }';
    $html .= '.border-bottom { border-bottom: 1px dotted #000; width: 100%; margin-top: 20px; }';
    $html .= '.signature-container { margin-top: 75px; width: 100%; display: flex; justify-content: space-between; }';
    $html .= '.signature-box { width: 20%; float: left; text-align: center; margin-bottom: 10px; line-height: 1.5; }';
    $html .= '.signature-box span { border-bottom: 1px solid #000; display: inline-block; width: 80%; }';
    $html .= '</style>';
    $html .= '</head>';
    $html .= '<body>';
    $html .= '<div style="margin-top: 10px; margin-bottom: 10px; text-align: center;">';
    $html .= '<h2 class="bangla page-header" style="font-weight: bold; font-size: 28px; margin-bottom: -3.4;">Metro Homes Limited</h2>';
    $html .= '<br>';
    $html .= '<h3 class="bangla page-header" style="font-size: 15px; font-weight: bold; margin: 0;">Metro Shopping Mall, (4th floor), House #1, Road #12/A (New), Mirpur Road, Dhanmondi Dhaka</h3>';
    $html .= '<hr style="border-top: 2px solid #000; margin: 5px 0;">';
    $html .= '<h3 class="bangla page-header" style="font-size: 15px; font-weight: bold; margin: 0;">Payments</h3>';

if ($projectId) {
    $project = Project::find($projectId);
    $html .= '' . $project->name;
}

if (!empty($itemIds) && !in_array('all', $itemIds)) {
    $selectedItems = Item::whereIn('id', $itemIds)->pluck('name')->toArray();
    $html .= ' / ' . implode(', ', $selectedItems);
}

$html .= '</h3>';

    $html .= '<div class="flex-container">';
    $html .= '<div style="text-align: right;">';
    $html .= 'Date Range:';

    if ($searchResults->isNotEmpty()) {
        $firstDate = $searchResults->min('month_date');
        $lastDate = $searchResults->max('month_date');
        $html .= $firstDate . ' - ' . $lastDate;
    }



    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';

    $html .= '<table class="txt-eng tbl-border">';
    $html .= '<thead>';
    $html .= '<tr>';
    $html .= '<th width="5%" class="bangla">Date</th>';
    $html .= '<th width="15%" class="bangla">Voucher No</th>';
    $html .= '<th width="25%" class="bangla">Details</th>';
    $html .= '<th width="15%" class="bangla">Taka</th>';
    $html .= '</tr>';
    $html .= '</thead>';
    $html .= '<tbody class="bangla">';

    $totalAmount = 0;

    foreach ($searchResults as $result) {
        $html .= '<tr>';
        $html .= "<td>{$result->month_date}</td>";
        $html .= "<td>{$result->voucher_no}</td>";
        $html .= "<td style='font-size: 13px; border: 1px solid #000; padding: 5px;'>";

        // Payee
        $html .= "<strong>Payee:</strong> {$result->payee}<br>";

        // Paid To
        $html .= "<strong>Paid To:</strong> {$result->paid_to}<br>";

        // Description
        $html .= "<strong>Description:</strong> {$result->description}";

        $html .= "</td>";
        $html .= "<td>{$result->amount}</td>";
        $html .= '</tr>';

        // Add amount to total
        $totalAmount += $result->amount;

        // Line separator
        $html .= '<tr><td colspan="4" style="border-top: 1px solid #000;"></td></tr>';
    }

    // Total row
    $html .= '<tr>';
    $html .= '<td colspan="3" style="text-align: right; font-weight: bold;">Total:</td>';
    $html .= "<td>{$totalAmount}</td>";
    $html .= '</tr>';



    $html .= '</tbody>';
    $html .= '</table>';
    $html .= '</body>';
    $html .= '</html>';

    $mpdf->WriteHTML($html);
    $mpdf->Output('search_results.pdf', 'D');

    return view('admin.voucher.index', [
        'items' => $items,
        'searchResults' => $searchResults,
        'projects' => $projects,
        'projectId' => $projectId,
        'startDate' => $startDate,
        'endDate' => $endDate,
    ]);
}




}
