<?php

namespace App\Imports;

use App\Models\Tugas;

use Carbon\Carbon;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TasksExport implements FromCollection, WithHeadings
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
            'task_id',
            'pegawai_id',
            'Nama Pegawai',
            'Nama Pekerjaan',
            'bobot',
            'asal',
            'target',
            'satuan',
            'realisasi',
            'deadline',
            'tgl_realisasi',
            'nilai_kualitas',
            'nilai_kuantitas',
            'keterangan',
            'catatan',
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
        $tasks = Tugas::select(
            'jenistasks_users.task_id',
            'jenistasks_users.pegawai_id',
            'users.name as Nama Pegawai',
            'jenis_tasks.tugas', // Kolom "tugas" dari tabel "jenis_tasks"
            'jenis_tasks.bobot', // Kolom "bobot" dari tabel "jenis_tasks"
            'tim.tim',
            'jenistasks_users.target',
            'jenis_tasks.satuan', // Kolom "satuan" dari tabel "jenis_tasks"
            'jenistasks_users.realisasi',
            'jenistasks_users.deadline',
            'jenistasks_users.tgl_realisasi',
            'jenistasks_users.nilai_kualitas',
            'jenistasks_users.nilai_kuantitas',
            'jenistasks_users.keterangan',
            'jenistasks_users.catatan',
            'jenistasks_users.link_file',
            'jenistasks_users.updated_at',
            'jenistasks_users.created_at',
        )
            ->leftJoin('users', 'jenistasks_users.pegawai_id', '=', 'users.id')
            ->leftJoin('jenis_tasks', 'jenistasks_users.jenistask_id', '=', 'jenis_tasks.no') // Menggabungkan tabel "jenis_tasks"
            ->leftJoin('tim', 'jenis_tasks.tim_id', '=', 'tim.kode') // Menggabungkan tabel "tim"
            ->where('tim.tim', $admin->tim)
            ->whereYear('jenistasks_users.deadline', '=', $this->selectedYear)
            ->whereMonth('jenistasks_users.deadline', '=', $this->selectedMonth)
            ->orderBy('users.name', 'asc')
            ->get();

        // Modifikasi nilai "pegawai_id" dengan menambahkan informasi tim (kode tim)
        $modifiedTasks = $tasks->map(function ($task) {
            $task->pegawai_id = '`' . $task->pegawai_id; // Menambahkan kode tim ke nilai "pegawai_id"
            return $task;
        });

        return $modifiedTasks;
    }
}
