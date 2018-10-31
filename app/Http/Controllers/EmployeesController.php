<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Http\Resources\Employees;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $row = Employee::create($request->only(['name']));
        return response()->json($row, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \App\Http\Resources\Employees
     */
    public function show($id)
    {
        $company = Employee::find($id);
        return new Employees($company);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $company = Employee::find($id);
        $company->name = $request->input('name');
        $company->save();

        return response()->json($company, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Employee::find($id);
        $company->delete();
        return response()->json(null, 204);
    }
}
