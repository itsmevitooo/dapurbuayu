<?php

namespace App\Filament\Resources\Pakets\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PaketsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->label('Nama Paket'),
                TextColumn::make('category')
                    ->searchable()
                    ->label('Kategori'),
                TextColumn::make('min_order')
                    ->label('Minimal Porsi')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('price')
                    ->label ('Harga')
                    ->money('IDR', locale: 'id_ID')
                    ->sortable(),
                ImageColumn::make('image')
                    ->label('Gambar')    
                    ->disk('public')
                    ->visibility('public'),
                TextColumn::make('total_orders')
                    ->label('Total Pesanan')
                    ->numeric()
                    ->sortable(),
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
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
