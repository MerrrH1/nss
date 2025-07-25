<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PurchaseContractResource\Pages;
use App\Filament\Resources\PurchaseContractResource\RelationManagers;
use App\Models\PurchaseContract;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PurchaseContractResource extends Resource
{
    protected static ?string $model = PurchaseContract::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Kontrak Pembelian';

    protected static ?string $navigationGroup = 'Manajemen Pembelian';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPurchaseContracts::route('/'),
            'create' => Pages\CreatePurchaseContract::route('/create'),
            'edit' => Pages\EditPurchaseContract::route('/{record}/edit'),
        ];
    }
}
