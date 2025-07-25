<?php

namespace App\Filament\Resources\PurchaseContractResource\Pages;

use App\Filament\Resources\PurchaseContractResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPurchaseContracts extends ListRecords
{
    protected static string $resource = PurchaseContractResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
