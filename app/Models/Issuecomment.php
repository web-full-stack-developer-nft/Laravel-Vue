<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
