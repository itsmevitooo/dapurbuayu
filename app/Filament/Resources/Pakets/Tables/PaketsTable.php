<?php

namespace App\Filament\Resources\Pakets\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SelectColumn; // Tambahkan ini jika ingin edit kategori langsung di tabel
use Filament\Tables\Filters\SelectFilter; // Tambahkan ini untuk filter
use Filament\Tables\Table;

class PaketsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                
                // Menampilkan kategori dengan Badge (label berwarna)
                TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'nasi_box' => 'info',
                        'prasmanan' => 'success',
                        'tumpeng' => 'warning',
                        'akikah' => 'danger',
                        default => 'gray',
                    })
                    ->searchable(),

                TextColumn::make('price')
                    ->money('IDR') // Mengatur format uang ke Rupiah
                    ->sortable(),

                ImageColumn::make('image'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Menambahkan Filter Kategori di pojok kanan atas tabel
                SelectFilter::make('category')
                    ->label('Filter Kategori')
                    ->options([
                        'nasi_box' => 'Nasi Box',
                        'prasmanan' => 'Prasmanan',
                        'tumpeng' => 'Tumpeng',
                        'aqiqah' => 'Aqiqah',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->bulkActions([ // Perbaikan: Gunakan bulkActions untuk BulkActionGroup
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}