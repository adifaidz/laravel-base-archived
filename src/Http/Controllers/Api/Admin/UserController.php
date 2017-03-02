<?php

namespace AdiFaidz\Base\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;

use AdiFaidz\Base\BaseUser;
use AdiFaidz\Base\Transformers\UserTransformer;
use AdiFaidz\Base\Paginators\UserPaginator;

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
