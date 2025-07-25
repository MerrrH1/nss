<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PurchaseTaxInvoiceResource\Pages;
use App\Filament\Resources\PurchaseTaxInvoiceResource\RelationManagers;
use App\Models\PurchaseTaxInvoice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PurchaseTaxInvoiceResource extends Resource
{
    protected static ?string $model = PurchaseTaxInvoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Faktur Pajak Masukan';

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
            'index' => Pages\ListPurchaseTaxInvoices::route('/'),
            'create' => Pages\CreatePurchaseTaxInvoice::route('/create'),
            'edit' => Pages\EditPurchaseTaxInvoice::route('/{record}/edit'),
        ];
    }
}
