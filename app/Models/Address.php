<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @package App\Models
 */
class Address extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'street',
        'city',
        'state',
        'zip',
        'lead_id'
    ];

    /**
     * @return BelongsTo 
     */
    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }
}
