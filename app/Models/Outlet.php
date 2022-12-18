<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    use HasFactory;

    public $fillable = [
        'name', 'image', 'description', 'owner_id', 'status'
    ];

    public function getData() {
        // $outlet->owner = User::where('id', $outlet->owner_id)->selectRaw("id, username")->first();
        $this->menu = Menu::where('outlet_id', $this->id)->get();
        $this->owner = User::find($this->owner_id);
        // unset($outlet->owner_id);
        return $this;
    }
}
