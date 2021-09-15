<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Absensi;
use App\Models\Holiday;
use App\Models\Cuti;
use App\Models\Assignment;
use App\Exports\AbsensiExport;
use Excel;

class AbsenController extends Controller
{

    public function index()
    {
        $absensi = collect(Absensi::getAbsensi());

        return response()->json([
            "status" => 1,
            "message" => "success",
            "data" => $absensi
        ], 200);
    }

    public function check_in(Request $request)
    {

        $request->validate([
            "date" => 'required',
            "id_employee" => 'required',
            "time_checkin" => 'required',
        ]);
        
        $date = Carbon::now();
        $today = $date->toDateString();
        $day = Carbon::createFromFormat('Y-m-d', $today)->format('l');

        if ($day != "Sunday" || $day != "Saturday") {

            $total_holiday = collect(Holiday::getHolidayByDate($request->date));
            
            if ($total_holiday[0]->total_holiday < 1) {

                $total_cuti = collect(Cuti::getCutiByIdDate($request->id_employee,$request->date));

                if ($total_cuti[0]->total_cuti < 1) {

                    $assignment = collect(Assignment::getAssignmentByIdDate($request->id_employee,$request->date));

                    if (count($assignment) > 0) {

                        $status = "";
                        $check = Carbon::createFromFormat('H:i:s', $request->time_checkin);
                        $time_in = Carbon::createFromFormat('H:i:s', $assignment[0]->time_in);
                        $time_out = Carbon::createFromFormat('H:i:s', $assignment[0]->time_out);

                        if ($check <= $time_in || $check <= $time_out) {

                            switch ($check) {
                                case $check < $time_in:
                                    $status = "Early";
                                    break;
                                case $check > $time_in:
                                    $status = "Late";
                                    break;
                                default:
                                    $status = "Valid";
                                    break;
                            }

                            $absensi = new Absensi();
                            $absensi->id_employee = $request->id_employee;
                            $absensi->absen_date = $request->date;
                            $absensi->check_in = $request->time_checkin;
                            $absensi->id_shift = $assignment[0]->id_shift;
                            $absensi->status = $status;
                            $absensi->save();

                            return response()->json([
                                "status" => 1,
                                "message" => "success",
                            ], 200);

                        } else {
                            
                            return response()->json([
                                "status" => 0,
                                "message" => "failed",
                                "data" => "Employee Not In Shift",
                            ], 401);

                        }

                    } else {

                        return response()->json([
                            "status" => 0,
                            "message" => "Employee Unassignment yet",
                        ], 401);

                    }

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
                "data" => "Today Is Weekend Day"
            ], 401);
        }
    }

    public function check_out(Request $request)
    {

        $request->validate([
            "date" => 'required',
            "id_employee" => 'required',
            "time_checkout" => 'required',
        ]);
        
        $date = Carbon::now();
        $today = $date->toDateString();
        $day = Carbon::createFromFormat('Y-m-d', $today)->format('l');

        if ($day != "Sunday" || $day != "Saturday") {

            $total_holiday = collect(Holiday::getHolidayByDate($request->date));
            
            if ($total_holiday[0]->total_holiday < 1) {

                $total_cuti = collect(Cuti::getCutiByIdDate($request->id_employee,$request->date));

                if ($total_cuti[0]->total_cuti < 1) {

                    $assignment = collect(Assignment::getAssignmentByIdDate($request->id_employee,$request->date));

                    if (count($assignment) > 0) {

                        $absensi = Absensi::where(['id_employee' => $request->id_employee, 'absen_date' => $request->date])->first();

                        $absensi->update([
                            "check_out" => $request->time_checkout,
                        ]);

                        return response()->json([
                            "status" => 1,
                            "message" => "success",
                        ], 200);

                    } else {

                        return response()->json([
                            "status" => 0,
                            "message" => "Employee Unassignment yet",
                        ], 401);

                    }

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
                "data" => "Today Is Weekend Day"
            ], 401);
        }
    }

    public function exportExcel()
    {
        return Excel::download(new AbsensiExport, 'Absensi.xlsx');
    }

    public function exportCSV()
    {
        return Excel::download(new AbsensiExport, 'Absensi.csv');
    }
}
