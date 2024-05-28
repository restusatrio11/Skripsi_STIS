<?php

namespace App\Imports;

use App\Models\OutputNilai;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NAExport implements FromCollection, WithHeadings
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
            'no',
            'pegawai_id',
            'nama',
            'nilai_akhir',
            'kategori_bobot',
            'total_bobot'
        ];
    }

    public function collection()
    {

        $NA = OutputNilai::select(
            'output_nilais.id',
            'output_nilais.pegawai_id',
            'output_nilais.nama',
            'output_nilais.nilai_akhir',
            'output_nilais.kategori_bobot',
            'output_nilais.total_bobot'
            )
            ->whereYear('output_nilais.updated_at', '=', $this->selectedYear)
            ->whereMonth('output_nilais.updated_at', '=', $this->selectedMonth)
            ->orderBy('nama', 'asc') // Mengurutkan secara ascending (A-Z)
            ->get();



            // Modifikasi nilai "pegawai_id" dengan menambahkan informasi tim (kode tim)
            $modifiedNilaiAkhir = $NA->map(function ($NAS) {
                $NAS->pegawai_id = '`' . $NAS->pegawai_id; // Menambahkan kode tim ke nilai "pegawai_id"
                return $NAS;
            });

            return $modifiedNilaiAkhir;
    }


}
