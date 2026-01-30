<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource; // Namespace yang benar
use App\Exports\OrderExport;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms\Components\Select;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

            Action::make('exportExcel')
                ->label('Export Excel')
                ->icon('heroicon-o-document-arrow-down')
                ->color('success')
                ->form([
                    Select::make('month')
                        ->label('Bulan')
                        ->options([
                            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
                            '04' => 'April', '05' => 'Mei', '06' => 'Juni',
                            '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
                            '10' => 'Oktober', '11' => 'November', '12' => 'Desember',
                        ])
                        ->default(date('m'))
                        ->required(),
                    Select::make('year')
                        ->label('Tahun')
                        ->options(array_combine(
                            range(date('Y'), date('Y') - 4), 
                            range(date('Y'), date('Y') - 4)
                        ))
                        ->default(date('Y'))
                        ->required(),
                ])
                ->action(function (array $data) {
                    // Nama file menggunakan format: penjualan-paket-MM-YYYY.xlsx
                    return Excel::download(
                        new OrderExport($data['month'], $data['year']), 
                        "penjualan-paket-{$data['month']}-{$data['year']}.xlsx"
                    );
                }),
        ];
    }
}