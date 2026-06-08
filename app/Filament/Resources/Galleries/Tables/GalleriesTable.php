<?php

namespace App\Filament\Resources\Galleries\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GalleriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable(),
                ImageColumn::make('image')
                    ->label('Gambar')
                    ->disk('public'),
                TextColumn::make('category')
                    ->label('Kategori')
                    ->searchable(),
                
                // Menarik deskripsi: Jika ada data relasi, pakai itu. Jika tidak, pakai kolom manual
                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->getStateUsing(fn ($record) => $record->review?->comment ?? $record->description)
                    ->limit(50)
                    ->searchable(),
                
                // Menarik nama: Jika ada data relasi, pakai itu. Jika tidak, pakai kolom manual
                TextColumn::make('uploaded_by')
                    ->label('Diupload Oleh')
                    ->getStateUsing(fn ($record) => $record->review?->name ?? $record->uploaded_by)
                    ->searchable(),
                
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