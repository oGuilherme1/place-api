<?php

namespace Src\Place\Infra\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string'; 

    protected $fillable = ['id', 'name', 'slug', 'city', 'state'];

    protected $casts = [
        'id' => 'string',
        'name' => 'string',
        'slug' => 'string',
        'city' => 'string',
        'state' => 'string',
    ];
}
