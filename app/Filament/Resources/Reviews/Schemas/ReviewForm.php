<?php

namespace App\Filament\Resources\Reviews\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;

class ReviewForm
{
    public static function configure($form)
    {
        return $form->schema([
            TextInput::make('name')
            ->required()
            ->label('Nama'),
            TextInput::make('rating')
            ->required()
            ->numeric()
            ->minValue(1)
            ->maxValue(5)->default(5),
            Textarea::make('comment')
            ->required()
            ->label('Komentar')
            ->columnSpanFull(),
            Repeater::make('gallery')
                ->relationship('gallery')
                ->schema([
                    FileUpload::make('image')->directory('gallery')->image()->required(),
                ])
                ->columnSpanFull(),
        ]);
    }
}