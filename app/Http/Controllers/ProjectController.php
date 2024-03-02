<?php

// app/Http/Controllers/ProjectController.php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Project;
use App\Models\Flat;

use App\Models\Item;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    public function index()
    {
        $recentProjects = Project::latest()->take(5)->get();
        $companys = Company::all();

        return view('admin.project')
        ->with(compact('recentProjects','companys'));
     }



    public function storeProject(Request $request)
    {

        $project = Project::create([
            'name' => $request->input('name'),
            'project_location' => $request->input('project_location'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'manager' => $request->input('manager'),
            'garage' => $request->input('garage'),
            'description' => $request->input('description'),
            'company_id' => $request->input('company_id'),
        ]);


         $flatNumbers = $request->input('flat_number');
        foreach ($flatNumbers as $flatNumber) {
            $flat = new Flat(['flat_number' => $flatNumber]);
            $project->flats()->save($flat);
        }

        return redirect()->route('admin.project')->with('success', 'Project created successfully!');
    }





    public function showData()
    {
        $recentProjects = Project::latest()->take(5)->get();
        $dailyVisitorsItems = Item::latest()->take(5)->get();


        return view('admin.accounts')
            ->with(compact('recentProjects', 'dailyVisitorsItems'));
    }
}
