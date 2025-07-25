<?php

namespace App\Filament\Resources\PurchaseTaxInvoiceResource\Pages;

use App\Filament\Resources\PurchaseTaxInvoiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPurchaseTaxInvoice extends EditRecord
{
    protected static string $resource = PurchaseTaxInvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
