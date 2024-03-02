<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Flat;

use App\Models\Project;

use App\Models\Customer;
use App\Models\Bank;

use App\Models\FlatVoucher;

use Mpdf\Mpdf;
use Illuminate\Support\Facades\View;
use NumberFormatter;

use DB;

class FlatsellController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        $flats = Flat::all();
        $customers = Customer::all();
        $banks = Bank::all();

        $flatvouchers = FlatVoucher::with(['customer', 'flat'])
        ->latest('created_at')
        ->get();

        return view('admin.flatsell', compact('projects', 'flats', 'customers', 'flatvouchers','banks'));
    }



    public function store(Request $request)
    {
        try {
            $months = $request->input('months');
            $voucherNos = $request->input('voucher_nos');
            $paidTo = $request->input('paid_to');
            $categories = $request->input('categories');
            $customerIds = $request->input('Customer');
            $projectIds = $request->input('project_ids');
            $bank_ids = $request->input('bank_ids');

            $flatIds = $request->input('flat_numbers');
            $amounts = $request->filled('amounts') ? $request->input('amounts') : 0;

             $descriptions = $request->input('descriptions');
            $payees = $request->input('payees');
            $notes = $request->input('notes');
            $delay_charge = $request->filled('delay_charge') ? $request->input('delay_charge') : 0;
            $car_money = $request->filled('car_money') ? $request->input('car_money') : 0;
            $special_discount = $request->filled('special_discount') ? $request->input('special_discount') : 0;
            $utility_charge = $request->filled('utility_charge') ? $request->input('utility_charge') : 0;
            $tiles_work = $request->filled('tiles_work') ? $request->input('tiles_work') : 0;
            $refund_money = $request->filled('refund_money') ? $request->input('refund_money') : 0;

            $miscellaneous_cost = $request->filled('miscellaneous_cost') ? $request->input('miscellaneous_cost') : 0;

            // dd($request->all());


            $totalAmount = array_sum($amounts); // Calculate the total amount

            foreach ($months as $key => $month) {
                FlatVoucher::create([
                    'month' => $month,
                    'voucher_no' => $voucherNos[$key],
                    'paid_to' => $paidTo[$key],
                    'category' => $categories[$key],
                    'customer_id' => $customerIds[$key],
                    'project_id' => $projectIds[$key],
                    'flat_id' => $flatIds[$key],
                    'bank_id' => $bank_ids[$key],

                    'amount' => isset($amounts[$key]) ? $amounts[$key] : 0,

                    'description' => $descriptions[$key],
                    'payee' => $payees[$key],
                    'note' => $notes[$key],
                    'delay_charge' => isset($delay_charge[$key]) ? $delay_charge[$key] : 0,
                    'utility_charge' => isset($utility_charge[$key]) ? $utility_charge[$key] : 0,
                    'special_discount' => isset($special_discount[$key]) ? $special_discount[$key] : 0,
                    'car_money' => isset($car_money[$key]) ? $car_money[$key] : 0,
                    'tiles_work' => isset($tiles_work[$key]) ? $tiles_work[$key] : 0,
                    'refund_money' => isset($refund_money[$key]) ? $refund_money[$key] : 0,
                    'miscellaneous_cost' => isset($miscellaneous_cost[$key]) ? $miscellaneous_cost[$key] : 0,


                ]);
            }

            $this->createInvoice($customerIds[0], $totalAmount);

            return redirect()->back()->with('success', 'Data stored successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while storing the data.');
        }
    }

    private function convertToBanglaNumber($number)
    {
        $locale = 'bn_BD';

        $formatter = new NumberFormatter($locale, NumberFormatter::SPELLOUT);
        return $formatter->format($number);
    }



    public function createInvoice($customerId, $totalAmount)
    {
        try {
            $customer = Customer::find($customerId);

            if ($customer) {
                $customer->load('flats', 'assignedCompany');

                $name = $customer->name ?? null;
               $assignedCompany = $customer->assignedCompany->name ?? null;
               $flatName = $customer->flats->first()->flat_number ?? null;

               $totalhavetopay = $customer->total_installment + $customer->car_money + $customer->utility_charge - $customer->special_discount + $customer->tiles_charge + $customer->other_charge;

               $totalVoucherAmount = '0';
               $customergiven = 0;

               foreach ($customer->flatVouchers as $voucher) {
                   $customergiven += $voucher->amount + $voucher->delay_charge + $voucher->utility_charge + $voucher->car_money + $voucher->tiles_work - $voucher->special_discount - $voucher->refund_money + $voucher->miscellaneous_cost;
                    $totalVoucherAmount = bcadd($totalVoucherAmount, $customergiven, 2);
               }

               $dueAmount = bcsub($totalhavetopay, $customergiven, 2);



                $latestVoucher = $customer->flatVouchers->sortByDesc('created_at')->first();

                $pdf = new Mpdf();
                $html = '<html lang="en">';
                $html .= '<head>';
                $html .= '<meta charset="UTF-8">';
                $html .= '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
                $html .= '<title>Combined Vouchers</title>';
                $html .= '<style>';
                $html .= '.bangla, .bangla td { font-family: SolaimanLipi; }';
                $html .= '.txt-eng { font-family: Helvetica; font-size: 12px; }';
                $html .= '.tbl-border { border-collapse: collapse; width: 100%; margin-top: 10px; }';
                $html .= '.tbl-border th, .tbl-border td { border: 1px solid #000; padding: 5px; }';
                $html .= '.page-header { font-size: 18px; }';
                $html .= '</style>';
                $html .= '</head>';
                $html .= '<body>';

                $html .= '<div style="margin-top: 10px; margin-bottom: 10px; text-align: center;">';
                $html .= '<h2 class="bangla page-header" style="font-weight: bold; font-size: 28px; margin-bottom: -3.4;">Metro Homes Limited</h2>';
                $html .= '<br>';
                $html .= '<h3 class="bangla page-header" style="font-size: 15px; font-weight: bold; margin: 0;">Metro Shopping Mall, (4th floor), House #1, Road #12/A (New), Mirpur Road, Dhanmondi Dhaka</h3>';

                $html .= '<p class="bangla page-header" style="font-size: 18px; font-weight: bold; border-top: 1px solid #000; padding-top: 10px;">Payment Voucher<br>';

                 $html .= '<span style="font-size: 14px;">' . $assignedCompany . '</span><br>';

                 $html .= '<span style="font-size: 14px;">' . $flatName . '</span>, ';

                 $html .= '<span style="font-size: 14px;">' . $name . '</span></p>';

                 $html .= '<span style="font-size: 14px;">Date: ' . $latestVoucher->month . '</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                 $html .= '<span style="font-size: 14px;">Total Due: ' . $dueAmount . '</span>';




                $html .= '</div>';

                $html .= '<table class="txt-eng tbl-border">';
                $html .= '<thead>';
                $html .= '<tr>';
                $html .= '<th width="10%" class="bangla">Voucher No</th>';
                $html .= '<th width="10%" class="bangla">Check No</th>';
                $html .= '<th width="15%" class="bangla">InstallMent Name</th>';
                $html .= '<th width="20%" class="bangla">Amount</th>';
                $html .= '<th width="30%" class="bangla">All Charge</th>';
                $html .= '<th width="15%" class="bangla">Total Taka</th>';
                $html .= '</tr>';
                $html .= '</thead>';
                $html .= '<tbody class="bangla">';

                $html .= '<tr>';
                $html .= "<td>{$latestVoucher->voucher_no}</td>";
                $html .= "<td>{$latestVoucher->payee}</td>";
                $html .= "<td>{$latestVoucher->description}</td>";
                $html .= "<td>";

                if ($latestVoucher->amount !== null && $latestVoucher->amount !== "0.00") {
                    $html .= $latestVoucher->amount;
                } else {
                    $html .= $latestVoucher->refund_money;
                }


                $html .= "</td>";

                $delayCharge = $latestVoucher->delay_charge;
                $carMoney = $latestVoucher->car_money;
                $utilityCharge = $latestVoucher->utility_charge;
                $tiles_work = $latestVoucher->tiles_work;
                $specialDiscount = $latestVoucher->special_discount;
                $miscellaneous_cost = $latestVoucher->miscellaneous_cost;


                 $allCharge = "<span>Delay Charge:</span> {$delayCharge}<br>";
                $allCharge .= "<span>Car Money:</span> {$carMoney}<br>";
                $allCharge .= "<span>Charge:</span> {$utilityCharge}<br>";
                $allCharge .= "<span>tiles_charge:</span> {$tiles_work}<br>";
                $allCharge .= "<span>Discount:</span> {$specialDiscount}<br>";
                $allCharge .= "<span>Miscellaneous Cost:</span> {$miscellaneous_cost}<br>";


                $html .= "<td>{$allCharge}</td>";

                 $refund_money = isset($latestVoucher->refund_money) ? $latestVoucher->refund_money : 0;

                $total = $latestVoucher->amount + $delayCharge + $carMoney + $utilityCharge + $tiles_work + $miscellaneous_cost - ($specialDiscount + $refund_money);
                $html .= "<td>{$total}</td>";


                $html .= '</tr>';


                $html .= '</tbody>';
                $html .= '</table>';

                $html .= '<div style="border-bottom: 1px dotted #000; width: 100%; margin-top: 20px;">';
                $html .= '<p class="bangla" style="font-size: 12px; margin-top: 2px;">In Taka: ' . $this->convertToBanglaNumber($total) . '  Taka Only</p>';
                $html .= '<div style="border-bottom: 2px dotted #000; width: 100%; margin-top: 10px;"></div>';
                $html .= '</div>';



                $html .= '</body>';
                $html .= '</html>';
                $pdf->WriteHTML($html);

                $pdf->Output('combined_vouchers.pdf', 'I');

                return redirect()->back()->with('success', 'Data streamed successfully!');
            } else {
                dd("Customer with ID $customerId not found.");
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while creating the invoice.');
        }
    }



    public function exportPdf($customerId)
    {
        $customer = Customer::findOrFail($customerId);

        $mpdf = new Mpdf();

         $html = '<table class="display table table-bordered table-striped">';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th>Voucher No</th>';
        $html .= '<th>Customer Name</th>';
        $html .= '<th>Flat No</th>';
        $html .= '<th>Checke-No/Cash:</th>';
        $html .= '<th>InstallMent Name</th>';
        $html .= '<th>Amount</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';

        foreach ($customer->flatVouchers as $flatvoucher) {
            $html .= '<tr>';
            $html .= '<td>' . ($flatvoucher->voucher_no ?? '') . '</td>';
            $html .= '<td>' . ($flatvoucher->customer->name ?? '') . '</td>';
            $html .= '<td>' . ($flatvoucher->flat->flat_number ?? '') . '</td>';
            $html .= '<td>' . ($flatvoucher->payee ?? '') . '</td>';
            $html .= '<td>' . ($flatvoucher->description ?? '') . '</td>';
            $html .= '<td>' . ($flatvoucher->amount ?? '') . '</td>';
            $html .= '</tr>';
        }

        $html .= '</tbody>';
        $html .= '</table>';

         $mpdf->WriteHTML($html);

         $mpdf->Output('customervouchers.pdf', 'D');

        exit;
    }

    public function destroy($id)
    {
         FlatVoucher::findOrFail($id)->delete();

        return redirect()->route('admin.flatsell')->with('success', 'Record deleted successfully.');
    }


    public function getFlatsByCustomerAjax($customer_id)
    {
        $flats = DB::table('customer_flat')
            ->join('flats', 'customer_flat.flat_id', '=', 'flats.id')
            ->select('flats.id', 'flats.flat_number')
            ->where('customer_id', $customer_id)
            ->get();

        return response()->json($flats);
    }

    public function edit($id)
    {
        $flatvoucher = FlatVoucher::findOrFail($id);
        $customers = Customer::all();
        $flats = Flat::all();
        $projects = Project::all();
        $banks = Bank::all();




        return view('admin.flatselledit', compact('flatvoucher', 'customers','flats','projects','banks'));
    }





public function update(Request $request, $id)
{
    try {
        $flatvoucher = FlatVoucher::findOrFail($id);

        $flatvoucher->update([
            'month' => $request->input('months')[0], // Assuming only one month is updated per request
            'voucher_no' => $request->input('voucher_nos')[0],
            'paid_to' => $request->input('paid_to')[0],
            'category' => $request->input('categories')[0],
            'customer_id' => $request->input('Customer')[0],
            'project_id' => $request->input('project_ids')[0],
            'bank_id' => $request->input('bank_ids')[0],
            'flat_id' => $request->input('flat_numbers')[0],
            'amount' => $request->filled('amounts') ? $request->input('amounts')[0] : 0,
            'description' => $request->input('descriptions')[0],
            'payee' => $request->input('payees')[0],
            'note' => $request->input('notes')[0],
            'delay_charge' => $request->filled('delay_charge') ? $request->input('delay_charge')[0] : 0,
            'car_money' => $request->filled('car_money') ? $request->input('car_money')[0] : 0,
            'utility_charge' => $request->filled('utility_charge') ? $request->input('utility_charge')[0] : 0,
            'special_discount' => $request->filled('special_discount') ? $request->input('special_discount')[0] : 0,
            'tiles_work' => $request->filled('tiles_work') ? $request->input('tiles_work')[0] : 0,
            'refund_money' => $request->filled('refund_money') ? $request->input('refund_money')[0] : 0,
            'miscellaneous_cost' => $request->filled('miscellaneous_cost') ? $request->input('miscellaneous_cost')[0] : 0,
        ]);

        $this->createInvoice($request->input('Customer')[0], $request->input('amounts')[0]);

         \Log::info('Data updated successfully!', $request->all());

        return redirect()->back()->with('success', 'Data updated successfully!');
    } catch (\Exception $e) {
         \Log::error('An error occurred while updating the data.', ['exception' => $e]);

        return redirect()->back()->with('error', 'An error occurred while updating the data.');
    }
}

public function getFlats(Request $request)
{
    $companyId = $request->input('company_id');

     $flats = Flat::where('project_id', $companyId)->get();

    return response()->json($flats);
}





}
