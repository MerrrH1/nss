<?php

namespace App\Filament\Resources\PurchaseTaxInvoiceResource\Pages;

use App\Filament\Resources\PurchaseTaxInvoiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPurchaseTaxInvoices extends ListRecords
{
    protected static string $resource = PurchaseTaxInvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
