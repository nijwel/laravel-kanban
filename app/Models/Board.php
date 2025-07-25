<?php

namespace App\Models;

use App\Models\Column;
use App\Models\Scopes\AuthUserScope;
use Illuminate\Database\Eloquent\Model;

class Board extends Model {

    protected $fillable = [
        'user_id',
        'name',
        'slug',
    ];

    protected static function booted() {
        static::addGlobalScope( new AuthUserScope );
    }

    public function columns() {
        return $this->hasMany( Column::class )->orderBy( 'order' );
    }

}
