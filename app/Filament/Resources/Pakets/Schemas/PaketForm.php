<?php

namespace App\Filament\Resources\Pakets\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select; // Import Select
use Filament\Schemas\Schema;

class PaketForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            // 1. Tambahkan Select Category agar muncul di filter halaman paket
            Select::make('category')
                ->label('Kategori Layanan')
                ->options([
                    'nasi_box' => 'Nasi Box',
                    'prasmanan' => 'Prasmanan',
                    'tumpeng' => 'Tumpeng',
                    'akikah' => 'Akikah',
                ])
                ->required()
                ->native(false)
                ->columnSpanFull(),

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

            // Repeater Bertingkat untuk Detail Menu
            Repeater::make('items')
                ->label('Pengaturan Kategori Menu')
                ->schema([
                    TextInput::make('category_name')
                        ->label('Nama Kategori')
                        ->placeholder('Contoh: Menu Utama atau Sayuran')
                        ->required(),
                    
                    Toggle::make('is_selectable')
                        ->label('Customer bisa pilih menu di kategori ini?')
                        ->default(false),

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
                ->itemLabel(fn (array $state): ?string => $state['category_name'] ?? null)
                ->columnSpanFull(),
        ]);
    }
}