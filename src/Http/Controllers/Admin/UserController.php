<?php

namespace AdiFaidz\Base\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

use AdiFaidz\Base\Http\Controllers\Controller;
use AdiFaidz\Base\Transformers\UserTransformer;
use AdiFaidz\Base\BaseUser;
use AdiFaidz\Base\BaseRole;
use AdiFaidz\Base\BaseUserProfile;

class UserController extends Controller
{

    function __construct(UserTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('base::admin.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('base::admin.user.create')->with($this->getFormReference());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = new BaseUser;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make('user123');
        $user->save();

        $userprofile = new BaseUserProfile;
        $userprofile->user_id = $user->id;
        $userprofile->save();

        $user->syncRoles(json_decode($request->roles));

        return redirect()->route('admin.user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $user
     * @return \Illuminate\Http\Response
     */
    public function show(BaseUser $user)
    {
        $userJson = json_encode($this->transformer->transform($user));
        return view('base::admin.user.show',compact('user', 'userJson'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(BaseUser $user)
    {
        $userJson = json_encode($this->transformer->transform($user));

        return view('base::admin.user.edit',compact('user', 'userJson'))->with($this->getFormReference());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BaseUser $user)
    {
        $this->validator($request->all())->validate();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        $user->syncRoles(json_decode($request->roles));

        return redirect()->route('admin.user.show', ['id' => $user->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(BaseUser $user)
    {
        $user->delete();

        if(request()->ajax())
          return $user;

        return redirect()->route('admin.user.index');
    }

    public function getFormReference()
    {
      return [
        'roles' => BaseRole::all(['id', 'display_name']),
      ];
    }

    public function validator(array $data)
    {
      return Validator::make($data, []);
    }
}
