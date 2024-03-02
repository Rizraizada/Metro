<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Item;

class ItemController extends Controller
{
    public function index()
    {
        $dailyVisitorsItems = Item::latest()->take(5)->get();

        return view('admin.item')
        ->with(compact('dailyVisitorsItems'));

    }

    public function storeItem(Request $request)
    {


        $item = Item::create([
            'name' => $request->input('name'),
            'purchase_date' => $request->input('purchase_date'),
            'supplier' => $request->input('supplier'),
            'details' => $request->input('details'),

         ]);

        return redirect()->route('admin.item')->with('success', 'Item created successfully!');
    }
}
