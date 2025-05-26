<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contest extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'contests';
    protected $fillable = [
        'match_title',
        'match_datetime',
        'match_location',
        'event_id',
        'franchises_1_id',
        'franchises_2_id',
        'score_1',
        'score_2',
        'status',
    ];

    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
    protected $primaryKey = 'id';

    protected $casts = [
        'match_datetime' => 'datetime',
    ];

    // Relationships
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function franchise1()
    {
        return $this->belongsTo(Franchise::class, 'franchises_1_id');
    }

    public function franchise2()
    {
        return $this->belongsTo(Franchise::class, 'franchises_2_id');
    }
}
