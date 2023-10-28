<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        "address1",
        "address2",
        "address3",
        "city",
        "zip_code",
        "country",
        "state"
    ];

    protected $hidden = [
        'business_id'
    ];

    protected $appends = [
        'display_address'
    ];

    function getDisplayAddressAttribute() {
        $addressArray = [];

        if ($this->address1) {
            $addressArray[] = $this->address1;
        }

        if ($this->address2) {
            $addressArray[] = $this->address2;
        }

        if ($this->address3) {
            $addressArray[] = $this->address3;
        }

        $cityStateZip = $this->city.', '.$this->state.' '.$this->zip_code;
        $addressArray[] = $cityStateZip;

        return $addressArray;
    }

}
