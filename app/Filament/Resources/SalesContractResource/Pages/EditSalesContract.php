<?php

namespace App\Filament\Resources\SalesContractResource\Pages;

use App\Filament\Resources\SalesContractResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSalesContract extends EditRecord
{
    protected static string $resource = SalesContractResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
