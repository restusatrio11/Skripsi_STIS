<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Tugas;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TasksImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Tugas([
            // 'task_id' => $row['task_id'],
            'pegawai_id' => $row['pegawai_id'],
            'nama' => $row['tugas'],
            'bobot' => $row['bobot'],
            'asal' => $row['asal'],
            'target' => $row['target'],
            'realisasi' => $row['realisasi'],
            'satuan' => $row['satuan'],
            // 'deadline' => Carbon::parse($row['deadline'])->format('Y-m-d'), // Mengonversi format tanggal
            'deadline' => Carbon::createFromFormat('d m Y', $row['deadline'])->format('Y-m-d'),
            // 'tgl_realisasi' => $row['tgl_realisasi'],
            // 'nilai' => $row['nilai'],
            'keterangan' => $row['keterangan'],
            // 'file' => $row['file'],
        ]);
    }
}
