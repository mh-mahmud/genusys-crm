<?php


namespace App\Services\API;

use App\Models\User;
use App\Repositories\UserRepository;
use Exception;

class UserService
{

    protected $userRepository;

    public function __construct()
    {
        $this->userRepository       = new UserRepository();
    }

    public function listItems($request)
    {

        try{

            $listing = $this->userRepository->listing($request);

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
            'user_list'             => $listing
        ]);
    }

    public function createItem($request)
    {
        $data = $request->all();

        try{
            
            $user = $this->userRepository->create($data);

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

            $user = $this->userRepository->show($id);

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
            'user_info'             => $user
        ]);
    }

    public function updateItem($request,$id)
    {
        $data = $request->all();
        
        try{
            
            $user = $this->userRepository->update($data, $id);

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
            
            $user = $this->userRepository->delete($id);

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

    public function changePassword($request)
    {
        $data = $request->all();
        try{
            
            $user = $this->userRepository->changePassword($data);

        }catch (Exception $e) {
            return response()->json([
                'status'            => 424,
                'messages'          => config('status.status_code.424'),
                'error'             => $e->getMessage()
            ]);

        }
        
        return response()->json([
            'status'                => 208,
            'messages'              => config('status.status_code.200'),
            'info'                  => $user
        ]);
    }

    public function userStatusChange($id)
    {
        try{
            
            $user = $this->userRepository->userStatusChange($id);

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
}