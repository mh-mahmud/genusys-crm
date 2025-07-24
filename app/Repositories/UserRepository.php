<?php
namespace App\Repositories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;

class UserRepository
{
    public function listing($request)
    {
        $query = User::select('users.*');
        $query->orderBy('users.created_at','DESC');
        
        return $query->paginate(config('constants.ROW_PER_PAGE'));
    }

    public function create(array  $data)
    { 
        $user                 = new User();
        $user->id             = Helper::generateTableId();
        $user->first_name     = $data['first_name'];
        $user->middle_name    = $data['middle_name'] ?? null;
        $user->last_name      = $data['last_name'] ?? null;
        $user->phone          = $data['phone'] ?? null;
        $user->address        = $data['address'] ?? null;
        $user->user_name      = $data['user_name'] ?? null;
        $user->email          = $data['email'] ?? null;
        $user->password       = bcrypt($data['password']);
        $user->role_id        = $data['role_id'] ?? null;
        $user->gender         = $data['gender'] ?? null;
        $user->status         = config('constants.ACTIVE');
        $user->save();

        return $user;
    }

    public function show($id)
    {

        return User::findorfail($id);

    }

    public function update(array $data, $id)
    {
        $user                 = User::findorfail($id);
        $user->first_name     = $data['first_name'] ?? $user->first_name;
        $user->middle_name    = $data['middle_name'] ?? $user->middle_name;
        $user->last_name      = $data['last_name'] ?? $user->last_name;
        $user->phone          = $data['phone'] ?? $user->phone;
        $user->address        = $data['address'] ?? $user->address;
        $user->email          = $data['email'] ?? $user->email;
        // $user->password       = bcrypt($data['password']);
        $user->role_id        = $data['role_id'] ?? $user->role_id;
        $user->gender         = $data['gender'] ?? $user->gender;
        $user->save();

        return $user;
    }

    public function delete($id)
    {
        if(User::findorfail($id)->delete()){
            return true;
        }
    }


    public function changePassword(array $data)
    {
        Auth::user()->update([
            'password' => bcrypt($data["password"]),
        ]);
    }

    public function userStatusChange($id)
    {  
        $user = User::findOrFail($id);
        $user->status = ($user->status == config('constants.ACTIVE')) ? config('constants.INACTIVE') : config('constants.ACTIVE');
        $user->save();
        return $user;
    }
}