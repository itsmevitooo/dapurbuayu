<?php

namespace App\Filament\Resources\Pakets\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Toggle;

class PaketForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Paket')
                            ->placeholder('Contoh: Paket A')
                            ->required(),

                        // INI SUDAH JADI OPTION BOX SESUAI GAMBAR
                        Select::make('category')
                            ->label('Kategori Paket')
                            ->options([
                                'nasi_box' => 'Nasi Box',
                                'prasmanan' => 'Prasmanan',
                                'tumpeng' => 'Tumpeng',
                                'akikah' => 'Akikah',
                            ])
                            ->native(false) // Tampilan lebih modern
                            ->required(),
                    ]),

                Grid::make(3)
                    ->schema([
                        TextInput::make('price')
                            ->label('Harga')
                            ->required()
                            ->numeric()
                            ->prefix('Rp'),
                        TextInput::make('min_order')
                            ->label('Min. Order')
                            ->required()
                            ->numeric()
                            ->default(1),
                        TextInput::make('total_orders')
                            ->label('Total Terjual')
                            ->numeric()
                            ->default(0),
                    ]),

                FileUpload::make('image')
                    ->label('Foto Paket')
                    ->image()
                    ->directory('pakets'),

                Textarea::make('description')
                    ->label('Deskripsi Singkat')
                    ->columnSpanFull(),

                // REPEATER GRUP MENU (Cara Januari yang Mas minta)
                Repeater::make('items')
                    ->label('Pengaturan Menu & Lauk')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('menu_category')
                                    ->label('Kategori Menu (Misal: Nasi / Lauk Pilihan)')
                                    ->options([
                                        'Nasi' => 'Nasi',
                                        'Lauk Utama' => 'Lauk Utama',
                                        'Lauk Pilihan' => 'Lauk Pilihan',
                                        'Sayuran' => 'Sayuran',
                                        'Pelengkap' => 'Pelengkap',
                                    ])
                                    ->searchable()
                                    ->createOptionUsing(fn (string $data) => $data)
                                    ->required(),

                                Toggle::make('is_selectable')
                                    ->label('Bisa Dipilih?')
                                    ->default(false),
                            ]),

                        TagsInput::make('list_lauk')
                            ->label('Isi Menu')
                            ->placeholder('Ketik nama menu lalu Enter')
                            ->required(),
                    ])
                    ->collapsible()
                    ->defaultItems(1)
                    ->createItemButtonLabel('Tambah Baris Kategori Menu')
            ]);
    }
}