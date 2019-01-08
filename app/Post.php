<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];

    protected $with = ['channel', 'user'];

    protected static function boot() {
        parent::boot();
        static::addGlobalScope('commentCount', function($builder) {
            $builder->withCount('comments');
        });

        static::deleting(function($post) {
            $post->comments->each->delete();
        });
    }


    public function channel() {
        return $this->belongsTo('App\Channel');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function comments() {
        return $this->hasMany('App\Comment');
    }
}
