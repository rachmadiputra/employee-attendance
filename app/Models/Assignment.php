<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Assignment extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function getTotalAssingmentByDate($id_employee,$date)
    {
        $total_assignment = DB::table('assignments')
                                    ->select(DB::raw('count(id) as total_id'))
                                    ->where('id_employee', '=', $id_employee)
                                    ->where('date', '=', $date)
                                    ->get();
        return $total_assignment;                            
    }

    public static function getTotalAssingmentByIdDate($id_employee,$id_shift,$date)
    {
        $total_assignment = DB::table('assignments')
                                ->select(DB::raw('count(id) as total_id'))
                                ->where('id_employee', '=', $id_employee)
                                ->where('id_shift', '=', $id_shift)
                                ->where('date', '=', $date)
                                ->get();
        return $total_assignment;
    }

    public static function getAssignmentAll()
    {
        $assignment = DB::table('assignments')
                            ->join('employees', 'assignments.id_employee', '=', 'employees.id')
                            ->join('shifts', 'assignments.id_shift', '=', 'shifts.id')
                            ->select('assignments.*', 'employees.first_name', 'employees.last_name','shifts.shift_name')
                            ->get();
        return $assignment;
    }

    public static function getAssignmentByIdDate($id_employee,$date)
    {
        $assignment = DB::table('assignments')
                            ->select('assignments.date','assignments.id_shift','shifts.time_in','shifts.time_out','shifts.shift_name')
                            ->join('employees', 'assignments.id_employee', '=', 'employees.id')
                            ->join('shifts', 'assignments.id_shift', '=', 'shifts.id')
                            ->where('assignments.id_employee','=', $id_employee)
                            ->where('assignments.date','=', $date)
                            ->get();
        return $assignment;
    }
}
