<?php

namespace Chart\Http\Controllers\Api;

use Illuminate\Http\Request;

use Chart\User;
use Chart\Transformers\UserTransformer;
use Chart\Paginators\UserPaginator;

class UserController extends ApiController
{
    function __construct(UserTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function user(Request $request)
    {
        $paginator = new UserPaginator($this->transformer);

        $json = $paginator->getJson();

        return response()->json($json);
    }
}
