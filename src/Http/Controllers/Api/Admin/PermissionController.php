<?php

namespace AdiFaidz\Base\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use AdiFaidz\Base\Http\Controllers\Api\ApiController;

use AdiFaidz\Base\BasePermission;
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
