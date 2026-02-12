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
                    ->searchable(),
                TextColumn::make('full_name')
                    ->label('Nama Lengkap')
                    ->searchable(),
                TextColumn::make('phone_number')
                    ->label('No Telp.')
                    ->searchable(),
                TextColumn::make('delivery_date')
                    ->label('Tanggal Pengiriman')
                    ->date()
                    ->sortable(),
                TextColumn::make('address')
                    ->label('Lokasi Pengiriman')
                    ->limit(50)
                    ->searchable(),
                TextColumn::make('total_price')
                    ->label('Harga')
                    ->money('IDR', locale: 'id_ID')
                    ->sortable(),
                TextColumn::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->badge()
                    ->color('gray')
                    ->searchable(),
                TextColumn::make('payment_status')
                    ->label('Status Bayar')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'LUNAS' => 'success',
                        'PENDING' => 'warning',
                        'EXPIRED' => 'danger',
                        default => 'gray',
                    })
                    ->searchable(),
                // Menggunakan SelectColumn agar status bisa diubah langsung di tabel
                SelectColumn::make('order_status')
                    ->label('Status Pesanan')
                    ->options([
                        'DIPROSES' => 'DIPROSES',
                        'TELAH SELESAI' => 'TELAH SELESAI',
                    ])
                    ->selectablePlaceholder(false),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}