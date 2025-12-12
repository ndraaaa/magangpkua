<?php

namespace App\Exports;

use App\Models\InternProfile;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ApplicantsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithDrawings, WithEvents
{
    private $profiles;

    public function __construct()
    {
        $this->profiles = InternProfile::with('user')->latest()->get();
    }

    public function collection()
    {
        return $this->profiles;
    }

    public function headings(): array
    {
        return [
            'No',
            'Pas Foto',
            'Status',
            'Nama Lengkap',
            'NIK',
            'NIM',
            'Institusi',
            'Jurusan',
            'Semester',
            'Stase',
            'No HP',
            'Alamat',
            'Pembimbing Akademik',
            'Tanggal Mulai',
            'Tanggal Berakhir',
            'Link CV',
            'Link Transkrip',
            'Link Surat Lamaran',
            'Link Ijazah',
            'Link KK',
            'Link Surat Ijin',
            'Tanggal Daftar',
        ];
    }

    public function map($profile): array
    {
        $getFile = function ($path) {
            return $path ? asset('storage/' . $path) : '-';
        };

        static $no = 0;
        $no++;

        return [
            $no,
            '',
            strtoupper($profile->status),
            $profile->nama_lengkap,
            "'" . $profile->nik,
            $profile->nim,
            $profile->institusi,
            $profile->jurusan,
            $profile->semester,
            $profile->stase,
            $profile->nomor_hp,
            $profile->alamat,
            $profile->pembimbing_akademik,
            $profile->tanggal_mulai,
            $profile->tanggal_berakhir,

            // Link Dokumen
            $getFile($profile->cv_path),
            $getFile($profile->transkrip_path),
            $getFile($profile->doc_surat_lamaran_path),
            $getFile($profile->doc_ijazah_path),
            $getFile($profile->doc_kk_path),
            $getFile($profile->doc_surat_ijin_path),

            $profile->created_at->format('d-m-Y H:i'),
        ];
    }

    public function drawings()
    {
        $drawings = [];

        foreach ($this->profiles as $key => $profile) {
            $fullPath = public_path('storage/' . $profile->pas_foto_path);

            if ($profile->pas_foto_path && file_exists($fullPath)) {
                $drawing = new Drawing();
                $drawing->setName('Foto ' . $profile->nama_lengkap);
                $drawing->setDescription('Pas Foto');
                $drawing->setPath($fullPath);
                $drawing->setHeight(80);
                $drawing->setCoordinates('B' . ($key + 2));
                $drawing->setOffsetX(10);
                $drawing->setOffsetY(10);

                $drawings[] = $drawing;
            }
        }

        return $drawings;
    }

    /**
     * 5. ATUR TINGGI BARIS (Agar foto muat)
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $count = $this->profiles->count() + 1;

                for ($i = 2; $i <= $count; $i++) {
                    $event->sheet->getDelegate()->getRowDimension($i)->setRowHeight(100);
                }

                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(20);

                $event->sheet->getDelegate()->getStyle('A1:V' . $count)
                    ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            },
        ];
    }
}