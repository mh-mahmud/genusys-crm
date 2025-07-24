<?php


namespace App\Services\API;

use App\Models\User;
use App\Repositories\MenuRepository;
use Exception;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Validator;

class MenuService
{

    protected $menuRepository;

    public function __construct()
    {
        $this->menuRepository       = new MenuRepository();
    }

    public function listItems($request)
    {

        try{

            $listing = $this->menuRepository->listing($request);

        }catch (Exception $e) {
            return response()->json([
                'status'            => 424,
                'messages'          => config('status.status_code.424'),
                'error'             => $e->getMessage()
            ]);

        }
        
        return response()->json([
            'status'                => 200,
            'messages'              => config('status.status_code.200'),
            'info'                  => $listing
        ]);
    }

    public function createItem($request)
    {
        $validator = Validator::make($request->all(),[

            'name'                  => 'required|string|max:50|min:3|unique:permission_groups',

        ]);
        if($validator->fails()) {

            return response()->json([
                'status'            => 400,
                'messages'          => config('status.status_code.400'),
                'errors'            => $validator->errors()->all()
            ]);

        }
        $data           = $request->all();
        $data['slug']   = Helper::slugify($request->name);

        try{
            
            $user = $this->menuRepository->create($data);

        }catch (Exception $e) {
            return response()->json([
                'status'            => 424,
                'messages'          => config('status.status_code.424'),
                'error'             => $e->getMessage()
            ]);

        }
        
        return response()->json([
            'status'                => 201,
            'messages'              => config('status.status_code.201'),
            'info'                  => $user
        ]);
    }

    public function showItem($id)
    {
        try{

            $user = $this->menuRepository->show($id);

        }catch (Exception $e) {


            return response()->json([
                'status'            => 424,
                'messages'          => config('status.status_code.424'),
                'error'             => $e->getMessage()
            ]);
        }

        return response()->json([
            'status'                => 200,
            'message'               => config('status.status_code.200'),
            'info'             => $user
        ]);
    }

    public function updateItem($request,$id)
    {
        $validator = Validator::make($request->all(),[
            'name' => "required|string|max:50|min:3|unique:permission_groups,name,$id,id",
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

        try{
            
            $user = $this->menuRepository->update($data, $id);
            

        }catch (Exception $e) {
            return response()->json([
                'status'            => 424,
                'messages'          => config('status.status_code.424'),
                'error'             => $e->getMessage()
            ]);

        }
        
        return response()->json([
            'status'                => 208,
            'messages'              => config('status.status_code.208'),
            'info'                  => $user
        ]);
    }

    public function delete($id)
    {
        try{
            
            $user = $this->menuRepository->delete($id);

        }catch (Exception $e) {
            return response()->json([
                'status'            => 424,
                'messages'          => config('status.status_code.424'),
                'error'             => $e->getMessage()
            ]);

        }
        
        return response()->json([
            'status'                => 209,
            'messages'              => config('status.status_code.209'),
            'info'                  => $user
        ]);
    }
}