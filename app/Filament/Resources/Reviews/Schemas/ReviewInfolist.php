<?php

namespace App\Filament\Resources\Reviews\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section;

class ReviewInfolist
{
    public static function configure($infolist)
    {
        return $infolist->schema([
            TextEntry::make('name'),
            TextEntry::make('rating'),
            TextEntry::make('comment')->columnSpanFull(),
            Section::make('Foto Ulasan')
                ->schema([
                    RepeatableEntry::make('gallery')
                        ->schema([
                            ImageEntry::make('image')->label('Foto'),
                        ])->grid(3),
                ]),
            TextEntry::make('created_at')->dateTime(),
        ]);
    }
}