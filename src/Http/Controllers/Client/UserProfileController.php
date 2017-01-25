<?php

namespace AdiFaidz\Base\Http\Controllers\Client;

use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;

use AdiFaidz\Base\Http\Controllers\Controller;
use AdiFaidz\Base\Transformers\UserProfileTransformer;
use AdiFaidz\Base\BaseUserProfile;

class UserProfileController extends Controller
{

    function __construct(UserProfileTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $userprofile
     * @return \Illuminate\Http\Response
     */
    public function show(UserProfile $userprofile)
    {
        $userprofileJson = json_encode($this->transformer->transform($userprofile));
        return view('base::client.userprofile.show',compact('userprofile', 'userprofileJson'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $userprofile
     * @return \Illuminate\Http\Response
     */
    public function edit(UserProfile $userprofile)
    {
        $userprofileJson = json_encode($this->transformer->transform($userprofile));
        return view('base::client.userprofile.edit',compact('userprofile', 'userprofileJson'))->with($this->getFormReference());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $userprofile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserProfile $userprofile)
    {
        $userprofile->first_name = $request->first_name;
        $userprofile->last_name = $request->last_name;
        $userprofile->ic= $request->ic;
        $userprofile->address= $request->address;
        $userprofile->dob= Carbon::createFromFormat('d/m/Y', $request->dob);
        $userprofile->save();

        return redirect()->route('client.userprofile.show', ['id' => $userprofile->id]);
    }

    public function getFormReference()
    {
      return [];
    }
}
