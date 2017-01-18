<?php

namespace Chart\Http\Controllers\Api;

use Illuminate\Http\Request;

use Chart\Role;
use Chart\Transformers\RoleTransformer;
use Chart\Paginators\RolePaginator;

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
