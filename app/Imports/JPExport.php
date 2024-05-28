<?php

namespace App\Imports;

use App\Models\jenis_tugas;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class JPExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        // Mendefinisikan nama kolom, termasuk "nama" dari tabel "user"
        return [
            'No',
            'Pekerjaan',
            'Satuan',
            'Tim',
            'Bobot'
        ];
    }

    public function collection()
    {

        return jenis_tugas::select(
            'jenis_tasks.no',
            'jenis_tasks.tugas',
            'jenis_tasks.satuan',
            'tim.tim',
            'jenis_tasks.bobot'
        )
        ->leftJoin('tim', 'jenis_tasks.tim_id', '=', 'tim.kode') // Menggabungkan tabel "tim"
        ->orderBy('tim', 'asc')
        ->get();

    }
}
