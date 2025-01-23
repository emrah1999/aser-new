<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class DeletedScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */

    protected $table_name;

    public function __construct($table_name)
    {
        $this->table_name = $table_name;
    }

    public function apply(Builder $builder, Model $model)
    {
        $builder->whereNull($this->table_name . '.deleted_by');
    }
}