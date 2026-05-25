<?php

namespace App\Filament\Resources\Galleries\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema; // Pastikan import ini ada

class GalleryForm
{
    // Tambahkan method ini agar sesuai dengan pemanggilan di Resource Anda
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')->required(),
            
            FileUpload::make('image')
                ->image()
                ->disk('public') 
                ->directory('gallery') // Sesuai dengan folder Anda
                ->visibility('public')
                ->required(),

            Select::make('category')
                ->options([
                    'Dokumentasi' => 'Dokumentasi',
                    'Testimoni Pelanggan' => 'Testimoni Pelanggan',
                ])
                ->default('Dokumentasi')
                ->required(),
            
            Textarea::make('description')->columnSpanFull(),
        ]);
    }
}