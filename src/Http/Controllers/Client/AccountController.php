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
        $this->middleware('check_owner:user');
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

        return redirect()->route('client.account.show', $user);
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

        $validator->after(function($validator) use ($request, $user){
          if(!Hash::check($request->current_password, $user->password)){
              $validator->errors()->add('current_password', 'Current password does not match');
          }
        });

        if($validator->fails()){
            return redirect()->back()
                   ->withErrors($validator);
        }
        else{
            $user->password = Hash::make($request->password);
            $user->save();
            return redirect()->route('client.account.show', $user)
                   ->with('success', 'Password Changed');
        }
    }

    public function validator(array $data, $rule = [])
    {
      return Validator::make($data, $rule);
    }
}
