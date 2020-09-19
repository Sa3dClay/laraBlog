<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    //table name
    protected $table = 'reports';
    // Timestamps
    public $timestamps = true;

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }
}
