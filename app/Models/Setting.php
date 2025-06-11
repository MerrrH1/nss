<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'company_name',
        'letterhead_company',
        'logo',
        'address',
        'phone',
        'email',
        'website',
        'tax_number',
        'account_number',
        'description'
    ];
}
