<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function individual(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Individual::class, 'id');
    }

    public function legal_persons(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Individual::class, 'id');
    }
}
