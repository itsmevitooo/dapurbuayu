<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OrderExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithEvents
{
    protected $month;
    protected $year;
    private $rowNumber = 0;
    private $totalRevenue = 0;

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

        // Hitung total pendapatan kotor
        $this->totalRevenue = $orders->sum('total_price');

        return $orders;
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal Pemesanan',
            'Nama Pemesan',
            'Jenis Paket Pesanan',
            'Harga Per Orang',
            'Total Harga'
        ];
    }

    public function map($order): array
    {
        $this->rowNumber++;
        return [
            $this->rowNumber,
            $order->created_at->format('d-m-Y'),
            $order->name,
            $order->package_type, // Nama model: paket [cite: 2025-12-30]
            $order->price_per_person,
            $order->total_price,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]], // Bold untuk header
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $lastRow = $this->rowNumber + 2; // +1 untuk header, +1 untuk baris baru
                
                // Menambahkan label Total Pendapatan
                $event->sheet->setCellValue("E{$lastRow}", 'Total Pendapatan Kotor:');
                
                // Menambahkan nilai totalnya
                $event->sheet->setCellValue("F{$lastRow}", $this->totalRevenue);

                // Styling baris total agar tebal
                $event->sheet->getStyle("E{$lastRow}:F{$lastRow}")->getFont()->setBold(true);
            },
        ];
    }
}