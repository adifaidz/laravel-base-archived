<?php

namespace AdiFaidz\Base\Http\Controllers\Api;

use Illuminate\Http\Request;

use AdiFaidz\Base\Role;
use AdiFaidz\Base\Transformers\RoleTransformer;
use AdiFaidz\Base\Paginators\RolePaginator;

class RoleController extends ApiController
{
    function __construct(RoleTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function role(Request $request)
    {
        $paginator = new RolePaginator($this->transformer);

        $json = $paginator->getJson();

        return response()->json($json);
    }
}
