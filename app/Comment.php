<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Comment extends Model
{
    protected $fillable = [
        'user_id', 'post_id', 'comment', 'ip_address',
    ];

    public function user(){
        return $this->belongsTo(\App\User::class,'user_id');
    }

    //created_atのフォーマットを変更
    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('Y/m/d H:i');
    }
}
