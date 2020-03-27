<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Issuecomment extends Model
{
     protected $fillable = [
        'user_id','comment','issue_id', 
    ];
}
