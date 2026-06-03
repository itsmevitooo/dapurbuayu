<?php

namespace App\Filament\Resources\Galleries\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Schema;

class GalleryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('title')->required(),
            
            FileUpload::make('image')
                ->image()
                ->disk('public')
                ->directory('gallery')
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

            // Menyimpan nama admin secara otomatis
            Hidden::make('uploaded_by')
                ->default(auth()->user()->name),
        ]);
    }
}