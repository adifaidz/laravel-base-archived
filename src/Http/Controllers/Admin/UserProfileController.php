<?php

namespace AdiFaidz\Base\Http\Controllers\Admin;

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
        $this->middleware('check_owner:userprofile,user');
        $this->transformer = $transformer;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $userprofile
     * @return \Illuminate\Http\Response
     */
    public function show(BaseUserProfile $userprofile)
    {
        $userprofileJson = json_encode($this->transformer->transform($userprofile));
        return view('base::admin.userprofile.show',compact('userprofile', 'userprofileJson'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $userprofile
     * @return \Illuminate\Http\Response
     */
    public function edit(BaseUserProfile $userprofile)
    {
        $userprofileJson = json_encode($this->transformer->transform($userprofile));
        return view('base::admin.userprofile.edit',compact('userprofile', 'userprofileJson'))->with($this->getFormReference());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $userprofile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BaseUserProfile $userprofile)
    {
        $this->validator($request->all())->validate();

        $userprofile->first_name = $request->first_name;
        $userprofile->last_name = $request->last_name;
        $userprofile->ic= $request->ic;
        $userprofile->address= $request->address;
        $userprofile->dob= Carbon::createFromFormat('d/m/Y', $request->dob);
        $userprofile->save();

        return redirect()->route('admin.userprofile.show', ['id' => $userprofile->id]);
    }

    public function getFormReference()
    {
      return [];
    }

    public function validator(array $data)
    {
      return Validator::make($data, []);
    }
}
