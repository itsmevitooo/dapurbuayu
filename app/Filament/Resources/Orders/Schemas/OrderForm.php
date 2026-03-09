<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
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

                DatePicker::make('delivery_date')
                    ->label('Tanggal Pengiriman')
                    ->required(),

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
                    ])
                    ->required()
                    ->native(false)
                    ->default('DIPROSES'),
            ]);
    }
}