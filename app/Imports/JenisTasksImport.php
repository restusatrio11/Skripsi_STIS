<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Tugas;
use App\Models\jenis_tugas;
use App\Models\tim;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;



class JenisTasksImport implements ToModel, WithHeadingRow, WithValidation
{

    use Importable;

    public function model(array $row)
    {
        // Memeriksa apakah baris benar-benar kosong
        if (empty(array_filter($row))) {
            return null; // Jika benar-benar kosong, lewati baris
        }

        if (!isset($row['tim']) || empty($row['tim'])) {
            return null;
        }

        // memeriksa kode tim apakah sesuai dengan yang ada di database
        $timId = tim::where('kode', $row['tim'])->first();

        // Jika tim tidak ditemukan, mungkin Anda ingin menangani kasus ini sesuai kebutuhan Anda
        if (!$timId) {
            return null;
        }

        // Menghitung jumlah tugas yang ada untuk tim tersebut
        $existingTasksCount = jenis_tugas::where('tim_id', $timId->kode)->count();

        // Menyusun kode_tugas berdasarkan kode tim dan urutan tugas
        $kodeTugas = $row['tim'] . '-' . ($existingTasksCount + 1);

        // Membuat atau memperbarui entitas jenis pekerjaan
        return new jenis_tugas([
            'no' => $kodeTugas,
            'tugas' => $row['tugas'], // Misalnya kolom 'nama' dari file impor
            'satuan' => $row['satuan'], // Misalnya kolom 'satuan' dari file impor
            'bobot' => $row['bobot'], // Misalnya kolom 'bobot' dari file impor
            'tim_id' => $timId->kode, // Menggunakan tim_id yang telah dikonversi
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
            'no' => function($attribute, $value, $onFailure) {
                if (empty($value)) {
                        $onFailure('Kode Tugas Kemungkinan Salah atau belum ada');
                }
            },
            'tim' => function($attribute, $value, $onFailure) {
                if (isset($value) && !empty($value)) {
                    $tim = tim::where('kode', $value)->first();
                    if (!$tim) {
                        $onFailure('Kode Tim tidak ditemukan. Silahkan menghubungi superadmin jika ada tim baru');
                    }
                }
            }
        ];
    }



}
