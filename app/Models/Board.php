<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Column;


class Board extends Model
{
    public function columns()
    {
        return $this->hasMany(Column::class)->orderBy('order');
    }

}
