<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class Upazila extends Model
{

    use LaravelVueDatatableTrait;

    protected $dataTableColumns = [
        'id' => [
            'searchable' => false,
        ],
        'name' => [
            'searchable' => true,
        ],
    ];
    protected $dataTableRelationships = [
        "belongsTo" => [
            'district' => [
                "model" => 'App\Models\District',
                'foreign_key' => 'district_id',
                'columns' => [
                    'name' => [
                        'searchable' => true,
                        'orderable' => true,
                    ],
                ],
            ],
        ],
    ];
    protected $fillable = [
        'name',
        'district_id'
    ];

    protected $columns = [
        'name' => '',
        'district' => ''
    ];

    public function getTableColumns() {
        return $this->columns;;
    }
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

    public function district()
    {
        return $this->belongsTo("App\Models\District");
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
