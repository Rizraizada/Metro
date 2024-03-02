<?php

namespace App\Http\Controllers;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
     {
         $companies = Company::all(); // Fetch all companies from the database
         return view('admin.company', compact('companies'));
     }
     public function store(Request $request)
     {

          $company = Company::create([
             'name' => $request->name,
             'address' => $request->address,
             'phone' => $request->phone,
             'email' => $request->email,
             'website' => $request->website,
             'founded_date' => $request->founded_date,
             'description' => $request->description,
             'contact_person' => $request->contact_person,
         ]);

         return redirect()->route('admin.company')->with('success', 'Company created successfully');
     }

}
