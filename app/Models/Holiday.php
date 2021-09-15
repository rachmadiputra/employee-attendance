<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Holiday extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function getTotalHolidayByDate($date)
    {
        $total_holiday = DB::table('holidays')
                                ->select(DB::raw('count(id) as total_holiday'))
                                ->where('holiday_date', '=', $date)
                                ->get();
        return $total_holiday;
    }
    
    public static function getHolidayByDate($date)
    {
        $holiday = DB::table('holidays')
                                ->select(DB::raw('count(id) as total_holiday'))
                                ->where('holiday_date', '=', $date)
                                ->get();
        return $holiday;
    }
}
