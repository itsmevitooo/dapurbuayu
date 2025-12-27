<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('invoice_code')
                    ->required(),
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
                    ->numeric(),
                TextInput::make('payment_method')
                    ->required(),
                TextInput::make('payment_status')
                    ->required()
                    ->default('PENDING'),
                TextInput::make('order_status')
                    ->required()
                    ->default('DIPROSES'),
            ]);
    }
}
