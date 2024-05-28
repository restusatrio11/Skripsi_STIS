<?php

namespace App\Imports;

use App\Models\OutputNilai;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KPExport implements FromCollection, WithHeadings
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
            'jumlah kegiatan'
        ];
    }

    public function collection()
    {
        $datacount = User::select('name', DB::raw('count(jenistask_id) as kegiatan'))
        ->leftJoin('jenistasks_users', 'users.id', '=', 'jenistasks_users.pegawai_id')
        ->whereYear('jenistasks_users.deadline', '=', $this->selectedYear)
        ->whereMonth('jenistasks_users.deadline', '=', $this->selectedMonth)
        ->whereNotIn('name', ['admin', 'user', 'Super Admin'])
        ->groupBy('name')
        ->orderBy('name', 'asc')
        ->get();

        $allpegawai = User::whereNotIn('name', ['admin', 'user', 'Super Admin'])->pluck('name');

        // Menggabungkan dengan semua pegawai
        $mergedDatacount = collect($allpegawai)->map(function ($allname) use ($datacount) {
            $foundname = $datacount->firstWhere('name', $allname);

            return [
                'name' => $allname,
                'kegiatan' => $foundname ? $foundname->kegiatan : 0,
            ];
            });

        return $mergedDatacount;
    }


}
