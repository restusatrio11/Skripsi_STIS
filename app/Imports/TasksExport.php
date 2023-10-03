<?php

namespace App\Imports;

use App\Models\Tugas;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TasksExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        // Mendefinisikan nama kolom, termasuk "nama" dari tabel "user"
        return [
            'task_id',
            'pegawai_id',
            'Nama Pegawai',
            'bobot',
            'asal',
            'target',
            'realisasi',
            'satuan',
            'deadline',
            'tgl_realisasi',
            'nilai',
            'keterangan',
            'file',
            'updated_at',
            'created_at',
        ];
    }

    public function collection()
    {

        // Ambil admin yang sedang masuk
        $admin = auth()->user();

        // Menggunakan query untuk mengambil data yang sesuai dengan join tabel "tugas" dan "user"
        return Tugas::select(
                'tasks.task_id',
                'tasks.pegawai_id',
                'users.name as Nama Pegawai', // Kolom "nama" dari tabel "user" diganti alias menjadi "Nama Pegawai"
                'tasks.bobot',
                'tasks.asal',
                'tasks.target',
                'tasks.realisasi',
                'tasks.satuan',
                'tasks.deadline',
                'tasks.tgl_realisasi',
                'tasks.nilai',
                'tasks.keterangan',
                'tasks.file',
                'tasks.updated_at',
                'tasks.created_at'
            )
            ->leftJoin('users', 'tasks.pegawai_id', '=', 'users.id')
            ->where('asal',$admin->tim)
            ->orderBy('task_id', 'desc')
            ->get();
    }
}
