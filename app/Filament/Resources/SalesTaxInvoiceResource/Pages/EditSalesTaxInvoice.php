<?php

namespace App\Filament\Resources\SalesTaxInvoiceResource\Pages;

use App\Filament\Resources\SalesTaxInvoiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSalesTaxInvoice extends EditRecord
{
    protected static string $resource = SalesTaxInvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
