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
                    ->required()
                    ->disabled() // Opsional: biasanya kode invoice tidak diedit manual
                    ->dehydrated(), 
                TextInput::make('full_name')
                    ->required(),
                TextInput::make('phone_number')
                    ->tel()
                    ->required(),
                Textarea::make('address')
                    ->required()
                    ->columnSpanFull(),
                DatePicker::make('delivery_date')
                    ->required(),
                TextInput::make('event_location'),
                TextInput::make('total_price')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                TextInput::make('payment_method')
                    ->required()
                    ->disabled(), // Biasanya diisi otomatis oleh sistem
                TextInput::make('payment_status')
                    ->required()
                    ->default('PENDING'),
                // Mengubah menjadi Select Dropdown
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