<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $fillable = array('courier_id', 'region_id', 'start', 'end');

    public function courier()
    {
        return $this->belongsTo('App\Courier');
    }

    public function region()
    {
        return $this->belongsTo('App\Region');
    }
}
