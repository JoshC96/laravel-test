<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @package App\Models
 */
class Lead extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string[]
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'electric_bill',
    ];

    /**
     * @return HasOne 
     */
    public function address(): HasOne
    {
        return $this->hasOne(Address::class);
    }
}
