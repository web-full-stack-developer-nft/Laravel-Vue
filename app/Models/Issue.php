<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'desc', 'project_id', 'created_by', 'issue_type_id', 'status_id'
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

    public function project()
    {
        return $this->belongsTo("App\Models\Project");
    }

    public function user()
    {
        return $this->belongsTo("App\Models\User",'created_by');
    }

    public function issue_type()
    {
        return $this->belongsTo("App\Models\IssuesType");
    }

    public function status()
    {
        return $this->belongsTo("App\Models\Status");
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
