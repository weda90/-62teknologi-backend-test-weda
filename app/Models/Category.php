<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $incrementing = false;

    protected $hidden = [
        'business_id'
    ];

    protected $fillable = [
        'alias',
        'title'
    ];
}
