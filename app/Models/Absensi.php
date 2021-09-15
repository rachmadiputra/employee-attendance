<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Absensi extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function getAbsensi()
    {
        $absensi = DB::table('absensis')
                        ->join('employees', 'absensis.id_employee', '=', 'employees.id')
                        ->join('shifts', 'absensis.id_shift', '=', 'shifts.id')
                        ->select('employees.first_name', 
                                 'employees.last_name',
                                 'shifts.shift_name',
                                 'absensis.absen_date',
                                 'absensis.check_in',
                                 'absensis.check_out',
                                 'absensis.status')
                        ->get();

        return $absensi;
    }
}
