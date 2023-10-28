<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;
    use Uuids;


    protected $table = 'business';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'alias',
        'name',
        'image_url',
        'is_closed',
        'url',
        'review_count',
        'rating',
        'price',
        'phone',
        'display_phone',
        'distance'
    ];


    /**
     * Get the locations associated with the business.
     */
    public function locations()
    {
        return $this->hasOne(Location::class);
    }

    /**
     * Get the categories associated with the business.
     */
    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    /**
     * Get the coordinates associated with the business.
     */
    public function coordinates()
    {
        return $this->hasOne(Coordinate::class);
    }

    /**
     * Get the transactions associated with the business.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

}
