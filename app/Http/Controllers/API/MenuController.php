<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\API\MenuService;
use Illuminate\Http\Request;
use App\Http\Requests\UserStoreRequest;
use Auth;

class MenuController extends Controller
{
    protected $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::user()->can('permission-group-list')) {
            return $this->menuService->listItems($request);
        }
        return $this->noPermissionResponse();
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->can('permission-group-create')) {
            return $this->menuService->createItem($request);
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
        if(Auth::user()->can('permission-group-show')) {
            return $this->menuService->showItem($id);
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
        if(Auth::user()->can('permission-group-edit')) {
            return $this->menuService->updateItem($request,$id);
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
        if(Auth::user()->can('permission-group-delete')) {
            return $this->menuService->delete($id);
        }

        return $this->noPermissionResponse();
    }
}