<?php

namespace App\Filament\Resources\Galleries\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class GalleryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                
                FileUpload::make('image')
                    ->image()
                    // --- TAMBAHKAN 2 BARIS INI ---
                    ->disk('public') 
                    ->directory('pakets') 
                    // -----------------------------
                    ->required(),

                TextInput::make('category'),
                
                Textarea::make('description')
                    ->columnSpanFull(),
            ]);
    }
}
