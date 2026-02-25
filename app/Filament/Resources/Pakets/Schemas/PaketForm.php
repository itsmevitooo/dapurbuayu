<?php

namespace App\Filament\Resources\Pakets\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
// Sisanya ambil dari Forms karena di Schemas memang belum ada
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
                    ->components([
                        TextInput::make('name')
                            ->label('Nama Paket')
                            ->placeholder('Contoh: Paket A')
                            ->required(),

                        Select::make('category')
                            ->label('Kategori Paket')
                            ->options([
                                'nasi_box' => 'Nasi Box',
                                'prasmanan' => 'Prasmanan',
                                'tumpeng' => 'Tumpeng',
                                'akikah' => 'Akikah',
                            ])
                            ->native(false)
                            ->required(),
                    ]),

                Grid::make(3)
                    ->components([
                        TextInput::make('price')
                            ->label('Harga')
                            ->required()
                            ->numeric()
                            ->prefix('Rp'),
                        TextInput::make('min_order')
                            ->label('Min. Order')
                            ->required()
                            ->numeric()
                            ->default(25),
                        TextInput::make('total_orders')
                            ->label('Total Terjual')
                            ->numeric()
                            ->default(0),
                    ]),

                FileUpload::make('image')
                    ->label('Foto Paket')
                    ->image()
                    ->disk('public')
                    ->directory('pakets')
                    ->visibility('public'),

                Textarea::make('description')
                    ->label('Deskripsi Singkat')
                    ->columnSpanFull(),

                // Repeater harus di-import dari Forms
                Repeater::make('details')
                    ->relationship('details') 
                    ->label('Pengaturan Menu & Lauk')
                    ->schema([ // REPEATER di Forms tetap pakai fungsi ->schema()
                        Grid::make(2)
                            ->components([
                                Select::make('category')
                                    ->label('Kategori Menu')
                                    ->options([
                                        'Nasi' => 'Nasi',
                                        'Lauk Utama' => 'Lauk Utama',
                                        'Lauk Pilihan' => 'Lauk Pilihan',
                                        'Sayuran' => 'Sayuran',
                                        'Pelengkap' => 'Pelengkap',
                                    ])
                                    ->required(),

                                Toggle::make('is_selectable')
                                    ->label('Bisa Dipilih?')
                                    ->default(false),
                            ]),

                        TagsInput::make('name')
                            ->label('Isi Menu')
                            ->placeholder('Ketik nama menu lalu Enter')
                            ->required(),
                    ])
                    ->collapsible()
                    ->defaultItems(1)
                    ->createItemButtonLabel('Tambah Baris Kategori Menu')
                    ->columnSpanFull(),
            ]);
    }
}