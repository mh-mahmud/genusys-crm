<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\API\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    protected $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        // $this->middleware('acl:super-admin');
        $this->permissionService = $permissionService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::user()->can('permission-list')) {

            return $this->permissionService->listItems($request);
        }
        return $this->noPermissionResponse();
    }

    public function getUserInfo(){
        return $this->permissionService->getUserInfo();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->can('permission-create')) {
            return $this->permissionService->createItem($request);
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
        if(Auth::user()->can('permission-show')) {
            return $this->permissionService->showItem($id);
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
        if(Auth::user()->can('permission-edit')) {
            return $this->permissionService->updateItem($request,$id);
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
        if(Auth::user()->can('permission-delete')) {
            return $this->permissionService->deleteItem($id);
        }
        return $this->noPermissionResponse();
    }

    public function checkUniqeInfo(Request $request)
    {

        return $this->permissionService->checkUniqueIdentity($request);
    }
}
