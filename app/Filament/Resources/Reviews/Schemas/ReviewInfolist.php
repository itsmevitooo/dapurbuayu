<?php

namespace App\Filament\Resources\Reviews\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;

class ReviewInfolist
{
    public static function configure($infolist)
    {
        return $infolist
            ->schema([
                TextEntry::make('name'),
                TextEntry::make('rating'),
                TextEntry::make('comment')
                    ->columnSpanFull(),
                ImageEntry::make('image')
                    ->multiple()
                    ->circular(),
                TextEntry::make('created_at')
                    ->dateTime(),
            ]);
    }
}