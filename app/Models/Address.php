<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'street',
        'city',
        'state',
        'zip',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
}
