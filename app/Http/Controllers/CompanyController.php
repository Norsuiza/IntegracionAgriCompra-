<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::all();
        return view('catalogs.companies', compact('companies'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $company = new Company();
        $company->name = $request->input('name');
        $company->save();

        return response()->json(['success' => 'Compañía creada con éxito.']);

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $company = Company::findOrFail($id);
        return response()->json($company);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request ->validate([
            'name' => 'required|string|max:255',
        ]);

        $company = Company::findOrFail($id);

        $company->name = $request->input('name');
        $company->save();

        return response()->json(['succes' => 'successfully updated company']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();
        return redirect()->back()->with('success', 'Company deleted successfully.');
    }
}
