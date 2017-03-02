<?php

namespace AdiFaidz\Base\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;

use AdiFaidz\Base\BaseUserProfile;
use AdiFaidz\Base\Transformers\UserProfileTransformer;
use AdiFaidz\Base\Paginators\UserProfilePaginator;

class UserProfileController extends ApiController
{
    function __construct(UserProfileTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function userprofile(Request $request)
    {
        $paginator = new UserProfilePaginator($this->transformer);

        $json = $paginator->getJson();

        return response()->json($json);
    }
}
