<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Board;
use App\Models\Task;



class Column extends Model
{   

    protected $fillable = [
        'board_id',
        'name',
        'order'
    ];

    public function board()
    {
        return $this->belongsTo(Board::class);
    }

public function tasks()
{
    return $this->hasMany(Task::class);
}

}
