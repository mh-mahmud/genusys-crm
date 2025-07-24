<?php


namespace App\Services\API;


use App\Helpers\Helper;
use App\Repositories\PermissionRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class PermissionService
{
    protected $permissionRepository;

    public function __construct(PermissionRepository $permissionRepository)
    {

        $this->permissionRepository       = $permissionRepository;

    }

    public function getUserInfo()
    {

        DB::beginTransaction();

        try{

            $userInfo = $this->permissionRepository->getUserInfo();

        }catch (Exception $e) {

            DB::rollBack();
            Log::error('Found Exception: ' . $e->getMessage() . ' [Script: ' . __CLASS__ . '@' . __FUNCTION__ . '] [Origin: ' . $e->getFile() . '-' . $e->getLine() . ']');

            return response()->json([
                'status'            => 424,
                'messages'          => config('status.status_code.424'),
                'error'             => $e->getMessage()
            ]);
        }

        DB::commit();

        return response()->json([
            'status'        => 200,
            'messages'      => config('status.status_code.200'),
            'userInfo'      => $userInfo
        ]);
    }

    public function listItems($request)
    {

        DB::beginTransaction();

        try{

            $listing                = $this->permissionRepository->listing($request);

        }catch (Exception $e) {

            DB::rollBack();
            Log::error('Found Exception: ' . $e->getMessage() . ' [Script: ' . __CLASS__ . '@' . __FUNCTION__ . '] [Origin: ' . $e->getFile() . '-' . $e->getLine() . ']');

            return response()->json([
                'status'            => 424,
                'messages'          => config('status.status_code.424'),
                'error'             => $e->getMessage()
            ]);
        }

        DB::commit();

        return response()->json([
            'status'                => 200,
            'messages'              => config('status.status_code.200'),
            'permission_list'       => $listing
        ]);
    }

    public function showItem($id)
    {

        DB::beginTransaction();

        try{

            $permission             = $this->permissionRepository->show($id);

        }catch (Exception $e) {

            DB::rollBack();
            Log::error('Found Exception: ' . $e->getMessage() . ' [Script: ' . __CLASS__ . '@' . __FUNCTION__ . '] [Origin: ' . $e->getFile() . '-' . $e->getLine() . ']');

            return response()->json([
                'status'            => 424,
                'messages'          => config('status.status_code.424'),
                'error'             => $e->getMessage()
            ]);
        }

        DB::commit();

        return response()->json([
            'status'                => 200,
            'message'               => config('status.status_code.200'),
            'permission_info'       => $permission
        ]);
    }


    public function createItem($request)
    {
        $validator = Validator::make($request->all(),[

            'name'                  => 'required|string|max:50|min:3|unique:permissions',

        ]);

        if($validator->fails()) {

            return response()->json([
                'status'            => 400,
                'messages'          => config('status.status_code.400'),
                'errors'            => $validator->errors()->all()
            ]);

        }
        $data                       = $request->all();
        $data['id']                 = Helper::generateTableId();
        $data['slug']               = Helper::slugify($request->name);

        DB::beginTransaction();

        try{

            $permission_info        = $this->permissionRepository->create($data);
           

        }catch (Exception $e) {

            DB::rollBack();

            return response()->json([
                'status'            => 424,
                'messages'          => config('status.status_code.424'),
                'error'             => $e->getMessage()
            ]);
        }

        DB::commit();

        return response()->json([
            'status'                => 200,
            'message'               => config('status.status_code.200'),
            'permission_created'    => $permission_info
        ]);
    }

    public function updateItem($request,$id)
    {
        $validator = Validator::make($request->all(),[
            'name' => "required|string|max:50|min:3|unique:permissions,name,$id,id",
        ]);

        if($validator->fails()) {

            return response()->json([
                'status'    => 400,
                'messages'  => config('status.status_code.400'),
                'errors'    => $validator->errors()->all()
            ]);

        }

        $data = $request->all();

        if (isset($data['name'])){
            $data['slug'] = Helper::slugify($data['name']);
        }

        DB::beginTransaction();

        try{
            $this->permissionRepository->update($data,$id);
            $permission_info = $this->permissionRepository->show($id);

        }catch (Exception $e) {

            DB::rollBack();

            return response()->json([
                'status'    => 424,
                'messages'  =>config('status.status_code.424'),
                'error'     => $e->getMessage()
            ]);
        }

        DB::commit();

        return response()->json([
            'status'            => 200,
            'messages'          => config('status.status_code.200'),
            'permission_info'   => $permission_info
        ]);
    }


    public function deleteItem($id)
    {

        DB::beginTransaction();

        try{

            $this->permissionRepository->delete($id);

        }catch (Exception $e) {

            DB::rollBack();

            Log::error('Found Exception: ' . $e->getMessage() . ' [Script: ' . __CLASS__ . '@' . __FUNCTION__ . '] [Origin: ' . $e->getFile() . '-' . $e->getLine() . ']');

            return response()->json([
                'status'            => 424,
                'messages'          => config('status.status_code.424'),
                'error'             => $e->getMessage()
            ]);
        }

        DB::commit();

        return response()->json([
            'status'                => 200,
            'message'               => config('status.status_code.200'),
        ]);

    }

    public function checkUniqueIdentity($request)
    {
        $data                       = $request->all();

        DB::beginTransaction();

        try{

            if (isset($data['name'])){
                $permission_info    = $this->permissionRepository->checkPermissionName($data);
            }

        }catch (Exception $e) {

            DB::rollBack();

            Log::error('Found Exception: ' . $e->getMessage() . ' [Script: ' . __CLASS__ . '@' . __FUNCTION__ . '] [Origin: ' . $e->getFile() . '-' . $e->getLine() . ']');

            return response()->json([
                'status'            => 424,
                'messages'          => config('status.status_code.424'),
                'error'             => $e->getMessage()
            ]);
        }

        DB::commit();

        if (count($permission_info) == 0){
            return response()->json([
                'status'                => 200,
                'message'               => config('status.status_code.200'),
                'availability'          => 'Available'
            ]);
        }else{
            return response()->json([
                'status'                => 200,
                'message'               => config('status.status_code.200'),
                'availability'          => 'Taken'
            ]);
        }
    }
}
