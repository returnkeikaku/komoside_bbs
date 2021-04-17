<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Post extends Model
{
    protected $fillable = [
        'user_id', 'category_id', 'content', 'title', 'image', 
    ];

    public function category(){
        // 投稿は1つのカテゴリーに属する
        return $this->belongsTo(\App\Category::class,'category_id');
    }

    public function user(){
        // 投稿は1つのカテゴリーに属する
        return $this->belongsTo(\App\User::class,'user_id');
    }

    public function comments(){
        return $this->hasMany(\App\Comment::class,'post_id', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag')->withTimestamps();
    }

    //created_atのフォーマットを変更
    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('Y/m/d H:i');
    }
}
