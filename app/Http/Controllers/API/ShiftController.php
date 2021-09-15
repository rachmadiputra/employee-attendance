<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shift;

class ShiftController extends Controller
{

    public function index()
    {
        $shift = Shift::get();

        return response()->json([
            "status" => 1,
            "message" => "success",
            "data" => $shift
        ], 200);
    }

    public function create(Request $request)
    {
        $request->validate([
            "shift_name" => 'required',
            "time_in" => 'required',
            "time_out" => 'required',
        ]);

        $shift = new Shift();
        $shift->shift_name = $request->shift_name;
        $shift->time_in = $request->time_in;
        $shift->time_out = $request->time_out;
        $shift->save();

        return response()->json([
            "status" => 1,
            "message" => "success",
        ], 200);
    }

    public function edit($id)
    {
        $shift = Shift::find($id);

        return response()->json([
            "status" => 1,
            "message" => "success",
            "data" => $shift
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $shift = Shift::find($id);

        $request->validate([
            "shift_name" => 'required',
            "time_in" => 'required',
            "time_out" => "required"
        ]);

        $shift->update([
            "shift_name" => $request->shift_name,
            "time_in" => $request->time_in,
            "time_out" => $request->time_out,
        ]);
        
        return response()->json([
            "status" => 1,
            "message" => "success",
        ], 200);
    }

    public function delete(Request $request, $id)
    {
        $shift = Shift::find($id)->delete();

        return response()->json([
            "status" => 1,
            "message" => "success",
        ], 200);
    }
}
