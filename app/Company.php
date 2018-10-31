<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [ 'name' ];

    public function employees()
    {
        return $this->belongsToMany(Employee::class)
            ->withTimestamps();
    }
}
