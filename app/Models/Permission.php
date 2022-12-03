<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    public $fillable = [
        "key", "description",
    ];

    private static $permissions = [
        "admin.dashboard" => "-"
    ];

    public static function init() {
        $permissions = json_decode(file_get_contents(public_path('permissions.json')), true);

        foreach ($permissions as $permission => $description) {
            $perm = Permission::where('key', $permission)->first();
            if (!$perm) {
                Permission::create([
                    "key" => $permission,
                    "description" => $description,
                ]);
            }
        }
    }
}
