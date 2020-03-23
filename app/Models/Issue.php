<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class Issue extends Model
{

    use LaravelVueDatatableTrait;

    protected $dataTableColumns = [
        'id' => [
            'searchable' => false,
        ],
        'title' => [
            'searchable' => true,
        ],
        'desc' => [
            'searchable' => false,
        ],
        'created_at' => [
            'searchable' => false,
        ]
    ];
    protected $columns = [
        'title'=>'', 'desc'=>'', 'client' => '', 'project'=> '', 'department' => '', 'issue_type'=> '',
    ];

    protected $dataTableRelationships = [
        "belongsTo" => [
            'issue_type' => [
                "model" => 'App\Models\IssueType',
                'foreign_key' => 'issue_type_id',
                'columns' => [
                    'name' => [
                        'searchable' => true,
                        'orderable' => true,
                    ],
                ],
            ],
            'project' => [
                "model" => 'App\Models\Project',
                'foreign_key' => 'project_id',
                'columns' => [
                    'name' => [
                        'searchable' => true,
                        'orderable' => true,
                    ],
                ],
            ],
            'client' => [
                "model" => 'App\Models\Client',
                'foreign_key' => 'client_id',
                'columns' => [
                    'name' => [
                        'searchable' => true,
                        'orderable' => true,
                    ],
                ],
            ],
            'department' => [
                "model" => 'App\Models\Department',
                'foreign_key' => 'department_id',
                'columns' => [
                    'name' => [
                        'searchable' => true,
                        'orderable' => true,
                    ],
                ],
            ],
            'user' => [
                "model" => 'App\User',
                'foreign_key' => 'created_by',
                'columns' => [
                    'name' => [
                        'searchable' => true,
                        'orderable' => true,
                    ],
                ],
            ],
            'status' => [
                "model" => 'App\Models\Status',
                'foreign_key' => 'status_id',
                'columns' => [
                    'name' => [
                        'searchable' => true,
                        'orderable' => true,
                    ],
                ],
            ],
        ],
    ];

    public function getTableColumns() {
        return $this->columns;;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'desc', 'project_id', 'client_id', 'department_id', 'created_by', 'issue_type_id', 'status_id'
    ];

    protected $casts = [
        'created_at' => 'datetime:d-m-y h:i A',
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
        return $this->belongsTo("App\User",'created_by');
    }

    public function issue_type()
    {
        return $this->belongsTo("App\Models\IssueType");
    }

    public function status()
    {
        return $this->belongsTo("App\Models\Status");
    }

    public function client()
    {
        return $this->belongsTo("App\Models\Client");
    }

    public function department()
    {
        return $this->belongsTo("App\Models\Department");
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
