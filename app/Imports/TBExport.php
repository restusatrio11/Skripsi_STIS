<?php

namespace App\Imports;

use App\Models\OutputNilai;
use App\Models\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TBExport implements FromCollection, WithHeadings
{
    protected $selectedYear;
    protected $selectedMonth;

    public function __construct($selectedYear, $selectedMonth)
    {
        $this->selectedYear = $selectedYear;
        $this->selectedMonth = $selectedMonth;
    }

    public function headings(): array
    {
        // Mendefinisikan nama kolom, termasuk "nama" dari tabel "user"
        return [
            'nama',
            'total_bobot'
        ];
    }

    public function collection()
    {
        $datatotalbobot =  OutputNilai::select('nama', 'total_bobot')
                    ->whereYear('output_nilais.updated_at', '=', $this->selectedYear)
                    ->whereMonth('output_nilais.updated_at', '=', $this->selectedMonth)
                    ->orderBy('nama', 'asc')
                    ->get();

        $allpegawai = User::whereNotIn('name', ['admin', 'user', 'Super Admin'])->pluck('name');

        // Menggabungkan dengan semua pegawai
        $mergedDatatotalbobot = collect($allpegawai)->map(function ($allnamee) use ($datatotalbobot) {
            $foundnamaa = $datatotalbobot->firstWhere('nama', $allnamee);

            return [
                'nama' => $allnamee,
                'total_bobot' => $foundnamaa ? $foundnamaa->total_bobot : 0,
            ];
        });

        return $mergedDatatotalbobot;
    }


}
