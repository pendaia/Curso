<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $fillable = [
        'title', 'description', 'slug'
    ];

    public function realStates(){
        return $this->belongsToMany(RealState::class,'real_state_categories');
    }
}
