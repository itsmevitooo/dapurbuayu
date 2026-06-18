<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\DateTimePicker; 
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Placeholder;
use Filament\Schemas\Schema; 

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Kita gunakan Placeholder dengan styling CSS agar terlihat seperti TextInput
                Placeholder::make('detail_paket')
                    ->label('Paket yang Dipilih')
                    ->content(fn ($record) => $record?->items->pluck('item_name')->implode(', '))
                    ->extraAttributes([
                        'style' => 'border: 1px solid #4a4a4a; padding: 10px; border-radius: 8px; background-color: #1f1f1f;'
                    ]),
                
                Placeholder::make('detail_lauk')
                    ->label('Lauk yang Dipilih')
                    ->content(fn ($record) => $record?->items->map(fn($item) => 
                        is_array($item->side_dish) ? implode(', ', $item->side_dish) : $item->side_dish
                    )->implode(', '))
                    ->extraAttributes([
                        'style' => 'border: 1px solid #4a4a4a; padding: 10px; border-radius: 8px; background-color: #1f1f1f;'
                    ]),

                TextInput::make('invoice_code')
                    ->label('Kode Invoice')
                    ->disabled() 
                    ->dehydrated(), 

                TextInput::make('full_name')
                    ->label('Nama Lengkap')
                    ->required(),

                TextInput::make('phone_number')
                    ->label('No. Telepon')
                    ->tel()
                    ->required(),

                Textarea::make('address')
                    ->label('Alamat Pengiriman')
                    ->required()
                    ->columnSpanFull(),

                DateTimePicker::make('delivery_date')
                    ->label('Tanggal & Jam Pengiriman')
                    ->required()
                    ->seconds(false)
                    ->displayFormat('d/m/Y H:i')
                    ->format('Y-m-d H:i:s'),

                TextInput::make('total_price')
                    ->label('Total Harga')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),

                TextInput::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->disabled()
                    ->dehydrated(),

                Select::make('payment_status')
                    ->label('Status Pembayaran')
                    ->options([
                        'PENDING' => 'PENDING',
                        'LUNAS' => 'LUNAS',
                        'EXPIRED' => 'EXPIRED',
                    ])
                    ->native(false),

                Select::make('order_status')
                    ->label('Status Pesanan')
                    ->options([
                        'DIPROSES' => 'DIPROSES',
                        'TELAH SELESAI' => 'TELAH SELESAI',
                        'DIBATALKAN' => 'DIBATALKAN',
                    ])
                    ->required()
                    ->native(false)
                    ->default('DIPROSES'),
            ]);
    }
}