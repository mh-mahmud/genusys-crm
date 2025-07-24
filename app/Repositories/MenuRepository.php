<?php
namespace App\Repositories;

use App\Models\PermissionGroup;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;

class MenuRepository
{
    public function listing($request)
    {
        $query = PermissionGroup::select('permission_groups.*');
        $query->orderBy('permission_groups.created_at','DESC');
        
        return $query->paginate(config('constants.ROW_PER_PAGE'));
    }

    public function create(array  $data)
    { 
        $menu                      = new PermissionGroup();
        $menu->id                  = Helper::generateTableId();
        $menu->name                = $data['name'];
        $menu->slug                = $data['slug'];
        $menu->save();

        return $menu;
    }

    public function show($id)
    {

        return PermissionGroup::findorfail($id);

    }

    public function update(array $data, $id)
    {
        $menu                 = PermissionGroup::findorfail($id);
        $menu->name           = $data['name'];
        $menu->slug           = $data['slug'];
        $menu->save();

        return $menu;
    }

    public function delete($id)
    {
        if(PermissionGroup::findorfail($id)->delete()){
            return true;
        }
    }
}