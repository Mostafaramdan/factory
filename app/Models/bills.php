<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bills extends Model
{
    public $timestamps = false,$with=['client','employee'];
    protected $guarded=[];
    function employee(){
        return $this->belongsTo(employees::class,'employees_id');
    }
    function client(){
        return $this->belongsTo(clients::class,'clients_id');
    }

}
