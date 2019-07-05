<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

class Replie extends Model
{
    protected $fillable = ['content','topic_id','user_id'];
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
