<?php

namespace App\Exports;

use App\Models\AppModelsAbsensi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Absensi;

class AbsensiExport implements FromCollection, WithHeadings
{

    public function headings():array
    {
        return[
            'First Name',
            'Last Name',
            'Shift',
            'Date',
            'Check In',
            'Check Out',
            'Status',
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return AppModelsAbsensi::all();
        return $absensi = collect(Absensi::getAbsensi());
    }
}
