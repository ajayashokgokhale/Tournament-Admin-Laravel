<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Player extends Model
{
    //
    use HasFactory, SoftDeletes;

    protected $table = 'players';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
    protected $primaryKey = 'id';
    protected $fillable = ['franchise_id',
        'name',
        'position',
        'photo',
        'status',
        'profile',
        'youtube_link',];

    public function franchise()
    {
        return $this->belongsTo(Franchise::class, 'franchise_id');
    }
}
