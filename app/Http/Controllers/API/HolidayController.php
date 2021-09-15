<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Holiday;

class HolidayController extends Controller
{

    public function index()
    {
        $holiday = Holiday::get();

        return response()->json([
            "status" => 1,
            "message" => "success",
            "data" => $holiday
        ], 200);
    }

    public function create(Request $request)
    {
        $request->validate([
            "holiday_name" => 'required',
            "holiday_date" => 'required',
        ]);

        $holiday = new Holiday();
        $holiday->holiday_name = $request->holiday_name;
        $holiday->holiday_date = $request->holiday_date;
        $holiday->description = $request->description;
        $holiday->save();

        return response()->json([
            "status" => 1,
            "message" => "success",
        ], 200);
    }

    public function edit($id)
    {
        $holiday = Holiday::find($id);

        return response()->json([
            "status" => 1,
            "message" => "success",
            "data" => $holiday
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $holiday = Holiday::find($id);

        $request->validate([
            "holiday_name" => 'required',
            "holiday_date" => 'required',
        ]);

        $holiday->update([
            "holiday_name" => $request->holiday_name,
            "holiday_date" => $request->holiday_date,
            "description" => $request->description,
        ]);
        
        return response()->json([
            "status" => 1,
            "message" => "success",
        ], 200);
    }

    public function delete(Request $request, $id)
    {
        $holiday = Holiday::find($id)->delete();

        return response()->json([
            "status" => 1,
            "message" => "success",
        ], 200);
    }
}
