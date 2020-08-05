<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    public function note()
    {
        return $this->hasMany(Note::class);
    }

    public function total()
    {
        return $this->note()->count();
    }

    public function getAll()
    {
        return Category::all();
    }
}
