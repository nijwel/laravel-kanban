<?php

namespace App\Models;

use App\Models\Board;
use App\Models\Scopes\AuthUserScope;
use App\Models\Task;
use Illuminate\Database\Eloquent\Model;

class Column extends Model {

    protected $fillable = [
        'board_id',
        'name',
        'slug',
        'user_id',
        'order',
    ];

    protected static function booted() {
        static::addGlobalScope( new AuthUserScope );
    }

    public function board() {
        return $this->belongsTo( Board::class );
    }

    public function tasks() {
        return $this->hasMany( Task::class );
    }

}
