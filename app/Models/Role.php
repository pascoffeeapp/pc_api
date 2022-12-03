<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public static function init() {
        $roles = json_decode(file_get_contents(public_path('roles.json')), true);

        // Init Permission
        Permission::init();

        foreach ($roles as $name => $permissions) {

            // Membuat Role Baru Bila Ada
            $role = Role::where('name', $name)->first();
            if (!$role) {
                $role = Role::create([
                    "name" => $name,
                ]);
            }

            //  Mereset Izin Pada Role
            $rp = RolePermission::where('role_id', $role->id)->get();
            foreach ($rp as $r) $r->delete();

            // Menambahkan Izin Baru Pada Role
            foreach ($permissions as $key) {
                $permission = Permission::where('key', $key)->first();

                if ($permission) {
                    RolePermission::create([
                        "role_id" => $role->id,
                        "permission_id" => $permission->id 
                    ]);
                }
                
            }
        }
    }

    public function getData() {
        $role = Role::where('id', $this->id)->first();
        $role->permissions = $this->getPermission();
        return $role;
    }

    public function getPermission() {
        return RolePermission::where('role_id', $this->id)
        ->join('permissions', 'permissions.id', '=', 'role_permissions.permission_id')
        ->selectRaw('role_permissions.permission_id as id, permissions.key, permissions.description')
        ->get();
    }

    public function hasPermission(string $key) {
        $permission = Permission::where('key', $key)->first();
        $permId = ($permission) ? $permission->id : -1;
        return !is_null(RolePermission::where('role_id', $this->id)->where('permission_id', $permId)->first());
    }

}
