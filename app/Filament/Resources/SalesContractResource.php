<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SalesContractResource\Pages;
use App\Filament\Resources\SalesContractResource\RelationManagers;
use App\Models\SalesContract;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SalesContractResource extends Resource
{
    protected static ?string $model = SalesContract::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Kontrak Penjualan';

    protected static ?string $navigationGroup = 'Manajemen Penjualan';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([]);
            // ->schema([
            //     TextInput::make('contract_number')
            //         ->label('Nomor Kontrak')
            //         ->required(),

            //     DatePicker::make('contract_date')
            //         ->label('Tanggal Kontrak')
            //         ->required(),

            //     Select::make('buyer_id')
            //         ->label('Pembeli')
            //         ->relationship('buyer', 'name')
            //         ->searchable()
            //         ->createOptionForm([
            //             TextInput::make('name')
            //                 ->label('Nama Pembeli')
            //                 ->required(),

            //             TextInput::make('address')
            //                 ->label('Alamat')
            //                 ->required(),

            //             TextInput::make('phone')
            //                 ->label('No. Telepon')
            //                 ->tel(),

            //             TextInput::make('contact_person')
            //                 ->label('Penanggung Jawab'),

            //             TextInput::make('email')
            //                 ->label('Email')
            //                 ->email(),

            //             TextInput::make('npwp')
            //                 ->label('NPWP'),
            //         ])
            //         ->required(),
            //     Select::make('commodity_id')
            //         ->label('Komoditas')
            //         ->relationship('commodity', 'name') // sesuaikan relasi
            //         ->searchable()
            //         ->required(),

            //     TextInput::make('total_quantity_kg')
            //         ->label('Total Qty (kg)')
            //         ->numeric()
            //         ->required(),

            //     TextInput::make('price_per_kg')
            //         ->label('Harga per Kg')
            //         ->numeric()
            //         ->required(),

            //     TextInput::make('tolerated_kk_percentage')
            //         ->label('Toleransi KK (%)')
            //         ->numeric(),

            //     TextInput::make('tolerated_ka_percentage')
            //         ->label('Toleransi KA (%)')
            //         ->numeric(),

            //     TextInput::make('tolerated_ffa_percentage')
            //         ->label('Toleransi FFA (%)')
            //         ->numeric(),

            //     TextInput::make('tolerated_dobi_percentage')
            //         ->label('Toleransi DOBI (%)')
            //         ->numeric(),

            //     TextInput::make('quantity_delivered_kg')
            //         ->label('Qty Terkirim (kg)')
            //         ->numeric(),

            //     Select::make('payment_term')
            //         ->label('Syarat Pembayaran')
            //         ->options([
            //             'bulk_payment' => 'Curah Bayar',
            //             'dp50' => 'DP 50%, BP setelah kontrak selesai',
            //             'full_payment' => '100% setelah kontrak selesai',
            //         ])
            //         ->required(),

            //     Textarea::make('notes')
            //         ->label('Catatan'),
            // ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('contract_number')
                    ->label('Nomor Kontrak')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('contract_date')
                    ->date('d M Y')
                    ->label('Tgl Kontrak')
                    ->alignStart()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('buyer.name')
                    ->label('Pembeli')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('commodity.name')
                    ->label('Produk')
                    ->formatStateUsing(fn($state) => collect(explode(' ', $state))
                        ->map(fn($word) => strtoupper($word[0]))
                        ->implode('')),
                TextColumn::make('total_quantity_kg')
                    ->label('Kuantitas (KG)')
                    ->numeric(0, ',', '.'),
                TextColumn::make('price_per_kg')
                    ->label('Harga (Rp)')
                    ->numeric(0, ',', '.'),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn($state) => ucfirst($state))
                    ->color(fn($state) => match ($state) {
                        'active' => 'warning',
                        'completed' => 'success',
                        'canceled' => 'danger',
                        default => 'gray'
                    })
                    ->searchable(),
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
            'index' => Pages\ListSalesContracts::route('/'),
            'create' => Pages\CreateSalesContract::route('/create'),
            'edit' => Pages\EditSalesContract::route('/{record}/edit'),
        ];
    }
}
