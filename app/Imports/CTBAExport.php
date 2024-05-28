<?php

namespace App\Imports;

use App\Models\Tugas;
use App\Models\Tim;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CTBAExport implements FromCollection, WithHeadings
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
            'Asal Tim',
            'Jumlah Tugas Selesai'
        ];
    }

    public function collection()
    {
        $completedTasksByAsal=Tugas::select(
            'tim.tim',
            DB::raw('COUNT(*) as total_completed')
        )
        ->leftJoin('jenis_tasks','jenistasks_users.jenistask_id','=','jenis_tasks.no')
        ->leftJoin('tim','jenis_tasks.tim_id','=','tim.kode')
        ->whereYear('jenistasks_users.deadline', '=', $this->selectedYear)
        ->whereMonth('jenistasks_users.deadline', '=', $this->selectedMonth)
        ->where('keterangan', 'Telah dikonfirmasi')
        ->groupBy('tim.tim')
        ->get();

        $allTeams = Tim::where('kode', '!=', 16)->pluck('tim');

        // Menggabungkan dengan semua tim
        $mergedData = collect($allTeams)->map(function ($team) use ($completedTasksByAsal) {
        $foundTeam = $completedTasksByAsal->firstWhere('tim', $team);

        return [
            'asal' => $team,
            'total_completed' => $foundTeam ? $foundTeam->total_completed : 0,
        ];
        });

        return $mergedData;
    }


}
