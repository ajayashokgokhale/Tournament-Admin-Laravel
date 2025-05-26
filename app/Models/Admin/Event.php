<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'events';
    protected $fillable = [
        'event_name',
        'event_start',
        'event_end',
        'event_location',
        'event_photo',
        'event_youtube_link',
        'event_status',
    ];

    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
    protected $primaryKey = 'id';

    protected $casts = [
        'event_start' => 'datetime',
        'event_end' => 'datetime',
    ];
}
