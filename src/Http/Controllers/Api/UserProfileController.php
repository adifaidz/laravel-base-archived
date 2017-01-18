<?php

namespace Chart\Http\Controllers\Api;

use Illuminate\Http\Request;

use Chart\UserProfile;
use Chart\Transformers\UserProfileTransformer;
use Chart\Paginators\UserProfilePaginator;

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
