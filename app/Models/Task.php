<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tasks;


class Task extends Model
{   
    protected $fillable = [
        'column_id',
        'title',
        'description',
        'image',
        'due_date',
        'order'
    ];

    public function column()
    {
        return $this->belongsTo(Column::class);
    }
}
