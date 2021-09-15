<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Assignment;
use App\Models\Holiday;
use App\Models\Cuti;

class AssignmentController extends Controller
{

    public function index()
    {
        $assignment = collect(Assignment::getAssignmentAll());

        return response()->json([
            "status" => 1,
            "message" => "success",
            "data" => $assignment
        ], 200);
    }

    public function assignment(Request $request)
    {
        $request->validate([
            "date" => 'required',
            "id_employee" => 'required',
            "id_shift" => 'required',
        ]);

        $total_assignment = collect(Assignment::getTotalAssingmentByIdDate($request->id_employee,
                                                                           $request->id_shift,
                                                                           $request->date));
        
        if ($total_assignment[0]->total_id < 1) {

            $total_holiday = collect(Holiday::getTotalHolidayByDate($request->date)); 
            
            if ($total_holiday[0]->total_holiday < 1) {

                $total_cuti = collect(Cuti::getCutiByIdDate($request->id_employee,$request->date)); 

                if ($total_cuti[0]->total_cuti < 1) {

                    $assignment = new Assignment();
                    $assignment->date = $request->date;
                    $assignment->id_employee = $request->id_employee;
                    $assignment->id_shift = $request->id_shift;
                    $assignment->save();

                    return response()->json([
                        "status" => 1,
                        "message" => "success",
                    ], 200);

                } else {

                    return response()->json([
                        "status" => 0,
                        "message" => "failed",
                        "data" => "Employee On Day Off"
                    ], 401);

                }

            } else {

                return response()->json([
                    "status" => 0,
                    "message" => "failed",
                    "data" => "Today Is Holiday"
                ], 401);

            }

        } else {

            return response()->json([
                "status" => 0,
                "message" => "failed",
                "data" => "Employee Already Assignment"
            ], 401);

        }
    }

    public function unassignment($id)
    {
        $unassignmet = Assignment::find($id)->delete();

        return response()->json([
            "status" => 1,
            "message" => "success",
        ], 200);
    }
}
