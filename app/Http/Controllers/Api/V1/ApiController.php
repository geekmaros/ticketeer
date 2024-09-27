<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    //
    public function include(string $relationship): bool
    {
        $params = request()->query('include');

        if(!isset($params)) {
            return false;
        }

        $includeValues = explode(',', strtolower($params));

        return in_array(strtolower($relationship), $includeValues);
    }
}
