<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
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
                    ->copyable(),

                TextColumn::make('paket_dipilih')
                    ->label('Paket yang Dipilih')
                    ->getStateUsing(fn ($record) => $record->items->pluck('item_name')->implode(', '))
                    ->wrap(),

                TextColumn::make('full_name')
                    ->label('Nama Lengkap')
                    ->searchable(),

                TextColumn::make('phone_number')
                    ->label('No Telp.')
                    ->searchable(),

                TextColumn::make('address')
                    ->label('Alamat')
                    ->searchable()
                    ->columnSpan('full'),

                TextColumn::make('delivery_date')
                    ->label('Tgl & Jam Kirim')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                TextColumn::make('total_price')
                    ->label('Total')
                    ->money('IDR', locale: 'id_ID')
                    ->sortable(),

                TextColumn::make('payment_method')
                    ->label('Pembayaran')
                    ->badge()
                    ->color('info'),

                TextColumn::make('payment_status')
                    ->label('Bayar')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'LUNAS'      => 'success',
                        'PENDING'    => 'warning',
                        'EXPIRED'    => 'danger',
                        'DIBATALKAN' => 'danger',
                        default      => 'gray',
                    }),

                TextColumn::make('order_status')
                    ->label('Status Pesanan')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'DIPROSES'      => 'warning',
                        'TELAH SELESAI' => 'success',
                        'DIBATALKAN'    => 'danger',
                        default         => 'gray',
                    }),
            ])
            ->defaultSort('created_at', 'desc')
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