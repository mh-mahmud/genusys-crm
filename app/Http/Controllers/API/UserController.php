<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\API\UserService;
use Illuminate\Http\Request;
use App\Http\Requests\UserStoreRequest;
use Illuminate\Support\Facades\Log;
use Auth;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        // $this->middleware('acl:super-admin');
        $this->userService = $userService;
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::user()->can('user-list')) {
                
             return $this->userService->listItems($request);

        }
        return $this->noPermissionResponse();
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        if(Auth::user()->can('user-create')) {

            return $this->userService->createItem($request);

        }

        return $this->noPermissionResponse();
    }

    public function show($id)
    {
        if(Auth::user()->can('user-show')) {

            return $this->userService->showItem($id);
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
        if(Auth::user()->can('user-edit')) {
            return $this->userService->updateItem($request,$id);
        }

        return $this->noPermissionResponse();
    }

     /**
     * Delete the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->can('user-delete')) {
            return $this->userService->delete($id);
        }

        return $this->noPermissionResponse();
    }

    public function changePassword(Request $request)
    {
        return $this->userService->changePassword($request);
    }

    public function userStatusChange($id)
    {
        if(Auth::user()->can('user-change-status')) {
            return $this->userService->userStatusChange($id);
        }

        return $this->noPermissionResponse();
    }

}