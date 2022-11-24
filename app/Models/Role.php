<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

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
        return !is_null(RolePermission::where('role_id', $this->id)->where('permission_id'));
    }

}
