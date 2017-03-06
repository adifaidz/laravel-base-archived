<?php

namespace AdiFaidz\Base\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Validator;

use AdiFaidz\Base\Http\Controllers\Controller;
use AdiFaidz\Base\Transformers\RoleTransformer;
use AdiFaidz\Base\BaseRole;
use AdiFaidz\Base\BasePermission;

class RoleController extends Controller
{

    function __construct(RoleTransformer $transformer)
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
        return view('base::admin.role.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('base::admin.role.create')->with($this->getFormReference());
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

        $role = new BaseRole;
        $role->name = $request->name;
        $role->display_name = $request->display_name;
        $role->description = $request->description;
        $role->save();
        $role->syncPermissions(json_decode($request->permissions));

        return redirect()->route('admin.role.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $role
     * @return \Illuminate\Http\Response
     */
    public function show(BaseRole $role)
    {
        $roleJson = json_encode($this->transformer->transform($role));
        return view('base::admin.role.show',compact('role', 'roleJson'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(BaseRole $role)
    {
        $roleJson = json_encode($this->transformer->transform($role));
        return view('base::admin.role.edit',compact('role', 'roleJson'))->with($this->getFormReference());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BaseRole $role)
    {
        $this->validator($request->all())->validate();

        $role->name = $request->name;
        $role->display_name = $request->display_name;
        $role->description = $request->description;
        $role->save();
        $role->syncPermissions(json_decode($request->permissions));

        return redirect()->route('admin.role.show', ['id' => $role->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(BaseRole $role)
    {
        $role->delete();

        if(request()->ajax())
          return $role;

        return redirect()->route('admin.role.index');
    }

    public function getFormReference()
    {
      return [
        'permissions' => BasePermission::all(['id','display_name']),
      ];
    }

    public function validator(array $data)
    {
      return Validator::make($data, []);
    }
}
