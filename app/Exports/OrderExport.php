<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class OrderExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithEvents, ShouldAutoSize
{
    protected $month;
    protected $year;
    private $rowNumber = 0;
    private $totalOrdersCount = 0;

    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    public function collection()
    {
        // Mengambil data order berdasarkan bulan dan tahun
        $orders = Order::whereMonth('created_at', $this->month)
                    ->whereYear('created_at', $this->year)
                    ->get();

        $this->totalOrdersCount = $orders->count();

        return $orders;
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal Pemesanan',
            'Tanggal Kirim Barang',
            'Nama Lengkap',
            'Nomor Telpon',
            'Total Harga Pesanan'
        ];
    }

    public function map($order): array
    {
        $this->rowNumber++;

        // Konversi format tanggal kirim dari database (YYYY-MM-DD) ke (DD-MM-YYYY)
        $tglKirim = '-';
        if ($order->delivery_date) {
            $tglKirim = is_string($order->delivery_date) 
                ? date('d-m-Y', strtotime($order->delivery_date)) 
                : $order->delivery_date->format('d-m-Y');
        }

        return [
            $this->rowNumber,
            $order->created_at ? $order->created_at->format('d-m-Y') : '-',
            $tglKirim,
            $order->full_name ?? '-',      // Menembak kolom full_name di database
            "'" . $order->phone_number,    // Menembak kolom phone_number dengan prefix "'" agar tidak di-convert acak oleh Excel
            $order->total_price ?? 0,      // Menembak kolom total_price di database
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style Header Utama (Baris 1)
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                    'size' => 11
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'EAB308'] // Warna kuning identitas katering Dapur Bu Ayu
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ]
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;
                
                $lastRow = $this->totalOrdersCount + 1; // Baris terakhir data order
                $totalRow = $lastRow + 1; // Baris tempat Total Pendapatan Kotor

                if ($this->totalOrdersCount > 0) {
                    // Format mata uang Rupiah khusus kolom Total Harga Pesanan (Kolom F)
                    $sheet->getStyle("F2:F{$lastRow}")
                        ->getNumberFormat()
                        ->setFormatCode('Rp #,##0');

                    // Alinyemen / Rata Tengah kolom No (A), Tanggal Pesan (B), Tgl Kirim (C), dan No Telp (E)
                    $sheet->getStyle("A2:C{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle("E2:E{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                    // --- BARIS TOTAL PENDAPATAN ---
                    $sheet->setCellValue("E{$totalRow}", 'Total Pendapatan Kotor:');
                    $sheet->setCellValue("F{$totalRow}", "=SUM(F2:F{$lastRow})"); // Rumus SUM Excel dinamis menarget kolom F

                    // Styling khusus Baris Total Pendapatan
                    $sheet->getStyle("E{$totalRow}:F{$totalRow}")->applyFromArray([
                        'font' => ['bold' => true, 'size' => 11],
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
                        'numberFormat' => ['formatCode' => 'Rp #,##0'],
                        'borders' => [
                            'top' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']],
                            'bottom' => ['borderStyle' => Border::BORDER_DOUBLE, 'color' => ['rgb' => '000000']], // Garis dua akuntansi keuangan
                        ]
                    ]);

                    // --- AREA TANDA TANGAN PEMILIK (KANAN BAWAH) ---
                    $rowTtdLabel = $totalRow + 3; // Beri spasi 3 baris di bawah total pendapatan
                    $rowTtdNama = $rowTtdLabel + 4; // Beri ruang kosong untuk space ttd tanda tangan fisik

                    // Mapping nama bulan Indonesia berdasarkan parameter konstruktor
                    $bulanIndo = [
                        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                    ];
                    $namaBulan = $bulanIndo[(int)$this->month] ?? date('F');

                    // Teks Tempat, Tanggal, dan Jabatan ditaruh di bawah kolom E agar simetris di sisi kanan dokumen
                    $sheet->setCellValue("E{$rowTtdLabel}", "Depok, " . date('d') . " " . $namaBulan . " " . $this->year . "\nPemilik Dapur Bu Ayu,");
                    $sheet->getStyle("E{$rowTtdLabel}")->getAlignment()->setWrapText(true);

                    // Teks Garis bawah nama pemilik
                    $sheet->setCellValue("E{$rowTtdNama}", "( ____________________ )");

                    // Memposisikan teks tanda tangan presisi di tengah kolom E dan F
                    $sheet->getStyle("E{$rowTtdLabel}:E{$rowTtdNama}")->applyFromArray([
                        'font' => ['italic' => true],
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
                    ]);
                }
            },
        ];
    }
}