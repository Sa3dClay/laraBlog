<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    public $primaryKey = 'id';
    public $timestamps = true;

    // Relations
    public function user() {
        return $this->belongsTo(User::class);
    }
}
