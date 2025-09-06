<?php

namespace App\Models;

use App\Models\Scopes\AuthUserScope;
use Illuminate\Database\Eloquent\Model;

class Task extends Model {

    protected static function booted() {
        static::addGlobalScope( new AuthUserScope );
    }

    protected $fillable = [
        'column_id',
        'user_id',
        'title',
        'slug',
        'description',
        'image',
        'due_date',
        'order',
        'status',

    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    public function column() {
        return $this->belongsTo( Column::class );
    }
}