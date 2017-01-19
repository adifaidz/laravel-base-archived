<?php

namespace AdiFaidz\Base\Http\Controllers\Api;

use Illuminate\Http\Request;
;
use AdiFaidz\Base\Permission;
use AdiFaidz\Base\Transformers\PermissionTransformer;
use AdiFaidz\Base\Paginators\PermissionPaginator;

class PermissionController extends ApiController
{
    function __construct(PermissionTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function permission(Request $request)
    {
        $paginator = new PermissionPaginator($this->transformer);

        $json = $paginator->getJson();

        return response()->json($json);
    }
}