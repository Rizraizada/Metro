<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Flat;
use App\Models\FlatVoucher;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use DB;
use Illuminate\Support\Facades\View;
use Mpdf\Mpdf;


class CustomerController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        $flats = Flat::all();
        $customers = Customer::all();
        $customerVouchers = [];
        foreach ($customers as $customer) {
            $customerId = $customer->id;

            $flatsForCustomer = $customer->flats;

        }
        return view('admin.customer', compact('projects', 'flats', 'customers', 'customerVouchers'));
    }

    public function getProjectFlats($projectId)
    {
        try {
            $project = Project::findOrFail($projectId);
            $flats = $project->flats;

            return response()->json($flats);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $customer = new Customer();
        $customer->name = $request->input('name');
        $customer->phone = $request->input('phone');
        $customer->email = $request->input('email');
        $customer->assigned_company = $request->input('assigned_company');
        $customer->details = $request->input('details');
        $customer->installment = $request->input('installment');
        $customer->total_installment = $request->input('total_installment');


        $customer->garage = $request->filled('garage') ? $request->input('garage') : 0;
        $customer->car_money = $request->filled('car_money') ? $request->input('car_money') : 0;

        $customer->special_discount = $request->filled('special_discount') ? $request->input('special_discount') : 0;
        $customer->utility_charge = $request->filled('utility_charge') ? $request->input('utility_charge') : 0;
        $customer->tiles_charge = $request->filled('tiles_charge') ? $request->input('tiles_charge') : 0;
        $customer->other_charge = $request->filled('other_charge') ? $request->input('other_charge') : 0;
        $customer->save();
        $customer->flats()->attach($request->input('selected_flats'));
        return redirect()->route('admin.customer')->with('success', 'Customer created successfully!');
    }

      public function getDetails($id)
    {
        $customer = Customer::find($id);
         return view('admin.customer-details', compact('customer'));
    }

    public function customergeneratePdf($customerId)
    {
         $customer = Customer::with('flatVouchers')->find($customerId);

         if (!$customer) {
            abort(404);
        }
         $customerVouchers = [];
         foreach ($customer->flatVouchers as $flatVoucher) {
            $customerVouchers[] = [
                'description' => $flatVoucher->description,
                'amount' => $flatVoucher->amount,
                'refund_money' => $flatVoucher->refund_money,
                'month' => $flatVoucher->month,
                'delay_charge' => $flatVoucher->delay_charge,
                'utility_charge' => $flatVoucher->utility_charge,
                'tiles_work' => $flatVoucher->tiles_work,
                'special_discount' => $flatVoucher->special_discount,
                'car_money' => $flatVoucher->car_money,
                'miscellaneous_cost' => $flatVoucher->miscellaneous_cost,
             ];
        }
         $pdfView = View::make('vouchers.pdf', compact('customer', 'customerVouchers'));
        $htmlContent = $pdfView->render();

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($htmlContent);
        $mpdf->Output('customer_report.pdf', 'D');
    }
       public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        $customers = Customer::all();
        $flats = Flat::all();
        $projects = Project::all();

        return view('admin.customeredit', compact('customer', 'customers', 'flats', 'projects'));
    }

    public function update(Request $request, $id)

      {

           $customer = Customer::findOrFail($id);

           $customer->update($request->all());

           $customer->flats()->sync($request->input('selected_flats', []));


           return redirect()->route('admin.customer')->with('success', 'Customer updated successfully');
        }

}
