<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Tugas;
use App\Models\jenis_tugas;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;



class TasksImport implements ToModel, WithHeadingRow, WithValidation
{

    use Importable;

    public function model(array $row)
    {
        // Memeriksa apakah baris benar-benar kosong
        if (empty(array_filter($row))) {
            return null; // Jika benar-benar kosong, lewati baris
        }

        if (!isset($row['pegawai_id']) || empty($row['pegawai_id'])) {
            return null;
        }

        // Mengambil data dari tabel jenis_tasks
        $jenisTask = jenis_tugas::where('no', $row['kode_tugas'])->first();

        // Jika jenis_task tidak ditemukan, mungkin Anda ingin menangani kasus ini sesuai kebutuhan Anda
        if (!$jenisTask) {
            return null;
        }

        // Perhitungan volume tertimbang
        $volume_tertimbang = $jenisTask->bobot * $row['target'];

        return new Tugas([
            'pegawai_id' => $row['pegawai_id'],
            'target' => $row['target'],
            'realisasi' => $row['realisasi'],
            'deadline' => Carbon::createFromFormat('d m Y', $row['deadline'])->format('Y-m-d'),
            'keterangan' => $row['keterangan'],
            'catatan' => $row['catatan'],
            'volume_tertimbang' => $volume_tertimbang,
            'jenistask_id' => $jenisTask->no
        ]);
    }


    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function rules(): array
    {
        return [
            'pegawai_id' => function($attribute, $value, $onFailure) {
                if (empty($value)) {
                        $onFailure('NIP Pegawai Kemungkinan Salah atau belum ada');
                }
            },
            'deadline' => function($attribute, $value, $onFailure) {
                // Lakukan validasi format tanggal
                $parsedDate = date_parse_from_format('d m Y', $value);
                if (empty($value)) {
                    $onFailure('Deadline Belum terisi');
                }elseif($parsedDate['error_count'] > 0 || $parsedDate['warning_count'] > 0)
                {
                    $onFailure('Format tanggal harus dd mm yyyy');
                }
            },
            'tugas' => function($attribute, $value, $onFailure) {
                if (isset($value) && !empty($value)) {
                    $jenisTask = jenis_tugas::where('no', $value)->first();
                    if (!$jenisTask) {
                        $onFailure('Jenis tugas tidak ditemukan. Periksa Kembali Kode Pekerjaan');
                    }
                }
            }
        ];
    }

    public function messages()
{
    return [
        'deadline.date_format' => 'Format tanggal pada kolom deadline tidak valid. Pastikan format tanggal yang dimasukkan adalah DD MM YYYY (tanggal bulan tahun), contohnya 07 02 2024.',
        'deadline.required' => 'deadline wajib terisi tidak boleh kosong'
    ];
}

}
