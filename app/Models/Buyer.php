<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Buyer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'contact_person',
        'email',
        'npwp'
    ];

    public function salesContracts() {
        return $this->hasMany(SalesContract::class);
    }
}