<?php

namespace App\Imports;

use App\Models\OutputNilai;
use App\Models\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NNAExport implements FromCollection, WithHeadings
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
            'nilai_akhir'
        ];
    }

    public function collection()
    {

        $dataavg =  OutputNilai::select('nama', 'nilai_akhir')
                    ->whereYear('output_nilais.updated_at', '=', $this->selectedYear)
                    ->whereMonth('output_nilais.updated_at', '=', $this->selectedMonth)
                    ->orderBy('nama', 'asc')
                    ->get();

        $allpegawai = User::whereNotIn('name', ['admin', 'user', 'Super Admin'])->pluck('name');

        // Menggabungkan dengan semua pegawai
        $mergedDataavg = collect($allpegawai)->map(function ($allname) use ($dataavg) {
            $foundnama = $dataavg->firstWhere('nama', $allname);

            return [
                'nama' => $allname,
                'nilai_akhir' => $foundnama ? $foundnama->nilai_akhir : 0,
            ];
        });

        return $mergedDataavg;
    }


}
