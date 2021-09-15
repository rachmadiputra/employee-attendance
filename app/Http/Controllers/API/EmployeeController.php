<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    public function index()
    {
        $employee = Employee::get();

        return response()->json([
            "status" => 1,
            "message" => "success",
            "data" => $employee
        ], 200);
    }

    public function create(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);

        $employee = new Employee();
        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->gender = $request->gender;
        $employee->religion = $request->religion;
        $employee->address = $request->address;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->save(); 

        return response()->json([
            "status" => 1,
            "message" => "success",
        ], 200);
    }

    public function edit($id)
    {
        $employee = Employee::find($id);

        return response()->json([
            "status" => 1,
            "message" => "success",
            "data" => $employee
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::find($id);

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);

        $employee->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'address' => $request->address,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return response()->json([
            "status" => 1,
            "message" => "success",
        ], 200);
    }

    public function delete(Request $request, $id)
    {
        $employee = Employee::find($id)->delete();

        return response()->json([
            "status" => 1,
            "message" => "success",
        ], 200);
    }
}
