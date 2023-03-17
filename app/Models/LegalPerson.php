<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegalPerson extends Model
{
    use HasFactory;

    protected $hidden = [
        'id_contact_address',
        'id_billing_address',
        'created_at',
        'updated_at'
    ];

    public function contact_address(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Address::class, 'id_contact_address');
    }

    public function billing_address(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Address::class, 'id_billing_address');
    }

    public function office(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Office::class, 'id_legal_person');
    }
}
