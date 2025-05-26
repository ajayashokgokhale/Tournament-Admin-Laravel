<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Franchise extends Model
{
    //
    use HasFactory, SoftDeletes;


    protected $table = 'franchises';
    protected $fillable = ['name',
        'email',
        'logo',
        'tagline',
        'about_franchise',
        'status',];

    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
    protected $primaryKey = 'id';


}
