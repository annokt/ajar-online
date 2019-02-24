<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    public $guarded = [];

    public function invoice()
    {
        return $this->morphOne(Invoice::class, 'entity');
    }
}
