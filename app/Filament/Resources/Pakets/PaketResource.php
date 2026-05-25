<?php

namespace App\Filament\Resources\Pakets;

use App\Filament\Resources\Pakets\Pages\CreatePaket;
use App\Filament\Resources\Pakets\Pages\EditPaket;
use App\Filament\Resources\Pakets\Pages\ListPakets;
use App\Filament\Resources\Pakets\Schemas\PaketForm;
use App\Filament\Resources\Pakets\Tables\PaketsTable;
use App\Models\Paket;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class PaketResource extends Resource
{
    protected static ?string $model = Paket::class;

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-cake';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Pesanan dan Makanan';
    }

    public static function getNavigationSort(): ?int
    {
        return 1;
    }

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return PaketForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PaketsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPakets::route('/'),
            'create' => CreatePaket::route('/create'),
            'edit' => EditPaket::route('/{record}/edit'),
        ];
    }
}