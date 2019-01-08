<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{

    protected static function boot() {
        parent::boot();
        static::addGlobalScope('postCount', function($builder) {
            $builder->withCount('posts');
        });
    }

    public function getRouteKeyName(){
        return 'title';
    }

    public function posts() {
        return $this->hasMany('App\Post');
    }
}
