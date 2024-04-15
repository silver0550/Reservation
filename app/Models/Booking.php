<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory;
    use SoftDeletes;

    const VALID_TIMES = [
        '08:00',
        '10:00',
        '12:00',
        '14:00',
        '16:00',
        '18:00',
    ];

    protected $guarded = ['id'];
    protected $attributes = [
        'status' => StatusEnum::PENDING,
    ];
    protected $casts = [
        'status' => StatusEnum::class,
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function user(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    public function startOfReservation(): Attribute
    {
        return Attribute::make(
            get: fn() => Carbon::parse($this->date.$this->time)
        );
    }

    public function endOfReservation(): Attribute
    {
        return Attribute::make(
            get: fn() => Carbon::parse($this->date.$this->time)->addHour(2)
        );
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
