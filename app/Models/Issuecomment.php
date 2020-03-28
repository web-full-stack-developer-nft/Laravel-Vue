<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Issuecomment extends Model
{
    protected $fillable = [
        'user_id','comment','issue_id', 'is_replyed', 
    ];

     public function issue()
    {
        return $this->belongsTo("App\Models\Issue");
    }

    public function user()
    {
        return $this->belongsTo("App\User");
    }

    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->diffForHumans();
    }
}
