<?php

namespace App\Filament\Resources\Pakets\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PaketForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->label('Nama Paket')
                ->required(),

            TextInput::make('min_order')
                ->label('Minimal Order (Porsi/Unit)')
                ->numeric()
                ->default(1)
                ->suffix('Porsi/Unit')
                ->required(),

            TextInput::make('price')
                ->label('Harga Satuan')
                ->numeric()
                ->prefix('Rp')
                ->required(),

            FileUpload::make('image')
                ->label('Foto Paket')
                ->image()
                ->directory('pakets')
                ->preserveFilenames()
                ->required(),

            // INI SOLUSINYA: Mengubah input items menjadi Repeater Bertingkat
            Repeater::make('items')
                ->label('Pengaturan Kategori Menu')
                ->schema([
                    TextInput::make('category_name')
                        ->label('Nama Kategori')
                        ->placeholder('Contoh: Menu Utama atau Sayuran')
                        ->required(),
                    
                    // Toggle inilah yang menentukan apakah menu bisa dipilih atau tidak
                    Toggle::make('is_selectable')
                        ->label('Customer bisa pilih menu di kategori ini?')
                        ->default(false),

                    // Repeater kedua untuk list menu di dalam kategori tersebut
                    Repeater::make('menus')
                        ->label('Daftar Menu')
                        ->schema([
                            TextInput::make('name')
                                ->label('Nama Menu')
                                ->required(),
                        ])
                        ->createItemButtonLabel('Tambah Menu')
                ])
                ->createItemButtonLabel('Tambah Kategori Baru')
                ->itemLabel(fn (array $state): ?string => $state['category_name'] ?? null),
        ]);
    }
}