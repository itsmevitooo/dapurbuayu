<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('invoice_code')
                    ->label('Invoice')
                    ->searchable()
                    ->copyable(), // Admin bisa klik untuk copy kode invoice

                TextColumn::make('full_name')
                    ->label('Nama Lengkap')
                    ->searchable(),

                TextColumn::make('phone_number')
                    ->label('No Telp.')
                    ->searchable(),

                TextColumn::make('delivery_date')
                    ->label('Tgl Kirim')
                    ->date()
                    ->sortable(),

                TextColumn::make('total_price')
                    ->label('Total')
                    ->money('IDR', locale: 'id_ID')
                    ->sortable(),

                TextColumn::make('payment_status')
                    ->label('Bayar')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'LUNAS' => 'success',
                        'PENDING' => 'warning',
                        'EXPIRED' => 'danger',
                        default => 'gray',
                    }),

                SelectColumn::make('order_status')
                    ->label('Status Pesanan')
                    ->options([
                        'DIPROSES' => 'DIPROSES',
                        'TELAH SELESAI' => 'TELAH SELESAI',
                    ])
                    ->selectablePlaceholder(false),
            ])
            ->defaultSort('created_at', 'desc') // Pesanan terbaru selalu di atas
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
