<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class admins extends  Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'admins',$guarded=[],$appends=['permissions'];
    public $timestamps = false;

    function GetPermissionsAttribute()
    {
        return json_decode($this->attributes['permissions'],true);
    }
}
