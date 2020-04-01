<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'desc',
        'user_id', 
        'issue_id', 
        'start_date', 
        'end_date', 
        'status_id', 
        'priority', 
        'created_by'
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function issue()
	{
		return $this->belongsTo("App\Models\Issue");
	}

	public function user()
	{
		return $this->belongsTo("App\User");
	}

	public function status()
	{
		return $this->belongsTo("App\Models\Status");
    }
    
    public function creator()
    {
        return $this->belongsTo("App\User", "created_by");
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
