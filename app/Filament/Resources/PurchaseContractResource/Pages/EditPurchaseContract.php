<?php

namespace App\Filament\Resources\PurchaseContractResource\Pages;

use App\Filament\Resources\PurchaseContractResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPurchaseContract extends EditRecord
{
    protected static string $resource = PurchaseContractResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
