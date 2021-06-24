<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tokens extends Model
{
    use HasFactory;
    protected $guarded=[];
    public $timestamps= false ;
    function admin ()
    {
        return $this->belongsTo(admins::class,'admins_id');
    }
    function user ()
    {
        return $this->belongsTo(users::class,'users_id');
    }
}
