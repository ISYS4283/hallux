<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Crypt;

class Connection extends Model
{
    protected $fillable = [
        'name',
        'config',
    ];

    public function getConfigAttribute($value)
    {
        return Crypt::decrypt($value);
    }

    public function setConfigAttribute($value)
    {
        $this->attributes['config'] = Crypt::encrypt($value);
    }
}
