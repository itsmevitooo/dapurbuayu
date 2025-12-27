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
                    ->searchable(),
                TextColumn::make('full_name')
                    ->label ('Nama Lengkap')
                    ->searchable(),
                TextColumn::make('phone_number')
                    ->label ('No Telp.')
                    ->searchable(),
                TextColumn::make('delivery_date')
                    ->label ('Tangga Pengiriman')
                    ->date()
                    ->sortable(),
                TextColumn::make('address') // Sesuaikan dengan field 'address' yang ada di Form Mas
                    ->label ('Lokasi Pengiriman')
                    ->limit(50) // Biar kalau alamatnya panjang nggak ngerusak layout tabel
                    ->searchable(),
                TextColumn::make('total_price')
                    ->label('Harga')
                    ->money('IDR', locale: 'id_ID') // Mengubah simbol $ ke Rp dan format ribuan ke titik
                    ->sortable(),
                TextColumn::make('payment_method')
                    ->label ('Metode Pembayaran')
                    ->searchable(),
                TextColumn::make('payment_status')
                    ->searchable(),
                TextColumn::make('order_status')
                    ->searchable(),
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
