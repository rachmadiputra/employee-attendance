<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cuti extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function getCutiAll()
    {
        $cuti = DB::table('cutis')
                        ->join('employees', 'cutis.id_employee', '=', 'employees.id')
                        ->select('cutis.*', 'employees.first_name', 'employees.last_name')
                        ->get();
        return $cuti;
    }

    public static function getCutiByIdDate($id_employee,$date)
    {
        $total_cuti = DB::table('cutis')
                            ->select(DB::raw('count(id) as total_cuti'))
                            ->where('id_employee', '=', $id_employee)
                            ->where('cuti_date', '=', $date)
                            ->get();
        return $total_cuti;
    }
}
