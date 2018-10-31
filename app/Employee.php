<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [ 'name' ];

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_employee')
            ->withTimestamps();
    }
}
