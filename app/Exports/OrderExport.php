<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class OrderExport implements FromCollection, WithMapping, WithEvents, ShouldAutoSize, WithCustomStartCell
{
    protected $month;
    protected $year;
    private $rowNumber = 0;
    private $totalOrdersCount = 0;
    private $startDataRow = 6; 
    private $totalPendapatanKotor = 0; // Tambahan properti untuk menampung total

    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    public function collection()
    {
        $orders = Order::whereMonth('created_at', $this->month)
                    ->whereYear('created_at', $this->year)
                    ->get();

        $this->totalOrdersCount = $orders->count();
        
        // Hitung total harga langsung menggunakan method sum() bawaan Eloquent Laravel
        $this->totalPendapatanKotor = $orders->sum('total_price');

        return $orders;
    }

    public function startCell(): string
    {
        return 'A6';
    }

    public function map($order): array
    {
        $this->rowNumber++;

        $tglKirim = '-';
        if ($order->delivery_date) {
            $tglKirim = is_string($order->delivery_date) 
                ? date('d-m-Y', strtotime($order->delivery_date)) 
                : $order->delivery_date->format('d-m-Y');
        }

        $hargaMurni = $order->total_price ? (float) $order->total_price : 0;

        return [
            $this->rowNumber,
            $order->created_at ? $order->created_at->format('d-m-Y') : '-',
            $tglKirim,
            $order->full_name ?? '-',
            "'" . $order->phone_number, 
            $order->address ?? '-',
            $hargaMurni, 
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;
                
                // 1. --- KOP JUDUL DI TENGAH ---
                $sheet->mergeCells('A1:G1');
                $sheet->mergeCells('A2:G2');
                
                $sheet->setCellValue('A1', 'LAPORAN PENJUALAN - DAPUR BU AYU');
                $sheet->setCellValue('A2', 'Periode Bulan: ' . $this->month . ' / Tahun: ' . $this->year);
                
                $sheet->getStyle('A1:G2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('A2')->getFont()->setItalic(true)->setSize(11);

                // 2. --- HEADER TABEL UTAMA ---
                $headers = [
                    'A5' => 'No',
                    'B5' => 'Tanggal Pemesanan',
                    'C5' => 'Tanggal Kirim Barang',
                    'D5' => 'Nama Lengkap',
                    'E5' => 'Nomor Telpon',
                    'F5' => 'Alamat Pengiriman',
                    'G5' => 'Total Harga Pesanan'
                ];

                foreach ($headers as $cell => $value) {
                    $sheet->setCellValue($cell, $value);
                }

                $sheet->getStyle('A5:G5')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'FFFFFF'],
                        'size' => 11
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'EAB308'] 
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ]
                ]);

                $firstDataRow = $this->startDataRow; 
                $lastDataRow = $firstDataRow + $this->totalOrdersCount - 1; 
                $totalRow = $lastDataRow + 1; 

                if ($this->totalOrdersCount > 0) {
                    // 3. --- FORMAT MATA UANG KOLOM DATA ---
                    $sheet->getStyle("G{$firstDataRow}:G{$lastDataRow}")
                        ->getNumberFormat()
                        ->setFormatCode('_\R\p* #,##0_ ;_\R\p* -#,##0_ ;_\R\p* "-"_ ;_@_ ');

                    $sheet->getStyle("A{$firstDataRow}:C{$lastDataRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle("E{$firstDataRow}:E{$lastDataRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                    // Grid Border
                    $sheet->getStyle("A5:G{$lastDataRow}")->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['rgb' => '000000']
                            ]
                        ]
                    ]);

                    // 4. --- BARIS TOTAL PENDAPATAN KOTOR (DIHITUNG DARI BACKEND) ---
                    $sheet->setCellValue("F{$totalRow}", 'Total Pendapatan Kotor:');
                    
                    // Kita langsung masukkan variabel angka aslinya dari Laravel, bukan lagi rumus "=SUM(G6:G9)"
                    $sheet->setCellValue("G{$totalRow}", $this->totalPendapatanKotor); 

                    $sheet->getStyle("F{$totalRow}:G{$totalRow}")->applyFromArray([
                        'font' => ['bold' => true, 'size' => 11],
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
                        'borders' => [
                            'top' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']],
                            'bottom' => ['borderStyle' => Border::BORDER_DOUBLE, 'color' => ['rgb' => '000000']],
                        ]
                    ]);
                    
                    // Format Rupiah untuk cell total pendapatan kotor
                    $sheet->getStyle("G{$totalRow}")
                        ->getNumberFormat()
                        ->setFormatCode('_\R\p* #,##0_ ;_\R\p* -#,##0_ ;_\R\p* "-"_ ;_@_ ');

                    // 5. --- TANDA TANGAN PEMILIK ---
                    $rowTtdLabel = $totalRow + 3; 
                    $rowTtdNama = $rowTtdLabel + 4; 

                    $bulanIndo = [
                        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                    ];
                    $namaBulan = $bulanIndo[(int)$this->month] ?? date('F');

                    $sheet->setCellValue("G{$rowTtdLabel}", "Depok, " . date('d') . " " . $namaBulan . " " . $this->year . "\nPemilik Dapur Bu Ayu,");
                    $sheet->getStyle("G{$rowTtdLabel}")->getAlignment()->setWrapText(true);

                    $sheet->setCellValue("G{$rowTtdNama}", "( ____________________ )");

                    $sheet->getStyle("G{$rowTtdLabel}:G{$rowTtdNama}")->applyFromArray([
                        'font' => ['italic' => true],
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
                    ]);
                }
            },
        ];
    }
}