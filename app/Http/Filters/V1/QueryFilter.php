<?php

namespace App\Http\Filters\V1;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class QueryFilter
{
    protected $builder;
    protected $request;
    protected $sortable = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;


        foreach ($this->request->all() as $key => $value) {
            if (method_exists($this, $key)) {
                $this->$key($value);
            }
        }

        return $builder;
    }

    protected function filter($arr)
    {

        foreach ($arr as $key => $value) {
            if (method_exists($this, $key)) {
                $this->$key($value);
            }
        }

        return $this->builder;
    }

    protected function sort($value)
    {
        $sortAttrs = explode(',', $value);

        foreach ($sortAttrs as $sortAttr) {
            $direction = 'asc';

            //we can also use strpos
            if (str_starts_with($sortAttr, '-')) {
                $direction = 'desc';

                $sortAttr = ltrim($sortAttr, '-');

            }

            if(!in_array($sortAttr, $this->sortable) && !array_key_exists($sortAttr, $this->sortable)) continue;

            $columnName = $this->sortable[$sortAttr] ?? null;

            if($columnName === null){
                $columnName = $sortAttr;
            }

            $this->builder->orderBy($columnName, $direction);
        }
    }


}
