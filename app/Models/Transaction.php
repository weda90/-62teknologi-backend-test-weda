<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $incrementing = false;

    protected $hidden = [
        'business_id'
    ];

    protected $fillable = [
        "transaction_type"
    ];

    function businesses($id){
        return $this->where('business_id', $id)->pluck('transaction_type');
    }


}
