<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        // 'date' => 'date_format:d/m/yyyy',
        // 'date' => 'date:Y-m-d',
        // 'reg_last_date' => 'datetime:Y-m-d H:00',
        'date' => 'timestamp',
        'reg_last_date' => 'timestamp',
        'fee' => 'json',
    ];

    /**
     * Get all of the comments for the Event
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function logistics()
    {
        return $this->hasMany(Logistics::class);
    }

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }
}
