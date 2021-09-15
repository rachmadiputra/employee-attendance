<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Assignment;
use App\Models\Holiday;
use App\Models\Cuti;

class CutiController extends Controller
{

    public function index()
    {
        $cuti = collect(Cuti::getCutiAll());

        return response()->json([
            "status" => 1,
            "message" => "success",
            "data" => $cuti
        ], 200);
    }

    public function add(Request $request)
    {
        $request->validate([
            "id_employee" => 'required',
            "cuti_date" => 'required',
        ]);

        $total_cuti = collect(Cuti::getCutiByIdDate($request->id_employee,$request->cuti_date)); 

        if ($total_cuti[0]->total_cuti < 1) {

            $total_holiday = collect(Holiday::getTotalHolidayByDate($request->cuti_date)); 
            
            if ($total_holiday[0]->total_holiday < 1) {

                $total_assignment = collect(Assignment::getTotalAssingmentByDate($request->id_employee,$request->cuti_date)); 
                
                if ($total_assignment[0]->total_id < 1) {

                    $cuti = new Cuti();
                    $cuti->id_employee = $request->id_employee;
                    $cuti->cuti_date = $request->cuti_date;
                    $cuti->description = $request->description;
                    $cuti->save();

                    return response()->json([
                        "status" => 1,
                        "message" => "success",
                    ], 200);

                } else {

                    return response()->json([
                        "status" => 0,
                        "message" => "Employee Have Been Assignment Shift",
                    ], 401);

                }

            } else {

                return response()->json([
                    "status" => 0,
                    "message" => "Today Is Off Day",
                ], 401);

            }

        } else {

            return response()->json([
                "status" => 0,
                "message" => "User Already Have Day Off",
            ], 401);

        }
        
    }

    public function remove($id)
    {
        $cuti = Cuti::find($id)->delete();

        return response()->json([
            "status" => 1,
            "message" => "success",
        ], 200);
    }
}
