<?php

namespace AdiFaidz\Base\Http\Controllers\Client;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

use AdiFaidz\Base\Http\Controllers\Controller;
use AdiFaidz\Base\Transformers\UserTransformer;
use AdiFaidz\Base\BaseUser;

class AccountController extends Controller
{
    function __construct(UserTransformer $transformer)
    {
        $this->transformer = $transformer;
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
        return view('base::client.account.show',compact('user', 'userJson'));
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
        return view('base::client.account.edit',compact('user', 'userJson'))->with($this->getFormReference());
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

        return redirect()->route('client.account.show', ['id' => $user->id]);
    }

    public function changePassword(BaseUser $user){
        return view('base::client.account.changePassword', compact('user'));
    }

    public function savePassword(Request $request, BaseUser $user){
        $validator = $this->validator($request->all(), [
            'current_password' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ]);
        $validator->validate();

        $validator->after(function(){
          if(!Hash::check($request->current_password, $user->password)){
              $validator->errors()->add('current_password', 'Does not match with current password');
          }
        });

        if($validator->fails()){
            dd("FAIL");
        }
        else{
            dd('OK');
        }
    }

    public function validator(array $data, $rule = [])
    {
      return Validator::make($data, $rule);
    }
}
