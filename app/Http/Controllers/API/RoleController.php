<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\API\RoleService;
use Illuminate\Http\Request;
use Auth;

class RoleController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        // $this->middleware('acl:super-admin');
        $this->roleService          = $roleService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::user()->can('role-list')) {

            return $this->roleService->listItems($request);

        }
        return $this->noPermissionResponse();
    }

    public function getList(Request $request)
    {
        return $this->roleService->listItems($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        if(Auth::user()->can('role-store')) {
            

            return $this->roleService->createItem($request);

        }
        return $this->noPermissionResponse();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::user()->can('role-show')) {

            return $this->roleService->showItem($id);

        }
        return $this->noPermissionResponse();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(Auth::user()->can('role-edit')) {

            return $this->roleService->updateItem($request,$id);

        }
        return $this->noPermissionResponse();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->can('role-delete')) {

            return $this->roleService->deleteItem($id);

        }
        return $this->noPermissionResponse();
    }

    public function changeItemStatus(Request $request, $id)
    {
        if(Auth::user()->can('role-edit')) {

            return $this->roleService->changeItemStatus($request, $id);

        }
        return $this->noPermissionResponse();
    }

    public function checkUniqeInfo(Request $request)
    {

        return $this->roleService->checkUniqueIdentity($request);


    }
}
