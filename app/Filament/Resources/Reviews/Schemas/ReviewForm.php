<?php

namespace App\Filament\Resources\Reviews\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;

class ReviewForm
{
    public static function configure($form)
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),
                TextInput::make('rating')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(5)
                    ->default(5),
                Textarea::make('comment')
                    ->required()
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->multiple()
                    ->directory('reviews')
                    ->image()
                    ->columnSpanFull(),
            ]);
    }
}